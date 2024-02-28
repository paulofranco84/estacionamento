<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sistema extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }

        $this->load->model('core_model');
    }

    public function index()
    {

        $data = array(
            'titulo' => 'Sistema',
            'sub_titulo' => 'Atualizando as informações do sistema',
            'icone' => 'ik-settings',
            'scripts' => array(
                'js/Mask/jquery.mask.min.js',
                'js/Mask/custom.js',
            ),
            'sistema' => $this->core_model->get_by_id('sistema', array('sistema_id' => 1)),
        );


        //        echo '<pre>';
        //        print_r($data['sistema']);
        //        exit();


        $this->form_validation->set_rules('sistema_razao_social', '', 'required|min_length[10]|max_length[145]');
        $this->form_validation->set_rules('sistema_nome_fantasia', '', 'required|min_length[5]|max_length[145]');
        $this->form_validation->set_rules('sistema_cnpj', 'CNPJ', 'required|exact_length[18]|callback_valida_cnpj');
        $this->form_validation->set_rules('sistema_ie', 'I.E.', 'required|exact_length[12]');
        $this->form_validation->set_rules('sistema_telefone_fixo', '', 'required|exact_length[14]');
        $this->form_validation->set_rules('sistema_telefone_movel', '', 'required|exact_length[14]');
        $this->form_validation->set_rules('sistema_cep', 'CEP', 'required|exact_length[9]');
        $this->form_validation->set_rules('sistema_endereco', '', 'required|min_length[10]|max_length[145]');
        $this->form_validation->set_rules('sistema_cidade', '', 'required|min_length[4]|max_length[45]');
        $this->form_validation->set_rules('sistema_estado', 'UF', 'required|exact_length[2]');
        $this->form_validation->set_rules('sistema_email', '', 'required|valid_email');
        $this->form_validation->set_rules('sistema_site_url', 'URL', 'required|min_length[10]|max_length[100]');
        //        $this->form_validation->set_rules('sistema_num_vagas_pequeno', '', 'required|greater_than[0]|integer');
        //        $this->form_validation->set_rules('sistema_num_vagas_grande', '', 'required|greater_than[0]|integer');


        $this->form_validation->set_rules('sistema_txt_ordem_servico', '', 'required');



        if ($this->form_validation->run()) {

            $data = elements(
                array(
                    'sistema_razao_social',
                    'sistema_nome_fantasia',
                    'sistema_cnpj',
                    'sistema_ie',
                    'sistema_telefone_fixo',
                    'sistema_telefone_movel',
                    'sistema_cep',
                    'sistema_endereco',
                    'sistema_cidade',
                    'sistema_estado',
                    'sistema_email',
                    'sistema_site_url',
                    //                'sistema_num_vagas_pequeno',
                    //                'sistema_num_vagas_grande',
                    'sistema_txt_ordem_servico',
                ),
                $this->input->post()
            );

            //$data = $this->security->xss_clean($data);


            $this->core_model->update('sistema', $data, array('sistema_id' => 1));

            redirect('sistema');
        } else {

            /* Erro de validações form_validation */
            $this->load->view('layout/header', $data);
            $this->load->view('sistema/index');
            $this->load->view('layout/footer');
        }
    }
}
