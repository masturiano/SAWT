<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><? echo $title; ?></title>
    
    <!-- JS -->
        <!-- Html 5 Shiv Minified -->
        <script src="<? echo base_url('application/libraries/bootstrap/js/html5shiv.min.js'); ?>"></script>
        <!-- Respond Minified -->
        <script src="<? echo base_url('application/libraries/bootstrap/js/respond.min.js'); ?>"></script> 
        <!-- Jquery Minified Javascript -->
        <script src="<? echo base_url('application/libraries/jquery/js/jquery-1.6.2.min.js'); ?>"></script>
        <script src="<? echo base_url('application/libraries/jquery/js/jquery-ui-1.8.16.custom.min.js'); ?>"></script>
    
    <!-- CSS -->
        <!-- Bootstrap Minified Css -->
        <link href="<? echo base_url('application/libraries/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
               
    
    
    
    
    
    
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
    
    <!-- Background -->
    <? $menu_css = array('application', 'libraries', 'background','css','styles.css'); ?>
    <link href="<? echo base_url($menu_css); ?>" rel="stylesheet">
    
    <!-- My Style CSS -->
    <? $my_style_css = array('application', 'libraries', 'my_style.css'); ?>
    <link href="<? echo base_url($my_style_css); ?>" rel="stylesheet">
    
    <!-- Foo Table 3 -->
    <? $footable_css = array('application','libraries','foo_table3','src','css','FooTable.css'); ?>
    <link href="<? echo base_url($footable_css); ?>" rel="stylesheet">
    <? $footable_js = array('application', 'libraries','foo_table3','src','js','FooTable.js'); ?>
    <script src="<? echo base_url($footable_js); ?>"></script>

    <!-- Javascript -->
    <script type="text/javascript">
        $('document').ready(function(){
            $('#customerList').dataTable({
                "sPaginationType": "full_numbers"
            })   
        });
        
        // CHECK SESSION
        function checkSession() {
            $.ajax({
                url: "<?php echo base_url();?>site/check_session",
                type: "GET",
                success: function(Data){
                        eval(Data);
                    }                
               });  
            setTimeout("checkSession()",5000); 
        }       
    </script>

   
        
  </head>

  <body onload=" checkSession(); startTime();">
  
    <div class="header_bg">
    </div>
    <div class="header_logo">
    </div>
    
    <?php 
    include('view_menu.php');
    ?>
    
    <br />
    
    <table id="customerList" align="center">
            <thead>
                <tr>
                    <td align="center"><b>CUSTOMER NUMBER</b></td>
                    <td align="center"><b>CUSTOMER NUMBER</b></td>
                    <td align="center"><b>ACTION</b></td>
                </tr>
            </thead>
        <tbody>
                    <tr>
                        <td align="left">a</td>
                        <td align="left">b</td>
                        <td align="left">c</td>
                    </tr>   
        </tbody>
        <tfoot></tfoot>
    </table>

  </body>
</html>