<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls acount registration on the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */

class Register extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		#Use the query cache if its enabled
		$this->load->model('person');
	}
	
	
	#The first step form for the registration process
	public function step_one()
	{
		$data = filter_forwarded_data($this);
		
		# The user posted the form
		if(!empty($_POST))
		{
			#Pass these details to the person object to handle with XSS filter turned on
			$data['result'] = $this->person->add_profile($this->input->post(NULL, TRUE));
			$data['msg'] = $data['result']['boolean'] && empty($data['result']['msg'])? "Please check your email for a confirmation code to proceed.": $data['result']['msg'];
		}
		
		$viewToLoad = !empty($data['result']['boolean']) && $data['result']['boolean']? 'register/step_two': 'register/step_one';
		$this->load->view($viewToLoad, $data); 
	}
	
	
	#The second step form for the registration process
	public function step_two()
	{
		$data = filter_forwarded_data($this);
		
		# The user posted the form
		if(!empty($_POST))
		{
			#Pass these details to the person object to handle with XSS filter turned on
			if($this->native_session->get('person_id'))
			{
				$data['result'] = $this->person->add_id_and_contacts($this->native_session->get('person_id'), $this->input->post(NULL, TRUE));
				$data['msg'] = $data['result']['boolean'] && empty($data['result']['msg'])? "Please enter your education and qualifications to proceed.": $data['result']['msg'];
			} 
			else 
			{
				$data['msg'] = "ERROR: We could not verify your data. Your session may have expired. If this problem persists, please contact us.";
			}
		}
		
		if(!empty($data['result']['boolean']) && $data['result']['boolean'])
		{
			$data['msg'] = $this->input->post('justsaving')? "Your application had been saved. <br>You will need to login using the details sent to your email to proceed with your application.": $data['msg'];
			$viewToLoad = $this->input->post('justsaving')? 'account/login': 'register/step_three'; 
		}
		else
		{
			$viewToLoad = 'register/step_two';
		}
		
		$this->load->view($viewToLoad, $data); 
	}
	
}

/* End of controller file */