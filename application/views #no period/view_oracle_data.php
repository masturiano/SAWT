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
    
    <!-- Jquery UI Minified Javascript -->
    <script src="<? echo base_url('includes/jquery/js/jquery-ui-1.8.23.custom.min.js'); ?>"></script>   
    <!-- Jquery UI -->
    <link href="<? echo base_url('includes/jquery/development-bundle/themes/base/jquery.ui.all.css'); ?>" rel="stylesheet">
    <!-- Bootstrap Date Picker CSS -->
    <link href="<? echo base_url('includes/bootstrap_datepicker_master/dist/css/bootstrap-datepicker3.min.css'); ?>" rel="stylesheet">
    <!-- Jquery Minified Javascript -->
    <script src="<? echo base_url('includes/jquery/js/jquery-ui-1.8.23.custom.min.js'); ?>"></script>
    <!-- Bootstrap Date Picker Js-->
    <script src="<? echo base_url('includes/bootstrap_datepicker_master/js/bootstrap-datepicker.js'); ?>"></script>
    <!-- My Javascript -->
    <script src="<? echo base_url('includes/my_javascript.js'); ?>"></script>     
        
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
        
        // BOOTSTRAP DATE PICKER
        $(function(){   
            $('.datepicker').datepicker({
                autoclose: true,
            })
        });   
        
        function copyData(){
            
            if($('#txt_date_from').val() == 0){
                bootbox.alert("Please select Date from!", function() {
                    $('#txt_date_from').css("border","red solid 1px");
                });    
                return false;
            } 
            else{
                $('#txt_date_from').css("border","lightgray solid 1px");    
            }   
            if($('#txt_date_to').val() == 0){
                bootbox.alert("Please select Date to!", function() {
                    $('#txt_date_to').css("border","red solid 1px");
                });    
                return false;
            } 
            else{
                $('#txt_date_to').css("border","lightgray solid 1px");    
            }  
            
            var dateStart = $('#txt_date_from').val();
            var dateEnd = $('#txt_date_to').val();
            var parseStart = Date.parse(dateStart);
            var parseEnd = Date.parse(dateEnd);
            
            if(parseStart > parseEnd){
                bootbox.alert("Date TO must greater than Date FROM!", function() {
                    $('#txt_date_from').css("border","red solid 1px");
                    $('#txt_date_to').css("border","red solid 1px");
                });    
                return false;
            } 
            else{
                $('#txt_date_from').css("border","lightgray solid 1px");    
                $('#txt_date_to').css("border","lightgray solid 1px");    
            }
            
            $.ajax
            ({
                url: '<? echo site_url('systema/copy_oracle_data');?>',
                type: 'POST',  
                data: $('#post_form').serialize(),
                beforeSend: function(data)
                {
                    jQuery('#loading').showLoading();
                },
                success: function(data){ 
                    jQuery('#loading').hideLoading();
                    bootbox.alert(data, function() {
                    }); 
                }
            });  
        }
    </script>  
        
  </head>

  <body onload=" checkSession(); startTime();">
  
    <div class="header_bg">
    </div>
    <div class="header_logo">
    </div>
    
    <div id="loading">
    
        <?php 
        include('view_menu.php');
        ?>
        
        <div class="header_bg_down">
        </div>
                        
        <div class="grey">
            <div class="container">
                <div class="row">
                    <div class="col-lg-20">
                        <div class="well">
                            
                            <div align="center">   
                                <form id="post_form" method="POST">
                                <table id="table_copy_data" border=0>
                                    <tr>
                                        <td class="table_label"><b>CREATION DATE</b></td>
                                        <td class="table_colon"><b>:</b></td>
                                        <td class="table_data">
                                            <input class="datepicker form-control" name="txt_date_from" id="txt_date_from" 
                                            data-date-format="yyyy-mm-dd" readonly="readonly"
                                            style="height:30px; width: 200px;" value="" placeholder="FROM">
                                        </td>
                                        <td class="table_data">
                                            <input class="datepicker form-control" name="txt_date_to" id="txt_date_to" 
                                            data-date-format="yyyy-mm-dd" readonly="readonly"
                                            style="height:30px; width: 200px;" value="" placeholder="TO">
                                        </td>
                                    </tr>
                                </table>
                                </form>
                                <br/>
                                <button id="btn_print_excel" type="button" class="btn btn-default" onclick="copyData();">Copy</button>
                            </div>
                            
                        </div>
                    </div>  
                </div>  
            </div>
        </div> 
    </div>
    
    <div class="footer_bg">
        <div align="center">
        &copy; 2015 Puregold Price Club Inc. IT-HO Mydel-Ar A. Asturiano All Rights Reserved
        </div>    
    </div> 

  </body>
</html>