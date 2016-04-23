<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require('fpdf.php');
class Pdf extends FPDF
{
      // Extend FPDF using this class
      // More at fpdf.org -> Tutorials
      # SIZES A3 A4 A5 Letter Legal
      /*
        $mpdf = new mPDF('',    // mode - default ''
         '',    // format - A4, for example, default ''
         0,     // font size - default 0
         '',    // default font family
         15,    // margin_left
         15,    // margin right
         16,     // margin top
         16,    // margin bottom
         9,     // margin header
         9,     // margin footer
         'L');  // L - landscape, P - portrait
      */
    function __construct($orientation='L', $unit='mm', $size='Legal')
    {
        // Call parent constructor
        parent::__construct($orientation,$unit,$size);
    }
    function Footer() {
        // SHOW PAGES
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,1,'C');  
    }
}
?>