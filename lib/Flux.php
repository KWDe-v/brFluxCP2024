<?php
require_once 'Flux/Config.php';
require_once 'Flux/Error.php';
require_once 'Flux/Connection.php';
require_once 'Flux/LoginServer.php';
require_once 'Flux/CharServer.php';
require_once 'Flux/MapServer.php';
require_once 'Flux/Athena.php';
require_once 'Flux/LoginAthenaGroup.php';
require_once 'Flux/Addon.php';
require_once 'functions/getReposVersion.php';
require_once 'functions/discordwebhook.php';

// Obter a revisão do SVN ou o hash do GIT do diretório de nível superior (FLUX_ROOT).
define('FLUX_REPOSVERSION', getReposVersion());

/**
 * A classe Flux contém métodos relacionados à aplicação em uma escala maior.
 * Em sua maior parte, ela lida com a inicialização da aplicação, como 
 * a análise dos arquivos de configuração e outras funcionalidades.
 */
class Flux {
	/**
	 * Versão Atual.
	 */
	const VERSION = '2.0.0';

	/**
	 * Versão do repositório SVN ou hash GIT da revisão de nível superior.
	 */
	const REPOSVERSION = FLUX_REPOSVERSION;

	/**
	 * Objeto de configuração específico do aplicativo.
	 *
	 * @access public
	 * @var Flux_Config
	 */
	public static $appConfig;

	/**
	 * Objeto de configuração dos servidores.
	 *
	 * @access public
	 * @var Flux_Config
	 */
	public static $serversConfig;

	/**
	 * Objeto de configuração de mensagens.
	 *
	 * @access public
	 * @var Flux_Config
	 */
	public static $messagesConfig;

	/**
	 * Coleção de objetos Flux_Athena.
	 *
	 * @access public
	 * @var array
	 */
	public static $servers = array();

	/**
	 * Registro onde as instâncias Flux_LoginAthenaGroup são mantidas para fácil 
	 * busca.
	 *
	 * @access public
	 * @var array
	 */
	public static $loginAthenaGroupRegistry = array();

	/**
	 * Registro onde as instâncias Flux_Athena são mantidas para fácil busca.
	 *
	 * @access public
	 * @var array
	 */
	public static $athenaServerRegistry = array();

	/**
	 * Objeto contendo todos os dados de sessão do Flux.
	 *
	 * @access public
	 * @var Flux_SessionData
	 */
	public static $sessionData;

	/**
	 *
	 */
	public static $numberOfQueries = 0;

	/**
	 *
	 */
	public static $addons = array();

	/**
	 * Inicialize a aplicação Flux. Isso irá lidar com a análise de configuração e
	 * instanciação de objetos cruciais para o painel de controle.
	 *
	 * @param array $options Options to pass to initializer.
	 * @throws Flux_Error Raised when missing required options.
	 * @access public
	 */
	public static function initialize($options = array())
	{
		$required = array('appConfigFile', 'serversConfigFile');
		foreach ($required as $option) {
			if (!array_key_exists($option, $options)) {
				self::raise("Faltando a opção necessária `$option` em Flux::initialize()");
			}
		}

		// Analisar os arquivos de configuração da aplicação e do servidor, isso também
		// lidará com a normalização dos arquivos de configuração. Veja o código fonte
		// dos métodos abaixo para mais detalhes sobre o que está sendo feito.
		self::$appConfig      = self::parseAppConfigFile($options['appConfigFile']);
		self::$serversConfig  = self::parseServersConfigFile($options['serversConfigFile']);

		if (array_key_exists('appConfigFileImport', $options) && file_exists($options['appConfigFileImport'])) {
			$importAppConfig = self::parseAppConfigFile($options['appConfigFileImport'], true);
			self::$appConfig->merge($importAppConfig, true, true);
		}

		// Os arquivos de configuração do servidor não são mesclados, em vez disso, substituem o original.
		if (array_key_exists('serversConfigFileImport', $options) && file_exists($options['serversConfigFileImport'])) {
			$importServersConfig = self::parseServersConfigFile($options['serversConfigFileImport'], true);
			self::$serversConfig = $importServersConfig;
		}

		// Usando o sistema de linguagem mais recente.
		self::$messagesConfig = self::parseLanguageConfigFile();

		// Inicializar objetos do servidor.
		self::initializeServerObjects();

		// Inicializar complementos.
		self::initializeAddons();
	}

