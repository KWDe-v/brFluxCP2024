<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Estatísticas do mapa</h2>
<?php if ($maps): ?>
<?php $playerTotal = 0; foreach ($maps as $map) $playerTotal += $map->player_count ?>
<p>Esta página mostra quantos jogadores online estão localizados em um mapa específico, para todos os mapas que possuem <em>qualquer</em> jogador online.</p>
<p><strong><?php echo number_format($playerTotal) ?></strong> jogador(es) online foram encontrados
distribuído em <strong><?php echo number_format(count($maps)) ?></strong> mapa(s).</p>
<div class="generic-form-div">
	<table class="generic-form-table">
		<?php foreach ($maps as $map): ?>
		<tr>
			<td align="right"><p class="important"><strong><?php echo htmlspecialchars(basename($map->map_name, '.gat')) ?></strong></p></td>
			<td><p><strong><em><?php echo number_format($map->player_count) ?></em></strong> Jogadores(s)</p></td>
		</tr>
		<?php endforeach ?>
	</table>
</div>
<?php else: ?>
<p>Nenhum jogador encontrado em nenhum mapa. <a href="javascript:history.go(-1)">Voltar</a>.</p>
<?php endif ?>
