<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Process_ho extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        # LIBRARY
        $this->load->library('form_validation');
        $this->load->library('pagination'); 
        $this->load->library('table');
        
        # HELPER
        $this->load->helper('url');
        $this->load->helper('path');  
        $this->load->helper('form');      
    }
    
    public function check_session(){
        # CHECK SESSION                 
        if($this->session->userdata('userName') == ""){
            $this->session->sess_destroy();    
            echo "location.href='".base_url()."'";    
        }    
    }
    
    #########################( ENCODE )#########################
    
    public function encode(){  
        # TITLE
        $data['title']  = "Process"; 
        
        # MODULE NAME
        $data['module_name']  = "Encode SAWT";   
        
        # MODEL
        $this->load->model('get_process_ho'); 
         
        $data['get_encode'] = $this->get_process_ho->get_encode($this->session->userdata('oracleUsername'),$this->input->post('post_org_id')); 
        $data['get_all_company'] = $this->get_process_ho->get_all_company(); 
        
        # VIEW
        $this->load->view('view_encode_ho',$data); 
    }    
    
    public function encode_per_company(){  
        # TITLE
        $data['title']  = "Process"; 
        
        # MODULE NAME
        $data['module_name']  = "Encode SAWT";   
        
        # MODEL
        $this->load->model('get_process_ho'); 
         
        $data['get_encode'] = $this->get_process_ho->get_encode($this->session->userdata('oracleUsername'),$this->input->post('post_org_id')); 
        $data['get_all_company'] = $this->get_process_ho->get_all_company(); 
        
        ?>
        <script type="text/javascript"> 
            
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
                            $('#btn_encode').removeAttr('disabled');
                            $('#btn_transmit').removeAttr('disabled');
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
                            $('#btn_encode').removeAttr('disabled');
                            $('#btn_transmit').removeAttr('disabled');
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
                
                $("#btn_view").on("click", function ()
                {
                    var value = $("#grid-data").bootgrid("getSelectedRows");
                    // SELECT TABLE ROW         
                    $.ajax({           
                        url: "<?php echo base_url('process_ho/encode');?>",
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
                        url: "<?php echo base_url('process_ho/encode');?>",
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
                        url: "<?php echo base_url('process_ho/check_transmit_without_null');?>",
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
            
            // SELECT TABLE ROW ENABLE DISABLE BUTTON
            // DO NOT USER
            //$(function(){               
            //    $.ajax({           
            //        url: "<?php //echo base_url('process_ho/encode');?>",
            //        type: "POST",
            //        success: function(){  
            //           $("#div_disp_data").show();   
            //            $("#grid-data tr").on("click", function (){    
            //               $('#btn_encode').removeAttr('disabled'); 
            //               $('#btn_transmit').removeAttr('disabled');
            //               $('#div_encode_sawt').modal('hide');        
            //            });    
            //        }         
            //    });    
            //});    
            
            // TRANSMIT RECEIPT NO
            function transmit(value){
                
                $.ajax({
                    url: "<?php echo base_url('process_ho/transmit_export_details');?>",
                    type: "POST",
                    data: "post_receipt_id="+value,
                    success: function(data){
                        $('#div_transmit_confirm .modal-body').html(data);
                        $('#div_transmit_confirm').modal('show');
                        $('#transmiting_confirm').click( function (e) {
                            e.stopImmediatePropagation();
                            $.ajax({
                                url: "<?php echo base_url('process_ho/transmit_export_update');?>",
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
                    url: "<?php echo base_url('process_ho/generate_pdf');?>",
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
            
            // VIEW RECEIPT NO
            function view(value){

                $.ajax({
                    url: "<?php echo base_url('process_ho/view_export');?>",
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
            
            // EDIT RECEIPT NO
            function encode(value){

                $.ajax({
                    url: "<?php echo base_url('process_ho/encode_export');?>",
                    type: "POST",
                    data: "post_id="+value,
                    success: function(data){   
                        
                        if(value.length > 1){
                            bootbox.alert("Please select one receipt number only!", function() {
                            });    
                            return false;
                        }
                        else{
                            
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
                                        url: "<?php echo base_url('process_ho/encode_export_update');?>",
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
                                                            url: "<?php echo base_url('process_ho/add_tin_master');?>",
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
                        
                    }         
                });  

            }    
        </script>    
        
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
                        <th data-column-id="cash_receipt_id" data-type="numeric" data-identifier="true" data-order="asc" data-visible="false" data-visible-in-selection="true">#</th>
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
                        foreach($data['get_encode'] as $row){
                    ?>
                    <tr>
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->CASH_RECEIPT_ID;?></td>
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->RECEIPT_NUMBER; ?></td>
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo date('Y-m-d',strtotime($row->RECEIPT_DATE)); ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->ACCOUNT_NUMBER; ?></td> 
                        <td id="<?php echo $row->CASH_RECEIPT_ID; ?>"><?php echo $row->ACCOUNT_NAME; ?></td>
                        <? // <td id="<?php echo $row->CASH_RECEIPT_ID; ">?><?php //echo $row->RECEIPT_METHOD_ID; ?><? //</td> ?>
                        <? // <td id="<?php echo $row->CASH_RECEIPT_ID; ">?><?php //echo $row->NAME; ?><? //</td> ?>  
                        <?php
                        # GET USER STATUS SELECTED
                        $result_company = $this->get_process_ho->get_company($row->ORG_ID); 
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

        <?php
    }   
    
    public function view_export(){  
        # MODEL
        $this->load->model('get_process_ho');
        
        $result_export_details = $this->get_process_ho->get_export_details($this->input->post('post_id'));
         
        if ($result_export_details->num_rows() > 0){
           $row = $result_export_details->row();
        }
        else{
           $row = "0"; 
        }   
        ?>  
        <!-- Jquery UI -->
        <link href="<? echo base_url('includes/jquery/development-bundle/themes/base/jquery.ui.all.css'); ?>" rel="stylesheet"> 
        <!-- Jquery Minified Javascript -->
        <script src="<? echo base_url('includes/jquery/js/jquery-ui-1.8.23.custom.min.js'); ?>"></script>
        <!-- My Javascript -->
        <script src="<? echo base_url('includes/my_javascript.js'); ?>"></script>

          
        <form id="encode_form" method="POST">
            <input type="hidden" class="form-control" name="txt_receipt_id" id="txt_receipt_id" value="<?php echo $row->CASH_RECEIPT_ID; ?>"> 
            <table id="table_edit" border="0" class="table table-condensed table-striped">    
                <tr>
                    <td class="table_label"><b>Receipt Number</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?php echo $row->RECEIPT_NUMBER; ?>
                        <input type="hidden" class="form-control" name="txt_receipt_no" id="txt_receipt_no" value="<?php echo $row->RECEIPT_NUMBER; ?>">
                        <input type="hidden" class="form-control" name="txt_amount" id="txt_amount" value="<?php echo $row->AMOUNT; ; ?>"> 
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>Receipt Date</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?php echo date('Y-m-d',strtotime($row->RECEIPT_DATE)); ?>
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>Account Number</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?php echo $row->ACCOUNT_NUMBER; ?>
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>Account Name</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?php echo $row->ACCOUNT_NAME; ?>
                    </td>
                </tr>  
                <?php
                $result_company = $this->get_process_ho->get_company($row->ORG_ID); 
                if ($result_company->num_rows() > 0){
                   $row_company = $result_company->row();
                }
                ?>
                <tr>
                    <td class="table_label"><b>Org Id</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?php echo $row_company->comp_short; ?>
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>Amount</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?php echo $row->AMOUNT; ?>
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>Tin Id Number</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?php echo $row->TIN; ?>
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>BIR Reg. Name</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?php echo $row->BIR_REG_NAME; ?>
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>ATC Code</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?php echo $row->ATC_CODE; ?>
                    </td>
                </tr>
                <tr>
                    <td class="table_label"><b>Tax Base Total</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?php echo $row->TAX_BASE; ?>
                    </td>
                </tr>
                <tr>
                    <td class="table_label"><b>SAWT Gl Date</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?php echo date('Y-m-d',strtotime($row->GL_DATE_SAWT)); ?>
                    </td>
                </tr>
            </table>    
        </form>
        <?php
    }   
    
    public function encode_export(){  
        # MODEL
        $this->load->model('get_process_ho');
        
        $result_export_details = $this->get_process_ho->get_export_details($this->input->post('post_id'));
         
        if ($result_export_details->num_rows() > 0){
           $row = $result_export_details->row();
        }
        else{
           $row = "0"; 
        }   
        ?>  
        <!-- Jquery UI -->
        <link href="<? echo base_url('includes/jquery/development-bundle/themes/base/jquery.ui.all.css'); ?>" rel="stylesheet"> 
        <!-- Jquery Minified Javascript -->
        <script src="<? echo base_url('includes/jquery/js/jquery-ui-1.8.23.custom.min.js'); ?>"></script>
        <!-- My Javascript -->
        <script src="<? echo base_url('includes/my_javascript.js'); ?>"></script>
        
        <script type="text/javascript">
            // ALLOW NUMERIC ONLY ON TEXTFIELD
            $(function(){
                $("#txt_tax_payer_id").keydown(function (e) {
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
            
            // ADD LEADING ZEROS
            $('#txt_tax_payer_id').focusout(function() {      
                if($("#txt_tax_payer_id").length < 9){
                    var value = $("#txt_tax_payer_id").val(); 
                    value = value.length; 
                    value_add_zero = $("#txt_tax_payer_id").val('000000000'+$("#txt_tax_payer_id").val());
                    value_display = value_add_zero.val().slice(value);
                    $("#txt_tax_payer_id").val(value_display);
                }
            });
            
            // TEXTFIELD AUTO COMPLETE
            $(function(){
                $("#txt_tax_payer_id").autocomplete({
                    source: "<?php echo base_url('process/search_bir_reg_name');?>",
                    minLength: 1,
                    select: function(event, ui) {    
                        var content = ui.item.id;
                        $("#txt_tax_payer_id").val(content); 
                        var content2 = ui.item.label2; 
                        $("#txt_bir_reg_name").val(content2);
                        // CHECK IF TIN NO EXIST IN DB
                        $.ajax({
                            url: "<?php echo base_url('process/check_tin_number');?>",
                            type: "POST",
                            data: "post_tin_no="+content,
                            success: function(data){
                                if(data == 1){   
                                    $('#txt_bir_reg_name').attr('readonly','readonly');  
                                } 
                                else{
                                    $('#txt_bir_reg_name').removeAttr('readonly'); 
                                }   
                            }         
                        }); 
                        
                    }
                });   
            }); 
            
            // CHECK IF TIN NO EXIST IN DB
            $("#txt_tax_payer_id").keyup(function()
            {    
                var value = $("#txt_tax_payer_id").val();
                $.ajax({   
                    type: "POST",
                    url: "<?php echo base_url('process/check_tin_number2');?>",
                    data: {'post_tin_no' : value},
                    success: function(data)
                    {
                        if(data == 1){ 
                            $('#txt_bir_reg_name').attr('readonly','readonly');     
                        } 
                        else{
                            $('#txt_bir_reg_name').removeAttr('readonly');
                        }  
                    }       
                });   
            });     
            
            // CLEAR TEXTFIELD AUTO COMPLETE
            function clearTextfield(){
                $("#txt_tax_payer_id").val('');    
                $("#txt_bir_reg_name").val('');    
            }
            
            // COMPUTE TAX PERCENT 
            $(function(){   
                var ora_txt_amount = $("#txt_amount").val();
                var value = $("#txt_tax_base").val();
                
                var display =  (ora_txt_amount / value) * 100;
                
                if(display == 'Infinity'){
                    display = '';    
                }
                else{
                    display = display.toFixed(2);    
                }
                
                $("#div_tax_percent").html(display);    
            });   
            
            $("#txt_tax_base").keyup(function()
            {    
                var ora_txt_amount = $("#txt_amount").val();
                var value = $("#txt_tax_base").val();
                
                var display =  (ora_txt_amount / value) * 100;
                
                if(display == 'Infinity'){
                    display = '';    
                }
                else{
                    display = display.toFixed(2);    
                }
                
                $("#div_tax_percent").html(display);
                
            });     
            
        </script> 
          
        <form id="encode_form" method="POST">
            <input type="hidden" class="form-control" name="txt_receipt_id" id="txt_receipt_id" value="<?php echo $row->CASH_RECEIPT_ID; ?>"> 
            <table id="table_edit" border="0" class="table table-condensed table-striped">    
                <tr>
                    <td class="table_label"><b>Receipt Number</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?php echo $row->RECEIPT_NUMBER; ?>
                        <input type="hidden" class="form-control" name="txt_receipt_no" id="txt_receipt_no" value="<?php echo $row->RECEIPT_NUMBER; ?>">
                        <input type="hidden" class="form-control" name="txt_amount" id="txt_amount" value="<?php echo $row->AMOUNT; ; ?>"> 
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>Tin Id #</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <input type="text" class="form-control inputBox" name="txt_tax_payer_id" id="txt_tax_payer_id"
                        style="height:30px; width: 400px;" maxlength="9" onclick="clearTextfield();" value="<?=$row->TIN; ?>">  
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>BIR Reg. Name</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <input type="text" class="form-control" name="txt_bir_reg_name" id="txt_bir_reg_name"
                        style="height:30px; width: 400px;" maxlength="255" readonly="readonly" value="<?=$row->BIR_REG_NAME; ?>" placeholder="Please encode correct Bir Reg Name">  
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>ATC Code</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">    
                        <?php $get_atc_code = $this->get_process_ho->get_atc_code(); ?>
                        <select name="cmb_atc_code" id="cmb_atc_code"
                        style="height:30px; width: 400px;">  
                            <?php 
                            if($row->ATC_CODE == ''){
                                ?>
                                <option value="0">SELECT</option> 
                                <?php
                            }
                            else{
                                ?>
                                <option value="<?=$row->ATC_CODE;?>"><?=$row->ATC_CODE;?></option> 
                                <?php    
                            }
                            ?>    
                            <?php foreach($get_atc_code as $row_atc){ ?>
                            <option value="<?=$row_atc->code_name;?>"><?=$row_atc->display;?></option>
                            <? } ?>
                        </select>  
                    </td>
                </tr>
                <tr>
                    <td class="table_label"><b>Amount</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?=$row->AMOUNT; ?> 
                    </td>
                </tr>
                <tr>
                    <td class="table_label"><b>Tax Base Total</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <input type="text" class="form-control" name="txt_tax_base" id="txt_tax_base"
                        style="height:30px; width: 400px;" maxlength="40" onkeypress="return isNumberKey(event)" value="<?=$row->TAX_BASE; ?>">  
                    </td>
                </tr>
                <tr>
                    <td class="table_label"><b>Tax Percent</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <div id="div_tax_percent"></div>  
                    </td>
                </tr>
            </table>    
        </form>
        <?php
    }    
    
    public function search_bir_reg_name(){ 
        # MODEL
        $this->load->model('get_process_ho');

        $arrResult = array();
            $arrRegName = $this->get_process_ho->get_tin_reg_name($_GET['term']);
                foreach($arrRegName as $val){
                    $arrResult[] = array(
                        "id"=>$val->TIN,
                        "label"=>$val->TIN." - ".$val->BIR_REG_NAME,
                        "label2"=>$val->BIR_REG_NAME,
                        "value" => strip_tags($val->TIN));    
                }
        echo json_encode($arrResult);    
    }
    
    public function check_tin_number(){ 
        # MODEL
        $this->load->model('get_process_ho');

        # CHECK TIN NO IF EXIST
        $result_tin_no = $this->get_process_ho->check_tin_no($this->input->post('post_tin_no'));   
        if ($result_tin_no->num_rows() > 0){
            echo "1";
        } 
        else{
            echo "0";    
        }       
    }
    
    public function check_tin_number2(){ 
        # MODEL
        $this->load->model('get_process_ho');

        # CHECK TIN NO IF EXIST
        $result_tin_no = $this->get_process_ho->check_tin_no($this->input->post('post_tin_no'));   
        if ($result_tin_no->num_rows() > 0){
            echo "1";
        } 
        else{
            echo "0";    
        }       
    }
    
    public function encode_export_update(){  
        # MODEL
        $this->load->model('get_process_ho');

        # GET CURRENT DATE
        $result_current_date_time = $this->get_process_ho->get_server_current_date_time();
        if ($result_current_date_time->num_rows() > 0){
           $row = $result_current_date_time->row();
        }
        else{
           $row = "0"; 
        } 
        
        $edit_export = array(
            "TIN" => $this->input->post('txt_tax_payer_id'), 
            "BIR_REG_NAME" => $this->input->post('txt_bir_reg_name'),
            "ATC_CODE" => $this->input->post('cmb_atc_code'),
            "TAX_BASE" => $this->input->post('txt_tax_base')
        );
        $this->get_process_ho->edit_export_id($edit_export,$this->input->post('txt_receipt_id'));
        echo "Export has been edited";
    } 
    
    public function add_tin_master(){  
        # MODEL
        $this->load->model('get_process_ho'); 
        
        # GET CURRENT DATE
        $result_current_date_time = $this->get_process_ho->get_server_current_date_time();   
        if ($result_current_date_time->num_rows() > 0){
           $row = $result_current_date_time->row();
        }
        else{
           $row = "0"; 
        } 
        
        $new_tin_no = array(
            "TIN" => $this->input->post('post_tin_no'), 
            "BIR_REG_NAME" => $this->input->post('post_bir_reg_name')
        );
        $this->get_process_ho->add_tin_master($new_tin_no);
        echo "New Tax Identification Number added";
    }
    
    public function check_transmit(){ 
        # MODEL
        $this->load->model('get_process_ho');

        # CHECK TIN NO IF EXIST
        $result_transmit = $this->get_process_ho->check_transmit_id($this->input->post('post_receipt_id'));   
        if ($result_transmit->num_rows() > 0){
            echo "1";
        } 
        else{
            echo "0";    
        }       
    }
    
    public function check_transmit_without_null(){ 
        # MODEL
        $this->load->model('get_process_ho');

        # CHECK TIN NO IF EXIST
        $result_transmit = $this->get_process_ho->check_transmit_id_without_null($this->input->post('post_receipt_id'));   
        if ($result_transmit->num_rows() > 0){
            echo "1";
        } 
        else{
            echo "0";    
        }       
    }
    
    public function transmit_export_details(){  
        # MODEL
        $this->load->model('get_process_ho');
        
        $result_export_details = $this->get_process_ho->get_export_details($this->input->post('post_receipt_id'));
         
        if ($result_export_details->num_rows() > 0){
           $row = $result_export_details->row();
        }
        else{
           $row = "0"; 
        }
        echo "Are you sure you want to transmit selected recipt number?";
        //echo "Are you sure you want to transmit recipt number ".$row->RECEIPT_NUMBER."?";  
    } 
    
    public function transmit_export_update(){  
        # MODEL
        $this->load->model('get_process_ho');

        # GET CURRENT DATE
        $result_current_date_time = $this->get_process_ho->get_server_current_date_time();
        if ($result_current_date_time->num_rows() > 0){
           $row = $result_current_date_time->row();
        }
        else{
           $row = "0"; 
        } 
        
        $edit_export = array(
            "IS_TRANSMITTED" => 'Y', 
            "TRANSMITTED_DATE" => $row->current_date_time,
        );
        $this->get_process_ho->edit_export_list_id($edit_export,$this->input->post('post_receipt_id'));
        echo "Export has been edited";
    }
    
    function generate_pdf()
    {   
        # TITLE
        $data['title']  = "Site"; 
        
        # MODEL
        $this->load->model('get_process_ho');
        
        $receipt_id = $this->input->post('post_receipt_id');
        
        echo "window.open('".base_url()."transmittal_ho/index/".str_replace(',','-',$receipt_id)."');";                  
    }
    
    #########################( RECEIVE )#########################
    
    public function receive(){  
        # TITLE
        $data['title']  = "Receive"; 
        
        # MODULE NAME
        $data['module_name']  = "Receive SAWT";   
        
        # MODEL
        $this->load->model('get_process_ho'); 
         
        $data['get_receive'] = $this->get_process_ho->get_receive($this->session->userdata('oracleUsername'),$this->input->post('post_org_id')); 
        $data['get_all_company'] = $this->get_process_ho->get_all_company(); 
        
        # VIEW
        $this->load->view('view_receive',$data);
    }  
    
    public function receive_per_company(){  
        # TITLE
        $data['title']  = "Receive"; 
        
        # MODULE NAME
        $data['module_name']  = "Receive SAWT";   
        
        # MODEL
        $this->load->model('get_process_ho'); 
         
        $data['get_receive'] = $this->get_process_ho->get_receive($this->session->userdata('oracleUsername'),$this->input->post('post_org_id'));
        $data['get_all_company'] = $this->get_process_ho->get_all_company();  
        ?>
        <script type="text/javascript"> 
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
                    $("#div_disp_grid").show();
                    $("#grid-data").bootgrid({
                        formatters: {
                            "link": function(column, row)
                            {
                                return "<?php echo base_url('process_ho/receive');?>" + column.id + ": " + row.id + "</a>";
                            }
                        },
                        rowCount: [10, 50, 75, -1]  
                    }).on("selected.rs.jquery.bootgrid", function (e, rows) {
                        var value = $("#grid-data").bootgrid("getSelectedRows");
                        if(value.length == 0){
                            $('#btn_view').attr('disabled','disabled'); 
                            $('#btn_receive').attr('disabled','disabled'); 
                        }
                        else if(value.length == 1){
                            $('#btn_view').removeAttr('disabled');
                            $('#btn_receive').removeAttr('disabled');
                        }
                        else{    
                            $('#btn_view').attr('disabled','disabled'); 
                            $('#btn_receive').removeAttr('disabled');     
                        }         
                    }).on("deselected.rs.jquery.bootgrid", function (e, rows){
                        var value = $("#grid-data").bootgrid("getSelectedRows");
                        if(value.length == 0){
                            $('#btn_view').attr('disabled','disabled'); 
                            $('#btn_receive').attr('disabled','disabled'); 
                        }
                        else if(value.length == 1){
                            $('#btn_view').removeAttr('disabled');
                            $('#btn_receive').removeAttr('disabled');
                        }
                        else{    
                            $('#btn_view').attr('disabled','disabled'); 
                            $('#btn_receive').removeAttr('disabled');     
                        }     
                    })
                }
                
                init();
                
                $("#btn_view").on("click", function ()
                {
                    var value = $("#grid-data").bootgrid("getSelectedRows");
                    // SELECT TABLE ROW         
                    $.ajax({           
                        url: "<?php echo base_url('process_ho/encode');?>",
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
                
                $("#btn_receive").on("click", function ()
                {
                    var value = $("#grid-data").bootgrid("getSelectedRows");
                    // SELECT TABLE ROW  
                    receive(value);  
                });       
            });  
            
            // VIEW RECEIPT NO
            function view(value){

                $.ajax({
                    url: "<?php echo base_url('process_ho/view_export');?>",
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
            
            // RECEIVE RECEIPT NO
            function receive(value){
                
                $('#div_receive_confirm .modal-body').html('Are you sure you want to receive selected receipt number?');
                $('#div_receive_confirm').modal('show');
                $('#receiving_confirm').click( function (e) {
                    e.stopImmediatePropagation();
                    $.ajax({
                        url: "<?php echo base_url('process_ho/receive_export_update');?>",
                        type: "POST",
                        data: "post_receipt_id="+value,
                        success: function(data){  
                            bootbox.alert("List of receipt number successfully received!", function() {  
                                $('#div_transmit_confirm').modal('hide');
                                $('#div_receive_confirm').modal('hide'); 
                                document.location.reload();
                            });  
                        }         
                    });   
                });    
            } 
        </script>
        
        &nbsp;
            <button id="btn_view" type="button" class="btn btn-default" disabled="disabled">View</button>             
            <button id="btn_receive" type="button" class="btn btn-default" disabled="disabled">Receive</button>             
                            
            <table id="grid-data" class="table table-condensed table-hover table-striped"
            data-selection="true" 
            data-multi-select="true" 
            data-row-select="true" 
            data-keep-selection="true">
                <thead>
                    <tr class="clickable-row"> 
                        <th data-column-id="cash_receipt_id" data-type="numeric" data-identifier="true" data-order="asc" data-visible="false" data-visible-in-selection="true">CASH RECEIPT ID</th>
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
                        foreach($data['get_receive'] as $row){
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
                        $result_company = $this->get_process_ho->get_company($row->ORG_ID); 
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
        <?php  
    }  
    
    public function receive_export_update(){  
        # MODEL
        $this->load->model('get_process_ho');

        # GET CURRENT DATE
        $result_current_date_time = $this->get_process_ho->get_server_current_date_time();
        if ($result_current_date_time->num_rows() > 0){
           $row = $result_current_date_time->row();
        }
        else{
           $row = "0"; 
        } 
        
        $edit_export = array(
            "IS_RECEIVED" => 'Y', 
            "RECEIVED_DATE" => $row->current_date_time,
            "RECEIVED_BY" => $this->session->userdata('userName')    
        );
        $this->get_process_ho->edit_export_list_id($edit_export,$this->input->post('post_receipt_id'));
        echo "Export has been edited";
    }
    
    #########################( RECEIVE EDIT )#########################
    
    public function received_edit(){  
        # TITLE
        $data['title']  = "Process"; 
        
        # MODULE NAME
        $data['module_name']  = "Received Edit SAWT";   
        
        # MODEL
        $this->load->model('get_process_ho'); 
         
        $data['get_received'] = $this->get_process_ho->get_received($this->input->post('post_org_id')); 
        $data['get_all_company'] = $this->get_process_ho->get_all_company(); 
        
        # VIEW
        $this->load->view('view_received_edit_ho',$data); 
    }    
    
    public function received_edit_per_company(){  
        # TITLE
        $data['title']  = "Receive"; 
        
        # MODULE NAME
        $data['module_name']  = "Receive SAWT";   
        
        # MODEL
        $this->load->model('get_process_ho'); 
         
        $data['get_received'] = $this->get_process_ho->get_received($this->input->post('post_org_id'));
        $data['get_all_company'] = $this->get_process_ho->get_all_company();  
        ?>
        <script type="text/javascript"> 
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
                    $("#div_disp_grid").show();
                    $("#grid-data").bootgrid({
                        formatters: {
                            "link": function(column, row)
                            {
                                return "<?php echo base_url('process_ho/received_edit');?>" + column.id + ": " + row.id + "</a>";
                            }
                        },
                        rowCount: [10, 50, 75, -1]  
                    }).on("selected.rs.jquery.bootgrid", function (e, rows) {
                        var value = $("#grid-data").bootgrid("getSelectedRows");
                        if(value.length == 0){
                            $('#btn_view').attr('disabled','disabled'); 
                            $('#btn_edit_received').attr('disabled','disabled'); 
                        }
                        else if(value.length == 1){
                            $('#btn_view').removeAttr('disabled');
                            $('#btn_edit_received').removeAttr('disabled');
                        }
                        else{    
                            $('#btn_view').attr('disabled','disabled'); 
                            $('#btn_edit_received').removeAttr('disabled');     
                        }                                                    
                    }).on("deselected.rs.jquery.bootgrid", function (e, rows){
                        var value = $("#grid-data").bootgrid("getSelectedRows");
                        if(value.length == 0){
                            $('#btn_view').attr('disabled','disabled'); 
                            $('#btn_edit_received').attr('disabled','disabled'); 
                        }
                        else if(value.length == 1){
                            $('#btn_view').removeAttr('disabled');
                            $('#btn_edit_received').removeAttr('disabled');
                        }
                        else{    
                            $('#btn_view').attr('disabled','disabled'); 
                            $('#btn_edit_received').removeAttr('disabled');     
                        }      
                    }) 
                }
                
                init();  
                
                $("#btn_view").on("click", function ()
                {
                    var value = $("#grid-data").bootgrid("getSelectedRows");
                    // SELECT TABLE ROW         
                    $.ajax({           
                        url: "<?php echo base_url('process_ho/encode');?>",
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
                
                $("#btn_edit_received").on("click", function ()
                {
                    var value = $("#grid-data").bootgrid("getSelectedRows");
                    // SELECT TABLE ROW         
                    received_edit_id(value)  
                });   
            });  
            
            // VIEW RECEIPT NO
            function view(value){

                $.ajax({
                    url: "<?php echo base_url('process_ho/view_export');?>",
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
            
            // EDIT RECEIPT NO
            function received_edit_id(value){

                $.ajax({
                    url: "<?php echo base_url('process_ho/received_edit_id_export');?>",
                    type: "POST",
                    data: "post_id="+value,
                    success: function(data){   
                        
                        if(value.length > 1){
                            bootbox.alert("Please select one receipt number only!", function() {
                            });    
                            return false;
                        }
                        else{
                            
                            $('#div_received_edit_sawt .modal-body').html(data);
                            $('#div_received_edit_sawt').modal('show');
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
                                
                                $('#div_received_edit_save_confirm .modal-body').html('Are you sure you want to update receipt number '+$('#txt_receipt_no').val()+'?');
                                $('#div_received_edit_save_confirm').modal('show');
                                $('#saving_confirm').click( function (e) {
                                    e.stopImmediatePropagation();
                                    $.ajax({
                                        url: "<?php echo base_url('process_ho/received_export_update');?>",
                                        type: "POST",
                                        data: $('#received_edit_form').serialize()+"&post_id="+value,
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
                                                            url: "<?php echo base_url('process_ho/add_tin_master');?>",
                                                            type: "POST",
                                                            data: "post_tin_no="+content+"&post_bir_reg_name="+content2,
                                                            success: function(data){
                                                                bootbox.alert("New Taxpayer Identification Number added!", function() {
                                                                    $('#div_received_edit_sawt').modal('hide'); 
                                                                    $('#div_received_edit_confirm').modal('hide'); 
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
                        
                    }         
                });  

            }     
        </script>
        
        &nbsp;
            <button id="btn_view" type="button" class="btn btn-default" disabled="disabled">View</button>
            <button id="btn_edit_received" type="button" class="btn btn-default" disabled="disabled">Edit</button>             
                            
            <table id="grid-data" class="table table-condensed table-hover table-striped"
            data-selection="true" 
            data-multi-select="true" 
            data-row-select="true" 
            data-keep-selection="true">
                <thead>
                    <tr class="clickable-row"> 
                        <th data-column-id="cash_receipt_id" data-type="numeric" data-identifier="true" data-order="asc" data-visible="false" data-visible-in-selection="true">CASH RECEIPT ID</th>
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
                        foreach($data['get_received'] as $row){
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
                        $result_company = $this->get_process_ho->get_company($row->ORG_ID); 
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
        <?php  
    } 
    
    public function received_edit_id_export(){  
        # MODEL
        $this->load->model('get_process_ho');
        
        $result_export_details = $this->get_process_ho->get_export_details($this->input->post('post_id'));
         
        if ($result_export_details->num_rows() > 0){
           $row = $result_export_details->row();
        }
        else{
           $row = "0"; 
        }   
        ?>  
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
        
        <script type="text/javascript">
            // ALLOW NUMERIC ONLY ON TEXTFIELD
            $(function(){
                $("#txt_tax_payer_id").keydown(function (e) {
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
            
            // ADD LEADING ZEROS
            $('#txt_tax_payer_id').focusout(function() {      
                if($("#txt_tax_payer_id").length < 9){
                    var value = $("#txt_tax_payer_id").val(); 
                    value = value.length; 
                    value_add_zero = $("#txt_tax_payer_id").val('000000000'+$("#txt_tax_payer_id").val());
                    value_display = value_add_zero.val().slice(value);
                    $("#txt_tax_payer_id").val(value_display);
                }
            });
        
            // TEXTFIELD AUTO COMPLETE
            $(function(){
                $("#txt_tax_payer_id").autocomplete({
                    source: "<?php echo base_url('process/search_bir_reg_name');?>",
                    minLength: 1,
                    select: function(event, ui) {    
                        var content = ui.item.id;
                        $("#txt_tax_payer_id").val(content); 
                        var content2 = ui.item.label2; 
                        $("#txt_bir_reg_name").val(content2);
                        // CHECK IF TIN NO EXIST IN DB
                        $.ajax({
                            url: "<?php echo base_url('process/check_tin_number');?>",
                            type: "POST",
                            data: "post_tin_no="+content,
                            success: function(data){
                                if(data == 1){   
                                    $('#txt_bir_reg_name').attr('readonly','readonly');  
                                } 
                                else{
                                    $('#txt_bir_reg_name').removeAttr('readonly'); 
                                }   
                            }         
                        }); 
                        
                    }
                });   
            }); 
            
            // CHECK IF TIN NO EXIST IN DB
            $("#txt_tax_payer_id").keyup(function()
            {    
                var value = $("#txt_tax_payer_id").val();
                $.ajax({   
                    type: "POST",
                    url: "<?php echo base_url('process/check_tin_number2');?>",
                    data: {'post_tin_no' : value},
                    success: function(data)
                    {
                        if(data == 1){ 
                            $('#txt_bir_reg_name').attr('readonly','readonly');     
                        } 
                        else{
                            $('#txt_bir_reg_name').removeAttr('readonly');
                        }  
                    }       
                });   
            });     
            
            // CLEAR TEXTFIELD AUTO COMPLETE
            function clearTextfield(){
                $("#txt_tax_payer_id").val('');    
                $("#txt_bir_reg_name").val('');    
            }
            
            // COMPUTE TAX PERCENT 
            $(function(){   
                var ora_txt_amount = $("#txt_amount").val();
                var value = $("#txt_tax_base").val();
                
                var display =  (ora_txt_amount / value) * 100;
                
                if(display == 'Infinity'){
                    display = '';    
                }
                else{
                    display = display.toFixed(2);    
                }
                
                $("#div_tax_percent").html(display);    
            });   
            
            $("#txt_tax_base").keyup(function()
            {    
                var ora_txt_amount = $("#txt_amount").val();
                var value = $("#txt_tax_base").val();
                
                var display =  (ora_txt_amount / value) * 100;
                
                if(display == 'Infinity'){
                    display = '';    
                }
                else{
                    display = display.toFixed(2);    
                }
                
                $("#div_tax_percent").html(display);
                
            });  
            
            // BOOTSTRAP DATE PICKER
            $(function(){   
                $('.datepicker').datepicker({
                    startDate: '-30d',
                    autoclose: true,
                })
            });  
            // format
                // startDate: 'd', current date
                // startDate: '-3d', minus 3days
            
        </script> 
          
        <form id="received_edit_form" method="POST">
            <input type="hidden" class="form-control" name="txt_receipt_id" id="txt_receipt_id" value="<?php echo $row->CASH_RECEIPT_ID; ?>"> 
            <table id="table_edit" border="0" class="table table-condensed table-striped">    
                <tr>
                    <td class="table_label"><b>Receipt Number</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?php echo $row->RECEIPT_NUMBER; ?>
                        <input type="hidden" class="form-control" name="txt_receipt_no" id="txt_receipt_no" value="<?php echo $row->RECEIPT_NUMBER; ?>">
                        <input type="hidden" class="form-control" name="txt_amount" id="txt_amount" value="<?php echo $row->AMOUNT; ; ?>"> 
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>Tin Id #</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <input type="text" class="form-control inputBox" name="txt_tax_payer_id" id="txt_tax_payer_id"
                        style="height:30px; width: 400px;" maxlength="9" onclick="clearTextfield();" value="<?=$row->TIN; ?>">  
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>BIR Reg. Name</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <input type="text" class="form-control" name="txt_bir_reg_name" id="txt_bir_reg_name"
                        style="height:30px; width: 400px;" maxlength="255" readonly="readonly" value="<?=$row->BIR_REG_NAME; ?>" placeholder="Please encode correct Bir Reg Name">  
                    </td>
                </tr> 
                <tr>
                    <td class="table_label"><b>ATC Code</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">    
                        <?php $get_atc_code = $this->get_process_ho->get_atc_code(); ?>
                        <select name="cmb_atc_code" id="cmb_atc_code"
                        style="height:30px; width: 400px;">  
                            <?php 
                            if($row->ATC_CODE == ''){
                                ?>
                                <option value="0">SELECT</option> 
                                <?php
                            }
                            else{
                                ?>
                                <option value="<?=$row->ATC_CODE;?>"><?=$row->ATC_CODE;?></option> 
                                <?php    
                            }
                            ?>    
                            <?php foreach($get_atc_code as $row_atc){ ?>
                            <option value="<?=$row_atc->code_name;?>"><?=$row_atc->display;?></option>
                            <? } ?>
                        </select>  
                    </td>
                </tr>
                <tr>
                    <td class="table_label"><b>Amount</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <?=$row->AMOUNT; ?>
                    </td>
                </tr>
                <tr>
                    <td class="table_label"><b>Tax Base Total</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <input type="text" class="form-control" name="txt_tax_base" id="txt_tax_base"
                        style="height:30px; width: 400px;" maxlength="40" onkeypress="return isNumberKey(event)" value="<?=$row->TAX_BASE; ?>">  
                    </td>
                </tr>
                <tr>
                    <td class="table_label"><b>Tax Percent</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <div id="div_tax_percent"></div>  
                    </td>
                </tr>
                <tr>
                    <td class="table_label"><b>SAWT Gl Date</b></td>
                    <td class="table_colon"><b>:</b></td>
                    <td class="table_data">
                        <input class="datepicker form-control" name="txt_sawt_gl_date" id="txt_sawt_gl_date" 
                        data-date-format="yyyy-mm-dd" readonly="readonly"
                        style="height:30px; width: 400px;" value="<?=date('Y-m-d',strtotime($row->GL_DATE_SAWT)); ?>">
                    </td>
                </tr>
                    
            </table>    
        </form>
        <?php
    } 
    
    public function received_export_update(){  
        # MODEL
        $this->load->model('get_process_ho');

        # GET CURRENT DATE
        $result_current_date_time = $this->get_process_ho->get_server_current_date_time();
        if ($result_current_date_time->num_rows() > 0){
           $row = $result_current_date_time->row();
        }
        else{
           $row = "0"; 
        } 
        
        $edit_export = array(
            "TIN" => $this->input->post('txt_tax_payer_id'), 
            "BIR_REG_NAME" => $this->input->post('txt_bir_reg_name'),
            "ATC_CODE" => $this->input->post('cmb_atc_code'),
            "TAX_BASE" => $this->input->post('txt_tax_base'),
            "GL_DATE_SAWT" => $this->input->post('txt_sawt_gl_date')
        );
        $this->get_process_ho->edit_export_id($edit_export,$this->input->post('txt_receipt_id'));
        echo "Export has been edited";
    }   
    
    #########################( POST )#########################
    
    public function post(){  
        # TITLE
        $data['title']  = "Post"; 
        
        # MODULE NAME
        $data['module_name']  = "Post SAWT";   
        
        # MODEL
        $this->load->model('get_process_ho'); 
        
        $data['get_post'] = $this->get_process_ho->get_receive($this->session->userdata('oracleUsername'),$this->input->post('post_org_id'));
        $data['get_all_company'] = $this->get_process_ho->get_all_company();   
        
        # VIEW
        $this->load->view('view_post',$data);  
    }  
    
    public function post_per_company(){  
        # TITLE
        $data['title']  = "Post"; 
        
        # MODULE NAME
        $data['module_name']  = "Post SAWT";   
        
        # MODEL
        $this->load->model('get_process_ho'); 
        
        $data['get_post'] = $this->get_process_ho->get_post($this->session->userdata('oracleUsername'),$this->input->post('post_org_id'));
        $data['get_all_company'] = $this->get_process_ho->get_all_company(); 
        $data['get_all_quarter'] = $this->get_process_ho->get_all_quarter();  
        ?>
        <!-- My Style CSS -->
        <link href="<? echo base_url('includes/my_style.css'); ?>" rel="stylesheet"> 
    
        <script type="text/javascript">
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
                                return "<?php echo base_url('process_ho/post');?>" + column.id + ": " + row.id + "</a>";
                            }
                        },
                        rowCount: [10, 50, 75, -1]
                    }).on("selected.rs.jquery.bootgrid", function (e, rows) {
                        var value = $("#grid-data").bootgrid("getSelectedRows");
                        if(value.length == 0){
                            $('#btn_view').attr('disabled','disabled'); 
                        }
                        else if(value.length == 1){
                            $('#btn_view').removeAttr('disabled');
                        }
                        else{    
                            $('#btn_view').attr('disabled','disabled'); 
                        }                                                    
                    }).on("deselected.rs.jquery.bootgrid", function (e, rows){
                        var value = $("#grid-data").bootgrid("getSelectedRows");
                        if(value.length == 0){
                            $('#btn_view').attr('disabled','disabled'); 
                        }
                        else if(value.length == 1){
                            $('#btn_view').removeAttr('disabled');
                        }
                        else{    
                            $('#btn_view').attr('disabled','disabled'); 
                        }      
                    }) 
                }
                
                init();
                
                $("#btn_view").on("click", function ()
                {
                    var value = $("#grid-data").bootgrid("getSelectedRows");
                    // SELECT TABLE ROW         
                    $.ajax({           
                        url: "<?php echo base_url('process_ho/encode');?>",
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
                
                $("#btn_post").on("click", function ()
                {
                    var value = $("#grid-data").bootgrid("getSelectedRows");
                    var quarter = $("#cmd_quarter").val();
                    var company = $("#cmd_company").val();
                              
                    if(company == 0){  
                        bootbox.alert("Please select company!", function() {
                            $('#cmd_company').css("border","red solid 1px");
                        });
                        return false;     
                    }
                    else if(quarter == 0){  
                        bootbox.alert("Please select quarter!", function() {
                            $('#cmd_quarter').css("border","red solid 1px");
                        });
                        return false;     
                    }
                    else{
                        // POST SELECTED QUARTER  
                        post(company,quarter);      
                    }   
                });       
            }); 
            
            // VIEW RECEIPT NO
            function view(value){

                $.ajax({
                    url: "<?php echo base_url('process_ho/view_export');?>",
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
            
            // RECEIVE RECEIPT NO
            function post(company,quarter){
                
                $('#div_post_confirm .modal-body').html('Are you sure you want to post selected quarter?');
                $('#div_post_confirm').modal('show');
                $('#posting_confirm').click( function () {
                    
                    $.ajax({
                        url: "<?php echo base_url('process_ho/post_export_update');?>",
                        type: "POST",
                        data: "post_company_id="+company+"&post_quarter_id="+quarter,
                        beforeSend: function()
                        {
                            jQuery('#loading').showLoading();
                        },
                        success: function(data){  
                            jQuery('#loading').hideLoading();
                            bootbox.alert("Selected quarter already posted!", function() {  
                                $('#div_post_confirm').modal('hide');
                                createTextfile(company,quarter); 
                                // document.location.reload();
                            });  
                        }         
                    });   
                });    
            }  
            
            function createTextfile(company,quarter){
                    
                $.ajax({
                    url: "<?php echo base_url('process_ho/create_textfile');?>",
                    type: "POST",
                    data: "post_company_id="+company+"&post_quarter_id="+quarter,
                    beforeSend: function()
                    {
                        jQuery('#loading').showLoading();
                    },
                    success: function(data){  
                        jQuery('#loading').hideLoading();
                        bootbox.alert("Selected quarter textfile created!", function() {  
                            $('#div_post_confirm').modal('hide'); 
                            // document.location.reload();
                        });  
                    }         
                });   
            }  
        </script>  
        
        &nbsp;&nbsp;
            <table id="table_quarter" border=0>
                <tr>
                    <td class="table_label">
                    &nbsp; QUARTER
                    </td>
                    <td class="table_colon">:</td>
                    <td class="table_data">
                        <select name="cmd_quarter" id="cmd_quarter"
                        style="height:30px; width: 200px;">   
                            <option value="0">SELECT</option>  
                            <?php foreach($data['get_all_quarter'] as $row){ ?>
                            <option value="<?=$row->label_id;?>"><?=$row->label_name." ".$row->label_year;?></option>
                            <? } ?>
                        </select> 
                    </td>
                </tr>
            </table>  
        
            <br/>
            &nbsp;
            <button id="btn_view" type="button" class="btn btn-default" disabled="disabled">View</button>    
            <button id="btn_post" type="button" class="btn btn-default">Post</button> 
                            
            <table id="grid-data" class="table table-condensed table-hover table-striped"
            data-selection="true" 
            data-multi-select="false" 
            data-row-select="true" 
            data-keep-selection="true">
                <thead>
                    <tr class="clickable-row"> 
                        <th data-column-id="cash_receipt_id" data-type="numeric" data-identifier="true" data-order="asc" data-visible="false" data-visible-in-selection="true">CASH RECEIPT ID</th>
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
                        foreach($data['get_post'] as $row){
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
                        $result_company = $this->get_process_ho->get_company($row->ORG_ID); 
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
        <?php
    }  
    
    public function post_export_update(){  
        # MODEL
        $this->load->model('get_process_ho');

        # GET CURRENT DATE
        $result_current_date_time = $this->get_process_ho->get_server_current_date_time();
        if ($result_current_date_time->num_rows() > 0){
           $row = $result_current_date_time->row();
        }
        else{
           $row = "0"; 
        } 

        if($this->get_process_ho->edit_export_quarter_id($this->input->post('post_company_id'),$this->input->post('post_quarter_id'),$row->current_date_time,$this->session->userdata('userName'))){
            echo "Export has been edited";
        }
        else{
            echo "Export editing error";    
        }      
        
    }
    
    public function create_textfile(){
        # MODEL
        $this->load->model('get_process_ho');
        $this->load->helper('file');
        
        # GET CURRENT DATE
        $result_current_date_time = $this->get_process_ho->get_server_current_date_time();
        if ($result_current_date_time->num_rows() > 0){
           $row = $result_current_date_time->row();
        }
        else{
           $row = "0"; 
        } 
        
        $result_textfile = $this->get_process_ho->posted_export_textfile($this->input->post('post_company_id'),$this->input->post('post_quarter_id'),$row->current_date_time,$this->session->userdata('userName'));
        
        $file_name = "fileformat.dat";
        
        $file_content = "";
        
        foreach($result_textfile as $row){     
            $file_content .= trim($row->RECEIPT_NUMBER)."|";
            $file_content .= trim($row->RECEIPT_NUMBER)."|";
            $file_content .= trim($row->RECEIPT_NUMBER)."|";
            $file_content .= trim($row->RECEIPT_NUMBER);
            $file_content .= "\r\n";  
        }  
        
        if ( ! write_file("exported_files/".$file_name, $file_content))
        {
            echo 'Unable to write the file';
        }
        else
        {
            echo 'File written!';
        } 
    }
    
    public function fpdf(){
        ?>
        <script type="text/javascript">
        $.ajax({
            url: "<?php echo base_url('process_ho/create_textfile');?>",
            type: "POST",
            data: "post_company_id="+company+"&post_quarter_id="+quarter,
            beforeSend: function()
            {
                jQuery('#loading').showLoading();
            },
            success: function(data){  
                jQuery('#loading').hideLoading();
                bootbox.alert("Selected quarter textfile created!", function() {  
                    $('#div_post_confirm').modal('hide'); 
                    // document.location.reload();
                });  
            }         
        }); 
        </script>  
        <?php        
    }
    
}