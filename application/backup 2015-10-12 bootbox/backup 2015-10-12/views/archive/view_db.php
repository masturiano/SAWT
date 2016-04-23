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
    
    <?php
        include('menu.php');
    ?>
	
	<br />
	
	<?php
		foreach($result as $row){
			echo $row->id;
			echo $row->first_name;
			echo $row->last_name;
			echo "<br />";
		}
	?>
</div>

</body>
</html>