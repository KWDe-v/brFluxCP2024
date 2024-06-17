<?php
// As variáveis do módulo estão disponíveis nos menus das páginas.
// Porém, a verificação do group_id de acesso deve ser feita diretamente no menu da página.
// Verificação mínima de acesso como $auth->actionAllowed('moduleName', 'actionName') deve ser realizada.
$groups  = AccountLevel::getArray();

$pageMenu = array();
if ((AccountLevel::getGroupLevel($account->group_id) <= $session->account->group_level || $auth->allowedToEditHigherPower) && $auth->actionAllowed('account', 'edit')) {
	$pageMenu[Flux::message('ModifyAccountLink')] = $this->url('account', 'edit', array('id' => $account->account_id));
}
return $pageMenu;
?>
