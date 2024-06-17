<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Lista de Monstros</h2>
<p class="toggler"><a href="javascript:toggleSearchForm()">Procurar...</a></p>
<form class="search-form" method="get">
	<?php echo $this->moduleActionFormInputs($params->get('module')) ?>
	<p>
		<label for="monster_id">ID do Monstro:</label>
		<input type="text" name="monster_id" id="monster_id" value="<?php echo htmlspecialchars($params->get('monster_id') ?: '') ?>" />
		...
		<label for="name">Nome:</label>
		<input type="text" name="name" id="name" value="<?php echo htmlspecialchars($params->get('name') ?: '') ?>" />
		...
		<label for="mvp">MVP:</label>
		<select name="mvp" id="mvp">
			<option value="all"<?php if (!($mvpParam=strtolower($params->get('mvp') ?: '')) || $mvpParam == 'all') echo ' selected="selected"' ?>>Todos</option>
			<option value="yes"<?php if ($mvpParam == 'yes') echo ' selected="selected"' ?>>Sim</option>
			<option value="no"<?php if ($mvpParam == 'no') echo ' selected="selected"' ?>>Não</option>
		</select>
	</p>
	<p>
		<label for="size">Tamanho:</label>
		<select name="size">
			<option value="-1"<?php if (($size=$params->get('size')) === '-1') echo ' selected="selected"' ?>>
				Qualquer Um
			</option>
			<?php foreach (Flux::config('MonsterSizes')->toArray() as $sizeId => $sizeName): ?>
				<option value="<?php echo $sizeId ?>"<?php if (($size=$params->get('size')) === strval($sizeId)) echo ' selected="selected"' ?>>
					<?php echo htmlspecialchars($sizeName) ?>
				</option>
			<?php endforeach ?>
		</select>
		...
		<label for="race">Raça:</label>
		<select name="race">
			<option value="-1"<?php if (($race=$params->get('race')) === '-1') echo ' selected="selected"' ?>>
				Qualquer Um
			</option>
			<?php foreach (Flux::config('MonsterRaces')->toArray() as $raceId => $raceName): ?>
				<option value="<?php echo $raceId ?>"<?php if (($race=$params->get('race')) === strval($raceId)) echo ' selected="selected"' ?>>
					<?php echo htmlspecialchars($raceName) ?>
				</option>
			<?php endforeach ?>
		</select>
		...
		<label for="element">Elemento:</label>
		<select name="element">
			<option value="-1"<?php if (($element=$params->get('element')) === '-1') echo ' selected="selected"' ?>>
				Qualquer Um
			</option>
			<?php foreach (Flux::config('Elements')->toArray() as $elementId => $elementName): ?>
				<option value="<?php echo $elementId ?>"<?php if (($element=$params->get('element')) === strval($elementId)) echo ' selected="selected"' ?>>
					<?php echo htmlspecialchars($elementName) ?>
				</option>
				<?php for ($elementLevel = 1; $elementLevel <= 4; $elementLevel++): ?>
					<option value="<?php echo $elementId ?>-<?php echo $elementLevel ?>"<?php if (($element=$params->get('element')) === ($elementId . '-' . $elementLevel)) echo ' selected="selected"' ?>>
						<?php echo htmlspecialchars($elementName . " (Lv $elementLevel)") ?>
					</option>
				<?php endfor ?>
			<?php endforeach ?>
		</select>
	</p>
	<p>
		<label for="custom">Custom:</label>
		<select name="custom" id="custom">
			<option value=""<?php if (!($custom=$params->get('custom'))) echo ' selected="selected"' ?>>Todos</option>
			<option value="yes"<?php if ($custom == 'yes') echo ' selected="selected"' ?>>Sim</option>
			<option value="no"<?php if ($custom == 'no') echo ' selected="selected"' ?>>Não</option>
		</select>
		
		<input type="submit" value="Procurar" />
		<input type="button" value="Resetar" onclick="reload()" />
	</p>
</form>
<?php if ($monsters): ?>
<?php echo $paginator->infoText() ?>
<table class="horizontal-table" >
	<tr>
		<th ><?php echo $paginator->sortableColumn('monster_id', 'ID do Monstro') ?></th>
		<th>Monstro</th>
		<th><?php echo $paginator->sortableColumn('name_japanese', 'Nome no kRO') ?></th>
		<th><?php echo $paginator->sortableColumn('name_english', 'Nome no iRO') ?></th>
		<th><?php echo $paginator->sortableColumn('level', 'Nível') ?></th>
		<th><?php echo $paginator->sortableColumn('hp', 'HP') ?></th>
		<th><?php echo $paginator->sortableColumn('size', 'Tamanho') ?></th>
		<th><?php echo $paginator->sortableColumn('race', 'Raça') ?></th>
		<th>Elemento</th>
		<th><?php echo $paginator->sortableColumn('base_exp', 'EXP de Base') ?></th>
		<th><?php echo $paginator->sortableColumn('job_exp', 'EXP de Classe') ?></th>
		<th><?php echo $paginator->sortableColumn('origin_table', 'Custom') ?></th>
	</tr>
	<?php foreach ($monsters as $monster): ?>
	<tr align="center">
		<td>
			<?php if ($auth->actionAllowed('monster', 'view')): ?>
				<?php echo $this->linkToMonster($monster->monster_id, $monster->monster_id) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($monster->monster_id) ?>
			<?php endif ?>
		</td>
		<?php if ($image=$this->monsterImageIndex($monster->monster_id)): ?>
		<td align="center">
			<img src="<?php echo $image ?>" style="max-width:50px;"/>
		</td>
		<?php endif ?>
		<td>
			<?php if ($monster->mvp_exp): ?>
			<span class="mvp">MVP!</span>
			<?php endif ?>
			<?php echo htmlspecialchars($monster->name_english) ?>
		</td>
		<td><?php echo htmlspecialchars($monster->name_english) ?></td>
		<td><?php echo number_format($monster->level) ?></td>
		<td><?php echo number_format($monster->hp) ?></td>
		<td>
			<?php if ($size=Flux::monsterSizeName($monster->size)): ?>
				<?php echo htmlspecialchars($size) ?>
			<?php else: ?>
				<span class="not-applicable">N/A</span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($race=Flux::monsterRaceName($monster->race)): ?>
				<?php echo htmlspecialchars($race) ?>
			<?php else: ?>
				<span class="not-applicable">N/A</span>
			<?php endif ?>
		</td>
		<td><?php echo Flux::elementName($monster->element) ?> (Lv <?php echo floor($monster->element_level) ?>)</td>
		<td><?php echo number_format($monster->base_exp * $server->expRates['Base'] / 100) ?></td>
		<td><?php echo number_format($monster->job_exp * $server->expRates['Job'] / 100) ?></td>
		<td>
			<?php if (preg_match('/mob_db2$/', $monster->origin_table)): ?>
				Sim
			<?php else: ?>
				Não
			<?php endif ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
	<p>Nenhum Monstro Encontrado. <a href="javascript:history.go(-1)"><?php echo Flux::config('GoBackLabel');?></a>.</p>
<?php endif ?>
