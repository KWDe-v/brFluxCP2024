<?php 

// https://www.mercadopago.com.br/developers
// Cria uma aplicação Checkout Transparente

 return [
    'accesstoken'                => Flux::config('accesstoken'),
    'url_notification_api'       => Flux::config('url_notification_api'),
    'notification_url_success'   => Flux::config('notification_url_success'),
    'notification_url_pending'   => Flux::config('notification_url_pending'),
    'notification_url_failure'   => Flux::config('notification_url_failure')
];