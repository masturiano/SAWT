<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $title?></title>
    
    
    <link href="includes/form_gray/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
    <link href="includes/form_gray/css/main.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="includes/form_gray/js/jquery-1.5.2.min.js"></script>
    <script type="text/javascript" src="includes/form_gray/js/jquery.autocomplete.pack.js"></script>
    <script type="text/javascript" src="includes/form_gray/js/script.js"></script>

    <style type="text/css">
    
    </style>
</head>
<body>
<div id="container">
    <h1><?php echo $welcome;?></h1>       
    

    
    <table border="1" align="center" width = "100%">
        <tr>
            <td width="20%"> First Name </td>
            <td width="1%"> : </td>
            <td> <?php echo form_input('txtFirstName', ''); ?> </td>
        </tr>
        <tr>
            <td width="20%"> Middle Name </td>
            <td width="1%"> : </td>
            <td> <?php echo form_input('txtMiddleName', ''); ?> </td>
        </tr>
        <tr>
            <td width="20%"> Last Name </td>
            <td width="1%"> : </td>
            <td> <?php echo form_input('txtLastName', ''); ?>
            </td>
        </tr>
        <tr>
            <td width="20%"> Sex </td>
            <td width="1%"> : </td>
            <td> <?php echo form_dropdown('dropShirts', $gender, 'large'); ?>
            </td>
        </tr>
        <tr>
            <td width="20%"> Status </td>
            <td width="1%"> : </td>
            <td>                             
                Single: <?php echo form_radio($status1); ?>
                Married: <?php echo form_radio($status2); ?>
            </td>
        </tr>
    </table>
    
    <?
        print "You are viewing " . $_SERVER['PHP_SELF'];
        //print phpinfo();
        //$price = 20.923456;
        //echo $roundToDec = Round($price); 
    ?>

    
</div>

</body>
</html>