<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tsp extends CI_Controller {
	public function __construct()
    {
        parent::__construct();

        $this->load->library('algen_lib');
    }

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function initiation()
	{
	    /*
	    $data['chromosom']     = json_decode($_POST['chromosom']);
	    $data['distance_list'] = json_decode($_POST['distanceList']);
	    $data['duration_list'] = json_decode($_POST['durationList']);
	    */
	    $data['module']		   = 'tsp';	
		$this->load->view('index.php', $data);
	}

	public function calculate()
	{
	    $data['chromosom']     = json_decode($_POST['chromosom']);
	    $data['distance_list'] = json_decode($_POST['distanceList']);
	    $data['duration_list'] = json_decode($_POST['durationList']);
	    $data['dna'] 		   = json_decode($_POST['dna']);
	    $data['module']		   = 'tsp';	
		$this->load->view('index.php', $data);
	}

	public function direction()
	{
	    $data['origin']     = $_GET['origin'];
	    $data['dest'] 		= $_GET['dest'];

	    $data['module']		= 'direction';	
		$this->load->view('index.php', $data);
	}
}
