<?php
if (!defined('FLUX_ROOT')) exit;

if (empty($amount)) {
	return false;
}
$session            = Flux::$sessionData;





$token = '';
$characters  = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$characters  = str_split($characters, 1);
$passLength  = 500;

for ($i = 0; $i < $passLength; ++$i) {
	$token .= $characters[array_rand($characters)];
}
?>



<?php if(Flux::config('MethodPaymentMP') == false):?>
<br>
<a class="sendDonate" href="?module=mp&token=<?php echo$token ?>&vl=<?php echo (float)$amount ?>&user_id=<?php echo $session->account->account_id?>&tipo=0"><img src="data/mp.png" /></a>
<?php else:?>
<br>
<a class="sendDonate" href="?module=mp&token=<?php echo$token ?>&action=pix&vl=<?php echo (float)$amount ?>&user_id=<?php echo $session->account->account_id?>&tipo=1"><img src="data/mp.png" /></a>
<?php endif?>
</form><br>
