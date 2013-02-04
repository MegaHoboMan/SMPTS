<?php

$AWS_ACCESS_KEY = 'AKIAJSHAWGUPFUYY5VRA';
$AWS_SECRET_KEY = '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';
$AWS_PHP_SDK_URL = "aws-php-sdk";
$creds_array = array(
	'key' => $AWS_ACCESS_KEY,
	'secret' => $AWS_SECRET_KEY,
);
/* Relplace variables with configuration values - END */

require_once $AWS_PHP_SDK_URL.'/sdk.class.php'; /* Include AWS PHP API Class file */

$sdb = new AmazonSDB($creds_array);
$domain = 'SMPTS';

$response = $sdb->create_domain($domain);

print_r($response);

?>
