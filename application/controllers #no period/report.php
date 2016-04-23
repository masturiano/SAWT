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
    
    #########################( CANCELLED )#########################
    
    public function cancelled(){  
        # TITLE
        $data['title']  = "SAWT"; 
        
        # MODULE NAME
        $data['module_name']  = "Cancelled Report";   
        
        # MODEL
        $this->load->model('get_report'); 
        
        $data['get_all_company'] = $this->get_report->get_all_company();

        # VIEW
        $this->load->view('view_cancelled_report',$data);  
    }
    
    function generate_cancelled_xls()
    {   
        # TITLE
        $data['title']  = "Report Unreceive"; 
        
        # MODEL
        $this->load->model('get_report');
                                                                                                   
        echo "window.open('".base_url()."cancelled_excel/print_excel/".$this->session->userdata('oracleUsername')."/".$this->input->post('cmb_company')."');";                  
    }     
    
    #########################( NOT TRANSMIT )#########################
    
    public function not_transmit_all(){  
        # TITLE
        $data['title']  = "SAWT"; 
        
        # MODULE NAME
        $data['module_name']  = "Not Transmit Report";   
        
        # MODEL
        $this->load->model('get_report'); 
        
        $data['get_all_company'] = $this->get_report->get_all_company();

        # VIEW
        $this->load->view('view_not_transmit_all_report',$data);  
    }
    
    function generate_not_transmit_all_xls()
    {   
        # TITLE
        $data['title']  = "Report Unreceive"; 
        
        # MODEL
        $this->load->model('get_report');
                                                                                                   
        echo "window.open('".base_url()."not_transmit_all_excel/print_excel/".$this->input->post('cmb_company')."');";                  
    } 
    
    public function not_transmit(){  
        # TITLE
        $data['title']  = "SAWT"; 
        
        # MODULE NAME
        $data['module_name']  = "Not Transmit Report";   
        
        # MODEL
        $this->load->model('get_report'); 
        
        $data['get_all_company'] = $this->get_report->get_all_company();

        # VIEW
        $this->load->view('view_not_transmit_report',$data);  
    }
    
    function generate_not_transmit_xls()
    {   
        # TITLE
        $data['title']  = "Report Unreceive"; 
        
        # MODEL
        $this->load->model('get_report');
                                                                                                   
        echo "window.open('".base_url()."not_transmit_excel/print_excel/".$this->session->userdata('oracleUsername')."/".$this->input->post('cmb_company')."');";                  
    } 
    
    #########################( UNRECEIVE )#########################
    
    public function unreceive(){  
        # TITLE
        $data['title']  = "SAWT"; 
        
        # MODULE NAME
        $data['module_name']  = "Unreceive Report";   
        
        # MODEL
        $this->load->model('get_report');
        
        $data['get_all_company'] = $this->get_report->get_all_company(); 

        # VIEW
        $this->load->view('view_unreceive_report',$data);  
    }
    
    function generate_unreceive_xls()
    {   
        # TITLE
        $data['title']  = "Report Unreceive"; 
        
        # MODEL
        $this->load->model('get_report');
        
        echo "window.open('".base_url()."unreceive_excel/print_excel/".$this->session->userdata('oracleUsername')."/".$this->input->post('cmb_company')."');";                  
    } 
    
    #########################( RECEIVED )#########################
    
    public function received(){  
        # TITLE
        $data['title']  = "SAWT"; 
        
        # MODULE NAME
        $data['module_name']  = "Receive Report";   
        
        # MODEL
        $this->load->model('get_report');
        
        $data['get_all_company'] = $this->get_report->get_all_company(); 

        # VIEW
        $this->load->view('view_received_report',$data);  
    }
    
    function generate_received_xls()
    {   
        # TITLE
        $data['title']  = "Report Received"; 
        
        # MODEL
        $this->load->model('get_report');
        
        echo "window.open('".base_url()."received_excel/print_excel/".$this->session->userdata('oracleUsername')."/".$this->input->post('cmb_company')."/".$this->input->post('txt_date_from')."/".$this->input->post('txt_date_to')."');";                  
    } 
    
    #########################( REPRINT TRANSMITTAL )#########################
    
    public function reprint_transmittal(){  
        # TITLE
        $data['title']  = "SAWT"; 
        
        # MODULE NAME
        $data['module_name']  = "Reprint Transmittal Report";   
        
        # MODEL
        $this->load->model('get_report');
        
        $data['get_all_transmittal'] = $this->get_report->get_all_reprint_transmittal($this->session->userdata('oracleUsername')); 

        # VIEW
        $this->load->view('view_reprint_transmittal',$data);  
    }
    
    function generate_reprint_pdf()
    {   
        # TITLE
        $data['title']  = "SAWT"; 
        
        # MODEL
        $this->load->model('get_report');
        
        $transmittal_number = $this->input->post('post_transmittal_number');
        
        echo "window.open('".base_url()."transmittal_reprint_pdf/index/".$transmittal_number."');";                  
    }
    
    #########################( FILE CREATION )#########################    
    
    public function post(){  
        # TITLE
        $data['title']  = "SAWT"; 
        
        # MODULE NAME
        $data['module_name']  = "BIR File Creation Report";   
        
        # MODEL
        $this->load->model('get_report');   
         
        // $data['get_unreceive'] = $this->get_report->get_unreceive($this->session->userdata('oracleUsername')); 
        $data['get_all_company'] = $this->get_report->get_all_company();
        // $data['get_all_quarter'] = $this->get_report->get_all_quarter();
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
        echo "window.open('".base_url()."post_excel/print_excel/".$this->input->post('cmb_type')."/".$this->input->post('cmb_company')."/".$this->input->post('txt_sawt_gl_date_from')."/".$this->input->post('txt_sawt_gl_date_to')."/".$post_account_number."');";                
    } 
    
}