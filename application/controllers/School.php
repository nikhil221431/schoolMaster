<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/school
	 *	- or -
	 * 		http://example.com/index.php/school/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/school/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function __construct() {
        parent::__construct();
        $this->load->helper('url', 'form');
        $this->load->library('form_validation');

		$this->load->model('school_model');

		$this->validateLogin();
    }

	public function index()
	{
		redirect("School/schoolinfo");
	}

	public function validateLogin(){

		$this->load->model('validate_model');
		$result = $this->validate_model->validate();
		
		if($result->output == "FALSE"){

			redirect("login");
		}
	}

	public function schoolinfo(){

		$name = "";

		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			$name = $this->input->post('schoolname');
		};

		$data['fname'] = $name;
		$data['schollinfo'] = $this->school_model->schoolinfo($name);

		$this->load->view('header');
		$this->load->view('schoolinfo', $data);
		$this->load->view('footer');
	}

	public function createschool(){

		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			//this is CI form validations
			$this->form_validation->set_rules('schoolname','School Name','trim|required|max_length[30]');
			$this->form_validation->set_rules('location','Location','trim|required');

			if($this->form_validation->run() == FALSE){

				$this->load->view('header');
				$this->load->view('createschool');
				$this->load->view('footer');
			}
			else {

				$schoolName = $this->input->post('schoolname');
				$schoolLocation = $this->input->post('location');
		
				$result     = $this->school_model->createschoolsave($schoolName, $schoolLocation);
		
				if($result == 1){
		
					redirect('school/schoolinfo');
				}
				else {
		
					$this->load->view('header');
					$this->load->view('createschool');
					$this->load->view('footer');
				}
			}
		} 
		else {

			$this->load->view('header');
			$this->load->view('createschool');
			$this->load->view('footer');
		}

	}

	public function editschoolinfo(){

		if ($this->input->server('REQUEST_METHOD') === 'POST') {

			//this is CI form validations
				$this->form_validation->set_rules('schoolname','School Name','trim|required|max_length[30]');
				$this->form_validation->set_rules('location','Location','trim|required');

			$schoolId = $this->input->get_post("for");

			
			if($this->form_validation->run() == FALSE){

				$data['schoolinfo'] = $this->school_model->editschoolinfo($schoolId);
				$this->load->view('header');
				$this->load->view('editschool', $data);
				$this->load->view('footer');
			}
			else {
				
				$schoolName = $this->input->get_post('schoolname');
				$location = $this->input->get_post('location');
		
				$result = $this->school_model->editschoolsave($schoolId, $schoolName, $location);
		
				if($result == 1){
		
					redirect('school/schoolinfo');
				}
				else {
		
					redirect('school/editschoolinfo');
				}
			}
		}
		else {

			$schoolId = $this->input->get_post('for');
			$data['schoolinfo'] = $this->school_model->editschoolinfo($schoolId);
			$this->load->view('header');
			$this->load->view('editschool', $data);
			$this->load->view('footer');
		}

	}

	public function deleteschooldata() {

		$schoolId  = $this->input->get_post("schoolId");
		$result  = $this->school_model->deleteschooldata($schoolId);

		echo json_encode($result);
	}

	public function logoutuser(){

		$this->session->sess_destroy();
		redirect("login");
	}
}
