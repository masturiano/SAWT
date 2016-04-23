<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demo extends CI_Controller {

     public function bs_pagination($config){
        /* This Application Must Be Used With BootStrap 3 *  */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] ="</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        return $config;
    }
 
    public function table($page='',$page_number = 1)
    {
        $data['title']='Code Igniter / Bootstrap Table Demo';        
        $this->load->model('demo_model');        
            
        //Pagination
        $this->load->library("pagination");
        //Set config options
        $config["per_page"] = 3;
        $config['use_page_numbers'] = TRUE;            
        $config['base_url'] = base_url()."demo/table/page/";//Link to use for pagination
        //Add bootstrap html to config
        $config = $this -> bs_pagination($config);
        //fix request for records for page number use
        $page_number = intval(($page_number  == 1 || $page_number  == 0) ? 0 : ($page_number * $config['per_page']) - $config['per_page']);
        
        $config['total_rows'] = $this->demo_model->count_results("table_name");        
        $records = $this->demo_model->get_results("table_name",$config["per_page"], $page_number);

        $this->pagination->initialize($config);                

        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->library('table');

            $this->table->set_empty("");

            $this->table->set_heading(
                
                'ID',
                
                'Name',                

                'Location'
                
            );

            if(count($records)>0){
            
                foreach ($records as $record){

                    $this->table->add_row(
                    
                        array('data' => $record->id),
                        
                        anchor(base_url(). $record->slug, $record->name, 'style="font-weight:bold;"'),            

                        array('data' => $record->address.", ".$record->state)                    

                    );

                }
                $tmpl = array ( 'table_open'  => '<table class="table table-striped table-bordered">' );
                $this->table->set_template($tmpl);
                $data['table'] = $this->table->generate();
            }    
    
        $this->load->view('templates/demo_header', $data);
        $this->load->view('demo_table', $data);
    }
}