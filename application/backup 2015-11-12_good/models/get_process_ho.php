<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_process_ho extends CI_Model {
    
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
        
        # FILTER COMPANY
        if($org_id == 0){
            $company = "";    
        }
        else{
            $company = "and ORG_ID = {$org_id}";    
        }     
        
        $query_get_encode = "
            select 
                DENSE_RANK() 
                OVER (ORDER BY CASH_RECEIPT_ID) AS NUMBER,
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
                {$company}
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
                org_id,comp_name,comp_short,glstid 
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
                CASH_RECEIPT_ID in ({$receipt_id}) 
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
    
    # CHECK IF VALID FOR TRANSMIT WITHOUT NULL VALUE
    function check_transmit_id_without_null($receipt_id)
    {
        $query_transmit = "
            select 
                * 
            from 
                tbl_export
            where 
                CASH_RECEIPT_ID in ({$receipt_id})
                and TIN IS NULL
                and BIR_REG_NAME IS NULL
                and ATC_CODE IS NULL
                and TAX_BASE IS NULL
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
    
    # GET TRANSMITTAL
    function get_transmittal($receipt_id) 
    {
        # FILTER TRANSMITTED
        $transmit = "and IS_TRANSMITTED = 'Y'";    
        
        # FILTER NOT YET RECEIVE
        $receive = "and IS_RECEIVED is null"; 
        
        # RELACE DUSH TO COMMA DUE TO ERROR IN URL
        $receipt_id = str_replace('-',',',$receipt_id);  
        
        $query_get_encode = "
            select 
                CASH_RECEIPT_ID,RECEIPT_NUMBER,RECEIPT_DATE,ACCOUNT_NUMBER,ACCOUNT_NAME,
                RECEIPT_METHOD_ID,NAME,tbl_export.ORG_ID,AMOUNT,USER_ID,USER_NAME,GL_DATE,TIN,
                BIR_REG_NAME,ATC_CODE,TAX_BASE,IS_TRANSMITTED,TRANSMITTED_DATE,
                IS_RECEIVED,RECEIVED_DATE,ORA_CREATION_DATE,SAWT_EXTRACT_DATE,
                IS_BIR_POSTED,BIR_POSTED_DATE,FXF1,FXF2,FXF3,FXF4,FXF5,
                GL_DATE_SAWT,COMP_SHORT
            from 
                tbl_export
            left join
                tbl_company on tbl_company.org_id = tbl_export.ORG_ID
            where
                CASH_RECEIPT_ID in ({$receipt_id})
                {$transmit}
                {$receive} 
            order by
                ACCOUNT_NUMBER,ACCOUNT_NAME,RECEIPT_NUMBER,RECEIPT_DATE
                
        ";
        $query = $this->db->query($query_get_encode);
        return $query->result();
    } 
    
    #########################( FOR MULTIPLE MODULE )#########################
    
    # EDIT EXPORT ID    
    function edit_export_list_id($data,$receipt_id){
        $this->db->update("tbl_export", $data, "CASH_RECEIPT_ID in ({$receipt_id})");
    }
    
    #########################( RECEIVE )#########################
    
    # GET ENCODE
    function get_receive($oracle_username,$org_id) 
    {
        # FILTER TRANSMITTED
        $transmit = "IS_TRANSMITTED = 'Y'";    
        
        # FILTER NOT YET RECEIVE
        $receive = "and IS_RECEIVED is null";   
        
        # FILTER COMPANY
        if($org_id == 0){
            $company = "";    
        }
        else{
            $company = "and ORG_ID = {$org_id}";    
        }  
        
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
                {$transmit}
                {$receive} 
                {$company}
            order by
                ACCOUNT_NUMBER,ACCOUNT_NAME,RECEIPT_NUMBER,RECEIPT_DATE
                
        ";
        $query = $this->db->query($query_get_encode);
        return $query->result();
    }  
    
    #########################( RECEIVE EDIT )######################### 
    
    function get_received($org_id)
    {
        # FILTER TRANSMITTED
        $transmit = "IS_TRANSMITTED = 'Y'";    
        
        # FILTER RECEIVED
        $receive = "and IS_RECEIVED = 'Y'";  
        
        # FILTER NOT YET POSTED
        $posted = "and IS_BIR_POSTED is null"; 
        
        # FILTER COMPANY
        if($org_id == 0){
            $company = "";    
        }
        else{
            $company = "and ORG_ID = {$org_id}";    
        }   
        
        $query_get_encode = "
            select 
                DENSE_RANK() 
                OVER (ORDER BY CASH_RECEIPT_ID) AS NUMBER,
                CASH_RECEIPT_ID,RECEIPT_NUMBER,RECEIPT_DATE,ACCOUNT_NUMBER,ACCOUNT_NAME,
                RECEIPT_METHOD_ID,NAME,ORG_ID,AMOUNT,USER_ID,USER_NAME,GL_DATE,TIN,
                BIR_REG_NAME,ATC_CODE,TAX_BASE,IS_TRANSMITTED,TRANSMITTED_DATE,
                IS_RECEIVED,RECEIVED_DATE,ORA_CREATION_DATE,SAWT_EXTRACT_DATE,
                IS_BIR_POSTED,BIR_POSTED_DATE,FXF1,FXF2,FXF3,FXF4,FXF5,
                GL_DATE_SAWT
            from 
                tbl_export
            where
                {$transmit}
                {$receive} 
                {$posted}
                {$company}
        ";
        $query = $this->db->query($query_get_encode);
        return $query->result();
    }      
    
    #########################( POST )#########################
    
    # GET POST
    function get_post($oracle_username,$org_id)
    {
        # FILTER TRANSMITTED
        $transmit = "IS_TRANSMITTED = 'Y'";    
        
        # FILTER RECEIVED
        $receive = "and IS_RECEIVED = 'Y'"; 
        
        # FILTER NOT YET POSTED
        //$posted = "and IS_BIR_POSTED is null"; # COMMENT DUE TO MULTIPLE CREATION OF FILE 
        $posted = "";
        
        # FILTER COMPANY
        if($org_id == 0){
            $company = "";    
        }
        else{
            # MERGE JUNIOR AND PPCI
            if($org_id == 87 || $org_id == 85){
                $company = "and ORG_ID in (87,85)";    
            } 
            else{
                $company = "and ORG_ID = {$org_id}"; 
            }     
        }  
        
        $query_get_post = "
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
                {$transmit}
                {$receive}
                {$posted}
                {$company} 
            order by
                ACCOUNT_NUMBER,ACCOUNT_NAME,RECEIPT_NUMBER,RECEIPT_DATE
                
        ";
        $query = $this->db->query($query_get_post);
        return $query->result();
    }
    
    # POST QUARTER ID  
    
    function get_quarter($post_quarter_id)
    {
        $query_get_quarter = "
            select 
                label_id,label_name,date_from,date_to,label_year,label_number
            from 
                tbl_quarter
            where 
                label_id = {$post_quarter_id}   
        ";
        return $query = $this->db->query($query_get_quarter);
    }  
     
    function edit_export_quarter_id($org_id,$post_quarter_id,$current_date,$user_name){
        
        $result_quarter = $this->get_quarter($post_quarter_id);
        if ($result_quarter->num_rows() > 0){
           $row = $result_quarter->row();
        }
        else{
           $row = "0"; 
        } 
        
        # MERGE JUNIOR AND PPCI
        if($org_id == 87 || $org_id == 85){
            $post_company_id = "87,85";    
        } 
        else{
            $post_company_id = $org_id;
        } 
        
        $sql = "
            update 
                tbl_export
            set 
                IS_BIR_POSTED = 'Y',
                BIR_POSTED_DATE = '{$current_date}',
                BIR_POSTED_BY = '{$user_name}',
                SAWT_EXTRACT_DATE = '{$current_date}'
            where 
                IS_TRANSMITTED = 'Y'
                and IS_RECEIVED = 'Y'
                and GL_DATE_SAWT between '{$row->date_from}' and '{$row->date_to}'
                and ORG_ID in ({$post_company_id})
        ";
            
        return $query = $this->db->query($sql);
    }
    
    function posted_export_textfile($org_id,$post_quarter_id,$current_date,$user_name){
        
        $result_quarter = $this->get_quarter($post_quarter_id);
        if ($result_quarter->num_rows() > 0){
           $row = $result_quarter->row();
        }
        else{
           $row = "0"; 
        } 
        
        # MERGE JUNIOR AND PPCI
        if($org_id == 87 || $org_id == 85){
            $post_company_id = "87,85";    
        } 
        else{
            $post_company_id = $org_id;
        } 
        
        # GET CURRENT DATE
        $result_current_date_time = $this->get_process_ho->get_server_current_date_time();
        if ($result_current_date_time->num_rows() > 0){
           $row2 = $result_current_date_time->row();
           $current_time = substr($row2->current_date_time,0,10);
        }
        else{
           $row2 = "0"; 
        }     
        
        $sql = "
            select 
                'DSAWT' as FIRST_COLUMN, -- 1ST
                'D1702Q' as SECOND_COLUMN, -- 2ND
                DENSE_RANK() OVER (ORDER BY TIN) AS THIRD_COLUMN, -- 3RD
                TIN, -- 4TH
                '00000' AS FIFTH_COLUMN, -- 5TH
                BIR_REG_NAME, -- 6TH
                ATC_CODE, --8TH
                '1.00' as TAX_PERCENT,
                sum(AMOUNT) as AMOUNT,
                sum(TAX_BASE) as TAX_BASE
            from
                tbl_export
            where 
                IS_TRANSMITTED = 'Y'
                and IS_RECEIVED = 'Y'
                and IS_BIR_POSTED = 'Y'    
                and GL_DATE_SAWT between '{$row->date_from}' and '{$row->date_to}'
                and CONVERT(char(10), BIR_POSTED_DATE,126) = '{$current_time}'
            group by
                TIN,
                BIR_REG_NAME,
                ATC_CODE
            order by 
                TIN,
                BIR_REG_NAME,
                ATC_CODE
        ";
            
        $query = $this->db->query($sql);
        return $query->result();
    }
    
}
