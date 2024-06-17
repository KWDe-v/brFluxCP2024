<?php if (!empty($errorMessage)): ?>
    <p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>
<?php if (!empty($successMessage)): ?>
    <p class="green"><?php echo htmlspecialchars($successMessage) ?></p>
<?php endif ?>

<h3>Configuração do PHP</h3>
<p>Esses valores devem ser maiores que o tamanho do seu arquivo itemInfo.</p>
<table class="vertical-table">
	<tr>
		<th>Configs do PHP</th><td>Valor</td>
	</tr>
	<tr>
		<th>post_max_size</th><td><?php echo ini_get('post_max_size') ?></td>
	</tr>
	<tr>
		<th>upload_max_filesize</th><td><?php echo ini_get('upload_max_filesize') ?></td>
	</tr>
</table>
<p>ShowItemDesc está <?php if(Flux::config('ShowItemDesc')):?>habilitado<?php else: ?>desabilitado<?php endif ?> no seu arquivo de configuração.</p>

<h3>Enviar itemInfo.lua</h3>
<form class="forms" method="post" enctype="multipart/form-data">
    <input type="file" name="iteminfo"><br>
    <input class="btn" type="submit">
</form>

<h3>Contagem Atual</h3>
<p>Atualmente, há <?php echo number_format($return->count) ?> descrições de itens no banco de dados</p>