	/**
	 * Inicialize cada objeto de servidor de Login/Char/Map e os contenha em seu
	 * próprio objeto Athena coletivo.
	 *
	 * Isso também faz parte da fase de inicialização do Flux.
	 *
	 * @access public
	 */
	public static function initializeServerObjects()
	{
		foreach (self::$serversConfig->getChildrenConfigs() as $key => $config) {
			$connection  = new Flux_Connection($config->getDbConfig(), $config->getLogsDbConfig(), $config->getWebDbConfig());
			$loginServer = new Flux_LoginServer($config->getLoginServer());

			// LoginAthenaGroup mantém a agrupação de um servidor de login central
			// e seus objetos Athena subjacentes.
			self::$servers[$key] = new Flux_LoginAthenaGroup($config->getServerName(), $connection, $loginServer);

			// Adicionar ao registro.
			self::registerServerGroup($config->getServerName(), self::$servers[$key]);

			foreach ($config->getCharMapServers()->getChildrenConfigs() as $charMapServer) {
				$charServer = new Flux_CharServer($charMapServer->getCharServer());
				$mapServer  = new Flux_MapServer($charMapServer->getMapServer());

				// Criar o objeto servidor coletivo, Flux_Athena.
				$athena = new Flux_Athena($charMapServer, $loginServer, $charServer, $mapServer);
				self::$servers[$key]->addAthenaServer($athena);

				// Adicionar ao registro.
				self::registerAthenaServer($config->getServerName(), $charMapServer->getServerName(), $athena);
			}
		}
	}

	/**
	 *
	 */
	public static function initializeAddons()
	{
		if (!is_dir(FLUX_ADDON_DIR)) {
			return false;
		}

		foreach (glob(FLUX_ADDON_DIR.'/*') as $addonDir) {
			if (is_dir($addonDir)) {
				$addonName   = basename($addonDir);
				$addonObject = new Flux_Addon($addonName, $addonDir);
				self::$addons[$addonName] = $addonObject;

				// Mesclar configurações.
				self::$appConfig->merge($addonObject->addonConfig);
				self::$messagesConfig->merge($addonObject->messagesConfig, false);
			}
		}
	}

	/**
	 * Método de envoltório para definir e obter valores do appConfig.
	 *
	 * @param string $key
	 * @param mixed $value
	 * @param array $options
	 * @access public
	 */
	public static function config($key, $value = null, $options = array())
	{
		if (!is_null($value)) {
			return self::$appConfig->set($key, $value, $options);
		}
		else {
			return self::$appConfig->get($key);
		}
	}

	/**
	 * Método de envoltório para definir e obter valores do messagesConfig.
	 *
	 * @param string $key
	 * @param mixed $value
	 * @param array $options
	 * @access public
	 */
	public static function message($key, $value = null, $options = array())
	{
		if (!is_null($value)) {
			return self::$messagesConfig->set($key, $value, $options);
		}
		if (!is_null($tmp=self::$messagesConfig->get($key)))
			return $tmp;
		else
			return ' '.$key;
	}

	/**
	 * Método de conveniência para gerar exceções Flux_Error.
	 *
	 * @param $string $message Mensagem para passar para o construtor.
	 * @throws Flux_Error
	 * @access public
	 */
	public static function raise($message)
	{
		throw new Flux_Error($message);
	}

	/**
	 * Analisar matriz PHP em uma instância Flux_Config.
	 *
	 * @param array $configArr
	 * @access public
	 */
	public static function parseConfig(array $configArr)
	{
		return new Flux_Config($configArr);
	}

