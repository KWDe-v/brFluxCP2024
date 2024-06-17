<?php
if (!defined('FLUX_ROOT')) exit;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>{emailtitle}</title>
    <meta name="description" content="" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h2 {
            color: #2c3e50;
            background-color: #ecf0f1;
            padding: 10px;
            border-radius: 5px;
        }

        p {
            line-height: 1.6;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            background: #3498db;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        ul li a {
            color: #fff;
            text-decoration: none;
        }

        ul li:hover {
            background: #2980b9;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        em {
            font-style: italic;
            color: #7f8c8d;
        }

        .footer {
            margin-top: 20px;
            padding: 10px;
            background: #2c3e50;
            color: #ecf0f1;
            text-align: center;
            border-radius: 5px;
        }

        .footer a {
            color: #ecf0f1;
            margin: 0 5px;
        }

        .footer a:hover {
            color: #3498db;
        }
    </style>
</head>
<body>

    <h2>Novo no Servidor</h2>
    <p>
      <ul>
        <li><a href="#">Sistema de Aliança</a></li>
        <li><a href="#">Sistema de Conquistas</a></li>
        <li><a href="#">Taxas Flutuantes</a></li>
        <li><a href="#">Sistema de Coleta</a></li>
        <li><a href="#">Habitação / Acomodação</a></li>
        <li><a href="#">Iniciativa do Herói</a></li>
      </ul>
    </p>

    <h2>{emailtitle}</h2>
    <p>Saudações, Aventureiro!<br /><br />
    Temos o prazer de anunciar que o Servidor está de volta online com novas atualizações e conteúdos para ... <br /><br />

    <em>A Equipe FluxCP</em>
    </p>

    <h2>Informações do Email</h2>
    <p>Este email foi enviado pelo FluxCP para {username} ({email}) porque você tem uma conta de jogador conosco. Nós <strong>nunca</strong> daremos seus dados para ninguém, nem mesmo para uma empresa de marketing real - então enviamos este email diretamente para você a partir do nosso site!<br /><br />

    Você pode cancelar a inscrição para receber esses emails alterando suas preferências em <a href="#">nosso site</a>.
    </p>

    <h2>Links Úteis</h2>
    <p class="footer"><a href="#">Página Inicial do Site</a> || <a href="#">Fóruns</a> || <a href="#">Central de Serviços</a> || <a href="#">Wiki</a></p>
</body>
</html>
