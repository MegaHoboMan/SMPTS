<?php

require "config.php"; /* Include Configuration File */
require $FB_PHP_SDK_URL.'/facebook.php'; /* Include Facebook PHP API Class file */
require $AWS_PHP_SDK_URL.'/sdk.class.php'; /* Include AWS PHP API Class file */

/* Invoke Facebook PHP API Class and create an Object */
$facebook = new Facebook(array(
  'appId'  => $FB_APP_ID,
  'secret' => $FB_APP_SECRET,
));

$user = $facebook->getUser(); /* Get the FB User ID for the logged in user */
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Satanic Mechanics 500 Question PTS</title>
		<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
		<script type="text/javascript" src="form-constructor.js"></script>
		<script type="text/javascript">
			$(function(){
	
				// Tabs
				$('#tabs').tabs();
				
				// Progressbar
				$("#progressbar").progressbar({
					value: 100
				});

				$('input').change(function() {
					var answers = $(":checked").length;
					var N = (500 - answers) / 5;
					setPurityScore(N);
				});

				$("form").bind("reset", function() {
					setPurityScore(100);
				});
				
			});

			function setPurityScore(percent) {
				$("#progressbar").progressbar( "option", "value", percent );
				$("#score > h2.demoHeaders").html("You are " + percent + "% pure.");
			};
		</script>
		<style type="text/css">
			/*demo page css*/
			body{ font: 62.5% "Trebuchet MS", sans-serif; margin: 50px;}
			.demoHeaders { margin-top: 2em; }
		</style>
	</head>
	<body>		

		<?php
			if($user) {
				try {
					$fql = 'SELECT name FROM user WHERE uid = ' . $user_id;
					$ret_obj = $facebook->api(array(
										'method' => 'fql.query',
										'query' =>$fql,
									));
					echo '<pre> Name: ' . $ret_obj[0]['name'] . '</pre>';
				} catch(FacebookApiException $e) {
					echo '<pre> Failure! </pre>';
				}
			}
		?>
		
		<!-- Progressbar -->
		
		<div id="score">
			<h2 class="demoHeaders">You are 100% pure.</h2>
			<div id="progressbar"></div>
		</div>
	
		<!-- Tabs -->
		<h2 class="demoHeaders">The Test</h2>
		<form action="tabbed.php" method="post">
		<input type="submit" value="Submit">
		<input type="reset">
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Friendly Relations</a></li>
				<li><a href="#tabs-2">Autoerotica and monosexualism</a></li>
				<li><a href="#tabs-3">Legislative misfits and other ethical things</a></li>
				<li><a href="#tabs-4">Drugs</a></li>
				<li><a href="#tabs-5">Non-platontic relations</a></li>
				<li><a href="#tabs-6">Non-primary choice relations</a></li>
				<li><a href="#tabs-7">Alternate choices</a></li>
				<li><a href="#tabs-8">Group sexual relations</a></li>
				<li><a href="#tabs-9">Non-sentient objects</a></li>
				<li><a href="#tabs-10">Localities</a></li>
				<li><a href="#tabs-11">Style</a></li>
			</ul>
			<div id="tabs-1">
			<?php require 'questions/S1.html';?>
			</div>
			<div id="tabs-2">
			<?php require 'questions/S2.html';?>
			</div>
			<div id="tabs-3">
			<?php require 'questions/S3.html';?>
			</div>
			<div id="tabs-4">
			<?php require 'questions/S4.html';?>
			</div>
			<div id="tabs-5">
			<?php require 'questions/S5.html';?>
			</div>
			<div id="tabs-6">
			<?php require 'questions/S6.html';?>
			</div>
			<div id="tabs-7">
			<?php require 'questions/S7.html';?>
			</div>
			<div id="tabs-8">
			<?php require 'questions/S8.html';?>
			</div>
			<div id="tabs-9">
			<?php require 'questions/S9.html';?>
			</div>
			<div id="tabs-10">
			<?php require 'questions/S10.html';?>
			</div>
			<div id="tabs-11">
			<?php require 'questions/S11.html';?>
			</div>
		</div>
		<input type="hidden" name="submitted" value="yes">
		</form>

	</body>
</html>


