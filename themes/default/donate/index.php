<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Doação</h2>
<?php if (Flux::config('AcceptDonations')): ?>
	<?php if (!empty($errorMessage)): ?>
		<p class="red"><?php echo "O valor da doação deve ser maior ou igual a R$ ".Flux::config('MinDonationAmount').",00!"; ?></p>
	<?php endif ?>
	
    <p>Ao doar, você está apoiando os custos de <em>manutenção</em> e <em>operação</em> deste servidor. Em troca, você será recompensado com <span class="keyword">CRÉDITOS DE DOAÇÃO</span> que poderão ser usados para comprar itens na nossa loja in-game.</p>
	<h3>Você está pronto(a) para doar?</h3>
	<p>Todas as doações para nós são recebidas via MercadoPago, mas não se preocupe! Mesmo que você não tenha uma conta no MercadoPago, ainda pode usar seu cartão de crédito para doar!</p>
		
	<?php
	$currency         = Flux::config('DonationCurrency');
	$dollarAmount     = (float)+Flux::config('CreditExchangeRate');
	$creditAmount     = 1;
	$rateMultiplier   = 10;
	$hoursHeld        = +(int)Flux::config('HoldUntrustedAccount');
	
	while ($dollarAmount < 1) {
		$dollarAmount  *= $rateMultiplier;
		$creditAmount  *= $rateMultiplier;
	}
	?>
	
	<?php if ($hoursHeld): ?>
		<p>Para prevenir pagamentos fraudulentos, nosso servidor atualmente bloqueia o processo de crédito por
   			 <span class="hold-hours"><?php echo number_format($hoursHeld) ?> horas</span>
   			 após a doação ter sido feita, para garantir um jogo legítimo e uma boa reputação no MercadoPago.</p>
		<p>Essa retenção é aplicada apenas uma vez para o e-mail do MercadoPago e a conta RagnaGO associados.</p>
	<?php endif ?>

	<div class="generic-form-div" style="margin-bottom: 10px">
		<table class="generic-form-table">
			<tr>
				<th><label>Valor dos Créditos:</label></th>
				<td><p><?php echo htmlspecialchars($currency) ?> <?php echo $this->formatCurrency($dollarAmount) ?>
				= <?php echo number_format($creditAmount) ?> crédito (s).</p></td>
			</tr>
			<tr>
				<th><label>Doação Mínima:</label></th>
				<td><p><?php echo htmlspecialchars($currency) ?> <?php echo $this->formatCurrency(Flux::config('MinDonationAmount')) ?></p></td>
			</tr>
		</table>
	</div>
		
	<?php if (!$donationAmount): ?>
	<form action="<?php echo $this->url ?>" method="post">
		<?php echo $this->moduleActionFormInputs($params->get('module')) ?>
		<input type="hidden" name="setamount" value="1" />
		<p class="enter-donation-amount">
			<label>
				Digite o valor que você gostaria de doar:
				<input class="money-input" type="text" name="amount"
					value="<?php echo htmlspecialchars($params->get('amount') ?: 0) ?>"
					size="<?php echo (strlen((string)+Flux::config('CreditExchangeRate')) * 2) + 2 ?>" />
				<?php echo htmlspecialchars(Flux::config('DonationCurrency')) ?>
			</label>
			ou
			<label>
				<input class="credit-input" type="text" name="credit-amount"
					value="<?php echo htmlspecialchars(intval($params->get('amount') / Flux::config('CreditExchangeRate'))) ?>"
					size="<?php echo (strlen((string)+Flux::config('CreditExchangeRate')) * 2) + 2 ?>" />
				Créditos
			</label>
		</p>
		<input type="submit" value="Confirmar Doação" class="submit_button" />
	</form>
	<?php else: ?>
	<p>Quando estiver pronto para doar, clique no grande botão "Pagar com MercadoPago" para prosseguir com sua transação.
		(Você pode escolher doar a partir do saldo existente no MercadoPago ou usar seu cartão de crédito se não tiver uma conta).</p>
		
	<p class="credit-amount-text">
		&mdash;
		<span class="credit-amount"><?php echo number_format(floor($donationAmount / Flux::config('CreditExchangeRate'))) ?></span> créditos
		&mdash;
	</p>
		
	<p class="donation-amount-text">Quantidade:
		<span class="donation-amount">
		<?php echo $this->formatCurrency($donationAmount) ?>
		<?php echo htmlspecialchars(Flux::config('DonationCurrency')) ?>
		</span>
	</p><br>
	<p class="reset-amount-text">
		<a href="<?php echo $this->url('donate', 'index', array('resetamount' => true)) ?>">(Cancelar)</a>
	</p>
		<!-- BOTÕES DE DOAÇÃO -->
		<?php 
		$gatePayment = Flux::config('GatePayment');
		if ($gatePayment == 0 || $gatePayment == 2): ?>
		    <p><?php echo $this->donateButtonMp($donationAmount); ?></p>
		<?php endif; 
		if ($gatePayment == 1 || $gatePayment == 2): ?>
		    <p><?php echo $this->donateButton($donationAmount); ?></p>
		<?php endif; ?>

	<?php endif ?>
<?php else: ?>
	<p><?php echo Flux::message('NotAcceptingDonations') ?></p>
<?php endif ?>
