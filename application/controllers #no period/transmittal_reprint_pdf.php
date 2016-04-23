<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Transmittal_Reprint_Pdf extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->library('pdf'); // Load library
        $this->pdf->fontpath = 'font/'; // Specify font folder
        $this->load->model('get_report');
    }
    
    public function index($transmittal_number)
    {
        $arr = $this->get_report->get_transmittal($transmittal_number);   
        
        $this->pdf->AliasNbPages();
        $this->pdf->AddPage();
        
        # HEADER
        $this->pdf->SetFont('Arial','',12);
        $this->pdf->Cell(0,5,'Puregold Price Club Inc.',0,1,'C');
        $this->pdf->Cell(0,5,'Bldg. 1, Tabacalera Compound, No. 900 D. Romualdez St. Paco Manila',0,1,'C');
        $this->pdf->Cell(0,5,'',0,1,'C');
        $this->pdf->SetFont('Arial','B',12);
        $this->pdf->Cell(0,5,'TRANSMITTAL',0,1,'C');
        $this->pdf->Cell(0,5,'',0,1,'C');    
        
        # BODY 
        // TABLE HEADER
        $this->pdf->SetFont('Arial','B',8); // SET FONT
        $this->pdf->Cell(30,6,'RECEIPT NUMBER','BTLR',0,'C');
        $this->pdf->Cell(30,6,'RECEIPT DATE','BTLR',0,'C');
        $this->pdf->Cell(30,6,'ACCOUNT NUMBER','BTLR',0,'C');
        $this->pdf->Cell(50,6,'ACCOUNT_NAME','BTLR',0,'C');
        $this->pdf->Cell(15,6,'ORG ID','BTLR',0,'C');
        $this->pdf->Cell(30,6,'AMOUNT','BTLR',0,'C');
        $this->pdf->Cell(20,6,'TIN','BTLR',0,'C');
        $this->pdf->Cell(50,6,'BIR_REG_NAME','BTLR',0,'C');
        $this->pdf->Cell(20,6,'ATC_CODE','BTLR',0,'C');
        $this->pdf->Cell(30,6,'TAX_BASE','BTLR',0,'C');
        $this->pdf->Cell(30,6,'GL_DATE_SAWT','BTLR',1,'C');
            
        $this->pdf->SetFont('Arial','',8); // SET FONT
        // TABLE DETAILS
        foreach($arr as $val) {
            $this->pdf->Cell(30,6,$val->RECEIPT_NUMBER,'BTLR',0,'L');
            $this->pdf->Cell(30,6,date('Y-m-d',strtotime($val->RECEIPT_DATE)),'BTLR',0,'C');
            $this->pdf->Cell(30,6,$val->ACCOUNT_NUMBER,'BTLR',0,'L');
            $this->pdf->Cell(50,6,substr($val->ACCOUNT_NAME,0,30),'BTLR',0,'L');
            $this->pdf->Cell(15,6,$val->COMP_SHORT,'BTLR',0,'L');
            $this->pdf->Cell(30,6,$val->AMOUNT,'BTLR',0,'R');
            $this->pdf->Cell(20,6,$val->TIN,'BTLR',0,'L');
            $this->pdf->Cell(50,6,substr($val->BIR_REG_NAME,0,30),'BTLR',0,'L');
            $this->pdf->Cell(20,6,$val->ATC_CODE,'BTLR',0,'L');
            $this->pdf->Cell(30,6,$val->TAX_BASE,'BTLR',0,'R');
            $this->pdf->Cell(30,6,date('Y-m-d',strtotime($val->GL_DATE_SAWT)),'BTLR',1,'C');
        } 
        # FOOTER
        $curr_date = $this->get_report->get_server_current_date_time();
        
        if ($curr_date->num_rows() > 0){
           $current_date = $curr_date->row();
        }
        else{
           $current_date = "0"; 
        }
        
        $this->pdf->Cell(0,5,'',0,1,'L');
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->Cell(30,5,'Transmittal Number:',0,0,'C');
        $this->pdf->Cell(53,5,$val->TRANSMITTAL_NUMBER,0,1,'C');
        $this->pdf->Cell(25,5,'Transmittal Date:',0,0,'C');
        $this->pdf->Cell(52,5,date('F d, Y h:i:s',strtotime($val->TRANSMITTED_DATE)),0,1,'C');
        $this->pdf->Cell(18,5,'Date printed:',0,0,'C');
        $this->pdf->Cell(52,5,date('F d, Y h:i:s',strtotime($current_date->current_date_time)),0,1,'C');
        $this->pdf->Cell(15,5,'Printed by:',0,0,'C');
        $this->pdf->Cell(30,5,$this->session->userdata('fullName'),0,1,'C');
        $this->pdf->Cell(0,5,'',0,1,'C');     
          
        # FPDF FUNCTION
        $this->pdf->Output('SAWT_Transmittal.pdf','D');     
    }  
}   
?>  