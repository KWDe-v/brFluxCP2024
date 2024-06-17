<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

// Obter e sanitizar os parâmetros
$ticket_id = trim($params->get('ticketid'));
$updateID = trim($params->get('update'));

// Configurações de tabelas
$tbla = Flux::config('FluxTables.ServiceDeskATable');
$tbl = Flux::config('FluxTables.ServiceDeskTable');
$tblcat = Flux::config('FluxTables.ServiceDeskCatTable');
$tblsettings = Flux::config('FluxTables.ServiceDeskSettingsTable');

if(isset($_POST['postreply']) && $_POST['postreply'] == 'gogolol'){
	if($_POST['secact']=='2'){
		// Validar resposta
		if(empty($_POST['response']) || $_POST['response'] === 'Deixe como está para pular a resposta de texto.') {
			$session->setMessageData(Flux::message('SDNoBlankResponse'));
			$this->redirect($this->url('servicedesk', 'view', array('ticketid' => $ticket_id)));
		} else {
			$text = htmlentities($_POST['response']);
			
			// Inserir resposta no banco de dados
			$sql = "INSERT INTO {$server->loginDatabase}.$tbla (ticket_id, author, text, action, ip, isstaff)";
			$sql .= " VALUES (?, ?, ?, 0, ?, 0)";
			$sth = $server->connection->getStatement($sql);
			$sth->execute(array($ticket_id, $session->account->userid, $text, $_SERVER['REMOTE_ADDR'])); 
			
			// Atualizar último reply no ticket
			$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET lastreply = 'Player' WHERE ticket_id = ?");
			$sth->execute(array($ticket_id));
			
			// Enviar email para todos os staffs com alertas ativados
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
					$link = $this->url('servicedesk', 'staffview', array('_host' => true, 'ticketid' => $ticket_id));
					
					$sent = $mail->send($email, 'Resposta de Jogador', 'ticketreplystaff', array(
						'Player'   => $session->account->userid,
						'TicketID'    => $ticket_id, // Verifique a definição de $subject
						'ViewID'       => $ticket_id,
						'ViewTicket' => htmlspecialchars($link)
					));
				}
			}
			
			// Redirecionar para a página inicial do servicedesk após o processamento
			$this->redirect($this->url('servicedesk', 'index'));
		}
		
	}elseif($_POST['secact']=='3'){
		$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET status = 'Resolved' WHERE ticket_id = ?");
		$sth->execute(array($ticket_id)); 
		
		if($_POST['response']=='Deixe como está para pular a resposta de texto.' || $_POST['response'] == '' || $_POST['response'] == NULL || !isset($_POST['response'])){
			$text = '0';
		} else {
			$text = htmlentities($_POST['response']);
		}
		$action='Jogador marcou ticket como Resolvido';
		$sql = "INSERT INTO {$server->loginDatabase}.$tbla (ticket_id, author, text, action, ip, isstaff)";
		$sql .= "VALUES (?, ?, ?, ?, ?, 0)";
		$sth = $server->connection->getStatement($sql);
		$sth->execute(array($ticket_id, $session->account->userid, $text, $action, $_SERVER['REMOTE_ADDR'])); 
		$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET lastreply = 'Player' WHERE ticket_id = ?");
		$sth->execute(array($ticket_id)); 
		
		
		
		
		
		
					// Enviar email para todos os staffs com alertas ativados
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
					$link = $this->url('servicedesk', 'staffview', array('_host' => true, 'ticketid' => $ticket_id));
					
					$sent = $mail->send($email, 'Ticket Fechado Pelo Jogador', 'ticketfechadostaff', array(
						'Player'   => $session->account->userid,
						'TicketID'    => $ticket_id, // Verifique a definição de $subject
						'ViewID'       => $ticket_id,
						'ViewTicket' => htmlspecialchars($link)
					));
				}
			}
			
			// Redirecionar para a página inicial do servicedesk após o processamento
			$this->redirect($this->url('servicedesk', 'index'));
		

		
	}elseif($_POST['secact']=='6'){
		$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET status = 'Pending' WHERE ticket_id = ?");
		$sth->execute(array($ticket_id)); 
		
		if($_POST['response']=='Deixe como está para pular a resposta de texto.' || $_POST['response'] == '' || $_POST['response'] == NULL || !isset($_POST['response'])){
			$text = '0';
		} else {
			$text = htmlentities($_POST['response']);
		}
		$sql = "INSERT INTO {$server->loginDatabase}.$tbla (ticket_id, author, text, action, ip, isstaff)";
		$sql .= "VALUES (?, ?, ?, ?, ?, 0)";
		$sth = $server->connection->getStatement($sql);
		$sth->execute(array($ticket_id, $session->account->userid, $text, Flux::message('SDReOpenPlayer'), $_SERVER['REMOTE_ADDR'])); 
		$sth = $server->connection->getStatement("UPDATE {$server->loginDatabase}.$tbl SET lastreply = 'Player' WHERE ticket_id = ?");
		$sth->execute(array($ticket_id)); 
		$this->redirect($this->url('servicedesk','index'));
	}
}
$rep = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.$tbl WHERE ticket_id = ? and account_id = ?");
$rep->execute(array($ticket_id, $session->account->account_id));
$ticketlist = $rep->fetchAll();
if($ticketlist) {
    foreach($ticketlist as $trow) {
		$chid=$trow->char_id;
		$sql = "SELECT * FROM {$server->charMapDatabase}.char WHERE char_id = ? and account_id = ?";
		$ch = $server->connection->getStatement($sql);
		$ch->execute(array($chid, $session->account->account_id));
		$chr = $ch->fetchAll();
		foreach($chr as $char) {
		}
	}
} else {
    $this->redirect($this->url('servicedesk','index'));
}

$repr = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.$tbla WHERE ticket_id = ?");
$repr->execute(array($ticket_id));
$replylist = $repr->fetchAll();

$tblc = Flux::config('FluxTables.ServiceDeskCatTable'); 
$sth  = $server->connection->getStatement("SELECT name FROM {$server->loginDatabase}.$tblc WHERE cat_id = ?");
$sth->execute(array($trow->category));
$ticketlist = $sth->fetchAll();
if($ticketlist) {
	foreach($ticketlist as $crow) {
		$catname=$crow->name;
	}
}
if ($trow->status == 'Pending'){
	$status = 'Pendente';
}else{
	if ($trow->status == 'Resolved'){
		$status = 'Resolvido';
	}else{
		if ($trow->status == 'Closed'){
			$status = 'Fechado';
		}else{
			$status = 'N/A';
		}
	}
}
?>
