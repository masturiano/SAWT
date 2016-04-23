<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Process extends CI_Controller {
    
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
        $this->load->model('get_process'); 
         
        $data['get_encode'] = $this->get_process->get_encode($this->session->userdata('oracleUsername'),$this->input->post('post_org_id')); 
        $data['get_all_company'] = $this->get_process->get_all_company(); 
        
        # VIEW
        $this->load->view('view_encode',$data);  
    }      
    
    public function encode_export(){  
        # MODEL
        $this->load->model('get_process');
        
        $result_export_details = $this->get_process->get_export_details($this->input->post('post_id'));
         
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
                $('#txt_tax_payer_id').keypress(
                    function(event) {
                        //Allow only backspace and delete
                        if (event.keyCode != 46 && event.keyCode != 8) {
                            if (!parseInt(String.fromCharCode(event.which))) {
                                event.preventDefault();
                            }
                        }
                    }
                )   
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
                    <td class="table_label"><b>Tax Payer Id #</b></td>
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
                        <?php $get_atc_code = $this->get_process->get_atc_code(); ?>
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
    
    public function view_export(){  
        # MODEL
        $this->load->model('get_process');
        
        $result_export_details = $this->get_process->get_export_details($this->input->post('post_id'));
         
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
                $result_company = $this->get_process->get_company($row->ORG_ID); 
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
    
    public function search_bir_reg_name(){ 
        # MODEL
        $this->load->model('get_process');

        $arrResult = array();
            $arrRegName = $this->get_process->get_tin_reg_name($_GET['term']);
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
        $this->load->model('get_process');

        # CHECK TIN NO IF EXIST
        $result_tin_no = $this->get_process->check_tin_no($this->input->post('post_tin_no'));   
        if ($result_tin_no->num_rows() > 0){
            echo "1";
        } 
        else{
            echo "0";    
        }       
    }
    
    public function check_tin_number2(){ 
        # MODEL
        $this->load->model('get_process');

        # CHECK TIN NO IF EXIST
        $result_tin_no = $this->get_process->check_tin_no($this->input->post('post_tin_no'));   
        if ($result_tin_no->num_rows() > 0){
            echo "1";
        } 
        else{
            echo "0";    
        }       
    }
    
    public function encode_export_update(){  
        # MODEL
        $this->load->model('get_process');

        # GET CURRENT DATE
        $result_current_date_time = $this->get_process->get_server_current_date_time();
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
        $this->get_process->edit_export_id($edit_export,$this->input->post('txt_receipt_id'));
        echo "Export has been edited";
    } 
    
    public function add_tin_master(){  
        # MODEL
        $this->load->model('get_process'); 
        
        # GET CURRENT DATE
        $result_current_date_time = $this->get_process->get_server_current_date_time();   
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
        $this->get_process->add_tin_master($new_tin_no);
        echo "New Tax Identification Number added";
    }
    
    public function check_transmit(){ 
        # MODEL
        $this->load->model('get_process');

        # CHECK TIN NO IF EXIST
        $result_transmit = $this->get_process->check_transmit_id($this->input->post('post_receipt_id'));   
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
        $this->load->model('get_process');
        
        $result_export_details = $this->get_process->get_export_details($this->input->post('post_receipt_id'));
         
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
        $this->load->model('get_process');

        # GET CURRENT DATE
        $result_current_date_time = $this->get_process->get_server_current_date_time();
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
        $this->get_process->edit_export_id($edit_export,$this->input->post('post_receipt_id'));
        echo "Export has been edited";
    }
    
    function generate_pdf()
    {   
        # TITLE
        $data['title']  = "Site"; 
        
        # MODEL
        $this->load->model('get_process');
        
        $receipt_id = $this->input->post('post_receipt_id');
        
        echo "window.open('".base_url()."transmittal_pdf/index/".str_replace(',','-',$receipt_id)."');";                  
    }
    
    #########################( RECEIVE )#########################
    
    public function receive(){  
        # TITLE
        $data['title']  = "Receive"; 
        
        # MODULE NAME
        $data['module_name']  = "Receive SAWT";   
        
        # MODEL
        $this->load->model('get_process'); 
         
        $data['get_receive'] = $this->get_process->get_receive($this->session->userdata('oracleUsername'),$this->input->post('post_org_id')); 
        
        # VIEW
        $this->load->view('view_receive',$data);  
    }  
    
    public function receive_export_update(){  
        # MODEL
        $this->load->model('get_process');

        # GET CURRENT DATE
        $result_current_date_time = $this->get_process->get_server_current_date_time();
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
        $this->get_process->edit_export_list_id($edit_export,$this->input->post('post_receipt_id'));
        echo "Export has been edited";
    }
    
    #########################( POST )#########################
    
    public function post(){  
        # TITLE
        $data['title']  = "Post"; 
        
        # MODULE NAME
        $data['module_name']  = "Post SAWT";   
        
        # MODEL
        $this->load->model('get_process'); 
         
        $data['get_post'] = $this->get_process->get_post(); 
        
        # VIEW
        $this->load->view('view_post',$data);  
    }  
    
    public function post_export_update(){  
        # MODEL
        $this->load->model('get_process');

        # GET CURRENT DATE
        $result_current_date_time = $this->get_process->get_server_current_date_time();
        if ($result_current_date_time->num_rows() > 0){
           $row = $result_current_date_time->row();
        }
        else{
           $row = "0"; 
        } 
        
        $edit_export = array(
            "IS_BIR_POSTED" => 'Y', 
            "BIR_POSTED_DATE" => $row->current_date_time,
            "IS_BIR_POSTED_BY" => $this->session->userdata('userName')    
        );
        $this->get_process->edit_export_list_id($edit_export,$this->input->post('post_receipt_id'));
        echo "Export has been edited";
    }
    
}