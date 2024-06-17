<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

$shopItemID = $params->get('id');

if (!$shopItemID) {
	$this->deny();
}

require_once 'Flux/ItemShop.php';

$shop = new Flux_ItemShop($server);
$shop->deleteShopItemImage($shopItemID);

$session->setMessageData('A imagem do item da loja foi excluída.');
$this->redirect($this->referer);
?>