	/**
	 * Analisar uma matriz PHP retornada como resultado de um arquivo incluído em um
	 * objeto de configuração Flux_Config.
	 *
	 * @param string $filename
	 * @access public
	 */
	public static function parseConfigFile($filename, $cache=true)
	{
		$basename  = basename(str_replace(' ', '', ucwords(str_replace(array('/', '\\', '_'), ' ', $filename))), '.php').'.cache.php';
		$cachefile = FLUX_DATA_DIR."/tmp/$basename";
		$directory = FLUX_DATA_DIR.'/tmp';
		if (!is_dir($directory))
			mkdir($directory, 0600);
		if ($cache && file_exists($cachefile) && filemtime($cachefile) > filemtime($filename)) {
			return unserialize(file_get_contents($cachefile, false, null, 28));
		}
		else {
			ob_start();
			// Usa require, portanto assume que o arquivo retorna um array.
			$config = require $filename;
			ob_end_clean();

			// Cache do arquivo de configuração.
			$cf = self::parseConfig($config);

			if ($cache) {
				$fp = fopen($cachefile, 'w');
				if ( !$fp ){
					self::raise("Falha ao gravar ".$cachefile." erro de permissão ou data/tmp não existe em Flux::parseConfigFile()");
				}
				fwrite($fp, '<?php exit("Forbidden."); ?>');
				fwrite($fp, $s=serialize($cf), strlen($s));
				fclose($fp);
			}

			return $cf;
		}
	}

	/**
	 * Analisar um arquivo de maneira específica para a configuração da aplicação.
	 *
	 * @param string $filename
	 * @param bool $import Whether this is an import config or not
	 * @access public
	 */
	public static function parseAppConfigFile($filename, $import = false)
	{
		$config = self::parseConfigFile($filename, false);

		if (!$config->getServerAddress() && !$import) {
			self::raise("O endereço do servidor deve ser especificado na configuração da sua aplicação.");
		}
		$themes = $config->get('ThemeName', false);
		if ((!$themes || count($themes) < 1) && !$import) {
			self::raise('ThemeName é obrigatório na configuração do aplicativo.');
		}
		if ($themes) {
			foreach ($themes as $themeName) {
				if (!self::themeExists($themeName)) {
					self::raise("O tema selecionado '$themeName' não existe.");
				}
			}
		}
		if (!($config->getPayPalReceiverEmails() instanceof Flux_Config)
			&& !($import && $config->getPayPalReceiverEmails() === null)) {
			self::raise("PayPalReceiverEmails deve ser um array.");
		}

		// Sanitizar BaseURI. (a barra inicial é obrigatória.)
		$baseURI = $config->get('BaseURI');
		if (!is_null($baseURI)) {
			if (strlen($baseURI) && $baseURI[0] != '/') {
				$config->set('BaseURI', "/$baseURI");
			}
			elseif (trim($baseURI) === '') {
				$config->set('BaseURI', '/');
			}
		}

		return $config;
	}

