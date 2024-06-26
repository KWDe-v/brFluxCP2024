<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>CashShop</h2>
<h3>Modificar item no CashShop</h3>
<?php if ($item): ?>
<?php if (!empty($errorMessage)): ?>
<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>
<form action="<?php echo $this->urlWithQs ?>" method="post" enctype="multipart/form-data">
<table class="vertical-table">
	<tr>
		<th>ID</th>
		<td><?php echo $this->linkToItem($item->shop_item_id, $item->shop_item_id) ?></td>
	</tr>
	<tr>
		<th>Nome</th>
		<td><?php echo htmlspecialchars($item->shop_item_name) ?></td>
		<td width="24"><img src="<?php echo htmlspecialchars($this->iconImage($item->shop_item_id)) ?>?nocache=<?php echo rand() ?>" /></td>
	</tr>
	<tr>
		<th><label for="tab">Aba</label></th>
		<td>
			<select name="tab" id="tab">
				<?php foreach ($tabs as $categoryID => $cat): ?>
					<option value="<?php echo (int)$categoryID ?>"<?php if ($tab === (string)$categoryID) echo ' selected="selected"' ?>><?php echo htmlspecialchars($cat) ?></option>
				<?php endforeach ?>
			</select>
		</td>
	</tr>
	<tr>
		<th><label for="price">Preço</label></th>
		<td><input type="text" class="short" name="price" id="price" value="<?php echo htmlspecialchars($price) ?>" /></td>
	</tr>
	<tr>
		<td colspan="2" align="right">
			<input type="submit" value="Modificar" />
		</td>
	</tr>
</table>
</form>
<?php else: ?>
<p>Cannot modify an unknown item to the cashshop. <a href="javascript:history.go(-1)">Go back</a>.</p>
<?php endif ?>
