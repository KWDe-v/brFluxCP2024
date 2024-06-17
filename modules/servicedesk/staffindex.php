<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();

$tbl = Flux::config('FluxTables.ServiceDeskTable'); 
$tblcat = Flux::config('FluxTables.ServiceDeskCatTable'); 

$rep = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.$tbl WHERE status != 'Closed' ORDER BY ticket_id DESC");
$rep->execute();
$ticketlist = $rep->fetchAll();
$rowoutput=NULL;
foreach($ticketlist as $trow){
$catsql = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.$tblcat WHERE cat_id = ?");
$catsql->execute(array($trow->category));
$catlist = $catsql->fetch();


if ($trow->status == 'Pending'){
	$status = 'Pendente';
}else{
	if ($trow->status == 'Resolved'){
		$status = 'Resolvido';
	}else{
		if ($trow->status == 'Closed'){
			$status = 'Fechado';
		}else{
			$status = 'N/A';
		}
	}
}


$rowoutput.='<tr  align="center">
				<td><a href="'. $this->url('servicedesk', 'staffview', array('ticketid' => $trow->ticket_id)) .'" >'. $trow->ticket_id .'</a></td>
				<td>'. $trow->account_id .'</td>
				<td><a href="'. $this->url('servicedesk', 'staffview', array('ticketid' => $trow->ticket_id)) .'" >'. $trow->subject .'</a></td>
				<td><a href="'. $this->url('servicedesk', 'staffview', array('ticketid' => $trow->ticket_id)) .'" >
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

?>
