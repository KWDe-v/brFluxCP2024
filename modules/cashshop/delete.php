<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

if (!$auth->allowedToManageCashShop) {
	$this->deny();
}

require_once 'Flux/CashShop.php';

$shop       = new Flux_CashShop($server);
$shopItemID = $params->get('id');
$deleted    = $shopItemID ? $shop->delete($shopItemID) : false;

if ($deleted) {
	$session->setMessageData('Item excluído com sucesso do CashShop. Você precisará recarregar seu itemdb para que isso tenha efeito no jogo.');
	$this->redirect($this->url('cashshop'));
}
?>