	/**
	 * Analisar um arquivo de maneira específica para a configuração dos servidores. Este método fica um pouco
	 * complicado, então tenha cuidado com o código feio ;)
	 *
	 * @param string $filename
	 * @param bool $import Whether this is an import config or not
	 * @access public
	 */
	public static function parseServersConfigFile($filename, $import = false)
	{
		$config            = self::parseConfigFile($filename);
		$options           = array('overwrite' => false, 'force' => true); // Opções de Config::set().
		$serverNames       = array();
		$athenaServerNames = array();

		if (!count($config->toArray()) && !$import) {
			self::raise('Pelo menos uma configuração de servidor deve estar presente.');
		}

		foreach ($config->getChildrenConfigs() as $topConfig) {
			//
			// Normalização de nível superior.
			//

			if (!($serverName = $topConfig->getServerName())) {
				self::raise('ServerName é obrigatório para cada configuração de servidor de nível superior, verifique seu arquivo de configuração de servidores.');
			}
			elseif (in_array($serverName, $serverNames)) {
				self::raise("O nome do servidor '$serverName' já foi configurado. Por favor, use outro nome.");
			}

			$serverNames[] = $serverName;
			$athenaServerNames[$serverName] = array();

			$topConfig->setDbConfig(array(), $options);
			$topConfig->setLogsDbConfig(array(), $options);
			$topConfig->setWebDbConfig(array(), $options);
			$topConfig->setLoginServer(array(), $options);
			$topConfig->setCharMapServers(array(), $options);

			$dbConfig     = $topConfig->getDbConfig();
			$logsDbConfig = $topConfig->getLogsDbConfig();
			$webDbConfig  = $topConfig->getWebDbConfig();
			$loginServer  = $topConfig->getLoginServer();

			foreach (array($dbConfig, $logsDbConfig, $webDbConfig) as $_dbConfig) {
				$_dbConfig->setHostname('localhost', $options);
				$_dbConfig->setUsername('ragnarok', $options);
				$_dbConfig->setPassword('ragnarok', $options);
				$_dbConfig->setPersistent(true, $options);
			}

			$loginServer->setDatabase($dbConfig->getDatabase(), $options);
			$loginServer->setUseMD5(true, $options);

			// Gerar erro se faltar diretrizes de configuração essenciais.
			if (!$loginServer->getAddress()) {
				self::raise('Address é obrigatório para cada seção LoginServer na configuração dos seus servidores.');
			}
			elseif (!$loginServer->getPort()) {
				self::raise('Port é obrigatório para cada seção LoginServer na configuração dos seus servidores.');
			}

			if (!$topConfig->getCharMapServers() || !count($topConfig->getCharMapServers()->toArray())) {
				self::raise('CharMapServers deve ser um array e conter pelo menos 1 entrada de servidor char/map.');
			}

			foreach ($topConfig->getCharMapServers()->getChildrenConfigs() as $charMapServer) {
				//
				// Normalização Char/Map.
				//
				$expRates = array(
					'Base'        => 100,
					'Job'         => 100,
					'Mvp'         => 100
				);
				$dropRates = array(
					'DropRateCap' => 9000,
					'Common'      => 100,
					'CommonBoss'  => 100,
					'CommonMVP'   => 100,
					'CommonMin'   => 1,
					'CommonMax'   => 10000,
					'Heal'        => 100,
					'HealBoss'    => 100,
					'HealMVP'     => 100,
					'HealMin'     => 1,
					'HealMax'     => 10000,
					'Useable'     => 100,
					'UseableBoss' => 100,
					'UseableMVP'  => 100,
					'UseableMin'  => 1,
					'UseableMax'  => 10000,
					'Equip'       => 100,
					'EquipBoss'   => 100,
					'EquipMVP'    => 100,
					'EquipMin'    => 1,
					'EquipMax'    => 10000,
					'Card'        => 100,
					'CardBoss'    => 100,
					'CardMVP'     => 100,
					'CardMin'     => 1,
					'CardMax'     => 10000,
					'MvpItem'     => 100,
					'MvpItemMin'  => 1,
					'MvpItemMax'  => 10000,
					'MvpItemMode' => 0
				);
				$charMapServer->setExpRates($expRates, $options);
				$charMapServer->setDropRates($dropRates, $options);
				$charMapServer->setRenewal(true, $options);
				$charMapServer->setCharServer(array(), $options);
				$charMapServer->setMapServer(array(), $options);
				$charMapServer->setDatabase($dbConfig->getDatabase(), $options);

				if (!($athenaServerName = $charMapServer->getServerName())) {
					self::raise('ServerName é obrigatório para cada par CharMapServers na configuração dos seus servidores.');
				}
				elseif (in_array($athenaServerName, $athenaServerNames[$serverName])) {
					self::raise("O nome do servidor '$athenaServerName' sob '$serverName' já foi configurado. Por favor, use outro nome.");
				}

				$athenaServerNames[$serverName][] = $athenaServerName;
				$charServer = $charMapServer->getCharServer();

				if (!$charServer->getAddress()) {
					self::raise('Address é obrigatório para cada seção CharServer na configuração dos seus servidores.');
				}
				elseif (!$charServer->getPort()) {
					self::raise('Port é obrigatório para cada seção CharServer na configuração dos seus servidores.');
				}

				$mapServer = $charMapServer->getMapServer();
				if (!$mapServer->getAddress()) {
					self::raise('Address é obrigatório para cada seção MapServer na configuração dos seus servidores.');
				}
				elseif (!$mapServer->getPort()) {
					self::raise('Port é obrigatório para cada seção MapServer na configuração dos seus servidores.');
				}
			}
		}

		return $config;
	}

