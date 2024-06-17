<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Exportar Emblemas de Guilda</h2>
<p>Selecione os servidores para os quais você gostaria que os emblemas da guilda fossem exportados como um arquivo ZIP.</p>
<form action="<?php echo $this->url ?>" method="post">
	<input type="hidden" name="post" value="1" />
	<?php foreach ($serverNames as $serverName): ?>
	<p class="emblem-server"><label>
		&raquo;
		<input type="checkbox" name="server[]" checked="checked" value="<?php echo htmlspecialchars($serverName) ?>" />
		<span><?php echo htmlspecialchars($serverName) ?></span>
	</label></p>
	<?php endforeach ?>
	<button type="submit" class="submit_button">Exportar</button>
</form>
