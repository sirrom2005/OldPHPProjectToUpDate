<?php
/**
 * Moneyline Corporate configuration file
 * See raxan/pdi/gateway.config.php for addition configuration information
 */

$config['session.name'] = 'mlcpz78a3ed42c5Tx';  // application session name

$config['site.path']    = __DIR__.'/'; // set site or application path
$config['site.url']     = $config['site.url'].'corporate/'; // site or application url
$config['views.path']   = $config['site.path'].'views/'; // views path
$config['locale.path']  = $config['site.path'].'locale/'; // locale path

// setup web page delegates
$config['delegate.public.class'] = '\Moneyline\Corporate\PublicWebPageDelegate'; // public
$config['delegate.secure.class'] = '\Moneyline\Corporate\SecureWebPageDelegate'; // secure


?>