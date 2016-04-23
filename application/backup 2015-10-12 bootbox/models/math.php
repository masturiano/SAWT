<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Math extends CI_Model {

	public function add($var1, $var2)
	{
		return $var1 + $var2;
	}
	
	public function sub($var1, $var2)
	{
		return $var1 - $var2;
	}
	
    /*
	public function query()
	{
		$query = $this->db->query("
		SELECT fname,lname FROM tb_ciintro
		");
		
		foreach ($query->result() as $row)
		{
		    echo $row->fname;
		    echo $row->lname;
		}
		//echo 'Total Results: ' . $query->num_rows(); 
		return $this->db->last_query($query);
	}
    */
}

