<?php
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
$title = Flux::message('MailerTitle');
$whoto = trim($params->get('whoto') ?: '');
$template = trim($params->get('template') ?: '');
$subject = trim($params->get('subject') ?: '');
$selectedtemplate = $template.'.php';

// Seleciona o Template
$template_dir = FLUX_DATA_DIR."/templates/";
$myDirectory = opendir($template_dir);
$dirArray = [];
while($entryName = readdir($myDirectory)) {
    if (substr($entryName, 0, 1) != "." &&
        substr($entryName, 0, 5) != "index" &&
        substr($entryName, 0, 10) != "changemail" &&
        substr($entryName, 0, 7) != "confirm" &&
        substr($entryName, 0, 11) != "contactform" &&
        substr($entryName, 0, 7) != "newpass" &&
        substr($entryName, 0, 9) != "newticket" &&
        substr($entryName, 0, 9) != "resetpass" &&
        substr($entryName, 0, 11) != "ticketreply" &&
        substr($entryName, 0, 15) != "ticketresolvido" && 
        substr($entryName, 0, 18) != "ticketfechadostaff"  
    ) {
        $dirArray[] = $entryName;
    }
}
closedir($myDirectory);
$indexCount = count($dirArray);
sort($dirArray);

if (count($_POST)) {
    if ($whoto == '1') {
        $type = 'Níguém';
    } elseif ($whoto == '2') {
        $sth = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.login WHERE `group_id` = '99'");
        $type = 'Somente Administradores';
    } elseif ($whoto == '3') {
        $sth = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.login WHERE (group_id=2 OR group_id=99)");
        $type = ' Somente Equipe';
    } elseif ($whoto == '4') {
        $sth = $server->connection->getStatement("SELECT * FROM {$server->loginDatabase}.login");
        $type = 'Todos';
    } elseif ($whoto == '5') {
        $type = 'Vip\'s';
    }

    $sth->execute();
    $list = $sth->fetchAll();

    foreach ($list as $lrow) {
        $email = $lrow->email;
        require_once 'Flux/Mailer.php';
        $mail = new Flux_Mailer();
        $sent = $mail->send($email, $subject, $template, array(
            'emailtitle' => $subject,
            'username'   => $lrow->userid,
            'email'      => $lrow->email,
        ));
    }

    $session->setMessageData(sprintf(Flux::message('MailerEmailHasBeenSent'), $type));

    if (Flux::config('DiscordUseWebhook')) {
        if (Flux::config('DiscordSendOnMarketing')) {
            sendtodiscord(Flux::config('DiscordWebhookURL'), 'E-mail em massa enviado: ' . $subject);
        }
    }
}
?>