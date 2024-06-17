<?php if (!$session->installerAuth): ?>
	<?php $success = TRUE; ?>
	<h3>Verificações de Requisitos</h3>

	<p>Antes de continuar com a instalação, você deve atender aos seguintes requisitos.</p>

	<h4>Requisitos Básicos</h4>
	<table class="table">
		<tr><td style="width:20%;">Versão do PHP</td><td>
			<?php if ( version_compare( PHP_VERSION, $minimumVersionCheck['php']['required'] ) >= 0 ): ?>
				<span class="text-success"><?php echo PHP_VERSION ?></span>
			<?php else: $success = FALSE; ?>
				<span class="text-danger">Você não está usando uma versão compatível do PHP. Você precisa do PHP <?php echo $minimumVersionCheck['php']['required']; ?> ou superior (<?php echo $requirements['php']['recommended']; ?> ou superior recomendado). Você deve contatar seu provedor de hospedagem ou administrador do sistema para solicitar uma atualização.</span>
			<?php endif ?>
		</td><td><?php echo $minimumVersionCheck['php']['required'] ?> requerido</td><td><?php echo $minimumVersionCheck['php']['recommended'] ?> recomendado</td></tr>
		<tr><td>Versão do MySQL</td><td>
			<?php if ( version_compare( $res->mysql_version, $minimumVersionCheck['mysql']['required'] ) >= 0 ): ?>
				<span class="text-success"><?php echo $res->mysql_version ?></span>
			<?php else: $success = FALSE; ?>
				<span class="text-danger">Você não está usando uma versão compatível do MySQL. Você precisa do MySQL <?php echo $minimumVersionCheck['mysql']['required']; ?> ou superior (<?php echo $requirements['mysql']['recommended']; ?> ou superior recomendado). Você deve contatar seu provedor de hospedagem ou administrador do sistema para solicitar uma atualização.</span>
			<?php endif ?>
			</td><td><?php echo $minimumVersionCheck['mysql']['required'] ?> requerido</td><td><?php echo $minimumVersionCheck['mysql']['recommended'] ?> recomendado</td></tr>
	</table>
	<p class="pb-4">Os Requisitos Básicos são os requisitos mínimos para executar o FluxCP. Se você não atender a esses requisitos, o FluxCP não funcionará.</p>

	<h4>Extensões do PHP</h4>
	<table class="table">
		<?php foreach($requiredExtensions as $requirement): ?>
			<tr><td style="width:20%;"><?php echo $requirement ?></td><td>
				<?php if ( extension_loaded($requirement) ): ?>
					<span class="text-success">Instalada</span>
				<?php else: $success = FALSE; ?>
					<span class="text-danger">Não Instalada</span>
				<?php endif ?>
			</td></tr>
		<?php endforeach ?>
	</table>
	<p class="pb-4">As Extensões do PHP são necessárias para o FluxCP operar corretamente. A maioria dessas extensões são necessárias para o uso normal, algumas são opcionais dependendo das configurações. Para o bem de instalações "adequadas", todas são definidas como necessárias.</p>

	<h4>Permissões de Arquivo</h4>

	<table class="table">
		<?php foreach($permissionsChecks as $pathCheck => $pathDesc): ?>
			<?php $pathCheck = realpath($pathCheck); ?>
			<tr><td style="width:20%;"><?php echo $pathCheck ?></td><td>
				<?php if ( is_writable($pathCheck) ): ?>
					<span class="text-success"><?php echo $pathDesc ?> é gravável</span>
				<?php else: $success = FALSE; ?>
					<span class="text-danger"><?php echo $pathDesc ?> não é gravável. Solucione com `chmod 0600 <?php echo $pathDesc ?>`</span>
				<?php endif ?>
			</td></tr>
		<?php endforeach ?>
	</table>
	<p class="pb-4">As Permissões de Arquivo são necessárias para o FluxCP operar corretamente. Se você não atender a esses requisitos, o FluxCP não funcionará.</p>


<?php if($success == TRUE): ?>
	<form action="<?php echo $this->url ?>" method="post" class="row g-3">
		<p>
			Por favor, insira sua <em>senha do instalador</em> para continuar com a atualização.
		</p>
		<div class="col-auto">
			<label for="installer_password">Senha:</label>
		</div>
		<div class="col-auto">
			<input class="form-control" type="password" id="installer_password" name="installer_password" />
		</div>
		<div class="col-auto">
			<button type="submit" class="btn btn-success">Autenticar</button>
		</div>
	</form>
<?php else: ?>
	<div class="alert alert-danger mb-5">
		<strong>Erro:</strong> Parece que você não atende aos requisitos para executar o FluxCP. Por favor, corrija os problemas acima e tente novamente.
	</div>
