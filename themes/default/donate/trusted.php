<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>E-mails confiáveis do PayPal</h2>
<?php if ($emails): ?>
<p>Abaixo está uma lista dos seus endereços de e-mail confiáveis do PayPal.</p>
<p>E-mails confiáveis não passam por nenhum processo de retenção, portanto, as doações feitas por eles permitirão que você receba seus créditos <strong>instantaneamente</strong>.</p>
<table class="vertical-table">
	<tr>
		<th>Endereço de E-mail</th>
		<th>Data/Hora de Estabelecimento</th>
	</tr>
	<?php foreach ($emails as $email): ?>
	<tr>
		<td><?php echo htmlspecialchars($email->email) ?></td>
		<td><?php echo $this->formatDateTime($email->create_date) ?></td>
	</tr>
	<?php endforeach ?>
</table>
<?php else: ?>
<p>Você não tem nenhum endereço de e-mail confiável do PayPal.</p>
<?php if (!Flux::config('HoldUntrustedAccount')): ?>
<p>Isso provavelmente ocorre porque o sistema de retenção de crédito está atualmente <strong>inativo</strong>, o que significa que uma doação feita de qualquer endereço de e-mail é imediatamente acreditada.</p>
<?php endif ?>
<?php endif ?>
