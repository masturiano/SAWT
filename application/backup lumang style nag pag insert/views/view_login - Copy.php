<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><? echo $title; ?></title>     

    <!-- Bootstrap Minified Css -->     
    <? $bootstrap_min_css = array('application', 'libraries', 'bootstrap','css','bootstrap.min.css'); ?>
    <link href="<? echo base_url($bootstrap_min_css); ?>" rel="stylesheet">
    
    <!-- Html 5 Shiv Minified -->
    <? $html5shiv_min_js = array('application', 'libraries', 'bootstrap','js','html5shiv.min.js'); ?>
    <script src="<? echo base_url($html5shiv_min_js); ?>"></script>
    
    <!-- Respond Minified -->
    <? $respond_min_js = array('application', 'libraries', 'bootstrap','js','respond.min.js'); ?>
    <script src="<? echo base_url($respond_min_js); ?>"></script> 
    
    <!-- Jquery Minified Javascript -->
    <? $jquery_min_js = array('application', 'libraries', 'jquery','js','jquery-1.6.2.min.js'); ?>
    <script src="<? echo base_url($jquery_min_js); ?>"></script>
    <!-- <? $jquery_custom_min_js = array('application', 'libraries', 'jquery','js','jquery-ui-1.8.16.custom.min.js'); ?> -->
	<? $jquery_custom_min_js = array('application', 'libraries', 'jquery','js','x.js'); ?>
    <script src="<? echo base_url($jquery_custom_min_js); ?>"></script>
    <!-- Jquery Datepicker -->
    <? $jquery_ui_button_js = array('application', 'libraries', 'jquery','development-bundle','ui','jquery.ui.button.js'); ?>
    <script src="<? echo base_url($jquery_ui_button_js); ?>"></script>
    <? $jquery_ui_datepicker_js = array('application', 'libraries', 'jquery','development-bundle','ui','jquery.ui.datepicker.js'); ?>
    <script src="<? echo base_url($jquery_ui_datepicker_js); ?>"></script>
    <!-- Jquery Css -->
    <? $jquery_ui_custom_css = array('application', 'libraries', 'jquery','css','jquery-ui-1.8.16.custom.css'); ?>
    <link href="<? echo base_url($jquery_ui_custom_css); ?>" rel="stylesheet">
    <? $demos_css = array('application', 'libraries', 'jquery','css','demos.css'); ?>
    <link href="<? echo base_url($demos_css); ?>" rel="stylesheet">
    <? $jquery_ui_all_css = array('application', 'libraries', 'jquery','development-bundle','themes','base','jquery.ui.all.css'); ?>
    <link href="<? echo base_url($jquery_ui_all_css); ?>" rel="stylesheet">
    <? $demos_css = array('application', 'libraries', 'jquery','development-bundle','demos','demos.css'); ?>
    <link type="text/css" href="<? echo base_url($demos_css); ?>" />
    
    <!-- Toast Message -->
    <? $jquery_toastmessage_js = array('application', 'libraries', 'toastmessage','src','main','javascript','jquery.toastmessage.js'); ?>
    <script src="<? echo base_url($jquery_toastmessage_js); ?>"></script>
    <? $jquery_toastmessage_css = array('application', 'libraries', 'toastmessage','src','main','resources','css','jquery.toastmessage.css'); ?>
    <link type="text/css" href="<? echo base_url($jquery_toastmessage_css); ?>" />
        
    <!-- Our CSS stylesheet file for Menu -->
    <? $menu_css = array('application', 'libraries', 'assets','css','styles.css'); ?>
    <link href="<? echo base_url($menu_css); ?>" rel="stylesheet">   
    
    <!-- My Style CSS -->
    <? $my_button_css = array('application', 'libraries', 'my_style.css'); ?>
    <link href="<? echo base_url($my_button_css); ?>" rel="stylesheet">
    
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
                $("#txt_username").css('background-color', 'white');    
            }
            
            if(password == ''){
                $("#txt_password").css('background-color', 'red');
                $("#message_display").html('Please input password');
                return false;
            }
            else{
                $("#message_display").css('color', 'red');
                $("#txt_password").css('background-color', 'white');    
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

    <div>
        <h1>Data8 vs CRM</h1>
    </div>
    
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    <div align="center">
        <form method="post" id="login_form">
        
        <div class="grey">
            <div class="container">
                <div class="well" style="background-color: black;" align="center">     
                    <b>LOGIN</b>                 
                </div>
            </div>
        </div>
        
        <div class="grey">
            <div class="container">
                <div class="well" style="background-color: black;" align="center">
                    <div name="message_display" id="message_display"> &nbsp </div> 
                    <br />    
                    <b>USERNAME :</b>
                    <input type="text" name="txt_username" id="txt_username" class="inputBox" value="" size="17" style="border-color: black;">
                    <b>PASSWORD :</b>
                    <input type="password" name="txt_password" id="txt_password" class="inputBox" value="" size="17" style="border-color: black;">  
                    <br />
                    <br />
                    <br />                 
                </div>
            </div>
        </div>
        
        <div class="grey">
            <div class="container">
                <div class="well" style="background-color: black;" align="center">
                    <input type="button" name="btn_login" id="btn_login" onclick="login();" class="btn" value="Login"/>     
                </div>
            </div>
        </div>
        
        </form>  
    </div>

  </body>
</html>