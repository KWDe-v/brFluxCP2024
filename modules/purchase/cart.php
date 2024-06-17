<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

if ($server->cart->isEmpty()) {
	$session->setMessageData('Seu carrinho está vazio no momento.');
	$this->redirect($this->url('purchase'));
}

$title = 'Carrinho';

require_once 'Flux/ItemShop.php';
$items = $server->cart->getCartItems();
?>
