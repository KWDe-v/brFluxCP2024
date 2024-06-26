<?php 
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired(Flux::message('LoginToDonate'));

$title = 'Faça uma Doação';

$donationAmount = false;

if (count($_POST) && $params->get('setamount')) {
	$minimum = Flux::config('MinDonationAmount');
	$amount  = (float)$params->get('amount');
	
	if (!$amount || $amount < $minimum) {
		$errorMessage = sprintf('O valor da doação deve ser maior ou igual a %s %s!',
			$this->formatCurrency($minimum), Flux::config('DonationCurrency'));
	}
	else {
		$donationAmount = $amount;
	}
}

if (!$params->get('setamount') && $params->get('resetamount')) {
	$this->redirect($this->url);
}
?>
