<?php

$user_id = $session->account->account_id;
$status = ['approved', 'pending', 'refunded', 'processing'];

// Verificar conexão
if (!$server->connection) {
    die("Conexão falhou: " . $server->connection->error);
}


function processResults($stmt) {
    $resultsArray = array();
    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        // Definir o tipo com base no valor da coluna 'tipo'
        $tipo = $row->tipo == '0' ? 'Link de Pagamento' : ($row->tipo == '1' ? 'PIX' : $row->tipo);
        $tipoNum = $row->tipo == '0' ? '0' : ($row->tipo == '1' ? '1' : $row->tipo);
        $resultsArray[] = array(
            'id' => $row->id,
            'valor' => $row->valor,
            'created' => $row->created,
            'tipo' => $tipo,
            'tipoNum' => $tipoNum
        );
    }
    return $resultsArray;
}

$aprovadas = array();
$pendentes = array();
$reembolsos = array();

$sql = "SELECT id, valor, created, tipo FROM payment WHERE status = ? AND user_id = ?";
$stmt = $server->connection->getStatement($sql);
if ($stmt) {
    $stmt->execute([$status[0], $user_id]);
    $aprovadas = processResults($stmt);
} else {
    die("Falha ao preparar statement: " . $server->connection->errorInfo());
}


$sql = "SELECT id, valor, created, tipo FROM payment WHERE (status = ? OR status = ?) AND user_id = ?";
$stmt = $server->connection->getStatement($sql);
if ($stmt) {
    $stmt->execute([$status[1], $status[3], $user_id]);
    $pendentes = processResults($stmt);
} else {
    die("Falha ao preparar statement: " . $server->connection->errorInfo());
}


$sql = "SELECT id, valor, created, tipo FROM payment WHERE status = ? AND user_id = ?";
$stmt = $server->connection->getStatement($sql);
if ($stmt) {
    $stmt->execute([$status[2], $user_id]);
    $reembolsos = processResults($stmt);
} else {
    die("Falha ao preparar statement: " . $server->connection->errorInfo());
}



?>
