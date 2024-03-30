<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }

        $this->load->model('core_model');
        $this->load->model('home_model');
        $this->load->model('estacionar_model');

        date_default_timezone_set('America/Sao_Paulo');
    }

    public function index() {

        $data = array(
            'titulo' => 'Home',
            'sub_titulo' => 'Seja muito bem vindo(a) ao Park Now.',
            'icone' => 'fas fa-home bg-blue',
            'styles' => array(
                'dist/css/home.css'
            ),
            'scripts' => array(
                'dist/js/util.js',
            ),
            'veiculos_estacionados' => $this->estacionar_model->get_all(),
            'numero_vagas_pequeno' => $this->estacionar_model->get_numero_vagas(1), // 1 = Carro pequeno
            'vagas_ocupadas_pequeno' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 1)),
            'numero_vagas_medio' => $this->estacionar_model->get_numero_vagas(1003), // 1003 = Carro Médio
            'vagas_ocupadas_medio' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 1003)),
            'numero_vagas_grande' => $this->estacionar_model->get_numero_vagas(1004), // 1004 = Carro grande
            'vagas_ocupadas_grande' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 1004)),
            'numero_vagas_moto' => $this->estacionar_model->get_numero_vagas(1005), // 1005 = Carro grande
            'vagas_ocupadas_moto' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 1005)),


            'numero_total_vagas' => $this->home_model->get_total_vagas(),


            'total_mensalidades' => $this->home_model->get_total_receber(),
            'total_mensalidades_receber' => $this->home_model->count_all('mensalidades', array('mensalidade_status' => 0)),
            'total_mensalidades_pagas' => $this->home_model->count_all('mensalidades', array('mensalidade_status' => 1)),

            'total_avulsos' => $this->home_model->get_total_avulsos(),
            'total_avulsos_pagos' => $this->home_model->count_all('estacionar', array('estacionar_status' => 1)),
            'total_avulsos_abertos' => $this->home_model->count_all('estacionar', array('estacionar_status' => 0)),


            'total_estacionados_agora' => $this->home_model->count_all('estacionar', array('estacionar_status' => 0)),

            'numero_total_mensalistas' => $this->home_model->count_all('mensalistas'),

            'mensalistas_ativos' => $this->home_model->count_all('mensalistas', array('mensalista_ativo' => 1)),
            'mensalistas_inativos' => $this->home_model->count_all('mensalistas', array('mensalista_ativo' => 0)),
        );

        $contador = 0;

        if ($this->home_model->get_mensalidades_vencidas()) {
            $data['mensalidades_vencidas'] = TRUE; //Setando a variável
            $contador++;
        }

        if ($this->core_model->get_by_id('precificacoes', array('precificacao_ativa' => 0))) {
            $data['precificacoes_desativadas'] = TRUE; //Setando a variável
            $contador++;
        }

        if ($contador > 0) {
            $data['contador'] = $contador;
        }

        $this->load->view('layout/header', $data);
        $this->load->view('index');
        $this->load->view('layout/footer');
    }
}
