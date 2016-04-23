<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
    <title><? echo $title; ?></title> 
    
    <?php 
    include('view_includes.php');
    ?>      

    <!-- JS -->
        <!-- Login --> 
        <script src="<? echo base_url('includes/random_login_form/js/prefixfree.min.js'); ?>"></script>
        
    <!-- CSS -->
        <!-- Login --> 
        <link href="<? echo base_url('includes/random_login_form/css/style.css'); ?>" rel="stylesheet">
    
    <!-- Javascript -->
    <script type="text/javascript">

        history.forward();
    
        $(function(){     
            $(".grey").show('blind').delay('99999'); 
        });                                    
        // CLICK BUTTON LOGIN
        function login()
        {
            var username = $("#txt_username").val();
            var password = $("#txt_password").val();
            
            if(username == ''){
                $("#txt_username").css('background-color', 'red');
                $("#message_display").css('color', 'red');
                $("#message_display").html('Please input username');
                return false;
            }
            else{
                $("#txt_username").css('background-color', 'transparent');    
            }
            
            if(password == ''){
                $("#txt_password").css('background-color', 'red');
                $("#message_display").html('Please input password');
                return false;
            }
            else{
                $("#message_display").css('color', 'red');
                $("#txt_password").css('background-color', 'transparent');    
            }
            
            $.ajax
            ({
                url: '<? echo site_url('site/login_user');?>',
                type: 'POST',  
                data: $('#login_form').serialize(),
                beforeSend: function(data)
                {
                    $('#btn_login').val('Validating...');
                },
                success: function(data){ 
                    $('#btn_login').val('Redirecting...');  
                    if(data == 0){
                        window.location.href = "<?php echo site_url('site/login'); ?>";    
                    }
                    else{
                        window.location.href = "<?php echo site_url('site/main'); ?>";     
                    }     
                }
            });    
        } 
        // GET DATA EIGHT DATA
        function process2()
        {
            $.ajax
            ({
                url: '<? echo site_url('site/add_data_eight');?>',
                type: 'POST',  
                data: $('#home_form').serialize(),
                beforeSend: function(data)
                {
                    $("#div_data8_message").html('Getting data from Data Eight');
                    $("#div_data8_data").show(data);  
                },
                success: function(data){         
                    $("#div_data8_message").html('Get data from Data Eight');
                    $("#div_data8_data").hide(data);
                    process3();   
                }
            });    
        }    
        // GENERATE CSV
        function process3()
        {
            $.ajax
            ({
                url: '<? echo site_url('site/generate_csv');?>',
                type: 'POST',  
                data: $('#home_form').serialize(),
                beforeSend: function(data)
                {
                    $("#div_csv_message").html('Generating CSV file');
                    $("#div_csv_data").show(data);  
                },
                success: function(data){         
                    $("#div_csv_message").html('Generate CSV file');
                    $("#div_csv_data").hide(data);
                    $('#btn_process').removeAttr('disabled');
                    $('#btn_process').val('Process');
                }
            });    
        } 
    </script>  
    
  </head>

  <body>

    <div class="body"></div>
    <div class="grad"></div>
    
    <br>
    <div><!-- SAWT --></div>
    
    <div class="login">
        <form method="post" id="login_form">
        <div class="header"> 
        </div>  
        <div class="body">
            <input type="text" placeholder="username" name="txt_username" id="txt_username"><br>
            <input type="password" placeholder="password" name="txt_password" id="txt_password"><br>
            <input type="button" value="Login" onclick="login();">
        </div>   
        </form>
    </div>

  </body>
</html>