<?php

$minDonate = Flux::config('MinDonationAmount');
$maxDonate = Flux::config('MaxDonationAmount');

if (!isset($_GET['vl'])) {
    echo "<script>alert('O Valor não pode ser vazio');</script>";
    echo "<script>setTimeout(function(){ window.location.href = '?module=donate'; }, 10);</script>";
    exit;
} elseif ($_GET['vl'] == "" || !is_numeric($_GET['vl'])) {
    echo "<script>alert('Digite somente números');</script>";
    echo "<script>setTimeout(function(){ window.location.href = '?module=donate'; }, 10);</script>";
    exit;
} elseif ($_GET['vl'] < $minDonate || $_GET['vl'] > $maxDonate) {
    echo "<script>alert('valor deve ser entre $minDonate e $maxDonate');</script>";
    echo "<script>setTimeout(function(){ window.location.href = '?module=donate'; }, 10);</script>";
    exit;
}

$config = require_once 'config.php';
require_once 'class/Conn.class.php';
require_once 'class/Payment.class.php';

// Captura o valor
$amount = (float) trim($_GET['vl']);

// Captura o user_id
$user_id = $_GET['user_id'] ?? null;

    $accessToken = $config['accesstoken'];
        if (strpos($accessToken, 'APP_USR') !== 0) {
    echo "<script>alert('Serviço Indisponível, Contate o Suporte');</script>";
    echo "<script>setTimeout(function(){ window.location.href = '?module=main'; }, 10);</script>";
    exit;
}
    


$pedido = $_GET['id'] ?? null;


// Captura o tipo (0 ou 1) da URL
$tipo = $_GET['tipo'] ?? null;

// Instancia a classe de pagamento
$payment = new Payment($user_id);

// Criação do pagamento
$payCreate = $payment->addPaymentForExistingOrder($amount, $tipo, $pedido);

if ($payCreate) {
    // Acessa o token do arquivo de configuração
    

    // URL para a solicitação PIX
    $pixUrl = 'https://api.mercadopago.com/v1/payments';

    // Inicia a solicitação PIX
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $pixUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
        "description": "Pagamento PIX",
        "external_reference": "'.$pedido.'",
        "notification_url": "'.$config['url_notification_api'].'",
        "payer": {
            "email": "test_user_123@testuser.com",
            "identification": {
            "type": "CPF",
            "number": "95749019047"
            }
        },
        "payment_method_id": "pix",
        "transaction_amount": ' . $amount . '
        }',
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $obj = json_decode($response);
    //print_r($obj);
    if (isset($obj->id)) {
        if ($obj->id != NULL) {
            $copiaCopia = $obj->point_of_interaction->transaction_data->qr_code;
            $imgQrCode = $obj->point_of_interaction->transaction_data->qr_code_base64;
            $linkExterno = $obj->point_of_interaction->transaction_data->ticket_url;
            $transactionAmount = $obj->transaction_amount;
            $externalReference = $obj->external_reference;
          

                header("Location: $linkExterno");
    exit;

        }
    }
}
?>
