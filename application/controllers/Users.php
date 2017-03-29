<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function index()
	{
		$this->inputDestination();
	}

	public function inputDestination()
	{
		$data['module'] = 'inputdestination';
		$this->load->view('index.php', $data);
	}
}
