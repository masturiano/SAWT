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
        
    <!-- Javascript -->
    <script type="text/javascript">     
        // CHECK SESSION
        function checkSession(){
            $.ajax({
                url: "<?php echo base_url('process/check_session');?>",
                type: "POST",
                success: function(Data){
                        eval(Data);
                    }                
               });  
            setTimeout("checkSession()",10000); 
        }  
        
        // BOOT GRID
        // Refer to http://jquery-bootgrid.com/Documentation for methods, events and settings
        // load gird on page\e load...
        $(function(){
            $("#grid-data").bootgrid(
             {
             caseSensitive:false
             })
        });     
        
        // SELECT TABLE ROW
        $(function(){   
            $.ajax({
                url: "<?php echo base_url('process/encode');?>",
                type: "POST",
                success: function(){
 
                    $("#div_disp_data").show();
                    $('#grid-data tbody').on( 'click', 'tr', function () {
                        if ($(this).hasClass('selected') ) {
                            $(this).removeClass('selected');  
                        }
                        else {  
                            $('tr.selected').removeClass('selected');
                            $(this).addClass('selected');
                            $('#encode').removeAttr('disabled');
                            
                            $(this).addClass('selected').siblings().removeClass('selected');    
                            var value=$(this).find('td:first').html();
                            
                            $.ajax({
                            url: "<?php echo base_url('process/encode');?>",
                            type: "POST",
                            data: "id="+value,
                            success: function(){ 
                                    encode(value); 
                                }                
                           });    
                        }
                    });       
                    
                }         
            });  
        });     
        
        // EDIT RECEIPT NO
        function encode(value){
            $('#encode').click( function () {  
                $.ajax({
                    url: "<?php echo base_url('process/encode_export');?>",
                    type: "POST",
                    data: "post_id="+value,
                    success: function(data){   
                       
                        $('#encodeSAWT .modal-body').html(data);
                        $('#encodeSAWT').modal('show');
                        $('#saving').click( function () {
                            
                            if($('#txt_tax_payer_id').val().length == 0){
                                bootbox.alert("Please input Taxpayer Identification Number!", function() {
                                    $('#txt_tax_payer_id').css("border","red solid 1px");
                                });         
                                return false;
                            }
                            else{
                                $('#txt_tax_payer_id').css("border","gray solid 1px");    
                            }
                            
                            if($('#txt_tax_payer_id').val().length < 9){
                                bootbox.alert("Taxpayer Identification Number must be 9 digits!", function() {
                                    $('#txt_tax_payer_id').css("border","red solid 1px");
                                });     
                                return false;
                            }else{
                                $('#txt_tax_payer_id').css("border","gray solid 1px");    
                            }
                            
                            if($('#txt_bir_reg_name').val().length == 0){
                                bootbox.alert("Please input BIR Reg Name!", function() {
                                    $('#txt_bir_reg_name').css("border","red solid 1px");
                                });    
                                return false;
                            }
                            else{
                                $('#txt_bir_reg_name').css("border","gray solid 1px");    
                            } 
                            
                            if($('#txt_atc_code').val().length == 0){
                                bootbox.alert("Please input ATC Code!", function() {
                                    $('#txt_atc_code').css("border","red solid 1px");
                                });     
                                return false;
                            }
                            else{
                                $('#txt_atc_code').css("border","gray solid 1px");    
                            } 
                            
                            if($('#txt_tax_base').val().length == 0){
                                bootbox.alert("Please input Tax Base Total!", function() {
                                    $('#txt_tax_base').css("border","red solid 1px");
                                });    
                                return false;
                            }
                            else{
                                $('#txt_tax_base').css("border","gray solid 1px");    
                            } 
                            
                            bootbox.confirm("Are you sure you want to update receipt number "+$('#txt_receipt_id').val()+"?", function(result) {
                                if(result == true){
                                    $.ajax({
                                        url: "<?php echo base_url('process/encode_export_update');?>",
                                        type: "POST",
                                        data: $('#encode_form').serialize()+"&post_id="+value,
                                        success: function(){
                                            // CHECK IF TIN NO EXIST IN DB
                                            var content = $("#txt_tax_payer_id").val(); 
                                            var content2 = $("#txt_bir_reg_name").val(); 
                                            $.ajax({
                                                url: "<?php echo base_url('process/check_tin_number');?>",
                                                type: "POST",
                                                data: "post_tin_no="+content,
                                                success: function(data){
                                                    if(data == 0){  
                                                        $.ajax({
                                                            url: "<?php echo base_url('process/add_tin_master');?>",
                                                            type: "POST",
                                                            data: "post_tin_no="+content+"&post_bir_reg_name="+content2,
                                                            success: function(data){
                                                                bootbox.alert("New Taxpayer Identification Number added!", function() {
                                                                    $('#editUser').modal('hide');  
                                                                    $('#edit').attr('disabled','disabled');
                                                                    $('#delete').attr('disabled','disabled'); 
                                                                    document.location.reload();
                                                                });    
                                                            }         
                                                        });    
                                                    } 
                                                    else{
                                                        $('#editUser').modal('hide');  
                                                        $('#edit').attr('disabled','disabled');
                                                        $('#delete').attr('disabled','disabled'); 
                                                        document.location.reload();
                                                    }   
                                                }         
                                            });   
                                        }         
                                    });     
                                }
                                else{
                                    document.location.reload();       
                                }
                            });   
                        });
                        $('#save_close').click( function () {
                            $('#edit').attr('disabled','disabled');
                            $('#delete').attr('disabled','disabled'); 
                            document.location.reload();         
                        });
                        
                    }         
                });  
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
    
    <div id="container">  
        <div id="div_disp_data" style="display:none;">
            &nbsp;
            <button type="button" id="encode" class="btn btn-primary" disabled="disabled">Encode</button>
                            
            <table id="grid-data" class="table table-condensed table-hover table-striped">
                <thead>
                    <tr class="clickable-row"> 
                        <th data-column-id="cash_receipt_id" data-type="numeric" data-identifier="true" data-order="asc">CASH RECEIPT ID</th>
                        <th data-column-id="receipt_number">RECEIPT NUMBER</th>
                        <th data-column-id="receipt_date">RECEIPT DATE</th>
                        <th data-column-id="account_number">ACCOUNT NUMBER</th>
                        <th data-column-id="account_name">ACCOUNT NAME</th>
                        <th data-column-id="receipt_method_id">RECEIPT METHOD ID</th>
                        <th data-column-id="name">NAME</th>
                        <th data-column-id="org_id">ORG ID</th>
                        <th data-column-id="amoount">AMOUNT</th>
                        <? // <th data-column-id="user_stat">USER ID</th> ?>
                        <th data-column-id="user_name">USER NAME</th>
                        <th data-column-id="gl_date">GL DATE</th>
                        <th data-column-id="tin">TIN</th>
                        <th data-column-id="bir_reg_name">BIR REG NAME</th>
                        <th data-column-id="atc_code">ATC CODE</th>
                        <th data-column-id="tax_base">TAX BASE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($get_encode as $row){
                    ?>
                    <tr>
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->CASH_RECEIPT_ID; ?></td>
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->RECEIPT_NUMBER; ?></td>
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo date('Y-m-d',strtotime($row->RECEIPT_DATE)); ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->ACCOUNT_NUMBER; ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->ACCOUNT_NAME; ?></td>
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->RECEIPT_METHOD_ID; ?></td>
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->NAME; ?></td>  
                        <?php
                        # GET USER STATUS SELECTED
                        $result_company = $this->get_process->get_company($row->ORG_ID); 
                        if ($result_company->num_rows() > 0){
                           $row_company = $result_company->row();
                        }
                        ?>
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row_company->comp_short; ?></td>      
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->AMOUNT; ?></td>    
                        <? // <td id="<?php echo $row->CASH_RECEIPT_ID; ">?><?php //echo $row->USER_ID; ?><? //</td> ?> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->USER_NAME; ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo date('Y-m-d',strtotime($row->GL_DATE)); ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->TIN; ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->BIR_REG_NAME; ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->ATC_CODE; ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->TAX_BASE; ?></td> 
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table> 
        </div>    
    
        <div class="modal fade" id="encodeSAWT" tabindex="-1" role="dialog" aria-labelledby="encodeSAWT" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Encode</h4>
              </div>
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" id="save_close" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="saving" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
    
    </div>    

    </body>
</html>