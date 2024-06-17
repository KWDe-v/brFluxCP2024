<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Historico de Transações</h2><br>
<h3>Transações: Aprovadas</h3>
<?php if ($aprovadas): ?>
<p style="color: #fff;"> <?php 
   if (count($aprovadas) > 1){
   
    echo 'Você tem '.count($aprovadas).' transações aprovadas.';
   
   }else{
   echo 'Você tem '.count($aprovadas).' transação aprovada.';
   						}
   						?> 
<table class="vertical-table">
   <tr>
      <th>ID da Transação</th>
      <th>Data da Transação</th>
      <th>Valor</th>
      <th>Forma de Pagamento</th>
   </tr>
   <?php foreach ($aprovadas as $aprovada): ?>
   <?php $data = date_create($aprovada['created']);
      $data_formatada = date_format($data, 'd-m-Y H:i:s'); ?>
   <tr align="center">
      <td><?php echo $aprovada['id']; ?></td>
      <td><?php echo $data_formatada;?></td>
      <td>R$ <?php echo $aprovada['valor']; ?></td>
      <td><?php echo $aprovada['tipo']; ?></td>
   </tr>
   <?php endforeach ?>
</table>
<?php else: ?>
<p style="color: #fff;">Você não tem transações Aprovadas.</p>
<?php endif ?>

<h3>Transações: Pendentes</h3>
<?php if ($pendentes): ?>
<p style="color: #fff;"> <?php 
   if (count($pendentes) > 1){
   
    echo 'Você tem '.count($pendentes).' transações pendentes.';
   
   }else{
   echo 'Você tem '.count($pendentes).' transação pendente.';
   						}
   						?> 
<table class="vertical-table">
   <tr>
		<th>ID da Transação</th>
		<th>Data da Transação</th>
		<th>Valor</th>
		<th>Meio de Pagamento</th>
		<th>Ação</th>
   </tr>
   <?php foreach ($pendentes as $pendente): ?>
   <?php $data = date_create($pendente['created']);
      $data_formatada = date_format($data, 'd-m-Y H:i:s'); ?>
   <tr align="center">
      <td><?php echo $pendente['id']; ?></td>
      <td><?php echo $data_formatada;?></td>
      <td>R$ <?php echo $pendente['valor']; ?></td>
      <td><?php echo $pendente['tipo']; ?></td>
	<td>



		<?php if(Flux::config('MethodPayment') == false):?>

		<a href="?module=mp&action=repaymentpix&token=aaa&id=<?php echo $pendente['id']; ?>&tipo=1&user_id=<?php echo $user_id; ?>&vl=<?php echo $pendente['valor']; ?>"><span  class="submit_button" style=" font-size: 15px;">Pagar com PiX</span></a>
		<a href="?module=mp&action=repaymentlink&token=aaa&id=<?php echo $pendente['id']; ?>&tipo=0&user_id=<?php echo $user_id; ?>&vl=<?php echo $pendente['valor']; ?>"><span  class="submit_button" style=" font-size: 15px;">Pagar com Link</span></a>
		<?php else:?>
			<a href="?module=mp&action=repaymentpix&token=aaa&id=<?php echo $pendente['id']; ?>&tipo=1&user_id=<?php echo $user_id; ?>&vl=<?php echo $pendente['valor']; ?>"><span  class="submit_button" style=" font-size: 15px;">Pagar</span></a>
		<?php endif?>
	</td>

   </tr>
   <?php endforeach ?>
</table>
<?php else: ?>
<p style="color: #fff;">Você não tem transações pendentes.</p>
<?php endif ?>

<h3>Transações: Reembolsadas</h3>
<?php if ($reembolsos): ?>
<p style="color: #fff;"> <?php 
   if (count($reembolsos) > 1){
   
    echo 'Você tem '.count($reembolsos).' transações reembolsadas.';
   
   }else{
   echo 'Você tem '.count($reembolsos).' transação reembolsada.';
   						}
   						?> 



   	<?php if (!(count($reembolsos) <= 0)): ?>
   		<br><br><p class="red">Atenção, a partir do segundo reembolso, você terá sua conta DELETADA A QUALQUER MOMENTO e não terá chances de recuperar conta!!!</p>
   	<?php endif ?>
<table class="vertical-table">
   <tr>
      <th>ID da Transação</th>
      <th>Data da Transação</th>
      <th>Valor</th>
      <th>Forma de Pagamento</th>
   </tr>
   <?php foreach ($reembolsos as $reembolso): ?>
   <?php $data = date_create($reembolso['created']);
      $data_formatada = date_format($data, 'd-m-Y H:i:s'); ?>
   <tr align="center"> 
      <td><?php echo $reembolso['id']; ?></td>
      <td><?php echo $data_formatada;?></td>
      <td>R$ <?php echo $reembolso['valor']; ?></td>
      <td><?php echo $reembolso['tipo']; ?></td>
   </tr>
   <?php endforeach ?>
</table>
<?php else: ?>
<p style="color: #fff;">Você não tem transações reembolsadas.</p>
<?php endif ?>
