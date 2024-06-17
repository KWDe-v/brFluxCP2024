<?php
if (!defined('FLUX_ROOT')) exit;

$title = Flux::message('LogoutTitle');

$session->logout();

?>
