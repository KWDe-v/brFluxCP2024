<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Visualizando detalhes da transação do PayPal</h2>
<?php if ($txn): ?>
<p>Se a transação contiver valores negativos de pagamento e liquidação, é provável que tenha havido um estorno e o doador tenha sido reembolsado.</p>
<table class="vertical-table">
	<tr>
		<th>ID da Transação</th>
		<td><?php echo htmlspecialchars($txn->txn_id) ?></td>
		<th>Conta</th>
		<td>
			<?php if ($txn->account_id): ?>
				<?php if ($auth->actionAllowed('account', 'view') && $auth->allowedToViewAccount): ?>
					<?php echo $this->linkToAccount($txn->account_id, $txn->userid) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($txn->userid) ?>
				<?php endif ?>
			<?php else: ?>
				<span class="not-applicable">N/A</span>
			<?php endif ?>
		</td>
		<th>Créditos Ganhos</th>
		<td><?php echo number_format((int)$txn->credits) ?></td>
	</tr>
	<tr>
		<th>Quantidade</th>
		<td>
			<?php echo $txn->mc_gross ?>
			<?php echo $txn->mc_currency ?>
		</td>
		<th>Valor da liquidação</th>
		<td colspan="3">
			<?php echo $txn->mc_gross - $txn->mc_fee ?>
			<?php echo $txn->mc_currency ?>
		</td>
	</tr>
	<tr>
		<th>Data de pagamento</th>
		<td><?php echo htmlspecialchars(date(Flux::config('DateTimeFormat'), strtotime($txn->payment_date))) ?></td>
		<th>Data de Processamento</th>
		<td colspan="3"><?php echo $this->formatDateTime($txn->process_date) ?></td>
	</tr>
	<tr>
		<th>Status</th>
		<td><?php echo htmlspecialchars($txn->payment_status) ?></td>
		<th>Nome do item</th>
		<td colspan="3"><?php echo htmlspecialchars($txn->item_name) ?></td>
	</tr>
	<tr>
		<th>Primeiro nome</th>
		<td><?php echo htmlspecialchars($txn->first_name) ?></td>
		<th rowspan="2">Endereço</th>
		<td colspan="3" rowspan="2">
			<?php echo htmlspecialchars($txn->address_street) ?><br />
			<?php echo htmlspecialchars($txn->address_city) ?>,
			<?php echo htmlspecialchars($txn->address_state) ?>,
			<?php echo htmlspecialchars($txn->address_country) ?>
			<?php echo htmlspecialchars($txn->address_zip) ?>
		</td>
	</tr>
	<tr>
		<th>Sobrenome</th>
		<td><?php echo htmlspecialchars($txn->last_name) ?></td>
	</tr>
</table>
<?php if ($auth->allowedToViewRawTxnLogData): ?>
	<h3>Log de transações bruto</h3>
	<?php if ($txnFileLog): ?>
	<pre class="raw-txn-log"><?php echo htmlspecialchars($txnFileLog) ?></pre>
	<?php else: ?>
	<p>O log bruto desta transação não foi encontrado.</p>
	<?php endif ?>	

	<?php else: ?>
	<p>Os registros indicam que tal transação nunca foi registrada. <a href="javascript:history.go(-1)">Volte</a>.</p>
	<?php endif ?>
<?php endif ?>
