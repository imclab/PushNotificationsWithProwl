<?php
require_once './vendor/autoload.php';

$logger = new Zend\Log\Logger();

// Open a file stream
$filename = date('Y-m-d') . '.log';
$stream = fopen('./logs/' . $filename, 'a');

$writerFile = new Zend\Log\Writer\Stream($stream);
$writerFile->addFilter(
	new Zend\Log\Filter\Priority(Zend\Log\Logger::INFO)
);
$logger->addWriter($writerFile);

$apiKeys = array(
    'YOUR-API-KEY',
    'ANOTHER-API-KEY',
);

$writer = new SitePoint\Log\Writer\Prowl($apiKeys);
$writer->addFilter(
	new Zend\Log\Filter\Priority(Zend\Log\Logger::CRIT)
);
$logger->addWriter($writer);

// Test it out
$logger->info('This is a test');
$logger->crit('This is a test (critical)');
