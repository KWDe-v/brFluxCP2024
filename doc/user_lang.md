Arquivos de idioma
======

Como eles funcionam?
---------
O diretório **lang/** contém traduções para uso com FluxCP. O idioma usado é controlado pela configuração 'DefaultLanguage' em config/application.php.

Simplificando, `'DefaultLanguage' => 'en_us'` carregará o arquivo do idioma inglês americano e usará as strings contidas sempre que `Flux::message()` for usado nos arquivos de tema. Existem alguns outros no diretório `lang/`, mas infelizmente eles não são mantidos.


Como os usamos?
---------
Por exemplo, em um arquivo de tema que mostra se o personagem de um jogador é masculino ou feminino, você veria `<?php echo Flux::message('GenderTypeMale') ?>` ou `<?php echo Flux::message ('GenderTypeFemale') ?>`.

Os menus definidos em `config/application.php` são configurados para usar automaticamente os arquivos de idioma. Por exemplo, vejamos este menu específico:

```
'MenuItems'		=> array(
		'MainMenuLabel'		=> array(
			'HomeLabel'			=> array('module' => 'main'),
			'NewsLabel'			=> array('module' => 'news'),
		),
),
```

Quando a página for renderizada, você verá que essas strings são substituídas por suas contrapartes no arquivo de idioma.
'MainMenuLabel' torna-se 'Menu Principal', 'HomeLabel' torna-se 'Home', 'NewsLabel' torna-se 'Notícias'.


Uso Indevido Comum
---------
Muitas pessoas ainda pensam que a parte 'Label' dessas strings deve ser removida do arquivo de configuração, pois está gerando 'HomeLabel' para a página em vez de 'Home'. **Isso está incorreto.** Isso significa simplesmente que o tema que você está usando foi criado antes de agosto de 2014 e você não deveria usá-lo.