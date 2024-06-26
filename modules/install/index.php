<?php
if (!defined('FLUX_ROOT')) exit;

require_once 'Flux/Installer/SchemaPermissionError.php';

// Força o modo de depuração aqui.
Flux::config('DebugMode', false);

//Definir requisitos mínimos.
$requiredExtensions = array(
	'pdo',
	'pdo_mysql',
	'curl',
	//'gd',
	//'dom',
	//'json',
	//'mbstring',
	//'zip',
	'xml',
	'xmlreader',
	'mysqli'
);

$minimumVersionCheck = [
	'php' => [
		'required' => '5.2.1',
		'recommended' => '8.0.0'
	],
	'mysql' => [
		'required' => '5.0.0',
		'recommended' => '5.6.2'
	]
];
$sth = $server->connection->getStatement("SELECT VERSION() AS mysql_version, CURRENT_USER() AS mysql_user");
$sth->execute();
$res = $sth->fetch();

$permissionsChecks = [
	FLUX_DATA_DIR.'/logs'		=> 'armazenamento de registros',
	FLUX_DATA_DIR.'/itemshop'	=> 'imagem da loja de itens',
	FLUX_DATA_DIR.'/tmp'		=> 'temporário'
];

if ($session->installerAuth) {
	if ($params->get('logout')) {
		$session->setInstallerAuthData(false);
	}
	else {
		$requiredMySqlVersion = '5.0';

		foreach (Flux::$loginAthenaGroupRegistry as $serverName => $loginAthenaGroup) {
			$sth = $loginAthenaGroup->connection->getStatement("SELECT VERSION() AS mysql_version, CURRENT_USER() AS mysql_user");
			$sth->execute();
			
			$res = $sth->fetch();
			if (!$res || version_compare($res->mysql_version, $requiredMySqlVersion, '<')) {
				$message  = "A versão do MySQL $requiredMySqlVersion ou superior é necessária para o Flux.";
				$message .= $res ? " Você está executando a versão {$res->mysql_version}" : "Você está executando uma versão desconhecida";
				$message .= " no servidor '$serverName'"; 
				throw new Flux_Error($message);
			}
		}
		
		if ($params->get('update_all')) {
			try {
				$installer->updateAll();
				if (!$installer->updateNeeded()) {
					$session->setMessageData('As atualizações foram instaladas.');
					$session->setInstallerAuthData(false);
					$this->redirect();
				}
			}
			catch (Flux_Installer_SchemaPermissionError $e) {
				$permissionError = $e;
			}
		}
		elseif (($username=$params->get('username')) && $username instanceOf Flux_Config &&
				($password=$params->get('password')) && $password instanceOf Flux_Config &&
				($update=$params->get('update')) && $update instanceOf Flux_Config) {
				
			$server64     = key($update->toArray());
			$username     = $username->get($server64);
			$password     = $password->get($server64);
			$serverName   = base64_decode($server64);
			$server       = array_key_exists($serverName, $installer->servers) ? $installer->servers[$serverName] : false;
			$updateNeeded = false;
			
			if ($server) {
				foreach ($server->schemas as $schema) {
					if (!$schema->isLatest()) {
						$updateNeeded = true;
						break;
					}
				}
				
				if (!$updateNeeded) {
					foreach ($server->charMapServers as $charMapServer) {
						foreach ($charMapServer->schemas as $schema) {
							if (!$schema->isLatest()) {
								$updateNeeded = true;
								break;
							}
						}
					}
				}
			}
			
			if (!$updateNeeded || !$server) {
				$errorMessage = 'Servidor inválido ou o servidor não possui atualizações.';
			}
			elseif (!$username || !$password) {
				$errorMessage = "Nome de usuário e senha são necessários para atualizações de servidores individuais.";
			}
			else {
				$connection = $server->loginAthenaGroup->connection;
				$connection->reconnectAs($username, $password);
				try {
					$server->updateAll();
					$session->setMessageData("As atualizações para $serverName foram instaladas.");
					$this->redirect();
				}
				catch (Flux_Installer_SchemaPermissionError $e) {
					$permissionError = $e;
				}
			}
		}
	}
}

if (count($_POST) && !$session->installerAuth) {
	$inputPassword  = $params->get('installer_password');
	$actualPassword = Flux::config('InstallerPassword');
	
	if ($inputPassword == $actualPassword) {
		$session->setInstallerAuthData(true);
	}
	else {
		$errorMessage = 'Senha Incorreta.';
	}
}
?>
