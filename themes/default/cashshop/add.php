<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>CashShop</h2>
<h3>Adicionar item ao CashShop</h3>
<?php if ($item): ?>
<?php if (!empty($errorMessage)): ?>
<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>
<form action="<?php echo $this->urlWithQs ?>" method="post" enctype="multipart/form-data">
<table class="vertical-table">
	<tr>
		<th>ID</th>
		<td><?php echo $this->linkToItem($item->item_id, $item->item_id) ?></td>
	</tr>
	<tr>
		<th>Nome</th>
		<td><?php echo htmlspecialchars($item->item_name) ?></td>
		<td width="24"><img src="<?php echo htmlspecialchars($this->iconImage($item->item_id)) ?>?nocache=<?php echo rand() ?>" /></td>
	</tr>
	<tr>
		<th><label for="tab">Guia no jogo</label></th>
		<td>
			<select name="tab" id="tab">
				<?php foreach ($categories as $categoryID => $cat): ?>
					<option value="<?php echo (int)$categoryID ?>"<?php if ($category === (string)$categoryID) echo ' selected="selected"' ?>><?php echo htmlspecialchars($cat) ?></option>
				<?php endforeach ?>
			</select>
		</td>
	</tr>
	<tr>
		<th><label for="price">Custo de CashPoints</label></th>
		<td><input type="text" class="short" name="price" id="price" value="<?php echo htmlspecialchars($params->get('price') ?: '') ?>" /></td>
	</tr>
	<tr>
		<td colspan="2" align="right">
			<input type="submit" value="Adicionar" />
		</td>
	</tr>
</table>
</form>
<?php else: ?>
<p>Não é possível adicionar um item desconhecido à loja de itens. <a href="javascript:history.go(-1)">Voltar</a>.</p>
<?php endif ?>
