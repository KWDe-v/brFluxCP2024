<?php

//  Este é o arquivo de configuração da aplicação. 
//  Todos os valores foram definidos como padrão e devem ser alterados conforme necessário.

return [
	'ServerAddress'				=> 'brFluxRO',				//  Este valor é o hostname:port onde o Flux está rodando. (ex: example.com ou example.com:80)
	'BaseURI'					=> '',		//  O URI base é a raiz web base onde sua aplicação está localizada.
	'InstallerPassword'			=> 'secretpassword',		//  Senha do instalador/atualizador.
	'RequireOwnership'			=> true,					//  Requer que o usuário executante seja o dono do diretório FLUX_ROOT/data/? (Melhor para segurança)
															//  AVISO: Isso será quase IGONRADO em sistemas operacionais não compatíveis com POSIX (ex: Windows).
	'accesstoken'				=> 'SEU_ACESSTOKEN', // COLE SEU ACESSTOKEN DO MERCADO PAGO (OBRIGATÓRIO PARA FUNCIONAR)
	'url_notification_api'		=> 'https://SUA_URL/?module=mp&action=notification', // Padrão = SUA_URL/?module=mp&action=notification (OBRIGATÓRIO PARA FUNCIONAR)
	'notification_url_success'	=> 'https://SUA_URL/?module=donate&action=complete', // Padrão = SUA_URL/?module=donate&action=complete (OBRIGATÓRIO PARA FUNCIONAR)
	'notification_url_pending'	=> 'https://SUA_URL/?module=donate&action=pending',  // Padrão = SUA_URL/?module=donate&action=pending (OBRIGATÓRIO PARA FUNCIONAR)
	'notification_url_failure'	=> 'https://SUA_URL/?module=donate&action=failure',  // Padrão = SUA_URL/?module=donate&action=failure (OBRIGATÓRIO PARA FUNCIONAR)
	'MethodPaymentMP'			=> true, 					// Formas de Pagamentos do MercadoPago?, (true = PIX, false = PIX e CARTÃO)
	'GatePayment'				=> 2, 						// Gateways de Pagamentos, (0 = somente MercadoPago, 1 = Somente Paypal, 2 = Ambos)
	'DefaultLoginGroup'			=> null,
	'DefaultCharMapServer'		=> null,
	'DefaultLanguage'			=> '#pt_br',				//  Especifique o idioma padrão do painel de controle (veja o diretório FLUX_ROOT/lang/ para idiomas disponíveis.)
	'SiteTitle'					=> 'Painel de Controle Flux',	//  Este valor é usado apenas se o tema decidir usá-lo.
    'ThemeName'                 => ['default', 'bootstrap'],// Nomes dos temas que você gostaria de listar para uso no rodapé. Os temas estão em FLUX_ROOT/themes.
	'ScriptTimeLimit'			=> 0,						//  Limite de tempo de execução do script. Especifica (em segundos) quanto tempo uma página deve rodar antes de expirar. (0 significa para sempre)
	'LogoName'					=> 'logomail.png',			//  DIGITE O NOME DO ARQUIVO DA LOGO QUE VAI APARECECR NOS EMAILS (Padrão: logomail.png) (DIRETORIO: data/logomail.png)
	'MissingEmblemBMP'			=> 'empty.bmp',				//
	'ItemIconNameFormat'		=> '%d.png',				//  Formato caso não tenha nenhum arquivo na pasta data/items/icons (FORMATO ACEITO É PNG E BMP)(padrão é .png).
	'ItemImageNameFormat'		=> '%d.png',				//  Formato caso não tenha nenhum arquivo na pasta data/items/images (FORMATO ACEITO É PNG E BMP)(padrão é .png).
	'MonsterImageNameFormat'	=> '%d.gif',				//  Formato caso não tenha nenhum arquivo na pasta data/monsters (FORMATO ACEITO É PNG E GIF)(padrão é .gif).
	'JobImageNameFormat'		=> '%d.gif',				//  O formato do nome do arquivo para imagens de classes (padrão é {jobid}.gif).
	'DivinePrideIntegration'	=> true,					//  Baixar imagens de monstros e itens de https://www.divine-pride.net se não existirem.
	'ForceEmptyEmblem'			=> false,					//  Forçar a exibição de emblemas de guilda vazios, útil quando você não tem GD2 instalado.
	'EmblemCacheInterval'		=> 12,						//  Intervalo em horas para recarregar emblemas de guilda (defina como 0 para desativar o cache de emblemas).
	'EmblemUseWebservice'		=> true,					//  Carregar emblemas do WebService?
	'SessionCookieExpire'		=> 48,						//  Duração em horas.
	'AdminMenuGroupLevel'		=> AccountLevel::LOWGM,		//  O ID de grupo inicial para o qual as ações do módulo são movidas para o menu de administração para exibição.
	'DateDefaultTimezone'		=> 'UTC',					//  O fuso horário padrão, consulte o manual do PHP para fusos horários válidos: http://php.net/timezones (null para fuso horário do sistema)
	'DateFormat'				=> 'Y-m-d',					//  Formato de DATA padrão a ser exibido nas páginas.
	'DateTimeFormat'			=> 'Y-m-d H:i:s',			//  Formato de DATA e HORA padrão a ser exibido nas páginas.
	'ShowSinglePage'			=> true,					//  Exibir ou não os números da página, mesmo se houver apenas uma página.
	'ResultsPerPage'			=> 20,						//  O número de resultados a ser exibido em um conjunto paginado, por página.
	'PagesToShow'				=> 10,						//  O número de números de páginas a serem exibidos de uma vez.
	'PageJumpMinimumPages'		=> 1,						//  Número mínimo de páginas necessárias antes que a caixa de salto de página seja mostrada. (0 para sempre mostrar!)
	'ShowPageJump'				=> true,					//  Exibir ou não a caixa de "Salto de Página".
	'SingleMatchRedirect'		=> true,					//  Redirecionar ou não para a ação de visualização da página índice se apenas uma correspondência for retornada (e a ação for permitida).
	'SingleMatchRedirectItem'	=> false,					//  O mesmo que acima, para o módulo de itens.
	'SingleMatchRedirectMobs'	=> false,					//  O mesmo que acima, para o módulo de monstros.
	'UsernameAllowedChars'		=> 'a-zA-Z0-9_',			//  Padrão de Formato PCRE. padrão: 'a-zA-Z0-9_' (alfanumérico e sublinhado)
															//  AVISO: Esta string não é escapada, então tome cuidado com os caracteres que você usa!
															//  Referência de Padrão PCRE: http://php.net/manual/en/pcre.pattern.php
	'MinUsernameLength'			=> 4,						//  Comprimento mínimo do nome de usuário.
	'MaxUsernameLength'			=> 23,						//  Comprimento máximo do nome de usuário.
	'MinPasswordLength'			=> 8,						//  Comprimento mínimo da senha.
	'MaxPasswordLength'			=> 31,						//  Comprimento máximo da senha.
	'PasswordMinUpper'			=> 1,						//  Número de letras maiúsculas a serem exigidas nas senhas.
	'PasswordMinLower'			=> 1,						//  Número de letras minúsculas a serem exigidas nas senhas.
	'PasswordMinNumber'			=> 1,						//  Número de números a serem exigidos nas senhas.
	'PasswordMinSymbol'			=> 0,						//  Número de símbolos a serem exigidos nas senhas.
	'GMMinPasswordLength'		=> 8,						//  Comprimento mínimo da senha para contas GM.
	'GMPasswordMinUpper'		=> 1,						//  Número de letras maiúsculas a serem exigidas nas senhas para contas GM.
	'GMPasswordMinLower'		=> 1,						//  Número de letras minúsculas a serem exigidas nas senhas para contas GM.
	'GMPasswordMinNumber'		=> 1,						//  Número de números a serem exigidos nas senhas para contas GM.
	'GMPasswordMinSymbol'		=> 1,						//  Número de símbolos a serem exigidos nas senhas para contas GM.
	'RandomPasswordLength'		=> 16,						//  Este é o comprimento da senha aleatória gerada pelo recurso "Redefinir Senha". (NOTA: Valor mínimo codificado de 8)
	'AllowUserInPassword'		=> false,					//  Permitir ou não que a senha contenha o nome de usuário. (NOTA: É realizada uma busca insensível a maiúsculas e minúsculas)
	'AllowDuplicateEmails'		=> false,					//  Permitir ou não que e-mails duplicados sejam usados no registro. (Consulte as opções de configuração do Mailer)
	'RequireEmailConfirm'		=> false,					//  Exigir confirmação por e-mail durante o registro.
	'RequireChangeConfirm'		=> false,					//  Exigir confirmação ao alterar endereços de e-mail.
	'EmailConfirmExpire'		=> 48,						//  As confirmações por e-mail expiram em horas. Contas não confirmadas expirarão após este período de tempo.
	'PincodeEnabled'			=> true,					//  O sistema de pincode está habilitado no seu servidor? (Verifique seu arquivo char_athena.conf. Habilitado por padrão.)
	'MailerFromAddress'			=> 'noreply@localhost',		//  O endereço de e-mail exibido no campo De.
	'MailerFromName'			=> 'MailerName',			//  O nome exibido com o endereço de e-mail do De.
	'MailerUseSMTP'				=> false,					//  Usar ou não um servidor SMTP separado para enviar e-mails.
	'MailerSMTPUseSSL'			=> false,					//  O mailer deve conectar usando SSL (sim para GMail).
	'MailerSMTPUseTLS'			=> false,					//  O mesmo que a configuração SSL acima, mas para TLS. Esta configuração substituirá a configuração SSL.
	'MailerSMTPPort'			=> null,					//  Quando MailerUseSMTP for true: Porta do servidor SMTP (o mailer usará a porta 25 por padrão).
	'MailerSMTPHosts'			=> null,					//  Quando MailerUseSMTP for true: Uma string de host ou array de hosts (ex: 'host1' ou ['host1', 'backuphost')).
	'MailerSMTPUsername'		=> null,					//  Quando MailerUseSMTP for true: Nome de usuário autorizado para o servidor SMTP.
	'MailerSMTPPassword'		=> null,					//  Quando MailerUseSMTP for true: Senha autorizada para o servidor SMTP (para o usuário acima).
	'ServerStatusCache'			=> 2,						//  Armazenar um status de servidor em cache e atualizar a cada X minutos. Padrão: 2 minutos (valor é medido em minutos).
	'ServerStatusTimeout'		=> 2,						//  Para cada servidor, gastar X quantidade de segundos para determinar se está ativo ou não.
	'SessionKey'				=> 'fluxSessionData',		//  Não deve ser alterado, apenas especifica a chave de sessão a ser usada para dados de sessão.
	'DefaultModule'				=> 'main',					//  Este é o módulo a ser executado quando nenhum foi especificado.
	'DefaultAction'				=> 'index',					//  Esta é a ação padrão para qualquer módulo, provavelmente deve ser deixada sozinha. (Descontinuado)
	'GzipCompressOutput'		=> false,					//  Usar ou não compressão de saída usando zlib.
	'GzipCompressionLevel'		=> 9,						//  Nível de compressão zlib. (1~9)
	'OutputCleanHTML'			=> true,					//  Use isso se você tiver Tidy instalado para limpar sua saída HTML ao servir páginas.
	'ShowCopyright'				=> true,					//  Exibir ou não o rodapé de direitos autorais.
	'ShowRenderDetails'			=> true,					//  Mostra "página renderizada em X segundos" e "número de consultas executadas: X" no tema padrão.
	'UseCleanUrls'				=> false,					//  Defina como true se você estiver executando Apache e ele suportar mod_rewrite e arquivos .htaccess.
	'DebugMode'					=> false,					//  Defina como false para minimizar os detalhes técnicos exibidos pelo Flux. AVISO: NÃO USE ESTA OPÇÃO EM UM CP ACESSÍVEL PUBLICAMENTE.
	'UseCaptcha'				=> false,					//  Usar imagem CAPTCHA para registro de contas para evitar criações automatizadas de contas. (Requer GD2/FreeType2)
	'UseLoginCaptcha'			=> false,					//  Usar imagem CAPTCHA para logins de contas. (Requer GD2/FreeType2)
	'EnableReCaptcha'			=> false,					//  Habilitar o uso do reCAPTCHA em vez da biblioteca nativa GD2 do Flux (http://www.google.com/recaptcha)
	'ReCaptchaPublicKey'		=> '...',					//  Esta é a sua chave pública do reCAPTCHA [OBRIGATÓRIA PARA RECAPTCHA] (cadastre-se em http://www.google.com/recaptcha)
	'ReCaptchaPrivateKey'		=> '...',					//  Esta é a sua chave privada do reCAPTCHA [OBRIGATÓRIA PARA RECAPTCHA] (cadastre-se em http://www.google.com/recaptcha)
	'ReCaptchaTheme'			=> 'light',					//  Tema do ReCaptcha a ser usado (Valor: dark ou light) (veja: https://developers.google.com/recaptcha/docs/display#render_param)
	'DisplaySinglePages'		=> true,					//  Exibir ou não a paginação para resultados de uma única página.
	'ForwardYears'				=> 15,						//  (Visual) O número de anos a serem exibidos à frente do ano atual nas entradas de data.
	'BackwardYears'				=> 60,						//  (Visual) O número de anos a serem exibidos atrás do ano atual nas entradas de data.
	'ColumnSortAscending'		=> ' ▲',					//  (Visual) Texto exibido para nomes de colunas classificadas em ordem ascendente.
	'ColumnSortDescending'		=> ' ▼',					//  (Visual) Texto exibido para nomes de colunas classificadas em ordem descendente.
	'DisplayCashPoints'			=> true,					//  Exibir ou não "Pontos de Dinheiro" em vez de "Créditos" do jogador no painel de controle.
	'CreditExchangeRate'		=> 1.0,						//  A taxa na qual os créditos são trocados por reais.
	'MinDonationAmount'			=> 1.0,						//  Valor mínimo de doação. (NOTA: Doações reais feitas que são menores do que essa quantia não serão trocadas)
	'MaxDonationAmount'			=> 1000.0,					//  Valor Maxima de doação. 
	'DonationCurrency'			=> 'R$',					//  Moeda de doação preferida. Apenas doações feitas nesta moeda serão processadas para depósitos de crédito.
	'MoneyDecimalPlaces'		=> 2,						//  (Visual) Número de casas decimais a serem exibidas no valor.
	'MoneyThousandsSymbol'		=> ',',						//  (Visual) Separador de milhar (um ponto em moedas europeias).
	'MoneyDecimalSymbol'		=> '.',						//  (Visual) Separador decimal (uma vírgula em moedas europeias).
	'AcceptDonations'			=> true,					//  Aceitar ou não doações.
	'PayPalIpnUrl'				=> 'www.paypal.com',		//  Os endpoints ipnpb.paypal.com e ipnpb.sandbox.paypal.com aceitam apenas conexões HTTPS. Se você usa atualmente www.paypal.com, deverá mudar para ipnpb.paypal.com ao atualizar seu código para usar HTTPS.
	'PayPalBusinessEmail'		=> 'admin@localhost',		//  Insira o e-mail sob o qual você registrou sua conta comercial.
	'PayPalReceiverEmails'		=> [					//  Estes são os endereços de e-mail de recebedores que estão autorizados a receber pagamento.
		//'admin2@localhost',								// 'admin2@localhost',                               // -- Este array pode estar vazio se você usar apenas um e-mail
		//'admin3@localhost'								// 'admin3@localhost'                                // -- porque seu E-mail Comercial também é verificado.
	],
	'PaypalHackNotify'          => true,                    //  Enviar notificação por e-mail se uma tentativa de hack for detectada (A notificação será enviada para cada endereço na lista PayPalBusinessEmail e PayPalReceiverEmails)
	'PayPalAllowedHosts'        => [					//  Lista de IPs do PayPal https://www.paypal.com/fm/smarthelp/article/what-are-the-ip-addresses-for-live-paypal-servers-ts1056
		'ipn.sandbox.paypal.com',
		'notify.paypal.com',
		'66.211.170.66',
		'173.0.81.1',
		'173.0.81.0/24',
		'173.0.81.33',
		'173.0.81.65',
		'173.0.81.140',
		'64.4.240.0/21',
		'64.4.248.0/22',
		'6.211.168.0/22',
		'173.0.80.0/20',
		'91.243.72.0/23'
	],
	'GStorageLeaderOnly'		=> false,					//  Permitir apenas o líder da guilda visualizar o armazenamento da guilda em vez de todos os membros?
	'DivorceKeepChild'			=> false,					//  Manter a criança após o divórcio?
	'DivorceKeepRings'			=> false,					//  Manter os anéis de casamento após o divórcio?
	'IpWhitelistPattern'		=>							//  Padrão de Formato PCRE. É recomendável adicionar IPs do servidor de jogos, servidor web e do proprietário do servidor aqui.
		'(127\.0\.0\.1|0(\.[0\*]){3})',						//  AVISO: Esta string não é escapada, então tome cuidado com os caracteres que você usa!
															//  Por padrão, permite 127.0.0.1 (localhost) e 0.0.0.0 (todas as interfaces; permite todos os bans curinga que podem alcançar isso também)
	'AllowIpBanLogin'			=> false,					//  Permitir login na conta a partir de IPs banidos.
	'AllowTempBanLogin'			=> false,					//  Permitir login de contas temporariamente banidas.
	'AllowPermBanLogin'			=> false,					//  Permitir login de contas permanentemente banidas.
	'AutoRemoveTempBans'		=> true,					//  Remover automaticamente bans temporários expirados em certas páginas.
	'ItemShopMaxCost'			=> 99,						//  Preço máximo que um item pode ser vendido.
	'ItemShopMaxQuantity'		=> 99,						//  Quantidade máxima que o item pode ser vendido de uma vez.
	'ItemShopItemPerPage'		=> 5,						//  Número de itens a serem exibidos por página na página "Item Shop".
    'ShowItemDesc'              => false,                   //  Exibir descrições de itens geradas a partir do itemInfo.lua analisado
	'HideFromWhosOnline'		=> AccountLevel::LOWGM,		//  Níveis maiores ou iguais a este serão ocultados da página "Quem está online".
	'HideFromMapStats'			=> AccountLevel::LOWGM,		//  Níveis maiores ou iguais a este serão ocultados da página "Estatísticas do Mapa".
	'EnableGMPassSecurity'		=> AccountLevel::LOWGM,		//  Níveis maiores ou iguais a este serão obrigados a usar senhas que atendam às configurações de Senha GM anteriores.
	'ChargeGenderChange'		=> 0,						//  Você pode especificar isso como o número de créditos a serem cobrados por mudança de gênero. Pode ser 0 para mudança gratuita.
	'BanPaymentStatuses'		=> [					//  Status de pagamento que banirão automaticamente o proprietário da conta se recebidos.
		'Cancelled_Reversal',								//  -- 'Cancelled_Reversal'
		'Reversed',											//  -- 'Reversed'
	],

	'HoldUntrustedAccount'		=> 0,						//  Este é o tempo em horas para segurar um processo de crédito de doação, se a conta
															//  não for uma conta confiável. Especifique 0 ou false para desativar este recurso.

	'AutoUnholdAccount'			=> false,					//  Ative isso para liberar automaticamente uma conta e creditar se a transação ainda
															//  for válida. Isso só se aplica se você estiver usando o recurso HoldUntrustedAccount.
															//  Se você deseja executar uma tarefa cron em vez disso, você pode fazer uma solicitação ao módulo/ação '/donate/update'
															//  com a InstallerPassword como a senha para executar a tarefa de atualização.
															//  Com URLs limpas: http://<server>/<baseURI>/donate/update?password=<InstallerPassword>
															//  Sem URLs limpas: http://<server>/<baseURI>?module=donate&action=update&password=<InstallerPassword>
															//  NOTA: Esta opção é ALTAMENTE ineficiente, é recomendável executar uma tarefa cron em vez disso.

	'AutoPruneAccounts'			=> false,					//  Ative isso para podar automaticamente contas expiradas. Ativar isso é um desempenho
															//  matador de performance. Veja 'AutoUnholdAccount' para executar esta tarefa como uma tarefa cron,
															//  o módulo é 'account' e a ação é 'prune'.
															//  Com URLs limpas: http://<server>/<baseURI>/conta/prune?password=<InstallerPassword>
															//  Sem URLs limpas: http://<server>/<baseURI>?module=conta&action=prune&password=<InstallerPassword>

	'ShopImageExtensions'		=> [					//  Estas são as extensões de imagem permitidas para upload na loja de itens.
		'png', 'jpg', 'gif', 'bmp', 'jpeg'
	],


	'NoResetPassGroupLevel'		=> AccountLevel::LOWGM,		//  Nível mínimo do grupo da conta para impedir a redefinição de senha usando o painel de controle.

	'CharRankingLimit'			=> 20,						//  Limite de classificação de personagens.
	'GuildRankingLimit'			=> 20,						//  Limite de classificação de guildas.
	'ZenyRankingLimit'			=> 20,						//  Limite de classificação de zeny.
	'DeathRankingLimit'			=> 20,						//  Limite de classificação de mortes.
	'AlchemistRankingLimit'		=> 20,						//  Limite de classificação de alquimistas.
	'BlacksmithRankingLimit'	=> 20,						//  Limite de classificação de ferreiros.
	'HomunRankingLimit'			=> 20,						//  Limite de classificação de homúnculos.
	'MVPRankingLimit'			=> 20,						//  Limite de classificação de MVP.

	'RankingHideGroupLevel'		=> AccountLevel::LOWGM,		//  Nível mínimo do grupo para ocultar da classificação.
	'InfoHideZenyGroupLevel'	=> AccountLevel::LOWGM,		//  Nível mínimo do grupo da conta para ocultar zeny na página de informações do servidor.

	'CharRankingThreshold'		=> 0,						//  Número de dias em que o personagem deve ter logado para ser listado na classificação de personagens. (0 = desativado)
	'ZenyRankingThreshold'		=> 0,						//  Número de dias em que o personagem deve ter logado para ser listado na classificação de zeny. (0 = desativado)
	'DeathRankingThreshold'		=> 0,						//  Número de dias em que o personagem deve ter logado para ser listado na classificação de mortes. (0 = desativado)
	'AlchemistRankingThreshold'	=> 0,						//  Número de dias em que o personagem deve ter logado para ser listado na classificação de alquimistas. (0 = desativado)
	'HomunRankingThreshold'		=> 0,						//  Número de dias em que o personagem deve ter logado para ser listado na classificação de homúnculos. (0 = desativado)

	'HideTempBannedCharRank'	=> false,					//  Ocultar personagens temporariamente banidos da classificação.
	'HidePermBannedCharRank'	=> true,					//  Ocultar personagens permanentemente banidos da classificação.

	'HideTempBannedZenyRank'	=> false,					//  Ocultar personagens temporariamente banidos da classificação de zeny.
	'HidePermBannedZenyRank'	=> true,					//  Ocultar personagens permanentemente banidos da classificação de zeny.

	'HideTempBannedDeathRank'	=> false,					//  Ocultar personagens temporariamente banidos da classificação de mortes.
	'HidePermBannedDeathRank'	=> true,					//  Ocultar personagens permanentemente banidos da classificação de mortes.

	'HideTempBannedAlcheRank'	=> false,					//  Ocultar personagens temporariamente banidos da classificação de alquimistas.
	'HidePermBannedAlcheRank'	=> true,					//  Ocultar personagens permanentemente banidos da classificação de alquimistas.

	'HideTempBannedSmithRank'	=> false,					//  Ocultar personagens temporariamente banidos da classificação de ferreiros.
	'HidePermBannedSmithRank'	=> true,					//  Ocultar personagens permanentemente banidos da classificação de ferreiros.

	'HideTempBannedStats'		=> false,					//  Ocultar contas temporariamente banidas das estatísticas.
	'HidePermBannedStats'		=> true,					//  Ocultar contas permanentemente banidas das estatísticas.

	'HideTempBannedHomunRank'	=> false,					//  Ocultar personagens temporariamente banidos da classificação de homúnculos.
	'HidePermBannedHomunRank'	=> true,					//  Ocultar personagens permanentemente banidos da classificação de homúnculos.

	'SortJobsByAmount'			=> false,					//  Classificar informações de classes na página de estatísticas por quantidade decrescente (false = Classificar por ID de Classe).

	'CpLoginLogShowPassword'	=> false,					//  Mostrar senha no log de login do CP (consulte também SeeCpLoginLogPass em access.php).

	'CpResetLogShowPassword'	=> false,					//  Mostrar senha no log de "redefinições de senha" do CP (consulte também SeeCpResetPass em access.php).

	'CpChangeLogShowPassword'	=> false,					//  Mostrar senha no log de "mudanças de senha" do CP (consulte também SeeCpChangePass em access.php).

	'AdminMenuNewStyle'			=> true,					//  Usar novo estilo de menu de administração; Aplica-se ao tema 'default'.
	'EnablePeakDisplay'			=> true,					//  Exibir contagem de usuários máximos na página de Status do Servidor.


//  Opções de Notícias
	'CMSNewsOnHomepage'			=> true,					//  Exibir Notícias na Página Inicial em vez da mensagem "Você acabou de instalar o FluxCP"?
	'CMSNewsType'				=> 1,						//  Tipo = origem do feed de notícias:
															//	1 = Built-in news page
															//	2 = RSS Import

	'CMSNewsRSS'				=> 'https://rathena.org/board/rss/1-latest-community-announcements.xml/',		//  Usar se CMSNewsType = 2
	'CMSNewsLimit'				=> 4,						//  Número de itens de notícias para exibir
	'CMSDisplayModifiedBy'		=> false,					//  Se um item de notícia foi modificado, exibir a data modificada abaixo do item de notícia?

//  Mesa de Serviço
	'StaffReplyColour'			=> 'white',
	'FontResolvedColour'		=> 'green',
	'FontPendingColour'			=> 'orange',
	'FontClosedColour'			=> 'darkgrey',
	'SDEnableCreditRewards'		=> true,					//  Mostrar opção na Mesa de Serviço para recompensar o jogador X créditos por relatar bugs/abuso/etc.
	'SDCreditReward'			=> 10,						//  Número de créditos para conceder à conta.

//  Webhooks do Discord
	'DiscordUseWebhook'			=> false,
	'DiscordWebhookURL'			=> 'enter_webhook_url_from_discord_here',
    'DiscordSendOnRegister'     => true, //  Envia uma mensagem no canal quando alguém se registra
    'DiscordSendOnNewTicket'    => true, //  Envia uma mensagem no canal quando alguém envia um novo ticket para a Mesa de Serviço
    'DiscordSendOnWebCommand'   => true, //  Envia uma mensagem no canal quando alguém usa o recurso de Comando Web no FluxCP
    'DiscordSendOnMarketing'    => true, //  Envia uma mensagem no canal quando alguém usa o recurso de Enviar Email no FluxCP
	'DiscordSendOnErrorException' => true, //  Envia uma mensagem no canal quando uma exceção é lançada

	'TinyMCEKey'				=> 'no-key',				//  Registre uma chave em https://www.tiny.cloud/my-account/dashboard/

	//  Estes são os itens de menu principal que devem ser exibidos pelos temas.
	//  Eles roteiam para módulos e ações. Se eles são exibidos ou não em um determinado momento
	//  depende do nível do grupo da conta do usuário e/ou
	//  seu status de login.
	'MenuItems'		=> [
		'MainMenuLabel'		=> [
			'HomeLabel'			=> ['module' => 'main'],
			//'ForumLabel'		=> ['exturl' => 'http://www.fluxro.com/community'],	//  Link externo para o fórum
			//'ForumLabel'		=> ['module' => 'forums'], 						//  Link para fórum incorporado
			'NewsLabel'			=> ['module' => 'news'],
			//  Itens de exemplo para a função de páginas.
			'DownloadsLabel'		=> ['module' => 'downloads'],
			'RulesLabel'			=> ['module' => 'rules'],
			//  Fim dos itens de exemplo para a função de páginas.
		],
		'AccountLabel'		=> [
			'AccountCreateHeading'		=> ['module' => 'account', 'action' => 'create'],
			'LoginTitle'			=> ['module' => 'account', 'action' => 'login'],
			'MyAccountLabel'	=> ['module' => 'account', 'action' => 'view'],
			'HistoryLabel'		=> ['module' => 'history'],
			'ServiceDeskLabel'	=> ['module' => 'servicedesk'],
			'LogoutTitle'		=> ['module' => 'account', 'action' => 'logout'],
		],
		'DonationsLabel'		=> [
			'PurchaseLabel'		=> ['module' => 'purchase'],
			'DonateLabel'		=> ['module' => 'donate'],
		],
		'InformationLabel'	=> [
			'ServerInfoLabel'	=> ['module' => 'server', 'action' => 'info'],
			'ServerStatusLabel'	=> ['module' => 'server', 'action' => 'status'],
			'WoeHoursLabel'		=> ['module' => 'woe'],
			'CastlesLabel'		=> ['module' => 'castle'],
			'WhosOnlineLabel'	=> ['module' => 'character', 'action' => 'online'],
			'MapStaticsLabel'=> ['module' => 'character', 'action' => 'mapstats'],
			'RankingInfoLabel'	=> ['module' => 'ranking', 'action' => 'character'],
			'VendingInfoLabel'	=> ['module' => 'vending'],
			'BuyingstoreInfoLabel'	=> ['module' => 'buyingstore'],
		],
		'DatabaseLabel'		=> [
			'ItemDatabaseLabel'	=> ['module' => 'item'],
			'MobDatabaseLabel'	=> ['module' => 'monster'],
		],
		'SocialLabel'		=> [
			'JoinUsInFacebookLabel'	=> ['exturl' => 'https://www.facebook.com/<change_me>'],
			'RateUsOnRMSLabel'		=> ['exturl' => '<link_to_RMS>'],
		],
		'Service Desk'	=> [
			'ServiceDeskLabel'	=> ['module' => 'servicedesk', 'action' => 'staffindex'],
		],
		'Misc. Stuff'	=> [
			'AccountLabel'		=> ['module' => 'account'],
			'CharacterLabel'	=> ['module' => 'character'],
			'CPLogsLabel'		=> ['module' => 'cplog'],
			'PagesLabel'		=> ['module' => 'pages'],
			'NewsLabel'			=> ['module' => 'news', 'action' => 'manage'],
			'GuildsLabel'		=> ['module' => 'guild'],
			'IPBanListLabel'	=> ['module' => 'ipban'],
			'rALogsLabel'		=> ['module' => 'logdata'],
			'ReInstallLabel'	=> ['module' => 'install', 'action' => 'reinstall'],
			'SendMailLabel'		=> ['module' => 'mail'],
			'WCTitleLabel'		=> ['module' => 'webcommands'],
			'Cash Shop'			=> ['module' => 'cashshop'],
			//'Auction'		=> ['module' => 'auction'],
			//'Economy'		=> ['module' => 'economy']
		]
	],

	//  Itens de sub-menu que são exibidos para qualquer ação pertencente a um
	//  módulo específico. O formato é simples.
	'SubMenuItems' => [
    'history' => [
        'gamelogin'     => 'Logins no Jogo',
        'cplogin'       => 'Logins no CP',
        'emailchange'   => 'Mudanças de E-mail',
        'passchange'    => 'Mudanças de Senha',
        'passreset'     => 'Redefinições de Senha'
    ],
    'account' => [
        'index'         => 'Listar Contas',
        'view'          => 'Visualizar Conta',
        'changepass'    => 'Mudar Senha',
        'changemail'    => 'Mudar E-mail',
        'changesex'     => 'Mudar Gênero',
        'transfer'      => 'Transferir Créditos',
        'xferlog'       => 'Histórico de Transferências de Créditos',
        'cart'          => 'Ir ao Carrinho de Compras',
        'login'         => 'Entrar',
        'create'        => 'Registrar',
        'resetpass'     => 'Redefinir Senha',
        'resend'        => 'Reenviar Confirmação de E-mail'
    ],
    'guild' => [
        'index'         => 'Listar Guildas',
        'export'        => 'Exportar Emblemas de Guildas'
    ],
    'server' => [
        'status'        => 'Ver Status',
        'status-xml'    => 'Ver Status como XML'
    ],
    'logdata' => [
        'branch'        => 'Branches',
        'char'          => 'Personagens',
        'cashpoints'    => 'Pontos de Dinheiro',
        'chat'          => 'Mensagens de Chat',
        'command'       => 'Comandos',
        'feeding'       => 'Alimentação',
        'inter'         => 'Interações',
        'pick'          => 'Drop de Itens',
        'login'         => 'Logins',
        'mvp'           => 'MVP',
        'npc'           => 'NPC',
        'zeny'          => 'Zeny'
    ],
    'cplog' => [
        'paypal'        => 'Transações PayPal',
        'create'        => 'Registros de Contas',
        'login'         => 'Logins',
        'resetpass'     => 'Redefinições de Senha',
        'changepass'    => 'Mudanças de Senha',
        'changemail'    => 'Mudanças de E-mail',
        'ban'           => 'Banimentos de Conta',
        'ipban'         => 'Banimentos de IP'
    ],
    'purchase' => [
        'index'         => 'Loja',
        'cart'          => 'Ir ao Carrinho',
        'checkout'      => 'Finalizar Compra',
        'clear'         => 'Esvaziar Carrinho',
        'pending'       => 'Resgates Pendentes'
    ],
    'donate' => [
        'index'         => 'Fazer uma Doação',
        'history'       => 'Histórico de Doações',
        'trusted'       => 'E-mails do PayPal Confiáveis'
    ],
    'ipban' => [
        'index'         => 'Lista de Banimentos de IP',
        'add'           => 'Adicionar Banimento de IP'
    ],
    'ranking' => [
        'character'     => 'Personagens',
        'death'         => 'Mortes',
        'alchemist'     => 'Alquimistas',
        'blacksmith'    => 'Ferreiros',
        'homunculus'    => 'Homunculus',
        'mvp'           => 'MVPs',
        'guild'         => 'Guildas',
        'zeny'          => 'Zeny'
    ],
    'item' => [
        'index'         => 'Listar Itens',
        'iteminfo'      => 'Adicionar Informações de Item',
    ],
    'pages' => [
        'index'         => 'Gerenciar Páginas',
        'add'           => 'Adicionar Nova Página',
    ],
    'news' => [
        'index'         => 'Últimas Notícias',
        'manage'        => 'Gerenciar',
        'add'           => 'Adicionar Notícia',
    ],
    'servicedesk' => [
        'staffindex'    => 'Ver Ativos',
        'staffviewclosed'=> 'Ver Fechados',
        'staffsettings' => 'Configurações da Equipe',
        'catcontrol'    => 'Controle de Categorias',
    ],
    'vending' => [
        'index'         => 'Vendedores',
    ],
    'buyingstore' => [
        'index'         => 'Compradores',
    ],
],


	'AllowMD5PasswordSearch'		=> false,
	'ReallyAllowMD5PasswordSearch'	=> false, //  Você está POSITIVAMENTE certo?

	//  Especifica quais módulos e ações devem ser ignorados pelo Tidy
	//  (ativado/desativado pela opção OutputCleanHTML).
	'TidyIgnore'	=> [
		['module' => 'captcha'],
		['module' => 'guild', 'action' => 'emblem']
	],

	//  Classes, carregadas de outro arquivo para evitar bagunçar este.
	//  Normalmente não há necessidade de modificar este arquivo, a menos que tenha sido
	//  modificado em uma atualização. (Em inglês: NÃO TOQUE NISSO.)
	'JobClasses'					=> include('jobs.php'),

	//  Classes de trabalho de Alquimista, usadas principalmente para rankings de alquimistas.
	//  Deve ser deixado sozinho, a menos que novas classes de trabalho relacionadas a alquimistas sejam introduzidas.
	'AlchemistJobClasses'			=> include('jobs_alchemist.php'),

	//  Classes de trabalho de Ferreiro, usadas principalmente para rankings de ferreiros.
	//  Deve ser deixado sozinho, a menos que novas classes de trabalho relacionadas a ferreiros sejam introduzidas.
	'BlacksmithJobClasses'			=> include('jobs_blacksmith.php'),

	//  IDs de classe de trabalho vinculados ao gênero e seus nomes correspondentes.
	//  Deve ser deixado sozinho, a menos que novas classes de trabalho específicas de gênero sejam introduzidas.
	'GenderLinkedJobClasses'		=> include('jobs_gender_linked.php'),

	//  IDs de classe de Homúnculo e seus nomes correspondentes.
	//  Melhor não mexer nisso também.
	'HomunClasses'					=> include('homunculus.php'),

	//  Tipos de item com seus nomes correspondentes.
	//  Também não deve mexer nisso.
	'ItemTypes'						=> include('itemtypes.php'),

	//  Subtipos de item com seus nomes correspondentes.
	//  Também não deve mexer nisso.
	'ItemSubTypes'					=> include('itemsubtypes.php'),

	//  Combinações comuns de localização de equipamento com seus nomes correspondentes.
	//  Não deve mexer nisso a menos que tenha adicionado combinações personalizadas.
	'EquipLocationCombinations'		=> include('equip_location_combinations.php'),

	//  Mapeamento de código de erro -> tipo de erro.
	//  Não deve precisar mexer nisso, no entanto, modificar loginerrors.php deve ser relativamente seguro.
	'LoginErrors'					=> include('loginerrors.php'),

	//  Mapeamento de classes de equipamento rA.
	'EquipJobs'						=> include('equip_jobs.php'),

	//  Mapeamento de locais de equipamento rA.
	'EquipLocations'				=> include('equip_locations.php'),

	//  Mapeamento de equipamento superior rA.
	'EquipUpper'					=> include('equip_upper.php'),

	//  Mapeamento de tamanhos de monstros rA.
	'MonsterSizes'					=> include('sizes.php'),

	//  Mapeamento de raças de monstros rA.
	'MonsterRaces'					=> include('races.php'),

	//  Mapeamento de elementos rA.
	'Elements'						=> include('elements.php'),

	//  Mapeamento de atributos rA.
	'Attributes'					=> include('attributes.php'),

	//  Mapeamento de modos de monstros rA.
	'MonsterModes'					=> include('monstermode.php'),
	'MonsterAI'						=> include('monster_ai.php'),

	//  Categorias de loja de itens.
	'ShopCategories'				=> include('shopcategories.php'),

	//  Categorias de loja de Cash.
	'CashShopCategories'			=> include('cashshopcategories.php'),

	//  Tipos de log de coleta de itens e zeny.
	'PickTypes'						=> include('picktypes.php'),

	//  Tipos de alimentação
	'FeedingTypes'					=> include('feedingtypes.php'),

	//  Nomes de castelos.
	'CastleNames'					=> include('castlenames.php'),

	//  Restrições de comércio.
	'TradeRestriction'				=> include('trade_restrictions.php'),

	//  Flags de item.
	'ItemFlags'						=> include('itemsflags.php'),

	//  Opções aleatórias de item.
	'RandomOptions'					=> include('item_randoptions.php'),

	//  NÃO TOQUE. ISSO É PARA DESENVOLVEDORES.
	'FluxTables'		=> [
		'CreditsTable'			=> 'cp_credits',
		'CreditTransferTable'	=> 'cp_xferlog',
		'ItemShopTable'			=> 'cp_itemshop',
		'TransactionTable'		=> 'cp_txnlog',
		'RedemptionTable'		=> 'cp_redeemlog',
		'AccountCreateTable'	=> 'cp_createlog',
		'AccountBanTable'		=> 'cp_banlog',
		'IpBanTable'			=> 'cp_ipbanlog',
		'DonationTrustTable'	=> 'cp_trusted',
		'AccountPrefsTable'		=> 'cp_loginprefs',
		'CharacterPrefsTable'	=> 'cp_charprefs',
		'ResetPasswordTable'	=> 'cp_resetpass',
		'ChangeEmailTable'		=> 'cp_emailchange',
		'LoginLogTable'			=> 'cp_loginlog',
		'ChangePasswordTable'	=> 'cp_pwchange',
		'OnlinePeakTable'		=> 'cp_onlinepeak',
		'CMSNewsTable'			=> 'cp_cmsnews',
		'CMSPagesTable'			=> 'cp_cmspages',
		'CMSSettingsTable'		=> 'cp_cmssettings',
		'ServiceDeskTable'		=> 'cp_servicedesk',
		'ServiceDeskATable'		=> 'cp_servicedeska',
		'ServiceDeskCatTable'	=> 'cp_servicedeskcat',
		'ServiceDeskSettingsTable'	=> 'cp_servicedesksettings',
		'WebCommandsTable'		=> 'cp_commands',
        'ItemDescTable'     	=> 'cp_itemdesc',
	]
];
?>
