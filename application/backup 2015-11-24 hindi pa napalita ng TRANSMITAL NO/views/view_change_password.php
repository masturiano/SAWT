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
        
        // ALLOW NUMERIC ONLY ON TEXTFIELD
        $(function(){
            $("#txt_account_number").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                     // Allow: Ctrl+A, Command+A
                    (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
                     // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                         // let it happen, don't do anything
                         return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        }); 
        
        // TEXTFIELD AUTO COMPLETE
        $(function(){
            $("#txt_account_display").autocomplete({
                source: "<?php echo base_url('report/search_account');?>",
                minLength: 1,
                select: function(event, ui) { 
                    var content = ui.item.id; 
                    $("#txt_account_number").val(content);       
                    var content2 = ui.item.label; 
                    $("#txt_account_display").val(content2); 
                    var content3 = ui.item.value; 
                    $("#txt_account_display").val(content3);   
                }
            });   
        });  
        
        // CLICK BUTTON PRINT EXCEL
        function savePassword()
        {
            if($('#txt_password').val() == 0){
                bootbox.alert("Please input new password!", function() {
                    $('#txt_password').css("border","red solid 1px");
                });    
                return false;
            }
            else{
                $('#txt_password').css("border","lightgray solid 1px");    
            }  
            if($('#txt_password').val().length < 5){
                bootbox.alert("Password atleast 5 characters!", function() {
                    $('#txt_password').css("border","red solid 1px");
                });    
                return false;
            }
            else{
                $('#txt_password').css("border","lightgray solid 1px");    
            } 
            if($('#txt_confirm_password').val() == 0){
                bootbox.alert("Please input confirm password!", function() {
                    $('#txt_confirm_password').css("border","red solid 1px");
                });    
                return false;
            } 
            else{
                $('#txt_confirm_password').css("border","lightgray solid 1px");    
            }   
            if($('#txt_password').val() != $('#txt_confirm_password').val()){
                bootbox.alert("Confirm password not matched!", function() {
                    $('#txt_confirm_password').css("border","red solid 1px");
                });    
                return false;
            } 
            else{
                $('#txt_confirm_password').css("border","lightgray solid 1px");    
            }   
               
            $('#div_save_confirm .modal-body').html('Are you sure you want to change your password?');
            $('#div_save_confirm').modal('show');
            $('#saving_confirm').click( function (e) {
                e.stopImmediatePropagation();
                $.ajax({
                    url: '<? echo site_url('systema/editing_user_password');?>',
                    type: 'POST',  
                    data: $('#post_form').serialize(),
                    beforeSend: function(data)
                    {
                        jQuery('#loading').showLoading();
                    },
                    success: function(data){      
                        jQuery('#loading').hideLoading();
                        $('#div_save_confirm').modal('hide'); 
                        $('#saving_confirm').modal('hide'); 
                        $('#txt_password').val('');
                        $('#txt_confirm_password').val('');  
                        bootbox.alert("New password has been save!");
                    }        
                });   
            }); 
            
        }   
        
        // BOOTSTRAP DATE PICKER
        $(function(){   
            $('.datepicker').datepicker({
                autoclose: true,
            })
        }); 
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
                                <table id="table_change_password" border=0>
                                    <tr>
                                        <td class="table_label"><b>USER NAME</b></td>
                                        <td class="table_colon">:</td>
                                        <td class="table_data" colspan="2" style="height: 30px;">
                                            <?=$this->session->userdata('userName');?>
                                            <input type="hidden" class="form-control" name="txt_username" id="txt_username" value="<?=$this->session->userdata('userName');?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table_label"><b>NEW PASSWORD</b></td>
                                        <td class="table_colon">:</td>
                                        <td class="table_data" colspan="2">
                                            <input type="password" class="form-control inputBox" name="txt_password" id="txt_password"
                                            style="height:30px; width: 200px;" maxlength="50"> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table_label"><b>CONFIRM PASSWORD</b></td>
                                        <td class="table_colon">:</td>
                                        <td class="table_data" colspan="2">
                                            <input type="password" class="form-control inputBox" name="txt_confirm_password" id="txt_confirm_password"
                                            style="height:30px; width: 200px;" maxlength="50"> 
                                        </td>
                                    </tr>
                                </table>
                                </form>
                                <br/>
                                <button id="btn_save" type="button" class="btn btn-default" onclick="savePassword();">Save</button>
                            </div>
                            
                        </div>
                    </div>  
                </div>  
            </div>
            
            <div class="modal fade" id="div_save_confirm" tabindex="-1" role="dialog" aria-labelledby="div_save_confirm" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-body">
                  </div>
                  <div class="modal-footer">
                    <button type="button" id="save_confirm_close" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="saving_confirm" class="btn btn-primary">Save</button>
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