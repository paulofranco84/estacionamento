<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Formas extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }

        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('warning', 'Você não tem permissão para acessar esse menu');
            redirect('/');
        }

        $this->load->model('core_model');
    }

    public function index() {

        $data = array(
            'titulo' => 'Formas de pagamento',
            'sub_titulo' => 'Listando as formas de pagamento cadastradas',
            'icone' => 'fas fas fa-credit-card bg-blue',
            'formas' => $this->core_model->get_all('formas_pagamentos'),
        );

        $this->load->view('layout/header', $data);
        $this->load->view('formas/index');
        $this->load->view('layout/footer');
    }

    public function core($forma_pagamento_id = NULL) {

        if (!$forma_pagamento_id) {

            //Cadastra

            $this->form_validation->set_rules('forma_pagamento_nome', 'Nome da forma de pagamento', 'required|min_length[3]|max_length[30]|is_unique[formas_pagamentos.forma_pagamento_nome]');

            if ($this->form_validation->run()) {

                $data = elements(
                    array(
                        'forma_pagamento_nome',
                        'forma_pagamento_ativa'
                    ),
                    $this->input->post()
                );

                $data = html_escape($data);

                $this->core_model->insert('formas_pagamentos', $data);

                redirect($this->router->fetch_class());
            } else {

                /* Erro de validação */
                $data = array(
                    'titulo' => 'Cadastrar forma de pagamento',
                    'sub_titulo' => 'Cadastrando uma nova forma de pagamento',
                    'icone' => 'fas fas fa-credit-card bg-blue',
                    'valor_btn' => 'Cadastrar',
                );


                $this->load->view('layout/header', $data);
                $this->load->view('formas/core');
                $this->load->view('layout/footer');
            }
        } else {

            //Atualiza

            if (!$this->core_model->get_by_id('formas_pagamentos', array('forma_pagamento_id' => $forma_pagamento_id))) {

                $this->session->set_flashdata('error', 'Forma de pagamento não encontrada');
                redirect($this->router->fetch_class());
            } else {

                $this->form_validation->set_rules('forma_pagamento_nome', 'Nome', 'required|min_length[3]|max_length[30]|callback_check_forma_pagamento_nome');

                if ($this->form_validation->run()) {


                    $data = elements(
                        array(
                            'forma_pagamento_nome',
                            'forma_pagamento_ativa'
                        ),
                        $this->input->post()
                    );

                    $data = html_escape($data);

                    $this->core_model->update('formas_pagamentos', $data, array('forma_pagamento_id' => $forma_pagamento_id));

                    redirect($this->router->fetch_class());
                } else {

                    /* Erro de validação */
                    $data = array(
                        'titulo' => 'Formas de pagamento',
                        'sub_titulo' => 'Editando a forma de pagamento',
                        'icone' => 'fas fas fa-credit-card bg-blue',
                        'valor_btn' => 'Atualizar',
                        'forma' => $this->core_model->get_by_id('formas_pagamentos', array('forma_pagamento_id' => $forma_pagamento_id)),
                    );


                    $this->load->view('layout/header', $data);
                    $this->load->view('formas/core');
                    $this->load->view('layout/footer');
                }
            }
        }
    }

    public function check_forma_pagamento_nome($forma_pagamento_nome) {

        $forma_pagamento_id = $this->input->post('forma_pagamento_id');

        if ($this->core_model->get_by_id('formas_pagamentos', array('forma_pagamento_nome' => $forma_pagamento_nome, 'forma_pagamento_id !=' => $forma_pagamento_id))) {

            $this->form_validation->set_message('check_forma_pagamento_nome', 'Forma de pagamento já existe!');

            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function del($forma_pagamento_id = NULL) {

        if (!$forma_pagamento_id || !$this->core_model->get_by_id('formas_pagamentos', array('forma_pagamento_id' => $forma_pagamento_id))) {
            $this->session->set_flashdata('error', 'Forma de pagamento não encontrada');
            redirect($this->router->fetch_class());
        } else {
            $this->core_model->delete('formas_pagamentos', array('forma_pagamento_id' => $forma_pagamento_id));
            redirect($this->router->fetch_class());
        }
    }
}
