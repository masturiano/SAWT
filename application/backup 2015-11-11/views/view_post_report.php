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
        function printExcel()
        {
            if($('#cmb_type').val() == 0){
                bootbox.alert("Please select SAWT Type!", function() {
                    $('#cmb_type').css("border","red solid 1px");
                });    
                return false;
            }
            else{
                $('#cmb_type').css("border","lightgray solid 1px");    
            }  
            if($('#cmb_company').val() == 0){
                bootbox.alert("Please select Company!", function() {
                    $('#cmb_company').css("border","red solid 1px");
                });    
                return false;
            } 
            else{
                $('#cmb_company').css("border","lightgray solid 1px");    
            }   
            if($('#cmb_quarter').val() == 0){
                bootbox.alert("Please select Quarter!", function() {
                    $('#cmb_quarter').css("border","red solid 1px");
                });    
                return false;
            } 
            else{
                $('#cmb_quarter').css("border","lightgray solid 1px");    
            }          
            
            $.ajax
            ({
                url: '<? echo site_url('report/generate_post_xls');?>',
                type: 'POST',  
                data: $('#post_form').serialize(),
                beforeSend: function(data)
                {
                    $("#btn_print_excel").html('Printing Excel');
                },
                success: function(data){ 
                    $("#btn_print_excel").html('Print Excel');
                    eval(data);
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
                            <table id="table_post_report" border=0>
                                <tr>
                                    <td class="table_label">
                                        SAWT TYPE
                                    </td>
                                    <td class="table_colon">:</td>
                                    <td class="table_data">
                                        <select name="cmb_type" id="cmb_type"
                                        style="height:30px; width: 200px;">   
                                            <option value="0">SELECT</option>  
                                            <?php foreach($get_sawt_type as $row1){ ?>
                                            <option value="<?=$row1->id;?>"><?=$row1->description;?></option>
                                            <? } ?>
                                        </select> 
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table_label">
                                        COMPANY
                                    </td>
                                    <td class="table_colon">:</td>
                                    <td class="table_data">
                                        <select name="cmb_company" id="cmb_company"
                                        style="height:30px; width: 400px;">   
                                            <option value="0">SELECT COMPANY</option>  
                                            <?php foreach($get_all_company as $row2){ ?>
                                            <option value="<?=$row2->org_id;?>"><?=$row2->comp_name;?></option>
                                            <? } ?>
                                        </select> 
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table_label">
                                        QUARTER
                                    </td>
                                    <td class="table_colon">:</td>
                                    <td class="table_data">
                                        <select name="cmb_quarter" id="cmb_quarter"
                                        style="height:30px; width: 200px;">   
                                            <option value="0">SELECT</option>  
                                            <?php foreach($get_all_quarter as $row3){ ?>
                                            <option value="<?=$row3->label_id;?>"><?=$row3->label_name." ".$row3->label_year;?></option>
                                            <? } ?>
                                        </select> 
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table_label">
                                    ACCOUNT NUMBER
                                    </td>
                                    <td class="table_colon">:</td>
                                    <td class="table_data">
                                        <input type="text" class="form-control inputBox" name="txt_account_display" id="txt_account_display"
                                        style="height:30px; width: 400px;" maxlength="9" onclick="this.value='';"> 
                                        <input type="hidden" class="form-control" name="txt_account_number" id="txt_account_number">
                                    </td>
                                </tr>
                            </table>
                            </form>
                            <br/>
                            <button id="btn_print_excel" type="button" class="btn btn-default" onclick="printExcel();">Print Excel</button>
                        </div>
                        
                    </div>
                </div>  
            </div>  
        </div>
    </div> 

  </body>
</html>