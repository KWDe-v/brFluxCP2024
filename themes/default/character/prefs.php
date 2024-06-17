<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Preferências</h2>
<?php if ($char): ?>
<?php if (!empty($errorMessage)): ?>
<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>
<h3>Visualizando preferências de personagem para “<?php echo ($charName=htmlspecialchars($char->name))  ?>” em <?php echo htmlspecialchars($server->serverName) ?></h3>
<form action="<?php echo $this->urlWithQs ?>" method="post" class="generic-form">
	<input type="hidden" name="charprefs" value="1" />
	<table class="generic-form-table">
		<tr>
			<th><label for="hide_from_whos_online">Esconder Personagem da "Quem Está Online"</label></th>
			<td><input type="checkbox" name="hide_from_whos_online" id="hide_from_whos_online"<?php if ($hideFromWhosOnline) echo ' checked="checked"' ?> /></td>
			<td><p>Isso esconderá <?php echo $charName ?> completamente da página "Quem Está Online".</p></td>
		</tr>
		<tr>
			<th><label for="hide_map_from_whos_online">Esconder Mapa Atual da "Quem Está Online"</label></th>
			<td><input type="checkbox" name="hide_map_from_whos_online" id="hide_map_from_whos_online"<?php if ($hideMapFromWhosOnline) echo ' checked="checked"' ?> /></td>
			<td><p>Isso esconderá a localização atual de <?php echo $charName ?> da página "Quem Está Online".</p></td>
		</tr>
		<?php if ($auth->allowedToHideFromZenyRank): ?>
		<tr>
			<th><label for="hide_from_zeny_ranking">Esconder Personagem do "Ranking de Zeny"</label></th>
			<td><input type="checkbox" name="hide_from_zeny_ranking" id="hide_from_zeny_ranking"<?php if ($hideFromZenyRanking) echo ' checked="checked"' ?> /></td>
			<td><p>Isso esconderá <?php echo $charName ?> da página "Ranking de Zeny".</p></td>
		</tr>
		<?php endif ?>
		<tr>
			<td align="right"><p><input type="submit" value="Modificar preferências" /></p></td>
			<td colspan="2"></td>
		</tr>
	</table>
</form>
<?php else: ?>
<p>Nenhum personagem encontrado. <a href="javascript:history.go(-1)">Voltar</a></a>.</p>
<?php endif ?>
