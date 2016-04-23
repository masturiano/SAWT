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
    <? $jquery_custom_min_js = array('application', 'libraries', 'jquery','js','jquery-ui-1.8.16.custom.min.js'); ?>
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
        
    <!-- Our CSS stylesheet file for Menu -->
    <? $menu_css = array('application', 'libraries', 'assets','css','styles.css'); ?>
    <link href="<? echo base_url($menu_css); ?>" rel="stylesheet">
    
    <!-- My Style CSS -->
    <? $my_button_css = array('application', 'libraries', 'my_style.css'); ?>
    <link href="<? echo base_url($my_button_css); ?>" rel="stylesheet">
    
    <!-- Javascript -->
    <script type="text/javascript">
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
        // DATE PICKER FROM
        $(function(){
            $( "#datepicker_from" ).datepicker
            ({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-M-yy'
            });
        });   
        // DATE PICKER TO
        $(function(){
            $( "#datepicker_to" ).datepicker
            ({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd-M-yy'
            });
        });  
        // CLICK BUTTON PROCESS
        // GET CRM DATA
        function process()
        {
            var date_from = $("#datepicker_from").val();
            var date_to = $("#datepicker_to").val();
            
            if(date_from == ''){
                $("#datepicker_from").css('background-color', 'red');
                return false;
            }
            else{
                $("#datepicker_from").css('background-color', 'white');    
            }
            
            if(date_to == ''){
                $("#datepicker_to").css('background-color', 'red');
                return false;
            }
            else{
                $("#datepicker_to").css('background-color', 'white');    
            }
            
            if(date_from > date_to){
                alert('Date to must be greater then date from!');
                return false;
            }
            
            $.ajax
            ({
                url: '<? echo site_url('index.php/site/add_crm_data');?>',
                type: 'POST',  
                data: $('#home_form').serialize(),
                beforeSend: function(data)
                {
                    $('#btn_process').attr('disabled','disabled');
                    $('#btn_process').val('Processing');
                    $("#div_crm_message").html('Getting data from CRM');
                    $("#div_crm_data").show(data);   
                },
                success: function(data){ 
                    $("#div_crm_message").html('Get data from CRM');
                    $("#div_crm_data").hide(data);        
                    process2();
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
                    <!-- process3();   -->
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

  <body onload=" checkSession(); startTime();">

    <div>
        <h1>Data8 vs CRM</h1>
    </div>
    
    <?php 
    include('view_menu.php');
    ?>
    
    <div class="grey">
        <div class="container" align="center">
            <div class="well">
            <form method="post" id="home_form">
            <b>DATE :</b>
            <input type="text" name="datepicker_from" id="datepicker_from" class="inputBox" value="" size="17"
            placeholder="FROM" readonly>
            -
            <input type="text" name="datepicker_to" id="datepicker_to" class="inputBox" value="" size="17"
            placeholder="TO" readonly>
            <input type="button" name="btn_process" id="btn_process" onclick="process();" class="btn" value="Process"/>
            </form>                     
            </div>
        </div>
    </div>
    
    <div class="grey">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="well">
                        <div class="col1" id="div_crm_message">Get data from CRM</div>
                        <div class="col1" id="div_crm_data" style="display:none;">
                            <? $image_loader = array('application', 'libraries','images','ajax-loader.gif'); ?>
                            <img src="<? echo base_url($image_loader); ?>" style="height:20px; width:20px;">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="well">
                        <div class="col2" id="div_data8_message">Get data from DATA EIGHT</div>
                        <div class="col2" id="div_data8_data" style="display:none;">
                            <? $image_loader = array('application', 'libraries','images','ajax-loader.gif'); ?>
                            <img src="<? echo base_url($image_loader); ?>" style="height:20px; width:20px;">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="well">
                        <div class="col3" id="div_csv_message">Generate CSV file</div>   
                        <div class="col3" id="div_csv_data" style="display:none;">
                            <? $image_loader = array('application', 'libraries','images','ajax-loader.gif'); ?>
                            <img src="<? echo base_url($image_loader); ?>" style="height:20px; width:20px;">
                        </div> 
                    </div>
                </div>
            </div>  
        </div>
    </div> 

  </body>
</html>