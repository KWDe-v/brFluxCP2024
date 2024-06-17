<?php
// Informações de configuração para o tratamento de erros críticos.
// Erros críticos são expostos devido a uma exceção no programa.

// Definir $showExceptions como true fará com que não apenas as exceções sejam exibidas
// mas também o rastreamento de pilha, o que pode resultar em problemas de segurança, como expor
// seu nome de usuário e senha do MySQL quando não for possível conectar. Por favor, mantenha-o como false
// em um ambiente de produção.

$adminEmail      = 'admin@localhost'; // Endereço de e-mail do administrador.
$errorFile       = 'error.php';       // Arquivo de erro para renderizar.
$showExceptions  = true;              // Se mostrar ou não exceções (aplica-se apenas a error.php)
?>
