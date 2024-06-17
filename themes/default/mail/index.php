<?php
if (!defined('FLUX_ROOT')) exit;
?>
<h2><?php echo htmlspecialchars(Flux::message('MailerHeading')) ?></h2>
<?php if (!empty($errorMessage)): ?>
<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php else: ?>
<p><?php echo htmlspecialchars(Flux::message('MailerInfo')) ?></p>
<?php endif ?>
<form action="<?php echo $this->urlWithQs ?>" method="post" name="mailerform" class="generic-form">
	<table class="generic-form-table">
		<tr>
			<th><label for="subject"><?php echo htmlspecialchars(Flux::message('MailerSubjectLabel')) ?></label></th>
			<td><input type="text" name="subject" id="subject" /></td>
		</tr>

		<tr>
			<th><label for="whoto"><?php echo htmlspecialchars(Flux::message('MailerToLabel')) ?></label></th>
			<td><input type="radio" name="whoto" id="whoto" value="1" checked="checked"> Ninguém<br />
				<input type="radio" name="whoto" id="whoto" value="2"> Somente administradores<br />
				<input type="radio" name="whoto" id="whoto" value="3"> Somente equipe<br />
				<input type="radio" name="whoto" id="whoto" value="5"> VIPs<br />
				<input type="radio" name="whoto" id="whoto" value="4"> Todos<br />
			</td>
		</tr>
		<tr>
			<th><label for="template"><?php echo htmlspecialchars(Flux::message('MailerSelectTemplateLabel')) ?></label></th>
			<td>
			<select name="template">
			    <?php for ($index = 0; $index < $indexCount; $index++): ?>
			        <?php $tempexp = explode('.', $dirArray[$index]); ?>
			        <option value="<?php echo $tempexp[0]; ?>"><?php echo $tempexp[0]; ?></option>
			    <?php endfor; ?>
			</select>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="submit" value="Enviar E-maill" />
			</td>
		</tr>
	</table>
</form>
