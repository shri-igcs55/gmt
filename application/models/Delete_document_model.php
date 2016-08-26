<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Delete_document_model extends CI_model
	{
		
	  

 
  function delete_document($input)
  {
  	$ipJson = json_encode($input);
  	
  	//$this->db->from('gmt_transporter_doc'); 
  

  	$this->db->where('trans_doc_id',$input['trans_doc_id']);
    $this->db->delete('gmt_transporter_doc');
  	//$query = $this->db->get();
  	//echo $this->db->last_query();

  	//$details = $query->result();
  //print_r($details);
			//exit();
  	//return $details;
  }  









	}
	


?>