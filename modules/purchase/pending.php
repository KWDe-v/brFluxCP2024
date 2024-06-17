<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

$title = 'Resgate Pendente';

try {
	// Cria a tabela temporária do banco de dados do item.
	require_once 'Flux/TemporaryTable.php';
	if($server->isRenewal) {
		$fromTables = array("{$server->charMapDatabase}.item_db_re", "{$server->charMapDatabase}.item_db2_re");
	} else {
		$fromTables = array("{$server->charMapDatabase}.item_db", "{$server->charMapDatabase}.item_db2");
	}
	$tableName = "{$server->charMapDatabase}.items";
	$tempTable = new Flux_TemporaryTable($server->connection, $tableName, $fromTables);

	$redeemTable = Flux::config('FluxTables.RedemptionTable');

	// JOINs, condições etc.
	$sqlpartial  = "LEFT OUTER JOIN $tableName ON items.id = $redeemTable.nameid WHERE account_id = ? ";
	$sqlpartial .= "AND redeemed < 1 ORDER BY purchase_date DESC";
	
	//Busca contagem de itens.
	$sql = "SELECT COUNT($redeemTable.id) AS total FROM {$server->charMapDatabase}.$redeemTable $sqlpartial";
	$sth = $server->connection->getStatement($sql);
	
	$sth->execute(array($session->account->account_id));
	$total = $sth->fetch()->total;

	//Busca itens.
	$col = "nameid, quantity, purchase_date, cost, credits_before, credits_after, items.name_english AS item_name";
	$sql = "SELECT $col FROM {$server->charMapDatabase}.$redeemTable $sqlpartial";
	$sth = $server->connection->getStatement($sql);
	
	$sth->execute(array($session->account->account_id));
	$items = $sth->fetchAll();
}
catch (Exception $e) {
	if (isset($tempTable) && $tempTable) {
		//Garante que a tabela seja descartada.
		$tempTable->drop();
	}
	
	// Levanta a exceção original.
	$class = get_class($e);
	throw new $class($e->getMessage());
}
?>
