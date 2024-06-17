<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Lista de Itens</h2>
<p class="toggler"><a href="javascript:toggleSearchForm()">Procurar...</a></p>
<form class="search-form" method="get">
	<?php echo $this->moduleActionFormInputs($params->get('module')) ?>
	<p>
		<label for="item_id">ID do Item:</label>
		<input type="text" name="item_id" id="item_id" value="<?php echo htmlspecialchars($params->get('item_id') ?: '') ?>" />
		...
		<label for="name">Nome:</label>
		<input type="text" name="name" id="name" value="<?php echo htmlspecialchars($params->get('name') ?: '') ?>" />
		...
		<label for="type">Tipo:</label>
		<select name="type">
			<option value="-1"<?php if (($type=$params->get('type')) === '-1') echo ' selected="selected"' ?>>
				Qualquer Um
			</option>
			<?php foreach (Flux::config('ItemTypes')->toArray() as $typeId => $typeName): ?>
				<option value="<?php echo $typeId ?>"<?php if (($type=$params->get('type')) === strval($typeId)) echo ' selected="selected"' ?>>
					<?php echo htmlspecialchars($typeName) ?>
				</option>
				<?php $itemSubTypes = Flux::config('ItemSubTypes')->toArray() ?>
				<?php if (array_key_exists($typeId, $itemSubTypes)): ?>
					<?php foreach ($itemSubTypes[$typeId] as $subtypeId => $subtypeName): ?>
					<option value="<?php echo $typeId ?>-<?php echo $subtypeId ?>"<?php if (($type=$params->get('type')) === ($typeId . '-' . $subtypeId)) echo ' selected="selected"' ?>>
						<?php echo htmlspecialchars($typeName . ' - ' . $subtypeName) ?>
					</option>
					<?php endforeach ?>
				<?php endif ?>
			<?php endforeach ?>
		</select>
		...
		<label for="equip_loc">Equipa Em:</label>
		<select name="equip_loc">
			<option value="-1"<?php if (($equip_loc=$params->get('equip_loc')) === '-1') echo ' selected="selected"' ?>>
				Qualquer Um
			</option>
			<?php foreach (Flux::config('EquipLocations')->toArray() as $locId => $locName): ?>
				<option value="<?php echo $locId ?>"<?php if (($equip_loc=$params->get('equip_loc')) === strval($locId)) echo ' selected="selected"' ?>>
					<?php echo htmlspecialchars($locName) ?>
				</option>
			<?php endforeach ?>
		</select>
	</p>
	<p>
		<label for="npc_buy">Preço de Compra de NPC:</label>
		<select name="npc_buy_op">
			<option value="eq"<?php if (($npc_buy_op=$params->get('npc_buy_op')) == 'eq') echo ' selected="selected"' ?>>É igual a</option>
			<option value="gt"<?php if ($npc_buy_op == 'gt') echo ' selected="selected"' ?>>É maior que</option>
			<option value="lt"<?php if ($npc_buy_op == 'lt') echo ' selected="selected"' ?>>É menor que</option>
		</select>
		<input type="text" name="npc_buy" id="npc_buy" value="<?php echo htmlspecialchars($params->get('npc_buy') ?: '') ?>" />
		...
		<label for="npc_sell">Preço de Venda de NPC:</label>
		<select name="npc_sell_op">
			<option value="eq"<?php if (($npc_sell_op=$params->get('npc_sell_op')) == 'eq') echo ' selected="selected"' ?>>É igual a</option>
			<option value="gt"<?php if ($npc_sell_op == 'gt') echo ' selected="selected"' ?>>É maior que</option>
			<option value="lt"<?php if ($npc_sell_op == 'lt') echo ' selected="selected"' ?>>É menor que</option>
		</select>
		<input type="text" name="npc_sell" id="npc_sell" value="<?php echo htmlspecialchars($params->get('npc_sell') ?: '') ?>" />
		...
		<label for="weight">Peso:</label>
		<select name="weight_op">
			<option value="eq"<?php if (($weight_op=$params->get('weight_op')) == 'eq') echo ' selected="selected"' ?>>É igual a</option>
			<option value="gt"<?php if ($weight_op == 'gt') echo ' selected="selected"' ?>>É maior que</option>
			<option value="lt"<?php if ($weight_op == 'lt') echo ' selected="selected"' ?>>É menor que</option>
		</select>
		<input type="text" name="weight" id="weight" value="<?php echo htmlspecialchars($params->get('weight') ?: '') ?>" />
	</p>
	<p>
		<label for="range">Alcance:</label>
		<select name="range_op">
			<option value="eq"<?php if (($range_op=$params->get('range_op')) == 'eq') echo ' selected="selected"' ?>>É igual a</option>
			<option value="gt"<?php if ($range_op == 'gt') echo ' selected="selected"' ?>>É maior que</option>
			<option value="lt"<?php if ($range_op == 'lt') echo ' selected="selected"' ?>>É menor que</option>
		</select>
		<input type="text" name="range" id="range" value="<?php echo htmlspecialchars($params->get('range') ?: '') ?>" />
		...
		<label for="slots">Slots:</label>
		<select name="slots_op">
			<option value="eq"<?php if (($slots_op=$params->get('slots_op')) == 'eq') echo ' selected="selected"' ?>>É igual a</option>
			<option value="gt"<?php if ($slots_op == 'gt') echo ' selected="selected"' ?>>É maior que</option>
			<option value="lt"<?php if ($slots_op == 'lt') echo ' selected="selected"' ?>>É menor que</option>
		</select>
		<input type="text" name="slots" id="slots" value="<?php echo htmlspecialchars($params->get('slots') ?: '') ?>" />
		...
		<label for="defense">Defesa:</label>
		<select name="defense_op">
			<option value="eq"<?php if (($defense_op=$params->get('defense_op')) == 'eq') echo ' selected="selected"' ?>>É igual a</option>
			<option value="gt"<?php if ($defense_op == 'gt') echo ' selected="selected"' ?>>É maior que</option>
			<option value="lt"<?php if ($defense_op == 'lt') echo ' selected="selected"' ?>>É menor que</option>
		</select>
		<input type="text" name="defense" id="defense" value="<?php echo htmlspecialchars($params->get('defense') ?: '') ?>" />
	</p>
	<p>
		<label for="attack">Ataquek:</label>
		<select name="attack_op">
			<option value="eq"<?php if (($attack_op=$params->get('attack_op')) == 'eq') echo ' selected="selected"' ?>>É igual a</option>
			<option value="gt"<?php if ($attack_op == 'gt') echo ' selected="selected"' ?>>É maior que</option>
			<option value="lt"<?php if ($attack_op == 'lt') echo ' selected="selected"' ?>>É menor que</option>
		</select>
		<input type="text" name="attack" id="attack" value="<?php echo htmlspecialchars($params->get('attack') ?: '') ?>" />
		...
		<?php if($server->isRenewal): ?>
		<label for="magic_attack">MATK:</label>
		<select name="matk_op">
			<option value="eq"<?php if (($matk_op=$params->get('matk_op')) == 'eq') echo ' selected="selected"' ?>>É igual a</option>
			<option value="gt"<?php if ($matk_op == 'gt') echo ' selected="selected"' ?>>É maior que</option>
			<option value="lt"<?php if ($matk_op == 'lt') echo ' selected="selected"' ?>>É menor que</option>
		</select>
		<input type="text" name="magic_attack" id="magic_attack" value="<?php echo htmlspecialchars($params->get('magic_attack') ?: '') ?>" />
		...
		<?php endif ?>
		<label for="refineable">Revinável:</label>
		<select name="refineable" id="refineable">
			<option value=""<?php if (!($refineable=$params->get('refineable'))) echo ' selected="selected"' ?>>Todos</option>
			<option value="yes"<?php if ($refineable == 'yes') echo ' selected="selected"' ?>>Sim</option>
			<option value="no"<?php if ($refineable == 'no') echo ' selected="selected"' ?>>Não</option>
		</select>
		...
		<label for="for_sale">À venda:</label>
		<select name="for_sale" id="for_sale">
			<option value=""<?php if (!($for_sale=$params->get('for_sale'))) echo ' selected="selected"' ?>>Todos</option>
			<option value="yes"<?php if ($for_sale == 'yes') echo ' selected="selected"' ?>>Sim</option>
			<option value="no"<?php if ($for_sale == 'no') echo ' selected="selected"' ?>>Não</option>
		</select>
		...
		<label for="custom">Custom:</label>
		<select name="custom" id="custom">
			<option value=""<?php if (!($custom=$params->get('custom'))) echo ' selected="selected"' ?>>Todos</option>
			<option value="yes"<?php if ($custom == 'yes') echo ' selected="selected"' ?>>Sim</option>
			<option value="no"<?php if ($custom == 'no') echo ' selected="selected"' ?>>Não</option>
		</select>
		...
		<input type="submit" value="Procurar" />
		<input type="button" value="Resetar" onclick="reload()" />
	</p>