	/**
	 * Analisar um arquivo de configuração de mensagens. (Descontinuado)
	 *
	 * @param string $filename
	 * @access public
	 */
	public static function parseMessagesConfigFile($filename)
	{
		$config = self::parseConfigFile($filename);
		// Nada ainda.
		return $config;
	}

	/**
	 * Analisar um arquivo de configuração de idioma, também pode analisar um configuração de idioma
	 * para qualquer complemento.
	 *
	 * @param string $addonName
	 * @access public
	 */
	public static function parseLanguageConfigFile($addonName=null)
	{
		$default = $addonName ? FLUX_ADDON_DIR."/$addonName/lang/en_us.php" : FLUX_LANG_DIR.'/en_us.php';
		$current = $default;

		if ($lang=self::config('DefaultLanguage')) {
			$current = $addonName ? FLUX_ADDON_DIR."/$addonName/lang/$lang.php" : FLUX_LANG_DIR."/$lang.php";
		}

		$languages = self::getAvailableLanguages();

		if(!empty($_COOKIE["language"]) && array_key_exists($_COOKIE["language"], $languages))
		{
			$lang = $_COOKIE["language"];
			$current = $addonName ? FLUX_ADDON_DIR."/$addonName/lang/$lang.php" : FLUX_LANG_DIR."/$lang.php";
		}

		if (file_exists($default)) {
			$def = self::parseConfigFile($default);
		}
		else {
			$tmp = array();
			$def = new Flux_Config($tmp);
		}

		if ($current != $default && file_exists($current)) {
			$cur = self::parseConfigFile($current);
			$def->merge($cur, false);
		}

		return $def;
	}

	/**
	 * Verificar se um tema existe.
	 *
	 * @return bool
	 * @access public
	 */
	public static function themeExists($themeName)
	{
		return is_dir(FLUX_THEME_DIR."/$themeName");
	}

	/**
	 * Registrar o grupo de servidor no registro.
	 *
	 * @param string $serverName Server group's name.
	 * @param Flux_LoginAthenaGroup Server group object.
	 * @return Flux_LoginAthenaGroup
	 * @access private
	 */
	private static function registerServerGroup($serverName, Flux_LoginAthenaGroup $serverGroup)
	{
		self::$loginAthenaGroupRegistry[$serverName] = $serverGroup;
		return $serverGroup;
	}

	/**
	 * Registrar o servidor Athena no registro.
	 *
	 * @param string $serverName Server group's name.
	 * @param string $athenaServerName Athena server's name.
	 * @param Flux_Athena $athenaServer Athena server object.
	 * @return Flux_Athena
	 * @access private
	 */
	private static function registerAthenaServer($serverName, $athenaServerName, Flux_Athena $athenaServer)
	{
		if (!array_key_exists($serverName, self::$athenaServerRegistry) || !is_array(self::$athenaServerRegistry[$serverName])) {
			self::$athenaServerRegistry[$serverName] = array();
		}

		self::$athenaServerRegistry[$serverName][$athenaServerName] = $athenaServer;
		return $athenaServer;
	}

	/**
	 * Obter o objeto do servidor Flux_LoginAthenaGroup pelo seu ServerName.
	 *
	 * @param string $serverName Server group name.
	 * @return mixed Returns Flux_LoginAthenaGroup instance or false on failure.
	 * @access public
	 */
	public static function getServerGroupByName($serverName)
	{
		$registry = &self::$loginAthenaGroupRegistry;

		if (array_key_exists($serverName, $registry) && $registry[$serverName] instanceOf Flux_LoginAthenaGroup) {
			return $registry[$serverName];
		}
		else {
			return false;
		}
	}

