<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_process extends CI_Model {
    
    #########################( ENCODE )#########################
    
    # GET SERVER CURRENT DATE
    function get_server_current_date_time()
    {
        $query_current_date = "
            select GETDATE() as current_date_time
        ";
        return $query = $this->db->query($query_current_date);
    }
    
    # GET ENCODE
    function get_encode($oracle_username,$org_id)
    {
        # FILTER NOT YET TRANSMITTED
        $transmit = "and IS_TRANSMITTED is null";
        
        $query_get_encode = "
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
                USER_NAME = '{$oracle_username}'
                {$transmit}
        ";
        $query = $this->db->query($query_get_encode);
        return $query->result();
    }
    
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
    
    # GET EXPORT
    function get_export_details($receipt_id)
    {
        $query_export_detail = "
            select 
                CASH_RECEIPT_ID,RECEIPT_NUMBER,RECEIPT_DATE,ACCOUNT_NUMBER,ACCOUNT_NAME,
                RECEIPT_METHOD_ID,NAME,ORG_ID,AMOUNT,USER_ID,USER_NAME,GL_DATE,TIN,
                BIR_REG_NAME,ATC_CODE,TAX_BASE,IS_TRANSMITTED,TRANSMITTED_DATE,
                IS_RECEIVED,RECEIVED_DATE,ORA_CREATION_DATE,SAWT_EXTRACT_DATE,
                IS_BIR_POSTED,BIR_POSTED_DATE,FXF1,FXF2,FXF3,FXF4,FXF5,
                GL_DATE_SAWT
            from 
                tbl_export
            WHERE
                CASH_RECEIPT_ID = {$receipt_id} 
        ";
        return $query = $this->db->query($query_export_detail);
    }
    
    # GET TIN BIR REG NAME
    function get_tin_reg_name($tin_no)
    {
        $query_tin = "
            select 
                top 10 TIN,BIR_REG_NAME
            from
                tbl_tin_master
            where
                TIN like '%{$tin_no}%'
        ";
        $query = $this->db->query($query_tin);
        return $query->result();
    }   
    
    # GET ATC CODE
    function get_atc_code()
    {
        $query_atc_code = "
            select 
                code_id,code_name,code_type,description,code_name+' ('+description+')' as display 
            from 
                tbl_atc_codes
            order by
                code_id  
        ";
        $query = $this->db->query($query_atc_code);
        return $query->result();
    } 
    
    # CHECK TIN NO IF EXIST
    function check_tin_no($tin_no)
    {
        $query_tin = "
            select 
                *
            from
                tbl_tin_master
            where
                TIN = {$tin_no}
        ";
        return $query = $this->db->query($query_tin);
    }  
    
    # CHECK IF VALID FOR TRANSMIT
    function check_transmit_id($receipt_id)
    {
        $query_transmit = "
            select 
                * 
            from 
                tbl_export
            where 
                CASH_RECEIPT_ID in ({$receipt_id})
                and TIN IS NOT NULL
                and BIR_REG_NAME IS NOT NULL
                and ATC_CODE IS NOT NULL
                and TAX_BASE IS NOT NULL
            order by 
                TIN desc
        ";
        return $query = $this->db->query($query_transmit);
    }  
    
    # EDIT EXPORT ID    
    function edit_export_id($data,$receipt_id){
        $this->db->update("tbl_export", $data, "CASH_RECEIPT_ID = '{$receipt_id}'");
    }
    
    # ADD TIN NUMBER 
    function add_tin_master($data){
        echo $this->db->insert("tbl_tin_master", $data);
    }
    
    #########################( RECEIVE )#########################
    
    # GET ENCODE
    function get_receive($oracle_username)
    {
        # FILTER TRANSMITTED
        $transmit = "IS_TRANSMITTED = 'Y'";    
        
        # FILTER NOT YET RECEIVE
        $receive = "IS_RECEIVED is null";   
        
        $query_get_encode = "
            select 
                CASH_RECEIPT_ID,RECEIPT_NUMBER,RECEIPT_DATE,ACCOUNT_NUMBER,ACCOUNT_NAME,
                RECEIPT_METHOD_ID,NAME,ORG_ID,AMOUNT,USER_ID,USER_NAME,GL_DATE,TIN,
                BIR_REG_NAME,ATC_CODE,TAX_BASE,IS_TRANSMITTED,TRANSMITTED_DATE,
                IS_RECEIVED,RECEIVED_DATE,ORA_CREATION_DATE,SAWT_EXTRACT_DATE,
                IS_BIR_POSTED,BIR_POSTED_DATE,FXF1,FXF2,FXF3,FXF4,FXF5
            from 
                tbl_export
            where
                {$transmit}
                and {$receive} 
            order by
                ACCOUNT_NUMBER,ACCOUNT_NAME,RECEIPT_NUMBER,RECEIPT_DATE
                
        ";
        $query = $this->db->query($query_get_encode);
        return $query->result();
    }
    
    # EDIT EXPORT ID    
    function edit_export_list_id($data,$receipt_id){
        $this->db->update("tbl_export", $data, "CASH_RECEIPT_ID in ({$receipt_id})");
    }
    
    #########################( POST )#########################
    
    # GET POST
    function get_post()
    {
        # FILTER TRANSMITTED
        $transmit = "IS_TRANSMITTED = 'Y'";    
        
        # FILTER RECEIVED
        $receive = "IS_RECEIVED = 'Y'";   
        
        $query_get_post = "
            select 
                CASH_RECEIPT_ID,RECEIPT_NUMBER,RECEIPT_DATE,ACCOUNT_NUMBER,ACCOUNT_NAME,
                RECEIPT_METHOD_ID,NAME,ORG_ID,AMOUNT,USER_ID,USER_NAME,GL_DATE,TIN,
                BIR_REG_NAME,ATC_CODE,TAX_BASE,IS_TRANSMITTED,TRANSMITTED_DATE,
                IS_RECEIVED,RECEIVED_DATE,ORA_CREATION_DATE,SAWT_EXTRACT_DATE,
                IS_BIR_POSTED,BIR_POSTED_DATE,FXF1,FXF2,FXF3,FXF4,FXF5
            from 
                tbl_export
            where
                {$transmit}
                and {$receive} 
            order by
                ACCOUNT_NUMBER,ACCOUNT_NAME,RECEIPT_NUMBER,RECEIPT_DATE
                
        ";
        $query = $this->db->query($query_get_post);
        return $query->result();
    }
    
}
