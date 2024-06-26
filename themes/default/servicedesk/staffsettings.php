<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
?>
<h2>Configurações de equipe</h2>
<h3><?php echo Flux::message('SDH3StaffList') ?></h3>
<?php if($stafflist): ?>
	<table class="horizontal-table" width="100%"> 
		<tbody>
		<tr>
			<th>Nome da Conta</th>
			<th>NickName</th>
			<th>Time</th>
			<th>Ativar Notificação por Email</th>
			<?php if(isset($staffsess) && $staffsess->team>'1'): ?>
			<th>Opções</th>
			<?php endif ?>
		</tr>
		<?php foreach($stafflist as $trow): ?>
		    <tr align="center">
		        <td><?php echo $trow->account_name ?></td>
		        <td><?php echo $trow->prefered_name ?></td>
		        <td><?php echo Flux::message('SDGroup' . $trow->team) ?></td>
		        <td>
		            <?php if($trow->emailalerts == '1'): ?>
		                Ativado
		            <?php else: ?>
		                Desativado
		            <?php endif; ?>
		            
		            <?php if($trow->account_id == $session->account->account_id): ?>
		                <a href="<?php echo $this->url('servicedesk', 'staffsettings', array('option' => 'alerttoggle', 'staffid' => $trow->account_id, 'cur' => $trow->emailalerts)) ?>">
		                    <i>
		                        <?php if($trow->emailalerts == '1'): ?>
		                            (Desativar)
		                        <?php else: ?>
		                            (Ativar)
		                        <?php endif; ?>
		                    </i>
		                </a>
		            <?php endif; ?>
		        </td>
		        
		        <?php if(isset($staffsess) && $staffsess->team > '1'): ?>
		            <td><a href="<?php echo $this->url('servicedesk', 'staffsettings', array('option' => 'delete', 'staffid' => $trow->account_id)) ?>">Deletar</a></td>
		        <?php endif; ?>
		    </tr>
		<?php endforeach; ?>

		</tbody>
	</table>
<?php else: ?>
	<p>
		Não há configurações de equipe atuais<br/><br/>
	</p>
<?php endif ?>
<br />
<h3><?php echo Flux::message('SDH3StaffCreate') ?></h3>
<form action="<?php echo $this->urlWithQs ?>" method="post">
	<table class="horizontal-table" width="100%">
		<tr>
			<th>Nome da Conta</th>
			<th>NickName</th>
			<th>Time</th>
			<th>Ativar Emails</th>
		</tr>
		<tr align="center">
			<td><input type="text" name="account_name" value="<?php echo $session->account->userid ?>" readonly="readonly" /></td>
			<td><input type="text" name="prefered_name" /></td>
			<td><select name="team"><option value="1"><?php echo Flux::message('SDGroup1') ?></option><option value="2"><?php echo Flux::message('SDGroup2') ?></option><option value="3"><?php echo Flux::message('SDGroup3') ?></option></select></td>
			<td><input type="checkbox" name="emailalerts" value="1" /></td>
		</tr>
		<tr>
			<td colspan="4">
			<input type="hidden" name="account_id" value="<?php echo $session->account->account_id ?>" />
			<input type="submit" value="Adicionar Staff" /></td>
		</tr>
    </table>
</form>
