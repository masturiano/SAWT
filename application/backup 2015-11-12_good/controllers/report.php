<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {
    
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
    
    #########################( UNRECEIVE )#########################
    
    public function unreceive(){  
        # TITLE
        $data['title']  = "Process"; 
        
        # MODULE NAME
        $data['module_name']  = "Unreceive Report";   
        
        # MODEL
        $this->load->model('get_report'); 
         
        $data['get_unreceive'] = $this->get_report->get_unreceive($this->session->userdata('oracleUsername')); 
        
        # VIEW
        $this->load->view('view_unreceive_report',$data);  
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
    
    function generate_unreceive_xls()
    {   
        # TITLE
        $data['title']  = "Report Unreceive"; 
        
        # MODEL
        $this->load->model('get_report');
        
        echo "window.open('".base_url()."unreceive_excel/print_excel/".$this->session->userdata('oracleUsername')."');";                  
    } 
    
    #########################( FILE CREATION )#########################    
    
    public function post(){  
        # TITLE
        $data['title']  = "Process"; 
        
        # MODULE NAME
        $data['module_name']  = "BIR File Creation Report";   
        
        # MODEL
        $this->load->model('get_report');   
         
        $data['get_unreceive'] = $this->get_report->get_unreceive($this->session->userdata('oracleUsername')); 
        $data['get_all_company'] = $this->get_report->get_all_company();
        $data['get_all_quarter'] = $this->get_report->get_all_quarter();
        $data['get_sawt_type'] = $this->get_report->get_sawt_type();
        
        # VIEW
        $this->load->view('view_post_report',$data);  
    }
    
    public function search_account(){ 
        
        # MODEL
        $this->load->model('get_report');

        $arrResult = array();
            $arrRegName = $this->get_report->get_account_number($_GET['term']);
                foreach($arrRegName as $val){
                    $arrResult[] = array(
                        "id"=>$val->account_number,
                        "label"=>$val->account_display,
                        "value" => strip_tags($val->account_display));    
                }
        echo json_encode($arrResult);    
    }
    
    function generate_post_xls()
    {   
        # TITLE
        $data['title']  = "Report BIR File Creation"; 
        
        # MODEL
        $this->load->model('get_report');
        
        if($this->input->post('txt_account_number') == ''){
            $post_account_number = 0;    
        }
        else{
            $post_account_number = $this->input->post('txt_account_number');    
        }
        echo "window.open('".base_url()."post_excel/print_excel/".$this->input->post('cmb_type')."/".$this->input->post('cmb_company')."/".$this->input->post('cmb_quarter')."/".$post_account_number."');";                
    } 
    
}