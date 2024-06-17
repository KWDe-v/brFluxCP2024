<?php if (!definido('FLUX_ROOT')) saída; ?>
<h2>Horas da Guerra do Emperium</h2>
<?php if ($woeTimes): ?>
<p>Abaixo estão os horários de WoE para <?php echo htmlspecialchars($session->loginAthenaGroup->serverName) ?>.</p>
<p>Esses horários estão sujeitos a alterações a qualquer momento, mas esperamos que não.</p>
<table class="woe-table">
	<tr>
		<th>Servidores</th>
		<th colspan="3">Horários da Guerra do Emperium</th>
	</tr>
	<?php foreach ($woeTimes as $serverName => $times): ?>
	<tr>
		<td class="server" rowspan="<?php echo count($times) ?>">
			<?php echo htmlspecialchars($serverName)  ?>
		</td>
		<?php foreach ($times as $time): ?>
		<td class="time">
			<?php echo htmlspecialchars($time['startingDay']) ?>
			@ <?php echo htmlspecialchars($time['startingHour']) ?>
		</td>
		<td>~</td>
		<td class="time">
			<?php echo htmlspecialchars($time['endingDay']) ?>
			@ <?php echo htmlspecialchars($time['endingHour']) ?>
		</td>
	</tr>
	<tr>
		<?php endforeach ?>
	</tr>
	<?php endforeach ?>
</table>
<?php else: ?>
<p>Não há horários de WoE programados.</p>
<?php endif ?>
