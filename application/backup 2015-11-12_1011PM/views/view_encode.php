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
        
        //selection:true,
        //multiSelect: true,
        //rowSelect : true,   
        $(function()
        {
            function init()
            {
                $("#div_disp_data").show();
                $("#grid-data").bootgrid({
                    formatters: {
                        "link": function(column, row)
                        {
                            return "<?php echo base_url('process/encode');?>" + column.id + ": " + row.id + "</a>";
                        }
                    },
                    rowCount: [10, 50, 75, -1]
                }).on("selected.rs.jquery.bootgrid", function (e, rows) {
                        var value = $("#grid-data").bootgrid("getSelectedRows");
                        if(value.length == 0){
                            $('#btn_view').attr('disabled','disabled'); 
                            $('#btn_encode').attr('disabled','disabled'); 
                            $('#btn_transmit').attr('disabled','disabled'); 
                        }
                        else if(value.length == 1){
                            $('#btn_view').removeAttr('disabled'); 
                            $('#btn_encode').removeAttr('disabled'); ;
                            $('#btn_transmit').removeAttr('disabled'); ;
                        }
                        else{    
                            $('#btn_view').attr('disabled','disabled');
                            $('#btn_encode').attr('disabled','disabled'); 
                            $('#btn_transmit').removeAttr('disabled');     
                        }                                                     
                    }).on("deselected.rs.jquery.bootgrid", function (e, rows){
                        var value = $("#grid-data").bootgrid("getSelectedRows");
                        if(value.length == 0){
                            $('#btn_view').attr('disabled','disabled'); 
                            $('#btn_encode').attr('disabled','disabled'); 
                            $('#btn_transmit').attr('disabled','disabled'); 
                        }
                        else if(value.length == 1){
                            $('#btn_view').removeAttr('disabled'); 
                            $('#btn_encode').removeAttr('disabled'); ;
                            $('#btn_transmit').removeAttr('disabled'); ;
                        }
                        else{    
                            $('#btn_view').attr('disabled','disabled');
                            $('#btn_encode').attr('disabled','disabled'); 
                            $('#btn_transmit').removeAttr('disabled');     
                        }     
                    }) 
            }
            
            init();    
            
            $("#append").on("click", function ()
            {
                $("#grid-data").bootgrid("append", [{
                        id: 0,
                        sender: "hh@derhase.de",
                        received: "Gestern",
                        link: ""
                    },
                    {
                        id: 12,
                        sender: "er@fsdfs.de",
                        received: "Heute",
                        link: ""
                    }]);
            });
            
            $("#clear").on("click", function ()
            {
                $("#grid-data").bootgrid("clear");
            });
            
            $("#removeSelected").on("click", function ()
            {
                $("#grid-data").bootgrid("remove");
            });
            
            $("#destroy").on("click", function ()
            {
                $("#grid-data").bootgrid("destroy");
            });
            
            $("#init").on("click", init);
            
            $("#clearSearch").on("click", function ()
            {
                $("#grid-data").bootgrid("search");
            });
            
            $("#clearSort").on("click", function ()
            {
                $("#grid-data").bootgrid("sort");
            });
            
            $("#getCurrentPage").on("click", function ()
            {
                alert($("#grid-data").bootgrid("getCurrentPage"));
            });
            
            $("#getRowCount").on("click", function ()
            {
                alert($("#grid-data").bootgrid("getRowCount"));
            });
            
            $("#getTotalPageCount").on("click", function ()
            {
                alert($("#grid-data").bootgrid("getTotalPageCount"));
            });
            
            $("#getTotalRowCount").on("click", function ()
            {
                alert($("#grid-data").bootgrid("getTotalRowCount"));
            });
            
            $("#getSearchPhrase").on("click", function ()
            {
                alert($("#grid-data").bootgrid("getSearchPhrase"));
            });
            
            $("#getSortDictionary").on("click", function ()
            {
                alert($("#grid-data").bootgrid("getSortDictionary"));
            });
            
            $("#btn_view").on("click", function ()
            {
                var value = $("#grid-data").bootgrid("getSelectedRows");
                // SELECT TABLE ROW         
                $.ajax({           
                    url: "<?php echo base_url('process/encode');?>",
                    type: "POST",
                    data: "post_id="+value,
                    success: function(){
                                             
                        $("#div_disp_data").show();  
                        $('#btn_view').removeAttr('disabled'); 
                        $('#div_view_sawt').modal('hide'); 
                        view(value)        
                    }         
                });  
            }); 
            
            $("#btn_encode").on("click", function ()
            {
                var value = $("#grid-data").bootgrid("getSelectedRows");
                // SELECT TABLE ROW         
                $.ajax({           
                    url: "<?php echo base_url('process/encode');?>",
                    type: "POST",
                    data: "post_id="+value,
                    success: function(){
                                             
                        $("#div_disp_data").show();  
                        $('#btn_encode').removeAttr('disabled'); 
                        $('#div_encode_sawt').modal('hide');   
                        encode(value)     
                    }         
                });  
            }); 
            
            $("#btn_transmit").on("click", function ()
            {
                var value = $("#grid-data").bootgrid("getSelectedRows");
                // SELECT TABLE ROW         
                $.ajax({           
                    url: "<?php echo base_url('process/check_transmit_without_null');?>",
                    type: "POST",
                    data: "post_receipt_id="+value,
                    success: function(data){            
                        if(data == 1){     
                            bootbox.alert("Please uncheck receipt number with blank TIN,BIR REG NAME,ATC CODE and TAX BASE before you transmit!", function() {   
                            });     
                            return false;     
                        }
                        else{
                            transmit(value)     
                        }  
                    }         
                });  
            });  
            
        });   
            
              
        // ON CHANGE COMPANY DROPDOWN
        $(function(){   
            $('#cmd_company').change(function() {
                $('#grid-data').bootgrid('reload');
                value = $(this).val();
                $.ajax({           
                    url: "<?php echo base_url('process/encode');?>",
                    type: "POST",
                    data: "post_org_id="+value,
                    success: function(data){   
                            
                    }         
                });    
            });
        });
        
        // VIEW RECEIPT NO
        function view(value){

            $.ajax({
                url: "<?php echo base_url('process/view_export');?>",
                type: "POST",
                data: "post_id="+value,
                success: function(data){   
                    
                    if(value.length > 1){
                        bootbox.alert("Please select one receipt number only!", function() {
                        });    
                        return false;
                    }
                    else{                                 
                        $('#div_view_sawt .modal-body').html(data);
                        $('#div_view_sawt').modal('show');                            
                    }   
                    
                }         
            });  

        }      
        
        // TRANSMIT RECEIPT NO
        function transmit(value){
            
            $.ajax({
                url: "<?php echo base_url('process/transmit_export_details');?>",
                type: "POST",
                data: "post_receipt_id="+value,
                success: function(data){
                    $('#div_transmit_confirm .modal-body').html(data);
                    $('#div_transmit_confirm').modal('show');
                    $('#transmiting_confirm').click( function (e) {
                        e.stopImmediatePropagation();
                        $.ajax({
                            url: "<?php echo base_url('process/transmit_export_update');?>",
                            type: "POST",
                            data: "post_receipt_id="+value,
                            success: function(){
                                bootbox.alert("Receipt number successfully transmitted!", function() {  
                                    $('#div_transmit_confirm').modal('hide'); 
                                    printTransmittal(value);
                                });       
                            }         
                        });     
                    });       
                }         
            });   
        }  
        
        // PRINT TRANSMITTAL
            function printTransmittal(value){
                $.ajax({
                    url: "<?php echo base_url('process/generate_pdf');?>",
                    type: "POST",
                    data: "post_receipt_id="+value,
                    success: function(data){
                        eval(data);
                        bootbox.alert("Print transmittal success!", function() {  
                            $('#div_transmit_confirm').modal('hide'); 
                            // document.location.reload();
                        });       
                    }         
                });       
            }       
        
        // EDIT RECEIPT NO
        function encode(value){

                $.ajax({
                    url: "<?php echo base_url('process/encode_export');?>",
                    type: "POST",
                    data: "post_id="+value,
                    success: function(data){   
                        
                        $('#div_encode_sawt .modal-body').html(data);
                        $('#div_encode_sawt').modal('show');
                        $('#saving').click( function (e) {
                            e.stopImmediatePropagation();
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
                            
                            if($('#cmb_atc_code').val() == 0){
                                bootbox.alert("Please select ATC Code!", function() {
                                    $('#cmb_atc_code').css("border","red solid 1px");
                                });    
                                return false;
                            }
                            else{
                                $('#cmb_atc_code').css("border","gray solid 1px");    
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
                            
                            $('#div_save_confirm .modal-body').html('Are you sure you want to update receipt number '+$('#txt_receipt_no').val()+'?');
                            $('#div_save_confirm').modal('show');
                            $('#saving_confirm').click( function (e) {
                                e.stopImmediatePropagation();
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
                                                                $('#div_encode_sawt').modal('hide'); 
                                                                $('#div_save_confirm').modal('hide'); 
                                                                $('#encode').attr('disabled','disabled');
                                                                document.location.reload();
                                                            });    
                                                        }         
                                                    });    
                                                } 
                                                else{      
                                                    document.location.reload();
                                                    $('#encodeSAWT').modal('hide'); 
                                                    $('#encode').attr('disabled','disabled');
                                                }   
                                            }         
                                        });   
                                    }         
                                });     
                            }); 
                              
                            $('#save_confirm_close').click( function () {    
                                $('#div_save_confirm').modal('hide');   
                            $('#encode').attr('disabled','disabled');  
                        });
                        });
                        $('#save_close').click( function () {     
                            $('#encode').attr('disabled','disabled'); 
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
    
    <?php 
    include('view_menu.php');
    ?>
    
    <div class="header_bg_down">
    </div>
    
    <div id="container">  
        <div id="div_disp_data" style="display:none;">
            &nbsp;
            <div align="center">
                <? # ALLOW DEPARTMENT MIS,ACCOUNTING ?>
                <? if($this->session->userdata('groupCode') == 1 || $this->session->userdata('groupCode') == 4){ ?>     
                <table id="table_company" border=0>
                    <tr>
                        <td class="table_label">
                            COMPANY
                        </td>
                        <td class="table_colon">:</td>
                        <td class="table_data">
                            <select name="cmd_company" id="cmd_company"
                            style="height:30px; width: 400px;">   
                                <option value="0">SELECT COMPANY</option>  
                                <?php foreach($get_all_company as $row){ ?>
                                <option value="<?=$row->org_id;?>"><?=$row->comp_name;?></option>
                                <? } ?>
                            </select> 
                        </td>
                    </tr>
                </table>
                <? } ?>
            </div>

            &nbsp;
            <button id="btn_view" type="button" class="btn btn-default" disabled="disabled">View</button>
            <button id="btn_encode" type="button" class="btn btn-default" disabled="disabled">Encode</button>
            <button id="btn_transmit" type="button" class="btn btn-default" disabled="disabled">Transmit</button>                  
                            
            <table id="grid-data" class="table table-condensed table-hover table-striped"
            data-selection="true" 
            data-multi-select="true" 
            data-row-select="true" 
            data-keep-selection="true">
                <thead>
                    <tr class="clickable-row"> 
                        <th data-column-id="cash_receipt_id" data-type="numeric" data-identifier="true" data-visible="false" data-visible-in-selection="true" data-order="asc">#</th>
                        <th data-column-id="receipt_number">RECEIPT NUMBER</th>
                        <th data-column-id="receipt_date">RECEIPT DATE</th>
                        <th data-column-id="account_number">ACCOUNT NUMBER</th>
                        <th data-column-id="account_name">ACCOUNT NAME</th>
                        <? // <th data-column-id="receipt_method_id">RECEIPT METHOD ID</th> ?>
                        <? // <th data-column-id="name">NAME</th> ?>
                        <th data-column-id="org_id">ORG ID</th>
                        <th data-column-id="amoount">AMOUNT</th>
                        <? // <th data-column-id="user_stat">USER ID</th> ?>
                        <? // <th data-column-id="user_name">USER NAME</th> ?>
                        <? // <th data-column-id="gl_date">GL DATE</th> ?>
                        <th data-column-id="tin">TIN</th>
                        <th data-column-id="bir_reg_name">BIR REG NAME</th>
                        <th data-column-id="atc_code">ATC CODE</th>
                        <th data-column-id="tax_base">TAX BASE</th>
                        <th data-column-id="gl_date_sawt">SAWT GL DATE</th>
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
                        <? // <td id="<?php echo $row->CASH_RECEIPT_ID; ">?><?php //echo $row->RECEIPT_METHOD_ID; ?><? //</td> ?>
                        <? // <td id="<?php echo $row->CASH_RECEIPT_ID; ">?><?php //echo $row->NAME; ?><? //</td> ?>  
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
                        <? // <td id="<?php echo $row->CASH_RECEIPT_ID; ">?><?php //echo $row->USER_NAME; ?><? //</td> ?>
                        <? // <td id="<?php echo $row->CASH_RECEIPT_ID; ">?><?php //echo date('Y-m-d',strtotime($row->GL_DATE)); ?><? //</td> ?>
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->TIN; ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->BIR_REG_NAME; ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->ATC_CODE; ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->TAX_BASE; ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo date('Y-m-d',strtotime($row->GL_DATE_SAWT)); ?></td> 
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table> 
        </div> 
        
        <div class="modal fade" id="div_view_sawt" tabindex="-1" role="dialog" aria-labelledby="div_view_sawt" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">View</h4>
              </div>
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" id="save_close" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>   
    
        <div class="modal fade" id="div_encode_sawt" tabindex="-1" role="dialog" aria-labelledby="div_encode_sawt" aria-hidden="true">
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
                <button type="button" id="saving" class="btn btn-primary">Save</button>
              </div>
            </div>
          </div>
        </div>
        
        <div class="modal fade" id="div_transmit_confirm" tabindex="-1" role="dialog" aria-labelledby="div_transmit_sawt" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" id="transmit_confirm_close" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="transmiting_confirm" class="btn btn-primary">Save</button>
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

    </body>
</html>