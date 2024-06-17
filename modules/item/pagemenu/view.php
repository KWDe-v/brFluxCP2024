<?php
$pageMenu = array();
if ($auth->actionAllowed('itemshop', 'add') && $auth->allowedToAddShopItem) {
	if ($item->cost) {
		$pageMenu['Adicionar à loja de itens (novamente)'] = $this->url('itemshop', 'add', array('id' => $item->item_id));
	}
	else {
		$pageMenu['Adicionar à loja de itens'] = $this->url('itemshop', 'add', array('id' => $item->item_id));
	}
}
if ($auth->actionAllowed('cashshop', 'add') && $auth->allowedToManageCashShop) {
	$pageMenu['Adicionar à loja de dinheiro'] = $this->url('cashshop', 'add', array('id' => $item->item_id));
}
return $pageMenu;
?>
