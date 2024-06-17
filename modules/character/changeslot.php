<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

$charID = $params->get('id');

if (!$charID) {
	$this->deny();
}

$char = $server->getCharacter($charID);
if (!$char || ($char->account_id != $session->account->account_id && !$auth->allowedToChangeSlot)) {
	$this->deny();
}

$title = "Alterar slot para {$char->name}";

if ($char->online) {
	$session->setMessageData("Não é possível alterar o slot de {$chat->name}. Ele/ela está atualmente online.");
	$this->redirect();
}

if (count($_POST)) {
	if (!$params->get('changeslot')) {
		$this->deny();
	}
	
	$slot = (int)$params->get('slot');
	
	if ($slot > $server->maxCharSlots) {
		$errorMensagem = "O número do slot não deve ser maior do que {$server->maxCharSlots}.";
	}
	elseif ($slot < 1) {
		$errorMensagem = 'O número do slot deve ser um número maior que zero.';
	}
	elseif ($slot === (int)$char->char_num+1) {
		$errorMensagem = 'Por favor, escolha um slot diferente.';
	}
	else {
		$sql  = "SELECT char_id, name, online FROM {$server->charMapDatabase}.`char` AS ch ";
		$sql .= "WHERE account_id = ? AND char_num = ? AND char_id != ?";
		$sth  = $server->connection->getStatement($sql);
		
		$sth->execute(array($char->account_id, $slot-1, $charID));
		
		$otherChar = $sth->fetch();
		
		if ($otherChar) {
			if ($otherChar->online) {
				$errorMensagem = "{$otherChar->name} está usando esse slot e está online no momento.";
			}else {
				$sql  = "UPDATE {$server->charMapDatabase}.`char` SET `char`.char_num = ?";
				$sql .= "WHERE `char`.char_id = ?";
				$sth  = $server->connection->getStatement($sql);
				
				$sth->execute(array($char->char_num, $otherChar->char_id));
			}
		}
		
		if (empty($errorMessage)) {
			$sql  = "UPDATE {$server->charMapDatabase}.`char` SET `char`.char_num = ?";
			$sql .= "WHERE `char`.char_id = ?";
			$sth  = $server->connection->getStatement($sql);
			
			$sth->execute(array($slot-1, $charID));
			
			if ($otherChar) {
				$otherNum = $char->char_num + 1;
				$session->setMessageData("Você trocou com sucesso o slot de {$char->name} com {$otherChar->name} (#$otherNum e #$slot).");
			}
			else {
				$session->setMessageData("Você alterou com sucesso o slot de {$char->name} para #$slot.");
			}
			
			$isMine = $char->account_id == $session->account->account_id;
			if ($auth->actionAllowed('character', 'view') && ($isMine || $auth->allowedToViewCharacter)) {
				$this->redirect($this->url('character', 'view', array('id' => $char->char_id)));
			}
			else {
				$this->redirect();
			}
		}
	}
}
?>
