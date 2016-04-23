<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {
    
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

	public function index(){
        # MAIN
		$this->login();   
	}
    
    public function login(){    
        # TITLE
        $data['title']  = "Login"; 
        
        # MODEL
        $this->load->model('get_user');   
        
        # VIEW
        $this->load->view('view_login',$data);  
        
        # DESTROY SESSIONS
        $this->session->sess_destroy();
        $session_user_name = $this->session->userdata('userName');
    }
    
    public function login_user()
    {
        # TITLE
        $data['title']  = "Login";
        
        # MODEL       
        $this->load->model('get_user');
        
        # GET USER
        if($_POST){
            $login = $this->get_user->validate_user($_POST); 
            if($login > 0){
                $user_details = $this->get_user->user_details($_POST);
                # FETCH RESULT
                if ($user_details->num_rows() > 0)
                {
                   $row = $user_details->row();
                   
                   # SET SESSIONS
                   $user_data = array(
                      'storeCode' => $row->store_code,
                      'groupCode' => $row->group_code,
                      'userName' => $row->user_name,
                      'userPass' => $row->user_pass,
                      'pages' => $row->pages,
                      'userLevel' => $row->user_level,
                      'dateEnter' => $row->date_enter,
                      'dateUpdate' => $row->date_update,
                      'userStat' => $row->user_stat,
                      'fullName' => $row->full_name,
                      'ipAddress' => $row->ip_address,
                      'log' => $row->log,
                      'deptShortDesc' => $row->dept_short_desc,
                      'loggedIn' => TRUE
                   );    
                   $this->session->set_userdata($user_data); 
                   echo "1";               
                }
                else{
                    echo "0"; 
                    $this->index();   
                }    
            }
            else
            {
                echo "0";            
            }   
        }
        else
        {
            echo "Error getting user details!";        
        }
    }
    
    public function logout_user(){    
        # TITLE
        $data['title']  = "Logout"; 
        
        # UNSET SESSION
        echo "location.href='".base_url()."'";   
    }
    
    public function check_session(){
        # CHECK SESSION                 
        if($this->session->userdata('userName') == ""){
            $this->session->sess_destroy();    
            echo "location.href='".base_url()."'";    
        }    
    }
    
    public function main(){  
        # TITLE
        $data['title']  = "Site"; 
        
        # MODULE NAME
        $data['module_name']  = "Home";   
        
        # MODEL
        $this->load->model('get_db'); 

        # VIEW
        $this->load->view('view_home',$data);  
    }
	
	public function data(){    
        # TITLE
		$data['title']  = "Site"; 
        
        # MODULE NAME
        $data['module_name']  = "Data";   
        
        # MODEL
        $this->load->model('get_db');
        
        # VIEW
        $this->load->view('view_data',$data);  
	}
    
    public function add_crm_data()
    {
        # TITLE
        $data['title']  = "Site"; 
        
        # MODEL
        $this->load->model('get_db'); 
        
        # GET CRM DATA
        if($_POST){
            $this->get_db->get_crm_data($_POST);   
        }
        else{
            echo "Error getting CRM data!";        
        }
    }
    
    function add_data_eight()
    {
        # TITLE
        $data['title']  = "Site";     
        
        # MODEL
        $this->load->model('get_db');
        
        # GET DATA EIGHT DATA
        if($_POST){
            $this->get_db->get_data_eight($_POST);   
        }
        else{
            echo "Error getting Data Eight data!";        
        }
    }
    
    function generate_csv()
    {
        # TITLE
        $data['title']  = "Site"; 
        
        # MODEL
        $this->load->model('get_db');
        
        # GET DATA EIGHT DATA
        if($_POST){
            $this->get_db->get_csv_data($_POST);   
        }
        else{
            echo "Error getting CSV data!";        
        }
    }
    
    function generate_xls()
    {   
        # TITLE
        $data['title']  = "Site"; 
        
        # MODEL
        $this->load->model('get_excel');
        
        $card_type = $this->input->post('cmb_card_typ');
        $date_from = $this->input->post('datepicker_from');
        $date_to = $this->input->post('datepicker_to');
        
        echo "window.open('".base_url()."perks_tnap_excel/print_excel/".$card_type."/".$date_from."/".$date_to."');";                  
    }
    
    # EXTRA FUNCTION
    
    function about(){
        $data['title']  = "About";
        $data['welcome']  = "Welcome to code igniter! About page!";
        $this->load->view('view_about',$data);
    }
	
	function addStuff($var1,$var2)
	{
		$this->load->model('math');
		return $this->math->add($var1,$var2);
	}
	
	function subStuff($var1,$var2)
	{
		$this->load->model('math');
		return $this->math->sub($var1,$var2);
	}
	
	function getValues(){
		$data['title']  = "View Database";
        $data['welcome']  = "Welcome to code igniter! Database page!";
        $this->load->model('get_db');
		$data['result'] = $this->get_db->getAll();
        $this->insertValues();
        $this->load->helper('url');
        $this->load->helper('path');
		$this->load->view('view_db', $data);
    }
	
	function insertValues(){
		$this->load->model('get_db');
		$newRow = array("first_name" => "Mydzell", "last_name" => "Asturiano");
		$this->get_db->insert1($newRow);
		echo "it has been added";
	}
	
	function insertValues2(){
		$this->load->model('get_db');
		$newRow = array( 
			array("first_name" => "Mydzell", "last_name" => "Asturiano"),
			array("first_name" => "Jayzelle", "last_name" => "Asturiano")
		);
		$this->get_db->insert2($newRow);
		echo "it has been added";
	}
	
	function updateValues1(){
		$this->load->model('get_db');
		$newRow = array("last_name" => "Tafalla");
		$this->get_db->update1($newRow);
		echo "it has beeen updated";
	}
	
	function updateValues2(){
		$this->load->model('get_db');
		$newRow = array( 
			array("id" => "1", "last_name" => "Calingasan"),
			array("id" => "2", "last_name" => "Calingasan")
		);
		$this->get_db->update2($newRow);
		echo "it has beeen updated";
	}
    
    function deleteValues(){
        $this->load->model('get_db');
        $oldRow = array(
            "id" => "1"
        );
        $this->get_db->delete1($oldRow);
        echo "deleted!";
    }
    
    function form(){
        $data['title']  = "Form";
        $data['welcome']  = "Welcome to code igniter! Form page!";
        
        $data['firstName'] = array(
            'name'        => 'firstName',
            'id'          => 'firstName',
            'maxlength'   => '100',
            'size'        => '50',
            'style'       => 'width:50%'
        );
        
        $data['middleName'] = array(
            'name'        => 'middleName',
            'id'          => 'middleName',
            'maxlength'   => '100',
            'size'        => '50',
            'style'       => 'width:50%'
        );
        
        $data['lastName'] = array(
            'name'        => 'lastName',
            'id'          => 'lastName',
            'maxlength'   => '100',
            'size'        => '50',
            'style'       => 'width:50%'
        );
        
        $data['gender'] = array(
            'select'  => 'Select Sex',
            'male'  => 'Male',
            'female'    => 'Female'
        );
        
        $data['status1'] = array(
            'name'        => 'status',
            'id'          => 'status',
            'value'       => 'single',
            'checked'     => FALSE,
            'style'       => 'margin:10px',
        );
        
        $data['status2'] = array(
            'name'        => 'status',
            'id'          => 'status',
            'value'       => 'married',
            'checked'     => FALSE,
            'style'       => 'margin:10px',
        );
       
        
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->view('view_form',$data);  
    }
}