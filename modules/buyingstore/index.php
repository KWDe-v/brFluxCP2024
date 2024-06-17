<?php
if (!defined('FLUX_ROOT')) exit;

$title = 'Compradores';

// Obtém a contagem total e retorna ao paginador.
$sth = $server->connection->getStatement("SELECT COUNT(id) AS total FROM buyingstores");
$sth->execute();
$paginator = $this->getPaginator($sth->fetch()->total);

// Define as colunas classificáveis
$sortable = array(
 'id' => 'asc', 'map', 'char_name'
);
$paginator->setSortableColumns($sortable);

// Cria a solicitação principal.
$sql = "SELECT `buyingstores`.char_id,`char`.name as char_name, `buyingstores`.id, `buyingstores`.sex, `buyingstores`.map, `buyingstores`.x, `buyingstores`.y, `buyingstores`.title, autotrade ";
$sql .= "FROM buyingstores ";
$sql .= "LEFT JOIN `char` on buyingstores.char_id = `char`.char_id ";
$sql = $paginator->getSQL($sql);
$sth = $server->connection->getStatement($sql);
$sth->execute();

$stores = $sth->fetchAll();
