<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');    

class unreceive_excel extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        
        # LIBRARY
        $this->load->library('form_validation');
        $this->load->library('session');
        
        # INCLUDE FILE
        ini_set('include_path','C:\wamp\php\PEAR');
        require_once 'Spreadsheet/Excel/Writer.php';
    }
    
    function print_excel($oracle_user_name,$org_id,$date_from,$date_to){	

        $workbook = new Spreadsheet_Excel_Writer(); 
        
        $workbook->setCustomColor(12,226,236,253);
        
        $headerFormat = $workbook->addFormat(array('Size' => 11,
                                      'Color' => 'black',
                                      'bold'=> 1,
                                      'border' => 1,
                                      'Align' => 'merge'));
        $headerFormat->setFontFamily('Calibri'); 
        
        $headerFormat2 = $workbook->addFormat(array('Size' => 11,
                                          'Color' => 'black',
                                          'bold'=> 1,
                                          'border' => 1,
                                          'Align' => 'center'));
        $headerFormat2->setFontFamily('Calibri'); 
        $headerFormat2->setNumFormat('#,##0.00');
    
        $workbook->setCustomColor(13,155,205,255);
        $TotalBorder    = $workbook->addFormat(array('Align' => 'right','bold'=> 1,'border'=>1,'fgColor' => 'white'));
        $TotalBorder->setFontFamily('Calibri'); 
        $TotalBorder->setTop(5); 
        $detailrBorder   = $workbook->addFormat(array('border' =>1,'Align' => 'right'));
        $detailrBorder->setFontFamily('Calibri'); 
        $detailrBorderAlignRight2   = $workbook->addFormat(array('Align' => 'left'));
        $detailrBorderAlignRight2->setFontFamily('Calibri');
        $workbook->setCustomColor(12,183,219,255);
        
        #DETAIL ALIGN LEFT COLOR WHITE 
        $detail_left_color_white   = $workbook->addFormat(array('Size' => 10,
                                              'fgColor' => 'white',
                                              'Pattern' => 1,
                                              'border' =>1,
                                              'Align' => 'left'));
        $detail_left_color_white->setFontFamily('Calibri'); 
        #DETAIL ALIGN LEFT COLOR BLUE 
        $detail_left_color_blue   = $workbook->addFormat(array('Size' => 10,
                                              'border' =>1,
                                              'Pattern' => 1,
                                              'Align' => 'left'));
        $detail_left_color_blue->setFgColor(12); 
        $detail_left_color_blue->setFontFamily('Calibri');
        
        #DETAIL ALIGN CENTER COLOR WHITE 
        $detail_center_color_white   = $workbook->addFormat(array('Size' => 10,
                                              'fgColor' => 'white',
                                              'Pattern' => 1,
                                              'border' =>1,
                                              'Align' => 'center'));
        $detail_center_color_white->setFontFamily('Calibri'); 
        #DETAIL ALIGN CENTER COLOR BLUE 
        $detail_center_color_blue   = $workbook->addFormat(array('Size' => 10,
                                              'border' =>1,
                                              'Pattern' => 1,
                                              'Align' => 'center'));
        $detail_center_color_blue->setFgColor(12); 
        $detail_center_color_blue->setFontFamily('Calibri');
        
        #DETAIL ALIGN RIGHT COLOR WHITE 
        $detail_right_color_white   = $workbook->addFormat(array('Size' => 10,
                                              'fgColor' => 'white',
                                              'Pattern' => 1,
                                              'border' =>1,
                                              'Align' => 'right'));
        $detail_right_color_white->setFontFamily('Calibri'); 
        #DETAIL ALIGN RIGHT COLOR BLUE 
        $detail_right_color_blue   = $workbook->addFormat(array('Size' => 10,
                                              'border' =>1,
                                              'Pattern' => 1,
                                              'Align' => 'right'));
        $detail_right_color_blue->setFgColor(12); 
        $detail_right_color_blue->setFontFamily('Calibri');
        
        #DETAIL ALIGN RIGHT COLOR WHITE WITH NUMBER FORMAT 
        $detail_right_color_white_number   = $workbook->addFormat(array('Size' => 10,
                                              'fgColor' => 'white',
                                              'Pattern' => 1,
                                              'border' =>1,
                                              'Align' => 'right'));
        $detail_right_color_white_number->setFontFamily('Calibri'); 
        $detail_right_color_white_number->setNumFormat('#,##0.00');
        #DETAIL ALIGN RIGHT COLOR BLUE WITH NUMBER FORMAT
        $detail_right_color_blue_number   = $workbook->addFormat(array('Size' => 10,
                                              'border' =>1,
                                              'Pattern' => 1,
                                              'Align' => 'right'));
        $detail_right_color_blue_number->setFgColor(12); 
        $detail_right_color_blue_number->setFontFamily('Calibri');
        $detail_right_color_blue_number->setNumFormat('#,##0.00');
        
        # FILENAME
        $filename = "Unreceive.xls";
        
        # SEND FILENAME
        $workbook->send($filename);
        
        # ADD WORK SHEET OR WORK SHEET LABEL
        $worksheet = &$workbook->addWorksheet('Unreceive');
        
        # SET LANDSCAPE
        $worksheet->setLandscape();
        
        # FREEZE PANE
        //$worksheet->freezePanes(array(3,0));
        
        # MAIN HEADER
        $worksheet->write(0,0,"UNRECEIVE SAWT REPORT",$headerFormat);
        for($i=1;$i<12;$i++) {
            $worksheet->write(0, $i, "",$headerFormat);    
        }
        
        # COLUMN WIDTH
        $worksheet->setColumn(0,0,20);
        $worksheet->setColumn(1,1,15);
        $worksheet->setColumn(2,2,20);
        $worksheet->setColumn(3,3,30);
        $worksheet->setColumn(4,4,10);
        $worksheet->setColumn(5,5,20);
        $worksheet->setColumn(6,6,15);
        $worksheet->setColumn(7,7,30);
        $worksheet->setColumn(8,8,15);
        $worksheet->setColumn(9,9,20);
        $worksheet->setColumn(10,10,15);
        $worksheet->setColumn(10,11,20);
        
        # HEADER
        $worksheet->write(2,0,"RECEIPT NUMBER",$headerFormat);
        $worksheet->write(2,1,"RECEIPT DATE",$headerFormat);
        $worksheet->write(2,2,"ACCOUNT NUMBER",$headerFormat);
        $worksheet->write(2,3,"ACCOUNT NAME",$headerFormat);
        $worksheet->write(2,4,"ORG ID",$headerFormat);
        $worksheet->write(2,5,"AMOUNT",$headerFormat);
        $worksheet->write(2,6,"TIN",$headerFormat);
        $worksheet->write(2,7,"BIR REG NAME",$headerFormat);
        $worksheet->write(2,8,"ATC CODE",$headerFormat);
        $worksheet->write(2,9,"TAX BASE",$headerFormat);
        $worksheet->write(2,10,"GL DATE SAWT",$headerFormat);
        $worksheet->write(2,11,"ORACLE USERNAME",$headerFormat);
        
        # DATABASE
        $this->load->model('get_report'); 
        
        $data = $this->get_report->get_unreceive($oracle_user_name,$org_id,$date_from,$date_to);
        
        # ASSIGN COUNTER ROW
        $ctr = 3; 
        
        #ASSIGN ALTERNATE COLOR
        $col = 0;     
        
        # LOOP DATA
        foreach($data as $row){  
             
            $row_left = ($col==0) ? $detail_left_color_blue:$detail_left_color_white;
            $row_center = ($col==0) ? $detail_center_color_blue:$detail_center_color_white;
            $row_right = ($col==0) ? $detail_right_color_blue:$detail_right_color_white;
            $row_right_number = ($col==0) ? $detail_right_color_blue_number:$detail_right_color_white_number;
            $col = ($col==0) ? 1:0;   
            
            $worksheet->write($ctr,0,$row->RECEIPT_NUMBER,$row_left);
            $worksheet->write($ctr,1,date('Y-m-d',strtotime($row->RECEIPT_DATE)),$row_center);
            $worksheet->write($ctr,2,$row->ACCOUNT_NUMBER,$row_left);
            $worksheet->write($ctr,3,$row->ACCOUNT_NAME,$row_left);     
            $result_company = $this->get_report->get_company($row->ORG_ID); 
            if ($result_company->num_rows() > 0){
               $row_company = $result_company->row();
            }   
            $worksheet->write($ctr,4,$row_company->comp_short,$row_left);
            $worksheet->write($ctr,5,$row->AMOUNT,$row_right_number);
            $worksheet->write($ctr,6," ".$row->TIN,$row_left);
            $worksheet->write($ctr,7,$row->BIR_REG_NAME,$row_left);
            $worksheet->write($ctr,8,$row->ATC_CODE,$row_left);
            $worksheet->write($ctr,9,$row->TAX_BASE,$row_right_number);
            $worksheet->write($ctr,10,date('Y-m-d',strtotime($row->GL_DATE_SAWT)),$row_center);
            $worksheet->write($ctr,11,$row->USER_NAME,$row_left);
           
            $ctr++;
        }  
               
        $data_total = $this->get_report->get_unreceive_total($oracle_user_name,$org_id,$date_from,$date_to);
        if ($data_total->num_rows() > 0){
           $row_total = $data_total->row();
        }  
            
        $worksheet->write($ctr,0,"TOTAL",$headerFormat);             
        $worksheet->write($ctr,5,$row_total->AMOUNT,$headerFormat2);             
        $worksheet->write($ctr,9,$row_total->TAX_BASE,$headerFormat2);             

        # CLOSE WORK BOOK     
        $workbook->close();
    }
}
?>