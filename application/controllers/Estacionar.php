<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estacionar extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }

        $this->load->model('estacionar_model');
        $this->load->model('core_model');
    }

    public function index() {

        // if (!$this->ion_auth->is_admin()) {
        //     $this->session->set_flashdata('info', 'Você não tem permissão para acessar esse menu');
        //     redirect('home');
        // }

        $data = array(
            'titulo' => 'Estacionar',
            'sub_titulo' => 'Listando todos os tickets de estacionamento cadastrados',
            'icone' => 'fas fa-parking bg-blue',
            'styles' => array(
                'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css'
            ),
            'scripts' => array(
                'plugins/datatables.net/js/jquery.dataTables.min.js',
                'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
                'plugins/datatables.net-responsive/js/dataTables.responsive.min.js',
                'plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js',
                'plugins/datatables.net/js/estacionamento.js',
            ),
            'veiculos_estacionados' => $this->estacionar_model->get_all(),
            'numero_vagas_pequeno' => $this->estacionar_model->get_numero_vagas(1), // 1 = Carro pequeno
            'vagas_ocupadas_pequeno' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 1)),
            'numero_vagas_medio' => $this->estacionar_model->get_numero_vagas(2), // 2 = Carro Médio
            'vagas_ocupadas_medio' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 2)),
            'numero_vagas_grande' => $this->estacionar_model->get_numero_vagas(3), // 3 = Carro grande
            'vagas_ocupadas_grande' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 3)),
        );

        $this->load->view('layout/header', $data);
        $this->load->view('estacionar/index');
        $this->load->view('layout/footer');
    }
}