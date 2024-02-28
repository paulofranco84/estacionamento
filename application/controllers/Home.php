<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }

        date_default_timezone_set('America/Sao_Paulo');
    }

	public function index()
	{
        $data = array (
            'titulo' => 'Home',
        );

        $this->load->view('layout/header', $data);
		$this->load->view('index');
        $this->load->view('layout/footer');
	}

}