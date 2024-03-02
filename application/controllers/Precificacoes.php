<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Precificacoes extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }

        $this->load->model('core_model');

        date_default_timezone_set('America/Sao_Paulo');
    }

    public function index(){

        $data = array (
            'titulo'        => 'Precificações cadastradas',
            'sub_titulo'    => 'Listando as precificações cadastradas',
            'icone'         =>  'fas fa-dollar-sign bg-blue',
            'usuarios'      => $this->ion_auth->users()->result(),
            'styles'        => array(
                'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
            ),
            'scripts'       => array(
                'plugins/datatables.net/js/jquery.dataTables.min.js',
                'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
                'plugins/datatables.net/js/estacionamento.js',
            ),
            'precificacoes' => $this->core_model->get_all('precificacoes'),
        );

        // echo '<pre>';
        // echo print_r($data['usuarios']);
        // exit();

        $this->load->view('layout/header', $data);
        $this->load->view('precificacoes/index');
        $this->load->view('layout/footer');
        
    }

}