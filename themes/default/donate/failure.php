<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Pagamento Recusado</h2>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pagamento Recusado</title>

</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($server->serverName);?></h1>
         <div class="header">
            <h1>Pagamento Recusado</h1>
        </div>
        <div class="order-info">
            <h2>Detalhes do Pedido:</h2>
            <p><strong>Número do Pedido:</strong> <?php echo $id?></p>
            <p><strong>Valor Pago:</strong> R$ <?php echo $valor?></p>
            <p><strong>Quantidade de ROP'S:</strong> R$ <?php echo $rop?></p>
            <p><strong>Data:</strong> <?php echo $data?></p>
            <p><strong>Meio de Pagamento:</strong> <?php echo $tipo?> (MercadoPago)</p>
            </div>
        <a href="../" class="button">Voltar à Página Inicial</a>
        <br />
<br />
<p class="red" style="text-align: center; font-weight: bold">"Seu Pagamento foi recusado, verifique os dados e/ou tente novamente mais tarde!"<br/> - <?php echo htmlspecialchars($session->loginAthenaGroup->serverName) ?> - </p>

    </div>  

        </div>
    </div>



</body>
</html>