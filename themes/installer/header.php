<?php if (!defined('FLUX_ROOT')) exit; ?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="./favicon.ico" />
		<title>FluxCP: Instalação &amp; Atualização</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style type="text/css">
			body { background-color: yellow; }
			.contentcontainer {
				background-color: #8888f9;
				border:1px black solid;
				border-radius:5px;
				padding:30px;
				color: white;
			}
			.header { padding-bottom: 10%; background-color: #016c03; margin-bottom: -8%; }
			td{
				color: white;
			}
			.text-success{
				color: #00ff00!important;
			}
			.text-danger{
				color: red!important;
			}

			a{
				color: green!important;
				transition: all 0.3s ease;
			}
			a:hover{
				color: green!important;
				text-shadow: 0px 0px 2px white;
				transition: all 0.3s ease;
				
			}
			h3, h4, th{
				color: black;
			}
		</style>
	</head>

	<body>
		<div class="header"></div>
		<div class="container">
			<div class="row pb-3">
				<div class="col">
					<img src="<?php echo $this->themePath('rathena-001.png') ?>" alt="Logo" style="max-height: 110px;">
				</div>
			</div>
			<div class="row">
				<div class="contentcontainer">
							<h1>Instalar &amp; Atualizar</h1>
					<?php if ($message=$session->getMessage()): ?>
						<p class="message"><?php echo htmlspecialchars($message) ?></p>
					<?php endif ?>
					<?php if (!empty($errorMessage)): ?>
						<p class="error"><?php echo htmlspecialchars($errorMessage) ?></p>
					<?php endif ?>
