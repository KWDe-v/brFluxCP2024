<?php
if (!defined('FLUX_ROOT')) exit;

$emailTitle = 'Alteração de e-mail';
$meses = [
    'January' => 'Janeiro',
    'February' => 'Fevereiro',
    'March' => 'Março',
    'April' => 'Abril',
    'May' => 'Maio',
    'June' => 'Junho',
    'July' => 'Julho',
    'August' => 'Agosto',
    'September' => 'Setembro',
    'October' => 'Outubro',
    'November' => 'Novembro',
    'December' => 'Dezembro'
];

$data = date("d-F-Y");
list($dia, $mesIngles, $ano) = explode('-', $data);
$mesPortugues = $meses[$mesIngles];

$data = "$mesPortugues, $ano"; 


$logo = Flux::config('LogoName');
if(empty($logo)){
  $logomail = 'logomail.png';
}else{
    if(strpos($logo, ".png") !== false){
      $logomail = $logo;
    }else{
      $logomail = $logo.'.png';
    }
}


?>


<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo htmlspecialchars($emailTitle) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">

  @media screen {
    @font-face {
      font-family: 'Source Sans Pro';
      font-style: normal;
      font-weight: 400;
      src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
    }
    @font-face {
      font-family: 'Source Sans Pro';
      font-style: normal;
      font-weight: 700;
      src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
    }
  }

  body,
  table,
  td,
  a {
    -ms-text-size-adjust: 100%; /* 1 */
    -webkit-text-size-adjust: 100%; /* 2 */
  }

  table,
  td {
    mso-table-rspace: 0pt;
    mso-table-lspace: 0pt;
  }

  img {
    -ms-interpolation-mode: bicubic;
  }

  a[x-apple-data-detectors] {
    font-family: inherit !important;
    font-size: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
    color: inherit !important;
    text-decoration: none !important;
  }

  div[style*="margin: 16px 0;"] {
    margin: 0 !important;
  }
  body {
    width: 100% !important;
    height: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
  }

  table {
    border-collapse: collapse !important;
  }
  a {
    color: #1a82e2;
  }
  img {
    height: auto;
    line-height: 100%;
    text-decoration: none;
    border: 0;
    outline: none;
  }
  </style>

</head>
<body style="background-color: #e9ecef;">

  <!-- start preheader -->
  <div class="preheader" style="display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;">
    
		<p>Alteração de e-mail.</p>
		
  </div>
  <!-- end preheader -->

  <!-- start body -->
  <table border="0" cellpadding="0" cellspacing="0" width="100%">

    <!-- start logo -->
    <tr>
      <td align="center" bgcolor="#e9ecef">
        <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
          <tr>
            <td align="center" valign="top" style="padding: 36px 24px;">
              <a href="#" target="_blank" style="display: inline-block;">
                
              </a>
            </td>
          </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
      </td>
    </tr>
    <!-- end logo -->

    <!-- start hero -->
    <tr>
      <td align="center" bgcolor="#e9ecef">
        <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->

        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
           <tr>
          <td align="center" bgcolor="#ffffff" style="font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf; text-align: center;">
              <img src="<?php echo Flux::config('ServerAddress');?>/data/<?php echo $logo;?>" width="250px" style="display: block; margin: 0 auto;" />
          </td> 
          </tr>
          <tr>

            <td align="left" bgcolor="#ffffff" style="padding: 36px 24px 0; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; ">
              <h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;"><?php echo htmlspecialchars($emailTitle) ?></h1>
            </td>
          </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
      </td>
    </tr>
    <!-- end hero -->

    <!-- start copy block -->
    <tr>
      <td align="center" bgcolor="#e9ecef">
        <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
  <!-- start copy -->
  <tr>
    <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
      <p style="margin: 0;">
        Você recebeu este e-mail porque recebemos uma solicitação de Alteração de e-mail para sua conta. 
        Se você não solicitou alteração de e-mail para a conta em <strong><?php echo htmlspecialchars($siteTitle); ?></strong>, você pode excluir este e-mail com segurança.
        Se foi focê pressione o botão abaixo para confirmar sua alteração de e-mail. 
      </p>
    </td>
  </tr>
  <!-- end copy -->

  <!-- start account info -->
  <tr>
    <td align="center" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%" >
        <tr>
          <td align="center" style="border: 1px #000 solid;">Conta:</td>
          <td align="center" style="border: 1px #000 solid;">{AccountUsername}</td>
        </tr>
        <tr>
          <td align="center" style="border: 1px #000 solid;">E-mail Antigo:</td>
          <td align="center" style="border: 1px #000 solid;">{OldEmail}</td>
        </tr>
        <tr >
          <td align="center" style="border: 1px #000 solid;">Novo E-mail:</td>
          <td align="center" style="border: 1px #000 solid;">{NewEmail}</td>
        </tr>
      </table>
    </td>
  </tr>
  <!-- end account info -->

  <!-- start button -->
  <tr>
    <td align="left" bgcolor="#ffffff">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td align="center" bgcolor="#ffffff" style="padding: 12px;">
            <table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" bgcolor="#1a82e2" style="border-radius: 6px;">
                  <a href="{ChangeLink}" target="_blank" style="display: inline-block; padding: 16px 36px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;">Alterar e-mail para esta conta</a>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <!-- end button -->

  <!-- start copy -->
  <tr>
    <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
      <p style="margin: 0;">Se isso não funcionar, copie e cole o seguinte link no seu navegador:</p>
      <p style="margin: 0;"><a href="{ChangeLink}" target="_blank">{ChangeLink}</a></p>
    </td>
  </tr>
  <!-- end copy -->

  <!-- start copy -->
  <tr>
    <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-bottom: 3px solid #d4dadf">
      <p style="margin: 0;"><?php echo htmlspecialchars($data); ?></p>
    </td>
  </tr>
  <!-- end copy -->
</table>
        <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
      </td>
    </tr>
    <!-- end copy block -->

    <!-- start footer -->
    <tr>
      <td align="center" bgcolor="#e9ecef" style="padding: 24px;">
        <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

          <!-- start permission -->
          <tr>
            <td align="center" bgcolor="#e9ecef" style="padding: 12px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;"><p><em><strong>Nota:</strong> Este é um e-mail automatizado, por favor não responda para este endereço.</em></p>
              <p style="margin: 0;"></p>
            </td>
          </tr>
          <!-- end permission -->

          <!-- start unsubscribe -->

          <!-- end unsubscribe -->

        </table>
        <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
      </td>
    </tr>
    <!-- end footer -->

  </table>
  <!-- end body -->

</body>
</html>