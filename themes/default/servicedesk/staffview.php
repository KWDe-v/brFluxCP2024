<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
?>
<?php if($ticketlist): ?>
<h2><?php echo Flux::message('SDHeaderID') ?><?php echo htmlspecialchars($trow->ticket_id) ?> - <?php echo htmlspecialchars($trow->subject) ?> - Staff Area</h2>
	<table class="vertical-table" width="100%">
    <tbody>
        <tr>
            <th>Conta</th>
            <td><?php echo $this->linkToAccount($trow->account_id,''. $ticketaccount->userid .' ('.$trow->account_id.')') ?></td>
            <th>Personagens Afetados</th>
            <?php if($trow->char_id=='0'):?>
                <td><i>Todos os Personagens</i></td>
            <?php elseif($trow->char_id=='-1'):?>
                <td><i>Nenhum na conta</i></td>
            <?php else:?>
                <td><?php echo $this->linkToCharacter($trow->char_id,$char->name) ?></td>
            <?php endif ?>
        </tr>
        <tr>
            <th>Categoria</th>
            <td><?php echo $catname ?></td>
            <th>Status Atual</th>
            <td><?php echo htmlspecialchars($trow->status) ?></td>
        </tr>
        <tr>
            <th>Data/Hora de Submissão</th>
            <td><?php echo htmlspecialchars($trow->timestamp) ?></td>
            <th>Equipe</th>
            <td>
                <?php if($trow->team=='1'): ?>
                    <?php echo Flux::message('SDGroup1') ?>
                <?php elseif($trow->team=='2'): ?>
                    <?php echo Flux::message('SDGroup2') ?>
                <?php elseif($trow->team=='3'): ?>
                    <?php echo Flux::message('SDGroup3') ?>
                <?php endif ?>
            </td>
        </tr>
        <tr>
            <th>Assunto</th>
            <td colspan="3"><?php echo nl2br($trow->subject) ?></td>
        </tr>
        <?php if($trow->chatlink!='0'): ?>
            <tr>
                <th>Logs de Chat</th>
                <td colspan="3"><a href="<?php echo htmlspecialchars($trow->chatlink) ?>" target="_blank"><?php echo htmlspecialchars($trow->chatlink) ?></a></td>
            </tr>
        <?php endif ?>
        <?php if($trow->sslink!='0'): ?>
            <tr>
                <th>Capturas de Tela</th>
                <td colspan="3"><a href="<?php echo $trow->sslink ?>" target="_blank"><img src="<?php echo $trow->sslink ?>" width="100px" height="100"></a></td>
            </tr>
        <?php endif ?>
        <?php if($trow->videolink!='0'): ?>
            <tr>
                <th>Captura de Vídeo</th>
                <td colspan="3"><?php echo htmlspecialchars($trow->videolink) ?></td>
            </tr>
        <?php endif ?>
        <tr>
            <th>Relatório</th>
            <td colspan="3"><?php echo htmlspecialchars($trow->text) ?></td>
        </tr>
    </tbody>
</table>

	<br />

	<?php if($replylist): ?>
	<?php foreach($replylist as $rrow): ?>
	<table class="vertical-table" width="100%">
		<tbody>
		<tr>
			<th width="100">Respondido Por</th>
			<td><?php if($rrow->isstaff==1): ?>
					<font color="<?php echo Flux::config('StaffReplyColour') ?>"><?php echo $rrow->author ?></font>
				<?php elseif($rrow->isstaff==0): ?>
					<?php echo $rrow->author ?>
				<?php endif ?></td>
		</tr>
		<?php if($rrow->text!='0'): ?>
		<tr>
			<th>Resposta</th>
			<td><?php echo nl2br(stripslashes($rrow->text)) ?></td>
		</tr>

		<?php endif ?>
		<?php if($rrow->action!='0'): ?>
		<tr>
			<th>Ação</th>
			<td><?php echo $rrow->action ?></td>
		</tr>
		<?php endif ?>
		<tr>
			<th>Timestamp</th>
			<td><?php echo $rrow->timestamp ?></td>
		</tr>
		</tbody>
	</table><br />
	<?php endforeach ?>
	<?php else: ?>
		<table class="vertical-table" width="100%">
		<tbody>
		<tr>
			<th>Não há respostas para este ticket.</th>
		</tr>
		</tbody>
	</table>
	<?php endif ?>
	<br />

	<?php if($trow->status!='Resolved' || $trow->status!='Closed'): ?>
	<form action="<?php echo $this->urlWithQs ?>" method="post">
	<table class="vertical-table" width="100%">
		<tbody>
		<tr>
			<th width="100">Resposta</th>
			<td><textarea cols="30" rows="10" name="response" placeholder="Clique aqui para inserir uma resposta."></textarea></td>
		</tr>
		<tr>
			<th>Ações</th>
			<td><table class="generic-form-table">
				<?php if($trow->status!="Resolved" && $trow->status!="Closed"): ?>
					<tr><td><?php echo Flux::message('SDRespTable1') ?>:</td><td><input type="radio" name="secact" value="1" checked="checked" /></td></tr>
					<tr><td><?php echo Flux::message('SDRespTable2') ?>:</td><td><input type="radio" name="secact" value="2" /></td></tr>
					<tr><td><?php echo Flux::message('SDRespTable3') ?>:</td><td><input type="radio" name="secact" value="3" /></td></tr>
					<?php if(Flux::config('SDEnableCreditRewards')):?>
					<tr><td><?php echo Flux::message('SDRespTable7') ?>: <input type="number" value="<?php echo Flux::config('SDCreditReward') ?>" name="award_credits" style="width:50px;"/></td><td><input type="radio" name="secact" value="7" /></td></tr>
					<?php endif ?>
					<?php if($trow->team<3): ?>
						<tr><td><?php echo Flux::message('SDRespTable4') ?>:</td><td><input type="radio" name="secact" value="4" /></td></tr>
						<input type="hidden" name="curteam" value="<?php echo $trow->team ?>" />
					<?php endif ?>
				<?php endif ?>
				<?php if($staffsess->team>=2 && $trow->status=="Resolved"): ?>
					<tr><td><?php echo Flux::message('SDRespTable5') ?>:</td><td><input type="radio" name="secact" value="5" /></td></tr>
				<?php endif ?>
				<?php if($trow->status=="Resolved" || $trow->status=="Closed"): ?>
					<tr><td><?php echo Flux::message('SDRespTable6') ?>:</td><td><input type="radio" name="secact" value="6" checked="checked" /></td></tr>
				<?php endif ?>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<?php if(Flux::config('SDEnableCreditRewards')):?>
			<input type="hidden" name="account_id" value="<?php echo $trow->account_id ?>" />
			<?php endif ?>
			<input type="hidden" name="staff_reply_name" value="<?php echo $staffsess->prefered_name ?>" />
			<input type="hidden" name="curemail" value="<?php echo $trow->curemail ?>" />
			<input type="hidden" name="postreply" value="gogolol" />
			<input type="submit" name="submit" value="Add Reply" /></td>
		</tr>
		</tbody>
	</table>
	</form>
	<?php endif ?>

<?php else: ?>
	<p>
		<?php echo htmlspecialchars(Flux::message('SDHuh')) ?>
	</p>
<?php endif ?>
