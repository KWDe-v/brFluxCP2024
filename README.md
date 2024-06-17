FluxCP
======
[![DeepSource](https://app.deepsource.com/gh/rathena/FluxCP.svg/?label=active+issues&show_trend=true&token=nhkIfid6qRIZxl2INWaaV4Qb)](https://app.deepsource.com/gh/rathena/FluxCP/?ref=repository-badge)
[![Open Issues](https://img.shields.io/github/issues/rathena/FluxCP.svg?logo=github&logoWidth=18&color=yellow)](https://lgtm.com/projects/g/rathena/FluxCP/alerts/)
[![Open PRs](https://img.shields.io/github/issues-pr/rathena/FluxCP.svg?logo=github&logoWidth=18&color=blue)](https://lgtm.com/projects/g/rathena/FluxCP/alerts/)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/4d1c0a43c0864764b3d3dc5ed2d93192)](https://www.codacy.com/gh/rathena/FluxCP/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=rathena/FluxCP&amp;utm_campaign=Badge_Grade)

Painel de controle Flux (FluxCP) para servidores rAthena.

Requisitos
---------
*PHP 8.2
* Extensões PDO e PDO-MYSQL para PHP5 (incluindo suporte PHP_MYSQL)
* MySQL 8
*Opcional: GD2 (para emblemas de guilda e CAPTCHA de registro)
* Opcional: Tidy (para saída HTML mais limpa)
* Opcional: suporte mod_rewrite para o recurso UseCleanUrls
* Opcional: [Imagens do item](http://rathena.org/board/files/file/2509-item-images/)


O que há de novo?
---------
* Os arquivos de descrição são mantidos atualizados a cada novo commit do rAthena.
*Temas pré-integrados:
  - padrão
  - Inicialização

* Construídas em:
  - CMS de notícias e páginas com TinyMCE integrado
  - Service Desk (sistema de tickets de suporte estilo ITIL Incident Management)
  - Registros Adicionais
  - Mais listas de classificação
  - Integração de discórdia
  - Google ReCaptcha
  - Funcionalidade AtCommand remota

* Atualizações by KWDe-v

  - Integração com MercadoPago
  - ServiceDesk Corrigido (agora tanto players quanto ADM recebe um email toda vez que tiver uma resposta no ticket)
  - Tradução 90% (Em breve 100%)
  - Data base de Itens e Monstro mais rápidas
  - Function novas para melhor funcionamento do sistema
  - Escolhas de Gateway de Pagamentos (MercadoPago, PayPal ou ambas)
  - Mudança no Visual do tema padrão para cores do Brasil (Verde, Amarelo e Azul) OBS: Fiz isso somente para ter novas ideias de intergração
  - Template de E-mail's com nova estrutura de HTML e com css, tornando mais legível
  - corrigido pasta equip_jobs
  - Atualizado alguns módulos para maior Desempenho do sistema


Como ... ?
---------
Temos uma pequena biblioteca de documentos que abrange:
* Documentação básica do usuário
 - Instalação
 - [Temas](https://github.com/rathena/FluxCP/blob/master/doc/user_theme.md)
 - [Idiomas](https://github.com/rathena/FluxCP/blob/master/doc/user_lang.md)
 - Instalando complementos
 - Atualizando FluxCP

* Documentação do desenvolvedor
 - Criando um complemento
 - Fornecendo atualizações de complementos
 - Criando um tema personalizado


Participe da discussão
---------
Temos um servidor discord separado do rAthena apenas para coisas do FluxCP!
Os canais podem ser usados ​​para obter ajuda, discutir testes, visualizar log de feedback anônimo, commits do Github, etc.
https://discord.gg/kMeMXWEvSV


Créditos extras
---------
FluxCP original criado por Paradox924X e Byteflux com contribuições adicionais de Xantara.
Alguns trabalhos de outros usuários foram integrados neste projeto.
Traduzido e otimizado por KWDev
