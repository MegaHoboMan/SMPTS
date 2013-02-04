<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Satanic Mechanics 500 Question PTS</title>
		<link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/ui-lightness/jquery-ui.css" rel="stylesheet" />	
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
		<script type="text/javascript" src="form-constructor.js"></script>
		<script type="text/javascript">
			$(function(){
	
				// Tabs
				$('#tabs').tabs({
					cache: true,
					load: function(event, ui) {
						 $("input", ui.panel).change(updatePurityScore);
					}
				});
				
				// Progressbar
				$("#progressbar").progressbar({
					value: 100
				});

				$("input").change(updatePurityScore);

				$("form").bind("reset", function() {
					setPurityScore(100);
				});
				
			});

			function updatePurityScore() {
			  var N = calculatePurityScore();
			  setPurityScore(N);
			};

			function calculatePurityScore() {
			  var answers = $(":checked").length;
			  var N = (500 - answers) / 5;
			  return N;
			};

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
	
		<!-- Progressbar -->
		
		<div id="score">
			<h2 class="demoHeaders">You are 100% pure.</h2>
			<div id="progressbar"></div>
		</div>
	
		<!-- Tabs -->
		<h2 class="demoHeaders">The Test</h2>
		<form action="action.php" method="post">
		<input type="submit" value="Submit">
		<input type="reset">
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Friendly Relations</a></li>
				<li><a href="questions/S2.html">Autoerotica and monosexualism</a></li>
				<li><a href="questions/S3.html">Legislative misfits and other ethical things</a></li>
				<li><a href="questions/S4.html">Drugs</a></li>
				<li><a href="questions/S5.html">Non-platontic relations</a></li>
				<li><a href="questions/S6.html">Non-primary choice relations</a></li>
				<li><a href="questions/S7.html">Alternate choices</a></li>
				<li><a href="questions/S8.html">Group sexual relations</a></li>
				<li><a href="questions/S9.html">Non-sentient objects</a></li>
				<li><a href="questions/S10.html">Localities</a></li>
				<li><a href="questions/S11.html">Style</a></li>
			</ul>
			<div id="tabs-1" class="ui-tabs-hide">
			<?php require 'questions/S1.html';?>
			</div>
		</div>
		<input type="hidden" name="submitted" value="yes">
		</form>

	</body>
</html>


