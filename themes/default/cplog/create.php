<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Registros</h2>
<p class="toggler"><a href="javascript:toggleSearchForm()">Procurar...</a></p>
<form action="<?php echo $this->url ?>" method="get" class="search-form">
	<?php echo $this->moduleActionFormInputs($params->get('module'), $params->get('action')) ?>
	<p>
		<label for="use_login_after">Data de login entre:</label>
		<input type="checkbox" name="use_login_after" id="use_login_after"<?php if ($params->get('use_login_after')) echo ' checked="checked"' ?> />
		<?php echo $this->dateField('login_after') ?>
		<label for="use_login_before">&mdash;</label>
		<input type="checkbox" name="use_login_before" id="use_login_before"<?php if ($params->get('use_login_before')) echo ' checked="checked"' ?> />
		<?php echo $this->dateField('login_before') ?>
		<?php if ($auth->allowedToSearchCpLoginLogPw): ?>
		...
		<label for="password">Senha:</label>
		<input type="text" name="password" id="password" value="<?php echo htmlspecialchars($params->get('password') ?: '') ?>" />
		<?php endif ?>
	</p>
	<p>
		<label for="account_id">ID da Conta:</label>
		<input type="text" name="account_id" id="account_id" value="<?php echo htmlspecialchars($params->get('account_id') ?: '') ?>" />
		...
		<label for="username">Usuário:</label>
		<input type="text" name="username" id="username" value="<?php echo htmlspecialchars($params->get('username') ?: '') ?>" />
		...
		<label for="ip">Endereço de IP:</label>
		<input type="text" name="ip" id="ip" value="<?php echo htmlspecialchars($params->get('ip') ?: '') ?>" />
		...
		
		
		<input type="submit" value="Procurar" />
		<input type="button" value="Resetar" onclick="reload()" />
	</p>
</form>
<?php if ($logins): ?>
<?php echo $paginator->infoText() ?>
<table class="horizontal-table">
	<tr>
		<th><?php echo $paginator->sortableColumn('account_id', 'ID da Conta') ?></th>
		<th><?php echo $paginator->sortableColumn('user_id', 'Usuário') ?></th>
		<?php if (($showPassword=Flux::config('CpLoginLogShowPassword')) && ($seePassword=$auth->allowedToSeeCpLoginLogPass)): ?>
		<th><?php echo $paginator->sortableColumn('user_pass', 'Password') ?></th>
		<?php endif ?>
		<th><?php echo $paginator->sortableColumn('reg_ip', 'Endereço de IP') ?></th>
		<th><?php echo $paginator->sortableColumn('reg_date', 'Data de Registro') ?></th>

	</tr>
	<?php foreach ($logins as $login): ?>
	<tr align="center">
		<td >
			<?php if ($auth->actionAllowed('account', 'view') && $auth->allowedToViewAccount): ?>
				<?php echo $this->linkToAccount($login->account_id, $login->account_id) ?>
			<?php else: ?>
				<?php echo $login->account_id ?>
			<?php endif ?>
		</td>
		<td><?php echo htmlspecialchars($login->userid) ?></td>
		<?php if ($showPassword && $seePassword): ?>
		<td><?php echo htmlspecialchars($login->user_pass) ?></td>
		<?php endif ?>
		<td>
			<?php if ($auth->actionAllowed('account', 'index')): ?>
				<?php echo $this->linkToAccountSearch(array('reg_ip' => $login->reg_ip), $login->reg_ip) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($login->reg_ip) ?>
			<?php endif ?>
		</td>
		<td><?php echo $this->formatDateTime($login->reg_date) ?></td>
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>Nenhum registro foi encontrado. <a href="javascript:history.go(-1)">Voltar</a>.</p>
<?php endif ?>
