<?php
if (!defined('FLUX_ROOT')) exit;



$title ='Pagamento Aprovado';


$tokenpayment = $_GET['token'] ?? null;



$id = $_GET['id'] ?? null;




if (!$id) {
    $this->deny();
}



$sql = "SELECT valor, created, tipo FROM payment WHERE id = :id";
$stmt = $server->connection->getStatement($sql);


$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();


$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($result && count($result) > 0) {
    // Iterar sobre os resultados
    foreach ($result as $row) {
        // Imprimir os resultados
        $valor = $row["valor"];
        $created = $row["created"];
        $tipo = $row["tipo"];


        $data_formatada = new DateTime($created);
        $data = $data_formatada->format('d/m/Y H:i:s');

       
        if (!is_float($valor)) {
            $valor = (float) str_replace(',', '.', $valor);
        }
        $valor_formatado = number_format($valor, 2, ',', '.');

        
        
        $rop =  number_format(floor($valor / Flux::config('CreditExchangeRate')));
        // Definir o tipo
        if ($tipo == "0") {
            $tipo = "Link de Pagamento";
        } elseif ($tipo == "1") {
            $tipo = "PIX";
        }


    }
} else {
    $this->deny();
}




?>
<style type="text/css">
	.container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: #6e74b9;
            border-radius: 7px;
        
            text-align: center;
        }
        .message {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .order-info {
           
            padding-top: 20px;
            margin-top: 20px;
        }
        .order-info h2 {
            margin-top: 0;
        }
        .order-info p {
            margin: 5px 0;
        }




    .header {
        background-color: #008800;
        color: #fff;
        padding: 20px;
        border-radius: 10px;
        
    }

    .header h1 {
        margin: 0;
    }

    .message {
        padding: 20px;
    }

    .message p {
        font-size: 18px;
        margin: 10px 0;
    }

    .button {
        background-color: #008800;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s;
        display: inline-block;
    }
    .button:hover {
        background-color: #008822;
     
        transition: all 0.3s;

    }


    .button:active {
        transform: scale(0.99);
    }
</style>