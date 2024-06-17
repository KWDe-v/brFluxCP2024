<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
?>
<h2>Controle de Categoria</h2>
<h3><?php echo Flux::message('SDH3CurrentCat') ?></h3>
<?php if($catlist): ?>
	<table class="horizontal-table" width="100%"> 
		<tbody>
		<tr >
			<th>ID</th>
			<th>Nome da Categoria</th>
			<th>Mostrar?</th>
			<th>Opções</th>
		</tr>
		<?php foreach($catlist as $trow):?>
			<tr align="center">
				<td><?php echo $trow->cat_id?></td>
				<td><?php echo $trow->name?></td>
				<td>
					<?php if($trow->display=='1'): ?>
					Sim
					<?php else: ?>
					<i>Não</i>
					<?php endif ?></td>
				<td>
					<?php if($trow->display=='1'): ?>
						<a href="<?php echo $this->url('servicedesk', 'catcontrol', array('option' => 'hide', 'catid' => $trow->cat_id))?>" >Esconder</a>
					<?php else: ?>
						<a href="<?php echo $this->url('servicedesk', 'catcontrol', array('option' => 'show', 'catid' => $trow->cat_id))?>" >Mostrar</a>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<p>
		<?php echo Flux::message('SDNoCats') ?><br/><br/>
	</p>
<?php endif ?>
<br />
<h3><?php echo Flux::message('SDH3CreateCat') ?></h3>
<form action="<?php echo $this->urlWithQs ?>" method="post">
	<table class="horizontal-table" width="100%">
		<tr>
			<th>Nome da Categoria</th>
			<th>Mostrar?</th>
		</tr>
		<tr align="center">
			<td><input type="text" name="name" /></td>
			<td><select name="display"><option value="1">Sim</option><option value="0">Não</option></select></td>
		</tr>
		<tr align="center">
			<td colspan="2">
			<input type="submit" value="Adicionar Categoria" /></td>
		</tr>
    </table>
</form>
