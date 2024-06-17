<?php
if (!defined('FLUX_ROOT')) exit; 

$this->loginRequired();

if (!$auth->allowedToManageCashShop) {
	$this->deny();
}
$title = 'Adicionar item à loja a dinheiro';

require_once 'Flux/TemporaryTable.php';
require_once 'Flux/CashShop.php';

$itemID = $params->get('id');

$category   = null;
$categories = Flux::config('CashShopCategories')->toArray();

if($server->isRenewal) {
	$fromTables = array("{$server->charMapDatabase}.item_db_re", "{$server->charMapDatabase}.item_db2_re");
} else {
	$fromTables = array("{$server->charMapDatabase}.item_db", "{$server->charMapDatabase}.item_db2");
}
$tableName = "{$server->charMapDatabase}.items";
$tempTable = new Flux_TemporaryTable($server->connection, $tableName, $fromTables);

$col = "id AS item_id, name_english AS item_name, type";
$sql = "SELECT $col FROM $tableName WHERE items.id = ?";
$sth = $server->connection->getStatement($sql);

$sth->execute(array($itemID));
$item = $sth->fetch();

if ($item && count($_POST)) {
	$tab         = $params->get('tab');
	$shop        = new Flux_CashShop($server);
	$price       = (int)$params->get('price');
	
	if (!$price) {
		$errorMessage = 'Você deve inserir um custo de caixa eletrônico maior que zero.';
	} else {
		if ($shop->add($tab, $itemID, $price)) {
			$message = 'O item foi adicionado com sucesso ao CashShop';
			$session->setMessageData($message);
			$this->redirect($this->url('cashshop'));
		} else {
			$errorMessage = 'Falha ao adicionar o item ao CashShop.';
		}
	}
}

?>
