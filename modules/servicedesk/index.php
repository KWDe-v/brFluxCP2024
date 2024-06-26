<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();

$tbl = Flux::config('FluxTables.ServiceDeskTable'); 
$tblcat = Flux::config('FluxTables.ServiceDeskCatTable'); 

$rep = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.$tbl WHERE account_id = ? AND status != 'Closed' ORDER BY ticket_id DESC");
$rep->execute(array($session->account->account_id));
$ticketlist = $rep->fetchAll();
$rowoutput=NULL;
foreach($ticketlist as $trow){
$catsql = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.$tblcat WHERE cat_id = ?");
$catsql->execute(array($trow->category));
$catlist = $catsql->fetch();

if($trow->status == 'Pending'){
	$status = 'Pendente';
}else{
	if($trow->status == 'Resolved'){
	$status = 'Resolvido';
	}else{
		
	}
}



$rowoutput.='<tr align="center">
				<td><a href="'. $this->url('servicedesk', 'view', array('ticketid' => $trow->ticket_id)) .'" >'. $trow->ticket_id .'</a></td>
				<td><a href="'. $this->url('servicedesk', 'view', array('ticketid' => $trow->ticket_id)) .'" >'. $trow->subject .'</a></td>
				<td><a href="'. $this->url('servicedesk', 'view', array('ticketid' => $trow->ticket_id)) .'" >
					'. $catlist->name .'</a></td>
				<td>
					<font color="'. Flux::config('Font'. $trow->status .'Colour') .'"><strong>'. $status .'</strong></font>
				</td>
				<td width="50">';
					if($trow->lastreply=='0'){$rowoutput.='<i>N/A</i>';} else {$rowoutput.= $trow->lastreply;}
$rowoutput.='</td>
				<td>
					'. Flux::message('SDGroup'. $trow->team) .'
				</td>
				<td>'. date(Flux::config('DateFormat'),strtotime($trow->timestamp)) .'</td>
			</tr>';
}

$oldrep = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.$tbl WHERE account_id = ? AND status = 'Closed' ORDER BY ticket_id DESC");
$oldrep->execute(array($session->account->account_id));
$oldticketlist = $oldrep->fetchAll();
$oldrowoutput=NULL;
foreach($oldticketlist as $oldtrow){
$catsql = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.$tblcat WHERE cat_id = ?");
$catsql->execute(array($oldtrow->category));
$catlist = $catsql->fetch();
if($oldtrow->status == 'Closed'){
	$oldStatus = 'Fechado';
}
$oldrowoutput.='<tr align="center">
				<td><a href="'. $this->url('servicedesk', 'view', array('ticketid' => $oldtrow->ticket_id)) .'" >'. $oldtrow->ticket_id .'</a></td>
				<td><a href="'. $this->url('servicedesk', 'view', array('ticketid' => $oldtrow->ticket_id)) .'" >'. $oldtrow->subject .'</a></td>
				<td><a href="'. $this->url('servicedesk', 'view', array('ticketid' => $oldtrow->ticket_id)) .'" >
					'. $catlist->name .'</a></td>
				<td>
					<font color="'. Flux::config('Font'. $oldtrow->status .'Colour') .'"><strong>'. $oldStatus .'</strong></font>
				</td>
				<td width="50">';
					if($oldtrow->lastreply=='0'){$oldrowoutput.='<i>N/A</i>';} else {$oldrowoutput.= $oldtrow->lastreply;}
$oldrowoutput.='</td>
				<td>
					'. Flux::message('SDGroup'. $oldtrow->team) .'
				</td>
				<td>'. date(Flux::config('DateFormat'),strtotime($oldtrow->timestamp)) .'</td>
			</tr>';
}
?>
