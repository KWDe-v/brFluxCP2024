<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Guild Ranking</h2>
<h3>
	Top <?php echo number_format($limit=(int)Flux::config('GuildRankingLimit')) ?> Guilds
	on <?php echo htmlspecialchars($server->serverName) ?>
</h3>
<?php if ($guilds): ?>
	<table class="horizontal-table">
		<tr>
			<th>Posição no Rank</th>
			<th colspan="2">Nome do Clã</th>
			<th>Nível do Clã</th>
			<th>Castelos de propriedade</th>
			<th>Membros</th>
			<th>Média de Nível</th>
			<th>Experiência</th>
		</tr>
		<?php for ($i = 0; $i < $limit; ++$i): ?>
		<tr<?php if (!isset($guilds[$i])) echo ' class="empty-row"'; if ($i === 0) echo ' class="top-ranked" title="<strong>'.htmlspecialchars($guilds[$i]->name).'</strong> é o TOP clã!"' ?>>
			<td align="right"><?php echo number_format($i + 1) ?></td>
			<?php if (isset($guilds[$i])): ?>
			<?php if ($guilds[$i]->emblem): ?>
			<td width="24"><img src="<?php echo $this->emblem($guilds[$i]->guild_id) ?>" /></td>
			<?php endif ?>
			<td<?php if (!$guilds[$i]->emblem) echo ' colspan="2"' ?>><strong>
				<?php if ($auth->actionAllowed('guild', 'view') && $auth->allowedToViewGuild): ?>
					<?php echo $this->linkToGuild($guilds[$i]->guild_id, $guilds[$i]->name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($guilds[$i]->name) ?>
				<?php endif ?>
			</strong></td>
			<td><?php echo number_format($guilds[$i]->guild_lv) ?></td>
			<td><?php echo number_format($guilds[$i]->castles) ?></td>
			<td><?php echo number_format($guilds[$i]->members) ?></td>
			<td><?php echo number_format($guilds[$i]->average_lv) ?></td>
			<td><?php echo number_format($guilds[$i]->exp) ?></td>
			<?php else: ?>
			<td colspan="8"></td>
			<?php endif ?>
		</tr>
		<?php endfor ?>
	</table>
<?php else: ?>
<p>Nenhum clã encontrado. <a href="javascript:history.go(-1)">Voltar</a>.</p>
<?php endif ?>