</form>
<?php if ($items): ?>
<?php echo $paginator->infoText() ?>
<table class="horizontal-table">
	<tr>
		<th><?php echo $paginator->sortableColumn('item_id', 'ID') ?></th>
		<th colspan="2"><?php echo $paginator->sortableColumn('name', 'Nome') ?></th>
		<th><?php echo $paginator->sortableColumn('type', 'Tipo') ?></th>
		<th><?php echo $paginator->sortableColumn('subtype', 'Categoria') ?></th>
		<th>Equipa em</th>
		<th><?php echo $paginator->sortableColumn('price_buy', 'Preço de Compra') ?></th>
		<th><?php echo $paginator->sortableColumn('price_sell', 'Preço de Venda') ?></th>
		<th><?php echo $paginator->sortableColumn('weight', 'Peso') ?></th>
		<th><?php echo $paginator->sortableColumn('attack', 'Ataque') ?></th>
		<?php if($server->isRenewal): ?>
		<th><?php echo $paginator->sortableColumn('magic_attack', 'MATK') ?></th>
		<?php endif ?>
		<th><?php echo $paginator->sortableColumn('defense', 'Defesa') ?></th>
		<th><?php echo $paginator->sortableColumn('range', 'Alcance') ?></th>
		<th><?php echo $paginator->sortableColumn('slots', 'Slots') ?></th>
		<th><?php echo $paginator->sortableColumn('refineable', 'Refinável') ?></th>
		<th><?php echo $paginator->sortableColumn('cost', 'À venda') ?></th>
		<th><?php echo $paginator->sortableColumn('origin_table', 'Custom') ?></th>
	</tr>
	<?php foreach ($items as $item): ?>
	<tr align="center">
		<td>
			<?php if ($auth->actionAllowed('item', 'view')): ?>
				<?php echo $this->linkToItem($item->item_id, $item->item_id) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($item->item_id) ?>
			<?php endif ?>
		</td>
		<?php if ($icon=$this->iconImage($item->item_id)): ?>
			<td width="24"><img src="<?php echo htmlspecialchars($icon) ?>?nocache=<?php echo rand() ?>" /></td>
			<td><?php echo htmlspecialchars($item->name ?: '') ?></td>
		<?php else: ?>
			<td colspan="2"><?php echo htmlspecialchars($item->name ?: '') ?></td>
		<?php endif ?>
		<td>
			<?php if ($type=$this->itemTypeText($item->type)): ?>
				<?php echo htmlspecialchars($type) ?>
			<?php else: ?>
				<span class="not-applicable">N/A</span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($subtype=$this->itemSubTypeText($item->type, $item->subtype)): ?>
				<?php echo htmlspecialchars($subtype) ?>
			<?php else: ?>
				<span class="not-applicable">N/A</span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($equip_locations=$this->equipLocations($item->equip_location)): ?>
				<?php echo $equip_locations ?>
			<?php else: ?>
				<span class="not-applicable">N/A</span>
			<?php endif ?>
		</td>
		<td><?php echo number_format((int)$item->price_buy) ?></td>
		<td><?php echo number_format((int)$item->price_sell) ?></td>
		<td><?php echo round($item->weight ?: 0, 1) ?></td>
		<td><?php echo number_format((int)$item->attack) ?></td>
		<?php if($server->isRenewal): ?>
			<td><?php echo number_format((int)$item->magic_attack) ?></td>
		<?php endif ?>
		<td><?php echo number_format((int)$item->defense) ?></td>
		<td><?php echo number_format((int)$item->range) ?></td>
		<td><?php echo number_format((int)$item->slots) ?></td>
		<td>
			<?php if ($item->refineable): ?>
				<span class="refineable yes">Sim</span>
			<?php else: ?>
				<span class="refineable no">Não</span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($item->cost): ?>
				<span class="for-sale yes"><a href="<?php echo $this->url('purchase') ?>" title="Ir Para a Loja">Sim</a></span>
			<?php else: ?>
				<span class="for-sale no">Não</span>
			<?php endif ?>
		</td>
		<td>
			<?php if (preg_match('/item_db2$/', $item->origin_table)): ?>
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
	<p>Nenhum item encontrado. <a href="javascript:history.go(-1)">Voltar ao ínicio</a>.</p>
	<?php if(Flux::config('Debug')): ?>
		<?php $msg = sprintf('Error info: %s', print_r($sth->errorInfo(), true)); ?>
		<?php echo $msg; ?>
	<?php endif ?>
<?php endif ?>
