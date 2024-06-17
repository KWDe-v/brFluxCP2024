<?php if (!defined('FLUX_ROOT')) exit; ?>
<?php $subMenuItems = $this->getSubMenuItems(); $menus = array() ?>
<?php if (!empty($subMenuItems)): ?>
	<div id="submenu">Menu:
	<?php foreach ($subMenuItems as $menuItem): ?>
		<?php $menus[] = sprintf('<a href="%s" class="sub-menu-item%s">%s</a>',
			$this->url($menuItem['module'], $menuItem['action']),
			$params->get('module') == $menuItem['module'] && $params->get('action') == $menuItem['action'] ? ' current-sub-menu' : '',
			htmlspecialchars($menuItem['name'])) ?>
	<?php endforeach ?>
	<?php echo implode(' / ', $menus) ?>
	</div>
<?php endif ?>
<?php
try {
    $sql = "SELECT DISTINCT p.user_id, l.userid
            FROM payment p
            INNER JOIN login l ON p.user_id = l.account_id
            WHERE p.status = 'refunded'";
    $stmt = $server->connection->getStatement($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {

    // die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}


?>


<?php if($session->account->group_level >= Flux::config('AdminMenuGroupLevel')):?>
<?php if($result):?>
<?php foreach ($result as $row) {?>
<p class="red"><?php  echo "Atenção, Este Usuário tem 1 ou mais reembolsos: "?> <a href="?module=account&action=view&id=<?php echo$row['user_id'];?>" style="color: white;">Usuário: <?php echo$row['userid'];?> - ID: <?php echo$row['user_id'];?></a></p>
<?php } ?>
<?php endif ?>
<?php endif ?>