	/**
	 * Obter a instância Flux_Athena pelo seu nome de grupo/servidor.
	 *
	 * @param string $serverName Server group name.
	 * @param string $athenaServerName Athena server name.
	 * @return mixed Returns Flux_Athena instance or false on failure.
	 * @access public
	 */
	public static function getAthenaServerByName($serverName, $athenaServerName)
	{
		$registry = &self::$athenaServerRegistry;
		if (array_key_exists($serverName, $registry) && array_key_exists($athenaServerName, $registry[$serverName]) &&
			$registry[$serverName][$athenaServerName] instanceOf Flux_Athena) {

			return $registry[$serverName][$athenaServerName];
		}
		else {
			return false;
		}
	}

	/**
	 * Criptografa uma senha para uso na comparação com a coluna login.user_pass.
	 *
	 * @param string $password Plain text password.
	 * @return string Returns hashed password.
	 * @access public
	 */
	public static function hashPassword($password)
	{
		// O esquema de hashing padrão é MD5.
		return md5($password);
	}

	/**
	 * Obter o nome da classe de trabalho a partir de um ID de trabalho.
	 *
	 * @param int $id
	 * @return mixed Job class or false.
	 * @access public
	 */
	public static function getJobClass($id)
	{
		$key   = "JobClasses.$id";
		$class = self::config($key);

		if ($class) {
			return $class;
		}
		else {
			return false;
		}
	}

	/**
	 * Obter o ID de trabalho a partir de um nome de classe de trabalho.
	 *
	 * @param string $class
	 * @return mixed Job ID or false.
	 * @access public
	 */
	public static function getJobID($class)
	{
		$index = self::config('JobClassIndex')->toArray();
		if (array_key_exists($class, $index)) {
			return $index[$class];
		}
		else {
			return false;
		}
	}

	/**
	 * Obter o nome da classe de homúnculo a partir de um ID de classe de homúnculo.
	 *
	 * @param int $id
	 * @return mixed Class name or false.
	 * @access public
	 */
	public static function getHomunClass($id)
	{
		$key   = "HomunClasses.$id";
		$class = self::config($key);

		if ($class) {
			return $class;
		}
		else {
			return false;
		}
	}

	/**
	 * Obter o nome do tipo de item a partir de um tipo de item.
	 *
	 * @return Item Type or false.
	 * @access public
	 */
	public static function getItemType($id1)
	{
		if (is_null($id1))
			return false;

		$type = self::config("ItemTypes")->toArray();

		if ($type[strtolower($id1)] != NULL) {
			return $type[strtolower($id1)];
		}
		else {
			return false;
		}
	}
	public static function getItemSubType($id1, $id2)
	{
		$subtype = "ItemSubTypes.$id1.$id2";
		$result = self::config($subtype);

		if ($result) {
			return $result;
		}
		else {
			return false;
		}
	}

	/**
	 * Descrição da opção aleatória.
	 */
	public static function getRandOption($id1)
	{
		$key   = "RandomOptions.$id1";
		$option = self::config($key);

		if ($option) {
			return $option;
		}
		else {
			return false;
		}
	}

	/**
	 * Obter o nome da combinação de localização de equipamento a partir de uma combinação de localização de equipamento.
	 *
	 * @param int $id
	 * @return mixed Equip Location Combination or false.
	 * @access public
	 */
	public static function getEquipLocationCombination()
	{
		$equiplocations = Flux::config('EquipLocationCombinations')->toArray();
		return $equiplocations;
	}