<?php endif; ?>
<?php else: ?>
	<?php if (isset($permissionError)): ?>
		<h2 class="error">Erro de Permissão do MySQL Encontrado</h2>
		<p>Oh não, o instalador encontrou um erro de permissão ao tentar executar uma das definições do esquema!</p>
		<p>Isso geralmente significa que a consulta falhou devido à falta de permissões de usuário/banco de dados/tabela no MySQL.</p>
		<table class="schema-info">
			<tr>
				<th>Servidor</th>
				<td>
					<?php echo htmlspecialchars($permissionError->mainServerName) ?>
					<?php if ($permissionError->charMapServerName): ?>
						(<?php echo htmlspecialchars($permissionError->charMapServerName) ?>)
					<?php endif ?>
				</td>
			</tr>
			<tr>
				<th>Banco de Dados</th>
				<td><?php echo htmlspecialchars($permissionError->databaseName) ?></td>
			</tr>
			<tr>
				<th>Erro</th>
				<td><?php echo htmlspecialchars($permissionError->getMessage()) ?></td>
			</tr>
			<tr>
				<th>Consulta SQL</th>
				<td><code><?php echo nl2br(htmlspecialchars($permissionError->query)) ?></code></td>
			</tr>
		</table>
		<h4 style="margin: 9px 0 0 0">A solução recomendada para um problema como este é conceder ao usuário as permissões para
			executar a consulta no banco de dados ou tabela.</h4>
		<h4 style="margin: 4px 0 0 0">Executar manualmente a consulta SQL não é um método suportado, pois o versionamento do esquema será interrompido
			e o instalador não será concluído.</h4>
	<?php else: ?>
	<div>
		<p class="menu">
			<a href="<?php echo $this->url($params->get('module'), null, array('logout' => 1)) ?>" onclick="return confirm('Tem certeza de que deseja sair?')">Logout</a> |
			<a href="<?php echo $this->url($params->get('module'), null, array('update_all' => 1)) ?>" onclick="return confirm('Ao realizar esta ação, alterações serão feitas em seu banco de dados.\n\nTem certeza de que deseja continuar instalando o Flux e suas atualizações associadas?')"><strong>Instalar ou Atualizar Tudo</strong></a>
		</p>
		<p>"Instalar ou Atualizar Tudo" usará o nome de usuário e senha do MySQL pré-configurados para cada servidor.</p>
		<p>Abaixo está uma lista dos esquemas atualmente instalados / que precisam ser instalados.</p>
		<form action="<?php echo $this->urlWithQs ?>" method="post">
			<?php foreach ($installer->servers as $mainServerName => $mainServer): ?>
			<?php $servName = base64_encode($mainServerName) ?>
			<div class="row">
				<div class="col"><h3><?php echo htmlspecialchars($mainServerName) ?></h3></div>
			</div>
			<div class="row pb-2">
				<div class="col">Nome de usuário/senha alternativa do MySQL</div>
			</div>
			<div class="row pb-2">
				<div class="col-6">
					<label for="username_<?php echo $servName ?>">Nome de usuário do MySQL</label>
				</div>
				<div class="col"><input class="form-control" type="text" name="username[<?php echo $servName ?>]" id="username_<?php echo $servName ?>" /></div>
			</div>
			<div class="row pb-3">
				<div class="col-6">
					<label for="password_<?php echo $servName ?>">Senha do MySQL</label>
				</div>
				<div class="col"><input class="form-control" type="password" name="password[<?php echo $servName ?>]" id="password_<?php echo $servName ?>" /></div>
			</div>
			<div class="row pb-5">
				<div class="col text-center">
					<button type="submit" name="update[<?php echo $servName ?>]" class="btn btn-success">
						Atualizar <strong><?php echo htmlspecialchars($mainServerName) ?></strong>
					</button>
				</div>
			</div>

<div class="row">
	<table class="table">
		<th>Nome do Esquema</th>
		<th>Última Versão</th>
		<th>Versão Instalada</th>
	</tr>
		<?php foreach ($mainServer->schemas as $schema): ?>
	<tr>
		<td>
			<span class="text-<?php echo ($schema->versionInstalled == $schema->latestVersion) ? 'success' : 'danger' ?>">
				<?php echo htmlspecialchars($schema->schemaInfo['name']) ?>
			</span>
		</td>
		<td>
			<?php if ($schema->latestVersion > $schema->versionInstalled): ?>
				<span class="schema-query" title="<?php echo htmlspecialchars(file_get_contents($schema->schemaInfo['files'][$schema->latestVersion])) ?>">
				<?php echo htmlspecialchars($schema->latestVersion) ?>
				</span>
			<?php else: ?>
				<?php echo htmlspecialchars($schema->latestVersion) ?>
			<?php endif ?>
		</td>
		<td><?php echo $schema->versionInstalled ? htmlspecialchars($schema->versionInstalled) : '<span class="none">Nenhuma</span>' ?></td>
	</tr>
		<?php endforeach ?>

		<?php foreach ($mainServer->charMapServers as $charMapServerName => $charMapServer): ?>
	<tr>
		<th colspan="3" class="pt-4"><h4><?php echo htmlspecialchars($charMapServerName) ?></h4></th>
	</tr>
	<tr>
		<th>Nome do Banco de Dados</th>
		<th>Última Versão</th>
		<th>Versão Instalada</th>
	</tr>
			<?php foreach ($charMapServer->schemas as $schema): ?>
	<tr>
		<td>
			<span class="text-<?php echo ($schema->versionInstalled == $schema->latestVersion) ? 'success' : 'danger' ?>">
				<?php echo htmlspecialchars($schema->schemaInfo['name']) ?>
			</span>
		</td>
		<td><?php echo htmlspecialchars($schema->latestVersion) ?></td>
		<td><?php echo $schema->versionInstalled ? htmlspecialchars($schema->versionInstalled) : '<span class="none">Nenhuma</span>' ?></td>
	</tr>
			<?php endforeach ?>

		<?php endforeach ?>
	<?php endforeach ?>
	</table>
</div>
</form>
</div>
<?php endif ?>
<?php endif ?>
