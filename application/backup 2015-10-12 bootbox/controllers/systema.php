<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Systema extends CI_Controller {
    
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
    
    public function user_maintenance(){  
        # TITLE
        $data['title']  = "User Maintenance"; 
        
        # MODULE NAME
        $data['module_name']  = "User Maintenance";   
        
        # MODEL
        $this->load->model('get_system');  
        $data['result_user_maintenance'] = $this->get_system->get_user_maintenance();   

        # VIEW
        $this->load->view('view_user_maintenance',$data);  
    }
    
    public function delete_user(){  
        # TITLE
        $data['title']  = "User Maintenance"; 
        
        # MODULE NAME
        $data['module_name']  = "User Maintenance";   
        
        # MODEL
        $this->load->model('get_system');
        $this->get_system->delete_user_id($_POST['id']); 

        # VIEW
        $this->load->view('view_user_maintenance',$data);  
    }
    
    public function edit_user(){  
        # TITLE
        $data['title']  = "User Maintenance"; 
        
        # MODULE NAME
        $data['module_name']  = "User Maintenance";   
        
        # MODEL
        $this->load->model('get_system'); 
        $data['result_user_maintenance'] = $this->get_system->get_user_maintenance();
        $result_user_details = $this->get_system->get_user_details($_POST['id']);
         
        if ($result_user_details->num_rows() > 0){
            $row2 = $result_user_details->row();  
            $data['user_id'] = $row2->user_id; 
        }
        else{
            $row2 = $result_user_details->row();  
            $data['user_id'] = $row2->user_id; 
        }  
        
        //$data['result_user_details'] = $this->get_system->get_user_details($_POST['id']);

        # VIEW
        $this->load->view('view_user_maintenance',$data);  
    }
    
    public function editing_user(){  
        # TITLE
        $data['title']  = "User Maintenance"; 
        
        # MODULE NAME
        $data['module_name']  = "User Maintenance";   
        
        # MODEL
        $this->load->model('get_system');
        $this->get_system->editing_user_id($_POST,$_POST['id']); 
    }
    
}