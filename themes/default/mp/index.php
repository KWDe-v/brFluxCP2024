<?php

$config = require_once 'config.php';
require_once 'class/Conn.class.php';
require_once 'class/Payment.class.php';
$minDonate = Flux::config('MinDonationAmount');
$maxDonate = Flux::config('MaxDonationAmount');
// Access token do arquivo config.php
$accesstoken = $config['accesstoken'];
if (strpos($accesstoken, 'APP_USR') !== 0) {
    echo "<script>alert('Serviço Indisponível, Contate o Suporte');</script>";
    echo "<script>setTimeout(function(){ window.location.href = '?module=main'; }, 10);</script>";
    exit;
}
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
// Captura o user_id da URL
$user_id = $_GET['user_id'] ?? null;

// Captura o tipo (0 ou 1) da URL
$tipo = $_GET['tipo'] ?? null;

// Validações de entrada para user_id e tipo
if (!$user_id || !is_numeric($user_id)) {
    die('user_id inválido');
}
if ($tipo === null || ($tipo != 0 && $tipo != 1)) {
    die('tipo inválido');
}

// Se não for requisição do formulário do cartão
if (!isset($_POST['token'])) {


    // Captura o valor
    $amount = (float) trim($_GET['vl']);

    // Instancia a classe de pagamento
    $payment = new Payment($user_id);

    // Criação do pagamento
    $payCreate = $payment->addPayment($amount, $tipo);
	

    if ($payCreate) {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.mercadopago.com/checkout/preferences',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'back_urls' => [
                    'success' => ''.$config['notification_url_success'].'',
                    'pending' => ''.$config['notification_url_pending'].'',
                    'failure' => ''.$config['notification_url_failure'].''
                ],
                'external_reference' => $payCreate,
                'notification_url' => $config['url_notification_api'],
                'auto_return' => 'approved',
                'items' => [
                    [
                        'title' => 'Créditos '.htmlspecialchars($server->serverName).'',
                        'description' => 'Dummy description',
                        'picture_url' => 'http://www.myapp.com/myimage.jpg',
                        'category_id' => 'car_electronics',
                        'quantity' => 1,
                        'currency_id' => 'BRL',
                        'unit_price' => $amount
                    ]
                ],
                'payment_methods' => [
                    'excluded_payment_types' => [
                        ['id' => 'ticket']
                    ]
                ]
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $accesstoken
            ],
        ]);

        $response = curl_exec($curl);

        if ($response === false) {
            $error = curl_error($curl);
            curl_close($curl);
            die('Erro na solicitação cURL: ' . $error);
        }
        curl_close($curl);

        $obj = json_decode($response);

        if (isset($obj->id) && $obj->id != NULL) {
            if (isset($_POST['card'])) {
                $preference_id = $obj->id;
				} else {
                $link_externo = $obj->init_point;
                $external_reference = $obj->external_reference;
                header("Location: $link_externo");
                exit;
            }
        }
    }
}
?>