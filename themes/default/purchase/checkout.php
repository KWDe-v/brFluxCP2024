<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Finalizar Compra</h2>
<p>O processo de finalização é bastante simples e, quando você terminar, estará pronto para resgatar seus itens no jogo através do nosso <span class="keyword">NPC de Resgate</span>.</p>
<h3>Informações da Compra</h3>
<p class="cart-total-text">O subtotal atual é de <span class="cart-sub-total"><?php echo number_format($total=$server->cart->getTotal()) ?></span> crédito(s).</p>
<p class="checkout-info-text">Seu saldo restante após esta compra será de <span class="remaining-balance"><?php echo number_format($session->account->balance - $total) ?></span> crédito(s).</p>
<p>Após revisar as informações dos itens abaixo, você pode prosseguir com a finalização da compra clicando no botão “Comprar Itens”.</p>
<p class="important">Nota: Esses itens são para resgate apenas no servidor <span class="server-name"><?php echo htmlspecialchars($server->serverName) ?></span>.</p>
<p>

	<form action="<?php echo $this->url ?>" method="post">
		<?php echo $this->moduleActionFormInputs($params->get('module'), 'checkout') ?>
		<input type="hidden" name="process" value="1" />
		<button type="submit" onclick="return confirm('Tem certeza de que deseja continuar comprando o(s) item(ns) abaixo?')">
			<strong>Finalizar Compra</strong>
		</button>
	</form>
</p>

<h3>Itens atualmente em seu carrinho:</h3>
<p class="cart-info-text">Você tem <span class="cart-item-count"><?php echo number_format(count($items)) ?></span> itens em seu carrinho.</p>
<table class="vertical-table cart">
	<?php foreach ($items as $item): ?>
	<tr>			
		<td class="shop-item-image">
			<?php if (($item->shop_item_use_existing && ($image=$this->itemImage($item->shop_item_nameid))) || ($image=$this->shopItemImage($item->shop_item_id))): ?>
				<img src="<?php echo $image ?>?nocache=<?php echo rand() ?>" />
			<?php endif ?>
		</td>
		<td>
			<h4>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($item->shop_item_nameid, $item->shop_item_name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($item->shop_item_nameid) ?>
				<?php endif ?>
			</h4>
			<?php if ($item->shop_item_qty > 1): ?>
			<p class="shop-item-qty">Quantidade: <span class="qty"><?php echo number_format($item->shop_item_qty) ?></span></p>
			<?php endif ?>
			<p class="shop-item-cost"><span class="cost"><?php echo number_format($item->shop_item_cost) ?></span> créditos</p>
			<p><?php echo nl2br(htmlspecialchars($item->shop_item_info)) ?></p>
		</td>
	</tr>
	<?php endforeach ?>
</table>
