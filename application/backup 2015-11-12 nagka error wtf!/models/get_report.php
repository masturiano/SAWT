<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_report extends CI_Model {
    
    # GET SERVER CURRENT DATE
    function get_server_current_date_time()
    {
        $query_current_date = "
            select GETDATE() as current_date_time
        ";
        return $query = $this->db->query($query_current_date);
    }
    
    #########################( UNRECEIVE )#########################
    
    # GET UNRECEIVE
    function get_unreceive($user_name)
    {   
        # FILTER NOT YET TRANSMITTED
        $filter_user = "and USER_NAME = '{$user_name}'";
             
        $query = "
            select 
                    CASH_RECEIPT_ID,RECEIPT_NUMBER,RECEIPT_DATE,ACCOUNT_NUMBER,ACCOUNT_NAME,
                    RECEIPT_METHOD_ID,NAME,ORG_ID,AMOUNT,USER_ID,USER_NAME,GL_DATE,TIN,
                    BIR_REG_NAME,ATC_CODE,TAX_BASE,IS_TRANSMITTED,TRANSMITTED_DATE,
                    IS_RECEIVED,RECEIVED_DATE,ORA_CREATION_DATE,SAWT_EXTRACT_DATE,
                    IS_BIR_POSTED,BIR_POSTED_DATE,FXF1,FXF2,FXF3,FXF4,FXF5,
                    GL_DATE_SAWT
            from 
                    tbl_export
            where
                    IS_TRANSMITTED = 'Y'
                    and IS_RECEIVED is null
                    {$filter_user}
            order by
                    ACCOUNT_NUMBER,ACCOUNT_NAME,RECEIPT_NUMBER,RECEIPT_DATE    
        ";
        $query = $this->db->query($query);
        return $query->result();
    }
    
    #########################( POST )#########################
    
    # GET ALL COMPANY
    function get_all_company()
    {
        $query_get_company = "
            select 
                org_id,comp_name,comp_short 
            from
                tbl_company
            where
                comp_name is not null
                and status = 'A'
            order by 
                comp_name    
        ";
        $query = $this->db->query($query_get_company);
        return $query->result();
    }  
    
    # GET FILTER COMPANY
    function get_company($org_id)
    {
        $query_get_company = "
            select 
                org_id,comp_name,comp_short 
            from
                tbl_company
            where 
                org_id = {$org_id}
        ";
        return $query = $this->db->query($query_get_company);
    }  
    
    # GET ALL QUARTER
    function get_all_quarter()
    {
        $query_get_quarter = "
            select 
                label_id,label_name,date_from,date_to,label_year
            from 
                tbl_quarter
            order by
                label_id asc  
        ";
        $query = $this->db->query($query_get_quarter);
        return $query->result();
    }  
    
    # GET TYPE OF SAWT 
    function get_sawt_type()
    {
        $query = "
            select 
                id,description 
            from 
                tbl_sawt_type
            order by
                id asc    
        ";
        $query = $this->db->query($query);
        return $query->result();
    }  
    
    # GET ACCOUNT NUMBER
    function get_account_number($account_number)
    {       
        $query = "
            select 
                top 10 account_number,account_name,cast(account_number as nvarchar)+' - '+account_name as account_display  
            from 
                tbl_export
            where
                account_number like '{$account_number}%' or account_name like '%{$account_number}%' 
            group by 
                account_number,account_name 
            order by 
                account_number  
        ";
        $query = $this->db->query($query);
        return $query->result();
    }  
    
    # POST QUARTER ID  
    
    function get_quarter($post_quarter_id)
    {
        $query_get_quarter = "
            select 
                label_id,label_name,date_from,date_to,label_year
            from 
                tbl_quarter
            where 
                label_id = {$post_quarter_id}   
        ";
        return $query = $this->db->query($query_get_quarter);
    }
    
    # GET POST
    function get_post($post_sawt_type,$post_org_id,$post_quarter,$post_account_number)
    {   
        # GET QUARTER DATE    
        $result_quarter = $this->get_quarter($post_quarter);
        if ($result_quarter->num_rows() > 0){
           $row = $result_quarter->row();
        }
        else{
           $row = "0"; 
        } 
        
        # GET CURRENT DATE
        $result_current_date_time = $this->get_report->get_server_current_date_time();
        if ($result_current_date_time->num_rows() > 0){
           $row2 = $result_current_date_time->row();
           $current_time = substr($row2->current_date_time,0,10);
        }
        else{
           $row2 = "0"; 
        }  
        
        # FILTER TYPE OF SAWT
        $filter_sawt_type = "
            and NAME like '%{$post_sawt_type}%'
        ";
        
        # FILTER COMPANY VIA ORG ID
        $filter_org_id = "
            and ORG_ID = {$post_org_id}
        "; 
        
        # FILTER QUARTER DATE
        $filter_quarter_date = "
            and GL_DATE_SAWT between '{$row->date_from}' and '{$row->date_to}'
        ";
        
        # FILTER ACCOUNT
        if($post_account_number == 0){
            $filter_account = "";  
        }
        else{  
            $filter_account = "
                and ACCOUNT_NUMBER = '{$post_account_number}'
            ";       
        }
                
        $sql = "
            select 
                CASH_RECEIPT_ID,RECEIPT_NUMBER,RECEIPT_DATE,ACCOUNT_NUMBER,ACCOUNT_NAME,
                RECEIPT_METHOD_ID,NAME,ORG_ID,AMOUNT,USER_ID,USER_NAME,GL_DATE,TIN,
                BIR_REG_NAME,ATC_CODE,TAX_BASE,IS_TRANSMITTED,TRANSMITTED_DATE,
                IS_RECEIVED,RECEIVED_DATE,ORA_CREATION_DATE,SAWT_EXTRACT_DATE,
                IS_BIR_POSTED,BIR_POSTED_DATE,FXF1,FXF2,FXF3,FXF4,FXF5,
                GL_DATE_SAWT
            from
                tbl_export
            where 
                IS_TRANSMITTED = 'Y'
                and IS_RECEIVED = 'Y'
                {$filter_sawt_type}
                {$filter_org_id}
                {$filter_quarter_date}
                {$filter_account}
        ";  
            
        $query = $this->db->query($sql);
        return $query->result();
    }
}
