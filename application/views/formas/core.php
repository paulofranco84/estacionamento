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
                                <li class="breadcrumb-item">
                                    <a data-toggle="tooltip" data-placement="bottom" title="Listar <?php echo $this->router->fetch_class() ?>" href="<?php echo base_url('/' . $this->router->fetch_class()) ?>">Listar Formas de Pagamento</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $titulo ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3><?php echo $titulo; ?></h3>
                        </div>
                        <div class="card-body">

                            <?php if (isset($forma)) : ?>

                                <p class="text-muted small mb-4"><i class="ik ik-edit-1 ik-2x">&nbsp;&nbsp;</i>Última atualização:&nbsp;&nbsp;</i><?php echo formata_data_banco_com_hora($forma->forma_pagamento_data_alteracao); ?></p>

                            <?php endif; ?>

                            <form class="forms-sample" name="form_modulo" method="post">

                                <div class="row mb-3">

                                    <div class="col-md-4 mb-3">
                                        <label for="">Nome da forma de pagamento</label>
                                        <input type="text" class="form-control" name="forma_pagamento_nome" value="<?php echo (isset($forma) ? $forma->forma_pagamento_nome : set_value('forma_pagamento_nome')) ?>">
                                        <?php echo form_error('forma_pagamento_nome', '<div class="text-danger">', '</div>') ?>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="">Ativa</label>
                                        <select class="form-control" name="forma_pagamento_ativa">
                                            <?php if (isset($forma)) : ?>

                                                <option value="0" <?php echo ($forma->forma_pagamento_ativa == 0 ? 'selected' : '') ?>>Não</option>
                                                <option value="1" <?php echo ($forma->forma_pagamento_ativa == 1 ? 'selected' : '') ?>>Sim</option>

                                            <?php else : ?>

                                                <option value="0">Não</option>
                                                <option value="1">Sim</option>

                                            <?php endif; ?>

                                        </select>

                                    </div>

                                </div>


                                <?php if (isset($forma)) : ?>
                                    <input type="hidden" name="forma_pagamento_id" value="<?php echo $forma->forma_pagamento_id ?>" />
                                <?php endif; ?>


                                <button type="submit" class="btn btn-primary mr-2" value="<?php echo $valor_btn ?>"><?php echo $valor_btn ?></button>

                                <a href="<?php echo base_url($this->router->fetch_class()); ?>" class="btn btn-light">Voltar</a>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>