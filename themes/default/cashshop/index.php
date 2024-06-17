<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>CashShop</h2>
<?php if (!empty($errorMessage)): ?>
<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>
<table class="vertical-table">
	<tr>
		<th>Aba</th>
		<th>ID</th>
		<th colspan="2">Nome</th>
		<th>Preço</th>
		<th>Opções</th>
	</tr>
	<?php foreach($items as $item):?>
	<tr>
		<td><?php echo $tabs[$item->tab] ?></td>
		<td><?php echo $this->linkToItem($item->item_id, $item->item_id) ?></td>

		<td width="24"><img src="<?php echo htmlspecialchars($this->iconImage($item->item_id)) ?>?nocache=<?php echo rand() ?>" /></td>
		<td><?php echo $this->linkToItem($item->item_id, htmlspecialchars($item->item_name)) ?></td>
		<td><?php echo $item->price ?></td>
		<td><a href="<?php echo $this->url('cashshop', 'edit', array('id' => $item->item_id)) ?>">Editar</a> | <a href="<?php echo $this->url('cashshop', 'delete', array('id' => $item->item_id)) ?>">Remover</a></td>
	</tr>	
	<?php endforeach ?>
</table>