	/**
	 * Processar doações que foram colocadas em espera.
	 */
	public static function processHeldCredits()
	{
		$txnLogTable            = self::config('FluxTables.TransactionTable');
		$trustTable             = self::config('FluxTables.DonationTrustTable');
		$loginAthenaGroups      = self::$loginAthenaGroupRegistry;
		list ($cancel, $accept) = array(array(), array());

		foreach ($loginAthenaGroups as $loginAthenaGroup) {
			$sql  = "SELECT account_id, payer_email, credits, mc_gross, txn_id, hold_until ";
			$sql .= "FROM {$loginAthenaGroup->loginDatabase}.$txnLogTable ";
			$sql .= "WHERE account_id > 0 AND hold_until IS NOT NULL AND payment_status = 'Completed'";
			$sth  = $loginAthenaGroup->connection->getStatement($sql);

			if ($sth->execute() && ($txn=$sth->fetchAll())) {
				foreach ($txn as $t) {
					$sql  = "SELECT id FROM {$loginAthenaGroup->loginDatabase}.$txnLogTable ";
					$sql .= "WHERE payment_status IN ('Cancelled_Reversed', 'Reversed', 'Refunded') AND parent_txn_id = ? LIMIT 1";
					$sth  = $loginAthenaGroup->connection->getStatement($sql);

					if ($sth->execute(array($t->txn_id)) && ($r=$sth->fetch()) && $r->id) {
						$cancel[] = $t->txn_id;
					}
					elseif (strtotime($t->hold_until) <= time()) {
						$accept[] = $t;
					}
				}
			}

			if (!empty($cancel)) {
				$ids  = implode(', ', array_fill(0, count($cancel), '?'));
				$sql  = "UPDATE {$loginAthenaGroup->loginDatabase}.$txnLogTable ";
				$sql .= "SET credits = 0, hold_until = NULL WHERE txn_id IN ($ids)";
				$sth  = $loginAthenaGroup->connection->getStatement($sql);
				$sth->execute($cancel);
			}

			$sql2   = "INSERT INTO {$loginAthenaGroup->loginDatabase}.$trustTable (account_id, email, create_date)";
			$sql2  .= "VALUES (?, ?, NOW())";
			$sth2   = $loginAthenaGroup->connection->getStatement($sql2);

			$sql3   = "SELECT id FROM {$loginAthenaGroup->loginDatabase}.$trustTable WHERE ";
			$sql3  .= "delete_date IS NULL AND account_id = ? AND email = ? LIMIT 1";
			$sth3   = $loginAthenaGroup->connection->getStatement($sql3);

			$idvals = array();

			foreach ($accept as $txn) {
				$loginAthenaGroup->loginServer->depositCredits($txn->account_id, $txn->credits, $txn->mc_gross);
				$sth3->execute(array($txn->account_id, $txn->payer_email));
				$row = $sth3->fetch();

				if (!$row) {
					$sth2->execute(array($txn->account_id, $txn->payer_email));
				}

				$idvals[] = $txn->txn_id;
			}

			if (!empty($idvals)) {
				$ids  = implode(', ', array_fill(0, count($idvals), '?'));
				$sql  = "UPDATE {$loginAthenaGroup->loginDatabase}.$txnLogTable ";
				$sql .= "SET hold_until = NULL WHERE txn_id IN ($ids)";
				$sth  = $loginAthenaGroup->connection->getStatement($sql);

				$sth->execute($idvals);
			}
		}
	}

	/**
	 *
	 */
	public static function pruneUnconfirmedAccounts()
	{
		$tbl    = Flux::config('FluxTables.AccountCreateTable');

		foreach (self::$loginAthenaGroupRegistry as $loginAthenaGroup) {
			$db   = $loginAthenaGroup->loginDatabase;
			$sql  = "DELETE $db.login, $db.$tbl FROM $db.login INNER JOIN $db.$tbl ";
			$sql .= "WHERE login.account_id = $tbl.account_id AND $tbl.confirmed = 0 ";
			$sql .= "AND $tbl.confirm_code IS NOT NULL AND $tbl.confirm_expire <= NOW()";
			$sth  = $loginAthenaGroup->connection->getStatement($sql);

			$sth->execute();
		}
	}

	/**
	 * Obter array de bits de equip_location. (pares bit => loc_name)
	 * @return array
	 */
	public static function getEquipLocationList()
	{
		$equiplocations = Flux::config('EquipLocations')->toArray();
		return $equiplocations;
	}

