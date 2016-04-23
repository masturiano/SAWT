<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $title?></title>

	<style type="text/css">
	
	</style>
</head>
<body>
<div id="container">
	<h1><?php echo $welcome;?></h1>	
	
	<p><?php echo $var1 ." + ". $var2 ." = ". $add;?></p>
	<p><?php echo $var1 ." - ". $var2 ." = ". $sub;?></p>	
    
    <?php
        include('menu.php');
    ?>
</div>

</body>
</html>