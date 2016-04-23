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
    
    #########################( CANCELLED )#########################
    
    # GET NOT TRANSMIT
    function get_cancelled($oracle_username,$org_id,$date_from,$date_to)
    {                                                   
        # FILTER USER NAME
        $filter_user = "USER_NAME = '{$oracle_username}'"; 
        
        # FILTER COMPANY
        $company = "ORG_ID = {$org_id}";
        
        # FILTER RANGE RECEIPT DATE
        $receipt_date = "RECEIPT_DATE between '{$date_from}' and '{$date_to}'";
        
        $query_get_cancelled = "
            select 
                CASH_RECEIPT_ID,RECEIPT_NUMBER,RECEIPT_DATE,ACCOUNT_NUMBER,ACCOUNT_NAME,
                RECEIPT_METHOD_ID,NAME,ORG_ID,AMOUNT,USER_ID,USER_NAME,GL_DATE,TIN,
                BIR_REG_NAME,ATC_CODE,TAX_BASE,IS_TRANSMITTED,TRANSMITTED_DATE,
                IS_RECEIVED,RECEIVED_DATE,ORA_CREATION_DATE,SAWT_EXTRACT_DATE,
                IS_BIR_POSTED,BIR_POSTED_DATE,CANCELLED_DATE,FXF2,FXF3,FXF4,FXF5,
                GL_DATE_SAWT,CANCELLED_DATE
            from 
                tbl_export_cancelled
            where
                {$filter_user}
                and {$company}
                and {$receipt_date}   
            order by
                RECEIVED_DATE,ACCOUNT_NUMBER,RECEIPT_NUMBER desc
        ";
        $query = $this->db->query($query_get_cancelled);
        return $query->result();
    }
    
    # GET NOT TRANSMIT TOTAL
    function get_cancelled_total($oracle_username,$org_id,$date_from,$date_to)
    {                                           
        # FILTER USER NAME
        $filter_user = "USER_NAME = '{$oracle_username}'"; 
        
        # FILTER COMPANY
        $company = "ORG_ID = {$org_id}";
        
        # FILTER RANGE RECEIPT DATE
        $receipt_date = "RECEIPT_DATE between '{$date_from}' and '{$date_to}'";
        
        $query_get_cancelled = "
            select 
                sum(AMOUNT) as AMOUNT,sum(TAX_BASE) as TAX_BASE
            from 
                tbl_export_cancelled
            where
                {$filter_user}
                and {$company}
                and {$receipt_date}   
        ";
        return $query = $this->db->query($query_get_cancelled);
    }
    
    #########################( NOT TRANSMIT )#########################
    
    # GET NOT TRANSMIT
    function get_not_transmit($oracle_username,$org_id,$date_from,$date_to)
    {   
        # FILTER NOT YET TRANSMITTED
        $transmit = "IS_TRANSMITTED is null";
                                                
        # FILTER USER NAME
        $filter_user = "USER_NAME = '{$oracle_username}'"; 
        
        # FILTER COMPANY
        $company = "ORG_ID = {$org_id}";
        
        # FILTER RANGE RECEIPT DATE
        $receipt_date = "RECEIPT_DATE between '{$date_from}' and '{$date_to}'";
        
        $query_get_encode = "
            select 
                CASH_RECEIPT_ID,RECEIPT_NUMBER,RECEIPT_DATE,ACCOUNT_NUMBER,ACCOUNT_NAME,
                RECEIPT_METHOD_ID,NAME,ORG_ID,AMOUNT,USER_ID,USER_NAME,GL_DATE,TIN,
                BIR_REG_NAME,ATC_CODE,TAX_BASE,IS_TRANSMITTED,TRANSMITTED_DATE,
                IS_RECEIVED,RECEIVED_DATE,ORA_CREATION_DATE,SAWT_EXTRACT_DATE,
                IS_BIR_POSTED,BIR_POSTED_DATE,CANCELLED_DATE,FXF2,FXF3,FXF4,FXF5,
                GL_DATE_SAWT
            from 
                tbl_export
            where
                {$transmit}
                and {$filter_user}
                and {$company}
                and {$receipt_date}   
            order by
                RECEIVED_DATE,ACCOUNT_NUMBER,RECEIPT_NUMBER desc
        ";
        $query = $this->db->query($query_get_encode);
        return $query->result();
    }
    
    # GET NOT TRANSMIT TOTAL
    function get_not_transmit_total($oracle_username,$org_id,$date_from,$date_to)
    {   
        # FILTER NOT YET TRANSMITTED
        $transmit = "IS_TRANSMITTED is null";
                                                
        # FILTER USER NAME
        $filter_user = "USER_NAME = '{$oracle_username}'"; 
        
        # FILTER COMPANY
        $company = "ORG_ID = {$org_id}";
        
        # FILTER RANGE RECEIPT DATE
        $receipt_date = "RECEIPT_DATE between '{$date_from}' and '{$date_to}'";
        
        $query_get_encode = "
            select 
                sum(AMOUNT) as AMOUNT,sum(TAX_BASE) as TAX_BASE
            from 
                tbl_export
            where
                {$transmit}
                and {$filter_user}
                and {$company}
                and {$receipt_date}   
        ";
        return $query = $this->db->query($query_get_encode);
    }
    
    #########################( UNRECEIVE )#########################
    
    # GET UNRECEIVE
    function get_unreceive($user_name,$org_id,$date_from,$date_to)
    {   
        # FILTER TRANSMITTED
        $transmit = "IS_TRANSMITTED = 'Y'";
        
        # FILTER NOT YET RECEIVE
        $unreceive = "IS_RECEIVED is null";
        
        # FILTER USER NAME
        $filter_user = "USER_NAME = '{$user_name}'";  
        
        # FILTER COMPANY
        $company = "ORG_ID = {$org_id}";   
        
        # FILTER RANGE RECEIPT DATE
        $receipt_date = "RECEIPT_DATE between '{$date_from}' and '{$date_to}'";
             
        $query = "
            select 
                CASH_RECEIPT_ID,RECEIPT_NUMBER,RECEIPT_DATE,ACCOUNT_NUMBER,ACCOUNT_NAME,
                RECEIPT_METHOD_ID,NAME,ORG_ID,AMOUNT,USER_ID,USER_NAME,GL_DATE,TIN,
                BIR_REG_NAME,ATC_CODE,TAX_BASE,IS_TRANSMITTED,TRANSMITTED_DATE,
                IS_RECEIVED,RECEIVED_DATE,ORA_CREATION_DATE,SAWT_EXTRACT_DATE,
                IS_BIR_POSTED,BIR_POSTED_DATE,CANCELLED_DATE,FXF2,FXF3,FXF4,FXF5,
                GL_DATE_SAWT
            from 
                tbl_export
            where
                {$transmit}
                and {$unreceive}
                and {$company}
                and {$receipt_date}  
            order by
                    ACCOUNT_NUMBER,ACCOUNT_NAME,RECEIPT_NUMBER,RECEIPT_DATE    
        ";
        $query = $this->db->query($query);
        return $query->result();
    }
    
    # GET UNRECEIVE TOTAL
    function get_unreceive_total($user_name,$org_id,$date_from,$date_to)
    {   
        # FILTER TRANSMITTED
        $transmit = "IS_TRANSMITTED = 'Y'";
        
        # FILTER NOT YET RECEIVE
        $unreceive = "IS_RECEIVED is null";
        
        # FILTER USER NAME
        $filter_user = "USER_NAME = '{$user_name}'";  
        
        # FILTER COMPANY
        $company = "ORG_ID = {$org_id}";      
        
        # FILTER RANGE RECEIPT DATE
        $receipt_date = "RECEIPT_DATE between '{$date_from}' and '{$date_to}'";
             
        $query = "
            select 
                sum(AMOUNT) as AMOUNT,sum(TAX_BASE) as TAX_BASE
            from 
                tbl_export
            where
                {$transmit}
                and {$unreceive}
                and {$company}
                and {$receipt_date} 
        ";
        return $query = $this->db->query($query);
    }
    
    #########################( RECEIVED )#########################
    
    # GET UNRECEIVE
    function get_received($user_name,$org_id,$date_from,$date_to)
    {   
        # FILTER TRANSMITTED
        $transmit = "IS_TRANSMITTED = 'Y'";
        
        # FILTER  RECEIVED
        $received = "IS_RECEIVED = 'Y'";
        
        # FILTER USER NAME
        $filter_user = "USER_NAME = '{$user_name}'";  
        
        # FILTER COMPANY
        $company = "ORG_ID = {$org_id}";   
        
        # FILTER RANGE RECEIPT DATE
        $receipt_date = "RECEIPT_DATE between '{$date_from}' and '{$date_to}'";
             
        $query = "
            select 
                CASH_RECEIPT_ID,RECEIPT_NUMBER,RECEIPT_DATE,ACCOUNT_NUMBER,ACCOUNT_NAME,
                RECEIPT_METHOD_ID,NAME,ORG_ID,AMOUNT,USER_ID,USER_NAME,GL_DATE,TIN,
                BIR_REG_NAME,ATC_CODE,TAX_BASE,IS_TRANSMITTED,TRANSMITTED_DATE,
                IS_RECEIVED,RECEIVED_DATE,ORA_CREATION_DATE,SAWT_EXTRACT_DATE,
                IS_BIR_POSTED,BIR_POSTED_DATE,CANCELLED_DATE,FXF2,FXF3,FXF4,FXF5,
                GL_DATE_SAWT,RECEIVED_BY,RECEIVED_DATE
            from 
                tbl_export
            where
                {$transmit}
                and {$received}
                and {$company}
                and {$receipt_date}  
            order by
                    ACCOUNT_NUMBER,ACCOUNT_NAME,RECEIPT_NUMBER,RECEIPT_DATE    
        ";
        $query = $this->db->query($query);
        return $query->result();
    }
    
    # GET UNRECEIVE TOTAL
    function get_received_total($user_name,$org_id,$date_from,$date_to)
    {   
        # FILTER TRANSMITTED
        $transmit = "IS_TRANSMITTED = 'Y'";
        
        # FILTER  RECEIVED
        $received = "IS_RECEIVED = 'Y'";
        
        # FILTER USER NAME
        $filter_user = "USER_NAME = '{$user_name}'";  
        
        # FILTER COMPANY
        $company = "ORG_ID = {$org_id}";      
        
        # FILTER RANGE RECEIPT DATE
        $receipt_date = "RECEIPT_DATE between '{$date_from}' and '{$date_to}'";
             
        $query = "
            select 
                sum(AMOUNT) as AMOUNT,sum(TAX_BASE) as TAX_BASE
            from 
                tbl_export
            where
                {$transmit}
                and {$received}
                and {$company}
                and {$receipt_date} 
        ";
        return $query = $this->db->query($query);
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
    function get_post($post_sawt_type,$post_org_id,$post_sawt_gldate_from,$post_sawt_gldate_to,$post_account_number)
    {    
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
        
        # FILTER GL SAWT DATE
        $filter_sawt_gldate = "
            and GL_DATE_SAWT between '{$post_sawt_gldate_from}' and '{$post_sawt_gldate_to}'
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
                IS_BIR_POSTED,BIR_POSTED_DATE,CANCELLED_DATE,FXF2,FXF3,FXF4,FXF5,
                GL_DATE_SAWT
            from
                tbl_export
            where 
                IS_TRANSMITTED = 'Y'
                and IS_RECEIVED = 'Y'
                {$filter_sawt_type}
                {$filter_org_id}
                {$filter_sawt_gldate}
                {$filter_account}
        ";  
            
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    # GET POST TOTAL
    function get_post_total($post_sawt_type,$post_org_id,$post_sawt_gldate_from,$post_sawt_gldate_to,$post_account_number)
    {    
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
        
        # FILTER GL SAWT DATE
        $filter_sawt_gldate = "
            and GL_DATE_SAWT between '{$post_sawt_gldate_from}' and '{$post_sawt_gldate_to}'
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
                sum(AMOUNT) as AMOUNT,sum(TAX_BASE) as TAX_BASE
            from
                tbl_export
            where 
                IS_TRANSMITTED = 'Y'
                and IS_RECEIVED = 'Y'
                {$filter_sawt_type}
                {$filter_org_id}
                {$filter_sawt_gldate}
                {$filter_account}
        ";  
            
        return $query = $this->db->query($sql);
    }
}
