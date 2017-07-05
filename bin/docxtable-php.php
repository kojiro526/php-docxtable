<?php
use Symfony\Component\Console\Application;
use PhpDocxtable\ListCommand;
use PhpDocxtable\UpdateCommand;

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
$app->add(new ListCommand());
$app->add(new UpdateCommand());
$app->run();