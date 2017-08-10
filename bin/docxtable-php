#!/usr/bin/env php
<?php
use Symfony\Component\Console\Application;
use PhpDocxtable\StylesCommand;
use PhpDocxtable\UpdateCommand;
use Symfony\Component\Console\Command\HelpCommand;

// installed via composer?
if (file_exists($a = __DIR__ . '/../../../autoload.php')) {
	require_once $a;
} else {
	require_once __DIR__ . '/../vendor/autoload.php';
}

/*
use PhpDocxtable\DocxTable;
$docxtable = new DocxTable($argv);
try {
	$docxtable->execute();
} catch (Exception $e) {
	echo 'Error: ' . $e->getMessage() . "\n";
	echo $e->getTraceAsString() . "\n";
}
*/
	
$app = new Application();
$app->add(new StylesCommand());
$app->add(new UpdateCommand());
$app->add(new HelpCommand());
$app->setDefaultCommand('help');
$app->run();