	/**
	 * Obter array de bits de equip_upper. (pares bit => upper_name)
	 * @return array
	 */
	public static function getEquipUpperList($isRenewal = 1)
	{
		$equipupper = Flux::config('EquipUpper.0')->toArray();

		if($isRenewal)
			$equipupper = array_merge($equipupper, Flux::config('EquipUpper.1')->toArray());

		return $equipupper;
	}

	/**
	 * Obter array de bits de equip_jobs. (pares bit => job_name)
	 */
	public static function getEquipJobsList($isRenewal = 1)
	{
		$equipjobs = Flux::config('EquipJobs.0')->toArray();

		if($isRenewal)
			$equipjobs = array_merge($equipjobs, Flux::config('EquipJobs.1')->toArray());

		return $equipjobs;
	}

	/**
	 * Obter array de restrições de troca
	 */
	public static function getTradeRestrictionList()
	{
		$restrictions = Flux::config('TradeRestriction')->toArray();
		return $restrictions;
	}

	/**
	 * Obter array de flags de item
	 */
	public static function getItemFlagList()
	{
		$flags = Flux::config('ItemFlags')->toArray();
		return $flags;
	}

	/**
	 * Verificar se um determinado tipo de item é empilhável.
	 * @param int $type
	 * @return bool
	 */
	public static function isStackableItemType($type)
	{
		$nonstackables = array(1, 4, 5, 7, 8, 9);
		return !in_array($type, $nonstackables);
	}

	/**
	 * Executar uma operação AND bit a bit de cada bit em getEquipUpperList() em $bitmask
	 * para determinar quais bits foram definidos.
	 * @param int $bitmask
	 * @return array
	 */
	public static function equipUpperToArray($bitmask, $isRenewal = 1)
	{
		$arr  = array();
		$bits = self::getEquipUpperList($isRenewal);

		foreach ($bits as $bit => $name) {
			if ($bitmask & $bit) {
				$arr[] = $bit;
			}
		}

		return $arr;
	}

	/**
	 * Executar uma operação AND bit a bit de cada bit em getEquipJobsList() em $bitmask
	 * para determinar quais bits foram definidos.
	 * @param int $bitmask
	 * @return array
	 */
	public static function equipJobsToArray($bitmask)
	{
		$arr  = array();
		$bits = self::getEquipJobsList();

		foreach ($bits as $bit => $name) {
			if ($bitmask & $bit) {
				$arr[] = $bit;
			}
		}

		return $arr;
	}

	/**
	 *
	 */
	public static function monsterModeToArray($bitmask)
	{
		$arr  = array();
		$bits = self::config('MonsterModes')->toArray();

		foreach ($bits as $name) {
				$arr[] = $name;
		}

		return $arr;
	}

	/**
	 *
	 */
	public static function elementName($ele)
	{
		$element = Flux::config("Elements")->toArray();
		return is_null($element[$ele]) ? $element['Neutral'] : $element[$ele];
	}

	/**
	 *
	 */
	public static function monsterRaceName($race)
	{
		$races = Flux::config("MonsterRaces")->toArray();
		return is_null($races[$race]) ? $races['Formless'] : $races[$race];
	}

	/**
	 *
	 */
	public static function monsterSizeName($size)
	{
		$sizes = Flux::config("MonsterSizes")->toArray();
		return is_null($sizes[$size]) ? $sizes['Small'] : $sizes[$size];
	}

	public static function getAvailableLanguages()
	{
		$langs_available = array_diff(scandir(FLUX_LANG_DIR), array('..', '.'));

		$dictionary = [];
		foreach($langs_available as $lang_file) {
			$lang_key = str_replace('.php', '', $lang_file);
			$lang_conf = self::parseConfigFile(FLUX_LANG_DIR.'/'.$lang_file);
			$lang_name = $lang_conf->get('Language');

			$dictionary[$lang_key] = $lang_name;
		}

		return $dictionary;
	}
}
?>
