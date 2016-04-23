<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_db extends CI_Model {

    # GET CRM DATA
	function get_crm_data($arr)
	{
        $date_from = $arr['datepicker_from'];
        $date_to = $arr['datepicker_to'];
        $card_type = $arr['cmb_card_typ'];
        
        if($card_type == 'Perks'){
            $db_crm = "MatrixCRM_Puregold";
            $db_data_eight = "Perks";
        }
        else if($card_type == 'Tnap'){
            $db_crm = "MatrixCRM_TNAP";  
            $db_data_eight = "TNAP";  
        }
        else{
            $db_crm = "";
            $db_data_eight = "";
        }
        
        $dateProcessCheckRange = strtotime($date_from);
        $dateProcessCheckRange2 = strtotime($date_to);

        $min_date = min($dateProcessCheckRange, $dateProcessCheckRange2);
        $max_date = max($dateProcessCheckRange, $dateProcessCheckRange2);
        $i = 0;
        
        while (($min_date = strtotime("+1 day", $min_date)) <= $max_date) {
            $i++;
        }
        
        $dateProcessStart = $date_from;
        
        $turnOnAnsiNulls = "SET ANSI_NULLS ON";
        $turnOnAnsiWarn = "SET ANSI_WARNINGS ON";
        
        $delete_all = "
            truncate 
            table data8vscrm_tb_crm 
        ";
        if($this->db->query($delete_all)){
            for($x=0;$x<=$i;$x++){
                $checkDateProcess = date("dmy", strtotime("$dateProcessStart +{$x} day", time()));
                
                $delete_per_date = "
                    delete 
                    from 
                        data8vscrm_tb_crm 
                    where 
                        RECEIPT_NO like '%$checkDateProcess'
                ";
                
                if($this->db->query($delete_per_date)){
                    
                    $data = "
                        insert into
                            data8vscrm_tb_crm(RECEIPT_NO,OUTLET_CODE,CARD_NO,AMOUNT_SPENT)
                        select
                            ReceiptNo,Outlet_Code,CardNo,AmountSpent 
                        from openquery([192.168.200.142],'
                            select 
                                * 
                            from 
                                {$db_crm}.dbo.transact 
                            where 
                                ReceiptNo like ''%$checkDateProcess''
                            ')
                    ";
                    $this->db->query($turnOnAnsiNulls);
                    $this->db->query($turnOnAnsiWarn);
                    $this->db->query($data);    
                }
                else
                {
                    echo "Error delete per date!";
                }
            }    
        }
        else
        {
            echo "Error delete all!";
        }  
	}
    
    # GET DATA EIGHT
    function get_data_eight($arr)
    {
        $date_from = $arr['datepicker_from'];
        $date_to = $arr['datepicker_to'];
        $card_type = $arr['cmb_card_typ'];
        
        if($card_type == 'Perks'){
            $db_crm = "MatrixCRM_Puregold";
            $db_data_eight = "Perks";
        }
        else if($card_type == 'Tnap'){
            $db_crm = "MatrixCRM_TNAP";  
            $db_data_eight = "TNAP";  
        }
        else{
            $db_crm = "";
            $db_data_eight = "";
        }
        
        $dateProcessCheckRange = strtotime($date_from);
        $dateProcessCheckRange2 = strtotime($date_to);

        $min_date = min($dateProcessCheckRange, $dateProcessCheckRange2);
        $max_date = max($dateProcessCheckRange, $dateProcessCheckRange2);
        $i = 0;
        
        while (($min_date = strtotime("+1 day", $min_date)) <= $max_date) {
            $i++;
        }
        
        $dateProcessStart = $date_from;
        
        $turnOnAnsiNulls = "SET ANSI_NULLS ON";
        $turnOnAnsiWarn = "SET ANSI_WARNINGS ON";
        
        $delete_all = "
            truncate 
            table data8vscrm_tb_data_eight 
        ";
        if($this->db->query($delete_all)){
            for($x=0;$x<=$i;$x++){
                $checkDateProcess = date("dmy", strtotime("$dateProcessStart +{$x} day", time()));
                
                $delete_per_date = "
                    delete 
                    from 
                        data8vscrm_tb_data_eight 
                    where 
                        RECEIPT_NO like '%$checkDateProcess'
                ";
                
                if($this->db->query($delete_per_date)){
                    
                    $data = "
                        INSERT INTO 
                            data8vscrm_tb_data_eight(RECEIPT_NO,RECEIPT_NO_DATE)
                        SELECT     
                            TOP 100 PERCENT
                            receiptNo, 
                            SUBSTRING(receiptNo, 12, 6) AS receiptNoDate
                        FROM            
                            {$db_data_eight}.dbo.tblTransHdr
                        WHERE 
                            receiptNo LIKE '%$checkDateProcess'
                            AND (NOT (receiptNo IS NULL))
                        GROUP BY 
                            receiptNo, 
                            SUBSTRING(receiptNo, 12, 6)
                    ";
                    $this->db->query($turnOnAnsiNulls);
                    $this->db->query($turnOnAnsiWarn);
                    $this->db->query($data);    
                }
                else
                {
                    echo "Error delete per date!";
                }
            }    
        }
        else
        {
            echo "Error delete all!";
        }  
    }
    
    # CREATE CSV DATA
    function get_csv_data($arr)    
    {
        # DATE RANGE
        $date_from = date('mdy',strtotime($arr['datepicker_from']));
        $date_to = date('mdy',strtotime($arr['datepicker_to']));
        
        # TYPE OF CARD
        $card_type = $arr['cmb_card_typ'];
        
        if($card_type == 'Perks'){
            $db_crm = "MatrixCRM_Puregold";
            $db_data_eight = "Perks";
        }
        else if($card_type == 'Tnap'){
            $db_crm = "MatrixCRM_TNAP";  
            $db_data_eight = "TNAP";  
        }
        else{
            $db_crm = "";
            $db_data_eight = "";
        }
        
        #FILE INFO
        $fileExt = ".CSV";
        $filename = $db_data_eight."CRM_VS_DATAEIGHT_".$date_from."_".$date_to.$fileExt;
        //$fileDesti = "C:\wamp\\www\\Data8VsCRM\\export_files\\";
        $fileDesti = "C:\\Data8VsCRM_Exportedfile\\";
        
        $data = "
            EXECUTE master.dbo.xp_cmdshell  'bcp \"SELECT * FROM perks.dbo.data8vscrm_view_csv \"  queryout $fileDesti$filename -t -c  -Uwil -Ppw@123456 -Swin-crmrep-db\\MSSQLSERVER_BI'
        ";  

        $this->db->query($data);       
    }
    
    # CREATE XLS DATA
    function get_xls_data($arr)    
    {
        # DATE RANGE
        $date_from = date('mdy',strtotime($arr['datepicker_from']));
        $date_to = date('mdy',strtotime($arr['datepicker_to']));
        
        # TYPE OF CARD
        $card_type = $arr['cmb_card_typ'];
        
        if($card_type == 'Perks'){
            $db_crm = "MatrixCRM_Puregold";
            $db_data_eight = "Perks";
        }
        else if($card_type == 'Tnap'){
            $db_crm = "MatrixCRM_TNAP";  
            $db_data_eight = "TNAP";  
        }
        else{
            $db_crm = "";
            $db_data_eight = "";
        }
        
        #FILE INFO
        $fileExt = ".xls";
        $filename = $db_data_eight."CRM_VS_DATAEIGHT_".$date_from."_".$date_to.$fileExt;
        //$fileDesti = "C:\wamp\\www\\Data8VsCRM\\export_files\\";
        $fileDesti = "C:\\Data8VsCRM_Exportedfile\\";
        
        $data = "
            SELECT 
                RECEIPT_NO,STORE,REG,TRX,TRXDATE
            FROM 
                Perks.dbo.data8vscrm_view
        ";   
        return $this->db->query($data);       
    }
    
    # DROP DOWN MENU
    
    function DropDownMenu($arrRes,$id,$selected='',$attr){
        echo "<select id=\"$id\" name=\"$id\" $attr>\n";
            foreach ((array)$arrRes as $index => $value){
                echo "<option value=\"$index\" ";
                if($index == $selected){
                    
                    echo "selected=\"selected\">\n";
                }
                else{
                    echo " >\n";
                }
                    echo ucwords(strtoupper($value))."\n";
                echo "</option>\n";
            }
        echo "</select>\n";
    }
	
	function insert1($data){
		$this->db->insert("tb_ciintro", $data);
	}
	
	function insert2($data){
		$this->db->insert_batch("tb_ciintro", $data);
	}
	
	function update1($data){
		$this->db->update("tb_ciintro", $data, "id = 1");
	}
	
	function update2($data){
		$this->db->update_batch("tb_ciintro", $data, "id");
	}
    
    function delete1($data){
        $this->db->delete("tb_ciintro", $data);
    }
}
