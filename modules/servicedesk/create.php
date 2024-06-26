<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
$tbl = Flux::config('FluxTables.ServiceDeskTable'); 
$tblcat = Flux::config('FluxTables.ServiceDeskCatTable'); 
$tblsettings = Flux::config('FluxTables.ServiceDeskSettingsTable'); 

$charsql = $server->connection->getStatement("SELECT * FROM {$server->charMapDatabase}.char WHERE account_id = ?");
$charsql->execute(array($session->account->account_id));
$charlist = $charsql->fetchAll();
$charselect=NULL;
if(!$charlist){
	$charselect='<option value="-1">Nenhum personagens disponível</option>';
} else {
	$charselect='<option value="0">Todos os personagens</option>';
	foreach($charlist as $char){$charselect.='<option value="'. $char->char_id .'">'. $char->name .'</option>';}
}

$catsql = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.$tblcat WHERE display = 1");
$catsql->execute();
$catlist = $catsql->fetchAll();

if(isset($_POST['account_id'])){
	$char_id	= intval($_POST['char_id']);
	$category	= intval($_POST['category']);
	$subject	= htmlentities($_POST['subject']);
	$text	= htmlentities($_POST['text']);
	$ip	= $_POST['ip'];
	if($_POST['sslink']==NULL || $_POST['sslink']==''){$_POST['sslink'] = '0';}else{$_POST['sslink'] = htmlentities($_POST['sslink']);}
	if($_POST['chatlink']==NULL || $_POST['chatlink']==''){$_POST['chatlink'] = '0';}else{$_POST['chatlink'] = htmlentities($_POST['chatlink']);}
	if($_POST['videolink']==NULL || $_POST['videolink']==''){$_POST['videolink'] = '0';}else{$_POST['videolink'] = htmlentities($_POST['videolink']);}

	$sql = "INSERT INTO {$server->loginDatabase}.$tbl (account_id, char_id, category, sslink, chatlink, videolink, subject, text, ip, curemail, lastreply)";
	$sql .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";
	$sth = $server->connection->getStatement($sql);
	$sth->execute(array($_POST['account_id'], $char_id, $category, $_POST['sslink'], $_POST['chatlink'], $_POST['videolink'], $subject, $text, $ip, $session->account->email)); 

	if(Flux::config('DiscordUseWebhook')) {
		if(Flux::config('DiscordSendOnNewTicket')) {
			sendtodiscord(Flux::config('DiscordWebhookURL'), 'Novo Ticket Aberto: '. $subject);
		}
	}
	
	// Send email to all staff with enable email setting.
	$sth = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.$tblsettings WHERE emailalerts = 1");
	$sth->execute();
	$staff = $sth->fetchAll();
	if($staff){
		foreach($staff as $staffrow){
			$catsql = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.$tblcat WHERE cat_id = ?");
			$catsql->execute(array($category));
			$catlist = $catsql->fetch();
			$stsql = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.login WHERE account_id = ?");
			$stsql->execute(array($staffrow->account_id));
			$stlist = $stsql->fetch();
			$email = $stlist->email;
			
			require_once 'Flux/Mailer.php';
			$name = $session->loginAthenaGroup->serverName;
			$mail = new Flux_Mailer();
			$link = $this->url('servicedesk', 'staffindex', array('_host' => true));
			$sent = $mail->send($email, 'Novo Ticket Aberto', 'newticket', array(
				'Category'		=> $catlist->name,
				'Subject'		=> $subject,
				'Text'			=> $text,
				'ViewTicket'	=> htmlspecialchars($link)
			));
		}
	}
	$this->redirect($this->url('servicedesk','index'));
}
?>
