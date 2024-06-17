<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Vendo Item</h2>
<?php if ($item): ?>
<?php $icon = $this->iconImage($item->item_id); ?>
<h3>
	<?php if ($icon): ?><img src="<?php echo $icon ?>" /><?php endif ?>
	#<?php echo htmlspecialchars($item->item_id) ?>: <?php echo htmlspecialchars($item->name) ?>
</h3>
<table class="vertical-table">
	<tr align="center">
		<th>ID do Item</th>
		<td><?php echo htmlspecialchars($item->item_id) ?></td>
		<?php if ($image=$this->itemImage($item->item_id)): ?>
		<td rowspan="<?php echo ($server->isRenewal)?9:8 ?>" style="width: 150px; text-align: center; vertical-alignment: middle">
			<img src="<?php echo $image ?>" />
		</td>
		<?php endif ?>
		<th>A Venda</th>
		<td>
			<?php if ($item->cost): ?>
				<span class="for-sale yes">
					Sim
				</span>
			<?php else: ?>
				<span class="for-sale no">
					Não
				</span>
			<?php endif ?>
		</td>
	</tr>
	<tr align="center">
		<th>Identificador</th>
		<td><?php echo htmlspecialchars($item->identifier) ?></td>
		<th>Preço em Créditos</th>
		<td>
			<?php if ($item->cost): ?>
				<?php echo number_format((int)$item->cost) ?>
			<?php else: ?>
				<span class="not-applicable">Não está a venda</span>
			<?php endif ?>
		</td>
	</tr>
	<tr align="center">
		<th>Nome</th>
		<td><?php echo htmlspecialchars($item->name) ?></td>
		<th>Tipe</th>
		<td><?php echo $this->itemTypeText($item->type) ?><?php if($item->subtype) echo ' - '.$this->itemSubTypeText($item->type, $item->subtype) ?></td>
	</tr>
	<tr align="center">
		<th>Preço de Compra em NPC</th>
		<td><?php echo number_format((int)$item->price_buy) ?></td>
		<th>Peso</th>
		<td><?php echo round($item->weight, 1) ?></td>
	</tr>
	<tr align="center">
		<th>Preço de Venda em NPC</th>
		<td>
			<?php if (is_null($item->price_sell) && $item->price_buy): ?>
				<?php echo number_format(floor($item->price_buy / 2)) ?>
			<?php else: ?>
				<?php echo number_format((int)$item->price_sell) ?>
			<?php endif ?>
		</td>
		<th>Level da Arma </th>
		<td><?php echo number_format((int)$item->weapon_level) ?></td>
	</tr>
	<tr align="center">
		<th>Alcance</th>
		<td><?php echo number_format((int)$item->range) ?></td>
		<th>Defesa</th>
		<td><?php echo number_format((int)$item->defense) ?></td>
	</tr>
	<tr align="center">
		<th>Slots</th>
		<td><?php echo number_format((int)$item->slots) ?></td>
		<th>Refinável</th>
		<td>
			<?php if ($item->refineable): ?>
				Yes
			<?php else: ?>
				No
			<?php endif ?>
		</td>
	</tr>
	<tr align="center">
		<th>Ataquek</th>
		<td><?php echo number_format((int)$item->attack) ?></td>
		<th>Mínimo de Nível para Equipar</th>
		<td>
			<?php if ($item->equip_level_min == 0): ?>
				<span class="not-applicable">N/A</span>
			<?php else: ?>
				<?php echo number_format((int)$item->equip_level_min) ?>
			<?php endif ?>
		</td>
	</tr>
	<tr align="center">
		<?php if($server->isRenewal): ?>
			<th>MATK</th>
			<td><?php echo number_format((int)$item->magic_attack) ?></td>
		<?php endif ?>
		<th>Máximo de Nível para Equipar</th>
		<td colspan="<?php echo $image ? 0 : 3 ?>">
			<?php if ($item->equip_level_max == 0): ?>
				<span class="not-applicable">N/A</span>
			<?php else: ?>
				<?php echo number_format((int)$item->equip_level_max) ?>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Equipado em</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($equip_locations=$this->equipLocations($equip_locs)): ?>
				<?php echo $equip_locations ?>
			<?php else: ?>
				<span class="not-applicable">N/A</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Superior</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($this->equipUpper($upper)): ?>
				<?php echo htmlspecialchars(implode(' / ', $this->equipUpper($upper))) ?>
			<?php else: ?>
				<span class="not-applicable">N/A</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Classes Equipáveis</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($this->equippableJobs($jobs)): ?>
				<?php echo htmlspecialchars(implode(' / ', $this->equippableJobs($jobs))) ?>
			<?php else: ?>
				<span class="not-applicable">N/A</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Gênero</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($item->gender == 'Female'): ?>
				Mulher
			<?php elseif ($item->gender == 'Male'): ?>
				Homem
			<?php elseif ($item->gender == 'Both' || $item->gender == NULL): ?>
				Ambos (Homem e Mulher)
			<?php else: ?>
				<span class="not-applicable">N/A</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Restrições</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($this->tradeRestrictions($restrictions)): ?>
				<?php echo htmlspecialchars(implode(' / ', $this->tradeRestrictions($restrictions))) ?>
			<?php else: ?>
				<span class="not-applicable">N/A</span>
			<?php endif ?>
		</td>
	</tr>
	<?php if (($isCustom && $auth->allowedToSeeItemDb2Scripts) || (!$isCustom && $auth->allowedToSeeItemDbScripts)): ?>
	<tr>
		<th>Script de Uso</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($script=$this->displayScript($item->script)): ?>
				<?php echo $script ?>
			<?php else: ?>
				<span class="not-applicable">N/A</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Script ao Equipar<</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($script=$this->displayScript($item->equip_script)): ?>
				<?php echo $script ?>
			<?php else: ?>
				<span class="not-applicable">None</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Script ao Desequipar</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($script=$this->displayScript($item->unequip_script)): ?>
				<?php echo $script ?>
			<?php else: ?>
				<span class="not-applicable">None</span>
			<?php endif ?>
		</td>
	</tr>
	<?php endif ?>
    <?php if(Flux::config('ShowItemDesc')):?>
	<tr>
		<th>Descrição</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if($item->itemdesc): ?>
                <?php echo $item->itemdesc ?>
            <?php else: ?>
                <span class="not-applicable">None</span>
			<?php endif ?>
		</td>
	</tr>
    <?php endif ?>
    
