<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

$title = 'Checkout';

if ($server->cart->isEmpty()) {
	$session->setMessageData('Seu carrinho está vazio no momento.');
	$this->redirect($this->url('purchase'));
}
elseif (!$server->cart->hasFunds()) {
	$session->setMessageData('Você não tem fundos suficientes para fazer esta compra!');
	$this->redirect($this->url('purchase'));
}

$items = $server->cart->getCartItems();

if (count($_POST) && $params->get('process')) {
	$redeemTable = Flux::config('FluxTables.RedemptionTable');
	$creditTable = Flux::config('FluxTables.CreditsTable');
	$deduct      = 0;
	
	$sql  = "INSERT INTO {$server->charMapDatabase}.$redeemTable ";
	$sql .= "(nameid, quantity, cost, account_id, char_id, redeemed, redemption_date, purchase_date, credits_before, credits_after) ";
	$sql .= "VALUES (?, ?, ?, ?, NULL, 0, NULL, NOW(), ?, ?)";
	$sth  = $server->connection->getStatement($sql);
	
	$balance = $session->account->balance;
	
	foreach ($items as $item) {
		$creditsAfter = $balance - $item->shop_item_cost;
		
		$res = $sth->execute(array(
			$item->shop_item_nameid,
			$item->shop_item_qty,
			$item->shop_item_cost,
			$session->account->account_id,
			$balance,
			$creditsAfter
		));
		
		if ($res) {
			$deduct  += $item->shop_item_cost;
			$balance -= $item->shop_item_cost;
		}
	}
	
	$session->loginServer->depositCredits($session->account->account_id, -$deduct);
	
	if ($res) {
		if (!$deduct) {
			$server->cart->clear();
			$session->setMessageData('Falha ao comprar todos os itens do seu carrinho!');
		}
		elseif ($deduct != $server->cart->getTotal()) {
			$server->cart->clear();
			$session->setMessageData('Os itens foram comprados, no entanto, alguns falharam (seus créditos ainda estão lá.)');
		}
		else {
			$server->cart->clear();
			$session->setMessageData('Os itens foram comprados. Você pode resgatá-los do NPC de Resgate.');
		}
	}
	else {
		$session->setMessageData('A compra deu errado, entre em contato com um administrador!');
	}
	
	$this->redirect();
}
?>
