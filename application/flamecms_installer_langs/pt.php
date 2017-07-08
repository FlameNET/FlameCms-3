<?php
/*script cuddies answer*/
defined('FlameCMS') or die('No Script Cuddies');
$sys=&get_inst();
$sys->ilang->define_name('pt','Português',base_url('assets/imgs/flags/pt-pt.png'));
$sys->ilang->lang('pt');
/*Header*/
__s('FlameCMS Installer','Instalador do FlameCMS');
__s('Installer','Instalador');
/*Footer*/
__s('Made by','Feito Por');
__s('with love and caffeine.',' Com Amor e Cafeina');
__s('Licensed under','Licença sobre');
__s('GNU license','A Licença GNU');
__s('Copyright FlameCMS','Copyright FlameCMS');
__s('All rights Reserved','Todos os Direitos Reservados');
/*Install step 1*/
__s('Welcome to FlameCMS','Bem Vindo ao FlameCMS');
__s('Content Management System for World of Warcraft Servers.','Sistema de gerenciamento de conteúdo para servidores de World of Warcraft.');

__s('Pick Your Language For the Installer','Escolha a Sua linguagem para o Instalador');
__s('Install Now','Instalar Agora');
__s('No, Thanks','Não Obrigado');
__s('Stargazers','Stargazers');
/*Install Step 2*/
__s('Application Requirements','Requerimentos da Aplicação');
__s('Modules','Modulos');
__s('Required Version','Versão Nessesária');
__s('Installed Version','Versão Instalada');
__s('Operating System','Sistema Operativo');
__s('Mysqli Client API Version','Versão do Cliente Mysqli');
__s('Apache Server Version','Versão do Apache');
__s('PHP Version','Versão do PHP');
__s('Soap Client API','Cliente SOAP');
__s('Soap Exists and Enabled','SOAP Existe e está ablitado');
__s('IconV Extension Exists','Extensão IconV Existe?');
__s('Curl Extension Exists','Extensão Curl Existe?');
__s('Hash Extension Exists','Extensão Hash Existe?');
__s('OpenSSL Extension Exists','Extensão OpenSSL Existe?');
__s('hey! look at the person who has the best Host provider!','Olha para a pessoa que tem o melhor provedor de alojamento!');
__s('Lets finish the install ok?','Vamos acabar a instalação OK?');
__s('Continue to Step 2','Continuar para o passo 2');
__s('Ups... it apears that you have some unsatisfied requirements...','Ups... parece quem têm alguns requerimentos insatisfeitos...');
__s('please talk to you host provider in order to install them.','Por favor fale com o seu provedor de alojamento, para que este instale os mesmos.');
/*Install Step 3*/
__s('Required','Nessesário');
__s('[CMS] Initiation of setup','[CMS] Inicio da instalação');
__s('[CMS] Mysql Server Connection','[CMS] Configuração do servidor MYSQL');
__s('[CMS] Mysql Server Configuration','[CMS] Configuração do servidor MYSQL');
__s('[CMS] Mysql Admin Account','[CMS] Conta de administrador do MYSQL');
__s('[CMS] Administrator Account','[CMS] Conta do administrador');
__s('Not Required','Não Nessesário');
__s('[WOW] Server Configuration and Realms','[WOW] Configurações do servidor e Realms');
__s('[WOW] Server Configurations and Realms','[WOW] Configurações do servidor e Realms');
/*[CMS] Initiation of setup*/
__s('Default CMS Language','Lingua Por defeito');
__s('Domain of this CMS','Dominio desta plataforma');
__s('CMS Public Name','Nome publico desta plataforma');
__s('Multi Language?','Várias Linguas?');
__s('Force HTTPS?','Forçar Ligação Segura (HTTPS)');
__s('Force HTTPS on Administration?','Forçar Ligação Segura (HTTPS) Na Administração');
__s('Yes','Sim');
__s('No','Não');
__s('Languages','Linguas');
__s('Changing the default language will reset the language list (the checkboxes)',
'A alteração da lingua por defeiro, vai resetar a lista de linguas (Caixas de seleção)');
__s('This is unnecessary, because you can do it on the admin panel','Isto é desnessesário, pois pode o fazer no painel de administração');
__s('Send Data','Enviar Dados');
/*[CMS] Mysql Settings*/
__s('[CMS] Mysql Host','[CMS] Endereço do Servidor MySql');
__s('80.00.00.00 or flamecms.github.io','Exemplo:80.00.00.00 ou flamecms.github.io');
__s('[CMS] Mysql User','[CMS] Utilizador do servidor MySql');
__s('dbuser','UtilizadorDaBaseDeDados');
__s('[CMS] Mysql Password','[CMS] Password do servidor Mysql');
__s('excelentPassword','Palavra-passeExcelente');
__s('[CMS] Mysql Port','[CMS] Porta do Servidor MySql');
__s('Port','Porta');
__s('[CMS] Database Name','[CMS] Nome da Base de Dados');
__s('greatdb','BasededadosFantástica');
__s('[CMS] Database Table Prefix','[CMS] Prefixo das tabelas da base de dados');
__s('tableprexif_','prefixodatabela_');
__s('Check [CMS] Mysql Settings','Verificar [CMS] As Definições do servidor Mysql');
/*[CMS] Mysql Settings Connection Errors*/
__s('Everything Ok! procced','Tudo Bem! Continue');
__s('Ups, Apears that your Connection Is not Right. Please Check Your Settings','Ups... parece que as suas definições não estão corretas, por favor, Verifique as mesmas.');
__s('The Database Does not exist, please check it','A Base de Dados Não Existe, por favor, Verifique');
/*[CMS] Admin Account*/
__s('Admin Username','Nome De Utilizador do Administrador');
__s('Admin_username123','Administrador123');
__s('Admin Password','Palavra-Passe de Administrador');
__s('super_admin_p455w0rd','Palavra-Passe_Super123?');
__s('Confirm the Admin Password','Confirme a Palavra-Passe do Administrador');
__s('Admin Email','Email do Administrador');
__s('admin@flamecms.github.io','admin@flamecms.github.io');
__s('Admin First Name','Primeiro Nome do Administrador');
__s('John','Zé');
__s('Admin Last Name','Segundo Nome do Administrador');
__s('Doe','Ninguém');
/*[CMS] wow server and realms*/
__s('Add WOW Server','Adicionar Servidor WOW');
__s('','');
__s('To continue, please fill all the information and submit the form.','para continuar, preencha todos os campos e envie o formulário');
__s('With all done, you will be redirected to the administation page and you will be able to and the wow server.','Com tudo feito, vai ser redirecionado para a pagina de administração, e poderá adicionar servidores de "World of Warcraft".');
/*Install End Fenching Current Status...*/
__s('Feching Current Status...','A obter o estado actual ...');
__s('Creating System Account...','Criando a conta do sistema...');
__s('Creating Owner Account...','Criando a conta do dono...');
__s('Setting up Settings...','Carregando as Configurações');
__s('Deleting and renaming unneded files...','Apagando e/ou Renomear ficheiros desnecessarios');
__s('Done! Redirecting to admin area... please wait...','Tudo Feito! Redirecionando para a area de administração... por favor, aguarde...');
/*
__s('','');
 * */