</table>
<?php if ($itemDrops): ?>
<h3><?php echo htmlspecialchars($item->name) ?> é Dropado por</h3>
<table class="vertical-table">
	<tr>
		<th>ID do Monstro</th>
		<th colspan="2">Nome do Monstro</th>
		<th><?php echo htmlspecialchars($item->name) ?> Chance de Drop</th>
		<th>Pode ser Roubado</th>
		<th>Level do Monstro</th>
		<th>Raça do Monstro</th>
		<th>Elemento do Monstro</th>
	</tr>
	<?php foreach ($itemDrops as $itemDrop): ?>
		<tr align="center" class="item-drop-<?php echo htmlspecialchars($itemDrop['type']) ?>">
			<td>
				<?php if ($auth->actionAllowed('monster', 'view')): ?>
					<?php echo $this->linkToMonster($itemDrop['monster_id'], $itemDrop['monster_id']) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($itemDrop['monster_id']) ?>
				<?php endif ?>
			</td>
			<?php if ($image = $this->monsterImageIndex($itemDrop['monster_id'])): ?>
			<td align="center">
				<img src="<?php echo htmlspecialchars($image) ?>" style="max-width:50px;max-height:75px;" />
			</td>
			<?php endif ?>
			<td>
				<?php if ($itemDrop['type'] == 'mvp'): ?>
					<span class="mvp">MVP!</span>
				<?php endif ?>
				<?php echo htmlspecialchars($itemDrop['monster_name']) ?>
			</td>
			<td><strong><?php echo htmlspecialchars($itemDrop['drop_rate']) ?>%</strong></td>
			<td><strong><?php echo htmlspecialchars(Flux::message($itemDrop['drop_steal'])) ?></strong></td>
			<td><?php echo number_format($itemDrop['monster_level']) ?></td>
			<td><?php echo htmlspecialchars(Flux::monsterRaceName($itemDrop['monster_race'])) ?></td>
			<td>
				Level <?php echo floor($itemDrop['monster_ele_lv']) ?>
				<em><?php echo htmlspecialchars(Flux::elementName($itemDrop['monster_element'])) ?></em>
			</td>
		</tr>
	<?php endforeach ?>
</table>
<?php endif ?>

<?php else: ?>
<p>Nenhum item foi encontrado. <a href="javascript:history.go(-1)">Voltar</a>.</p>
<?php endif ?>
