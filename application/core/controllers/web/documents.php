<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls showing user documents.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 041/01/2013
 */
class Documents extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->model('file_upload','libfileobj');
        $this->load->model('sys_file','sysfile');
    }
	
	
	
	
	
	#Function to force download of file
	function force_download()
	{
		$data = filter_forwarded_data($this);
		$folder = !empty($data['f'])?decrypt_value($data['f']): "documents";
		
		if(!empty($data['i'])){
			$document = $this->Query_reader->get_row_as_array('get_document_by_id', array('id'=>decrypt_value($data['i'])) );
		} else {
			$document['documenturl'] = decrypt_value($data['u']);
		}
		
		#only proceed if the file exists
		if(file_exists(UPLOAD_DIRECTORY.$folder."/".$document['documenturl']))
		{
			if(strtolower(strrchr($document['documenturl'],".")) == '.pdf')
			{
				header('Content-disposition: attachment; filename="'.$document['documenturl'].'"');
				header('Content-type: application/pdf');
				readfile(UPLOAD_DIRECTORY.$folder."/".$document['documenturl']);
			}
			if(strtolower(strrchr($document['documenturl'],".")) == '.pdf')
			{
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-Description: File Transfer');
				header('Content-Disposition: attachment; filename="'.strtotime('now').str_replace('.','',get_ip_address()).'.zip"');
				header('Content-Transfer-Encoding: binary');
				header('Vary: Accept-Encoding');
				header('Content-Encoding: gzip');
				header('Keep-Alive: timeout=5, max=100');
				header('Connection: Keep-Alive');
				header('Transfer-Encoding: chunked');
				header('Content-Type: application/octet-stream');
				apache_setenv('no-gzip', '1');

			}
			else
			{
				redirect(base_url()."assets/uploads/".$folder."/".$document['documenturl']);
			}
		}
		else
		{
			$data['msg'] = "<div style='background-color:#FFF; height:300px'>".format_notice("WARNING: The file does not exist.")."
			<br>
			<br>
			<input type='button' name='fileredirect' id='fileredirect' value='&laquo;Previous Page' onclick='javascript: history.go(-1)' class='button'/></div>";
			
			$data['area'] = 'basic_msg';
			$this->load->view('web/addons/basic_addons', $data);
		}
		
	}
	
	
	
	
	
	#Function to upload a file 
	function upload_file()
	{
		$data = filter_forwarded_data($this);
		$this->native_session->set('local_allowed_extensions', array('.csv','.xls','.xlsx'));
		
		#Continue to upload if a file was actually uploaded
		if(!empty($_FILES) && !empty($data['s']))
		{
			$documentUrl = !empty($_FILES[$data['s']]['name'])? $this->sysfile->local_file_upload($_FILES[$data['s']], 'upload_'.strtotime('now'), (!empty($data['f'])? $data['f']: 'documents'), 'filename'): '';
		}
		#format the return message
		$data['msg'] = !empty($documentUrl)? "Document uploaded":"ERROR: Document not uploaded.";
		$data['area'] = 'basic_msg';
		$this->load->view('web/addons/basic_addons', $data);
	}
	
}

/* End of controller file */