<?php

/* Read the configuration file to get the configuration information */
$secrets_file = "C:\\Users\\Barr\\Documents\\fb_config.txt";
$handle = fopen($secrets_file, "r");
$res = fread($handle, filesize($secrets_file));
fclose($handle);

$res_arr = explode("\n", $res);
$val_arr = array();

foreach ($res_arr as $val) {
   $tmp = explode('=',$val);
   $val_arr[$tmp[0]] = $tmp[1];
}

/* Relplace variables with configuration values - START */
$FB_APP_ID = $val_arr['FacebookAppId'];
$FB_APP_SECRET = $val_arr['FacebookSecretKey'];
$FB_APP_URL = "http://apps.facebook.com/".$val_arr['FacebookNamespace']."/";

$S3_BUCKET_NAME = $val_arr['S3BucketName'];
$AWS_ACCESS_KEY = $val_arr['AWSAccessKeyId'];
$AWS_SECRET_KEY = $val_arr['AWSSecretAccessKey'];

$FB_PHP_SDK_URL = "facebook-php-sdk/src";
$AWS_PHP_SDK_URL = "aws-php-sdk";
/* Relplace variables with configuration values - END */

?>
