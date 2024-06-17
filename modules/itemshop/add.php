<?php
if (!defined('FLUX_ROOT')) exit; 

$this->loginRequired();

$title = 'Add Item to Shop';

require_once 'Flux/TemporaryTable.php';
require_once 'Flux/ItemShop.php';

$itemID = $params->get('id');

$category   = null;
$categories = Flux::config('ShopCategories')->toArray();

if($server->isRenewal) {
	$fromTables = array("{$server->charMapDatabase}.item_db_re", "{$server->charMapDatabase}.item_db2_re");
} else {
	$fromTables = array("{$server->charMapDatabase}.item_db", "{$server->charMapDatabase}.item_db2");
}
$tableName = "{$server->charMapDatabase}.items";
$tempTable = new Flux_TemporaryTable($server->connection, $tableName, $fromTables);
$shopTable = Flux::config('FluxTables.ItemShopTable');

$col = "id AS item_id, name_english AS item_name, type";
$sql = "SELECT $col FROM $tableName WHERE items.id = ?";
$sth = $server->connection->getStatement($sql);

$sth->execute(array($itemID));
$item = $sth->fetch();

$stackable = false;
if ($item && Flux::isStackableItemType($item->type)) {
	$stackable = true;
}

if ($item && count($_POST)) {
	$maxCost     = (int)Flux::config('ItemShopMaxCost');
	$maxQty      = (int)Flux::config('ItemShopMaxQuantity');
	$category    = $params->get('category');
	$shop        = new Flux_ItemShop($server);
	$cost        = (int)$params->get('cost');
	$quantity    = (int)$params->get('qty');
	$info        = trim(htmlspecialchars($params->get('info')));
	$image       = $files->get('image');
	$useExisting = (int)$params->get('use_existing');
	
	if (!$cost) {
		$errorMessage = 'Você deve inserir um custo de crédito maior que zero.';
	}
	elseif ($cost > $maxCost) {
		$errorMessage = "O custo de crédito não deve exceder $maxCost.";
	}
	elseif (!$quantity) {
		$errorMessage = 'Você deve inserir uma quantidade maior que zero.';
	}
	elseif ($quantity > 1 && !$stackable) {
		$errorMessage = 'Este item não é empilhável. A quantidade deve ser 1.';
	}
	elseif ($quantity > $maxQty) {
		$errorMessage = "A quantidade do item não deve exceder $maxQty.";
	}
	elseif (!$info) {
		$errorMessage = 'Você deve inserir pelo menos algum texto informativo.';
	}
	else {
		if ($id=$shop->add($itemID, $category, $cost, $quantity, $info, $useExisting)) {
			$message = 'O item foi adicionado com sucesso à loja';
			if ($image && $image->get('size') && !$shop->uploadShopItemImage($id, $image)) {
				$message .= ', mas a imagem falhou ao carregar. Você pode tentar novamente modificando.';
			}
			else {
				$message .= '.';
			}
			$session->setMessageData($message);
			$this->redirect($this->url('purchase'));	
		}
		else {
			$errorMessage = 'Falha ao adicionar o item à loja.';
		}
	}
}

if (!$stackable) {
	$params->set('qty', 1);
}
?>
