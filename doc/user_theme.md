Usando um tema personalizado
======

Como funciona?
---------
O Sistema de Temas no FluxCP é baseado em uma "estrutura de herança". Em termos simples, isso significa que você só precisa adicionar os arquivos que deseja alterar à nova pasta do tema.

Tudo funciona de forma semelhante ao sistema de importação de configuração no rAthena. O tema padrão é lido primeiro e, em seguida, se houver algum arquivo que corresponda à visualização necessária no tema personalizado, ele será carregado. Isso significa que **você não precisa copiar/colar o tema padrão toda vez que criar um novo tema personalizado**.

O arquivo manifest.php controla a herança com `'inherit' => 'default',`.

Como deve ser o meu tema?
---------
Este é um exemplo de estrutura de diretório para um tema personalizado em uma nova instalação do FluxCP:
```
.
├── addons
├── config
├── data
├── doc
├── lang
├── lib
├── modules
├── themes
|   ├── bootstrap
|   └── cust_theme1
|       └── css
|           ├── flux.css
|           └── customstyle.css
|       └── img
|           ├── bg.jpg
|           └── logo.png
|       └── js
|           ├── flux.unitip.js
|           └── ie9.js
|       └── main
|           ├── index.php
|           └── sidebar.php
|       ├── footer.php
|       ├── header.php
|       └── manifest.php
|   ├── default
|   └── installer
├── .gitignore
├── .htaccess
├── LICENSE
├── README.md
├── error.php
└── index.php
```

Como você pode ver, existem apenas alguns arquivos na pasta **cust_theme1**.


Como faço para exibi-lo em meu site?
---------
Para habilitar seu tema, basta adicioná-lo ao array de temas em /config/application.php:
```'ThemeName' => array('default', 'bootstrap', 'cust_theme1'),```

Se você quiser que seu novo tema sempre seja exibido e remova a caixa de seleção de tema no rodapé, remova os outros temas desta matriz para que fique assim:
```'NomeDoTema' => array('cust_theme1'),```


Como posso saber se um tema que baixei funcionará?
---------
Como regra geral, se o seu novo tema tiver um arquivo `manifest.php` na pasta do tema, ele funcionará perfeitamente com as versões atuais do FluxCP.

Se não tiver `manifest.php`, você precisará criar um. Isso fará com que o novo tema seja carregado, mas você ainda terá problemas.

No passado, mesmo após a introdução deste sistema de temas, os designers de temas ainda optaram por criar temas dependentes de versões antigas do FluxCP. Eles são preguiçosos. Use por sua conta e risco.