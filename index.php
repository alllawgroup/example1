 <?php 
require_once "./cl/db_class.php";
?> 
	<!DOCTYPE html>
    <html lang='ru'>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./css/crt.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="./js/crt.js"></script>
        <title>Городки</title>
    </head>
    <body>
	<header class="header">
	<p>Выбор города Европы</p>
	</header>
	<div class="container">
	<select name='languages' id='ru'>
	<option value='0' lang='ru'>Русский</option>
	<option value='1' lang='en'>English</option>
	<option value='2' lang='de'>German</option>
	</select>
	<div class='descript'></div>
	<ul class='crtclass'>
	<?php
	$li = new DbC();
	$li->connect();
	echo $li->selectall("rus");
	?>
	</ul>
	</div>
	</body>
	</html>