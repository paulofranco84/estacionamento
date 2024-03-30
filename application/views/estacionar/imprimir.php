<?php $this->load->view('layout/navbar'); ?>

<div class="page-wrap">

    <?php $this->load->view('layout/sidebar'); ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="<?php echo $icone ?>"></i>
                            <div class="d-inline">
                                <h5><?php echo $titulo ?></h5>
                                <span><?php echo $sub_titulo ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a data-toggle="tooltip" data-placement="bottom" title="Home" href="<?php echo base_url('/') ?>"><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $titulo ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row clearfix">

                <div class="col-md-12">

                    <div class="card bg-empty">

                        <div class="card-header d-block text-center">
                            <h5>Escolha a opção desejada:</h5>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col col-md-4 col-6" title="Imprimir ticket">
                                    <div class="widget social-widget">
                                        <div class="widget-body">
                                            <div class="icon"><i class="ik ik-printer ik-2x text-success"></i></div>
                                            <div class="content pt-20">
                                                <a data-toggle="tooltip" data-placement="bottom" title="Imprimir o ticket" target="_blank" class="btn btn-success" href="<?php echo base_url('estacionar/pdf/' . $ordem->estacionar_id); ?>">Imprimir ticket</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col col-md-4 col-6" title="Listar tickets">
                                    <div class="widget social-widget">
                                        <div class="widget-body">
                                            <div class="icon"><i class="ik ik-list ik-2x text-dark"></i></div>
                                            <div class="content pt-20">
                                                <a data-toggle="tooltip" data-placement="bottom" title="Listar os tickets" class="btn btn-dark" href="<?php echo base_url('estacionar'); ?>">Listar tickets</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col col-md-4 col-6" title="Novo ticket">
                                    <div class="widget social-widget">
                                        <div class="widget-body">
                                            <div class="icon"><i class="ik ik-file-plus ik-2x text-primary"></i></div>
                                            <div class="content pt-20">
                                                <a data-toggle="tooltip" data-placement="bottom" title="Cadastrar novo ticket" class="btn btn-primary" href="<?php echo base_url('estacionar/core/'); ?>">Cadastrar ticket</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>