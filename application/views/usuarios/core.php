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
                                    <a data-toggle="tooltip" data-placement="bottom" title="Listar <?php echo $this->router->fetch_class() ?>" href="<?php echo base_url('/' . $this->router->fetch_class()) ?>">Listar Usuários</a>
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

                            <?php if (isset($usuario)) : ?>

                                <p class="text-muted small mb-4"><i class="ik ik-calendar ik-2x">&nbsp;&nbsp;</i>Última atualização:&nbsp;&nbsp;</i><?php echo formata_data_banco_com_hora($usuario->user_data_alteracao); ?></p>

                            <?php endif; ?>

                            <form class="forms-sample" name="form_modulo" method="post">

                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3">
                                        <label for="">Nome</label>
                                        <input type="text" class="form-control" name="first_name" value="<?php echo (isset($usuario) ? $usuario->first_name : set_value('first_name')) ?>">
                                        <?php echo form_error('first_name', '<div class="text-danger">', '</div>') ?>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Sobrenome</label>
                                        <input type="text" class="form-control" name="last_name" value="<?php echo (isset($usuario) ? $usuario->last_name : set_value('last_name')) ?>">
                                        <?php echo form_error('last_name', '<div class="text-danger">', '</div>') ?>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="">E-mail</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo (isset($usuario) ? $usuario->email : set_value('email')) ?>">
                                            <?php echo form_error('email', '<div class="text-danger">', '</div>') ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="">Usuário</label>
                                            <input type="text" class="form-control" name="username" value="<?php echo (isset($usuario) ? $usuario->username : set_value('username')) ?>">
                                            <?php echo form_error('username', '<div class="text-danger">', '</div>') ?>
                                        </div>
                                    </div>


                                </div>


                                <div class="row mb-3">

                                    <div class="col-md-6">
                                        <label for="exampleInputPassword4">Senha</label>
                                        <input type="password" class="form-control" name="password">
                                        <?php echo form_error('password', '<div class="text-danger">', '</div>') ?>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="exampleInputPassword4">Confirma senha</label>
                                        <input type="password" class="form-control" name="confirma_senha">
                                        <?php echo form_error('confirma_senha', '<div class="text-danger">', '</div>') ?>
                                    </div>

                                </div>


                                <?php if ($this->ion_auth->is_admin()) : ?>
                                    <div class="row mb-3">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Perfil</label>
                                                <select class="form-control" name="perfil">
                                                    <?php if (isset($usuario)) : ?>

                                                        <option value="2" <?php echo ($perfil_usuario->id == 2 ? 'selected' : ''); ?>>Atendente</option>
                                                        <option value="1" <?php echo ($perfil_usuario->id == 1 ? 'selected' : '') ?>>Administrador</option>

                                                    <?php else : ?>

                                                        <option value="2">Atendente</option>
                                                        <option value="1">Administrador</option>

                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Ativo</label>
                                                <select class="form-control" name="active">
                                                    <?php if (isset($usuario)) : ?>

                                                        <option value="0" <?php echo ($usuario->active == 0 ? 'selected' : ''); ?>>Não</option>
                                                        <option value="1" <?php echo ($usuario->active == 1 ? 'selected' : '') ?>>Sim</option>

                                                    <?php else : ?>

                                                        <option value="0">Não</option>
                                                        <option value="1">Sim</option>

                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                <?php endif; ?>

                                <?php if (isset($usuario)) : ?>
                                    <input type="hidden" name="user_id" value="<?php echo $usuario->id ?>" />
                                <?php endif; ?>


                                <button type="submit" class="btn btn-primary mr-2" name="btn_acao" value="<?php echo $valor_btn ?>"><?php echo $valor_btn ?></button>
                                <?php if ($this->ion_auth->is_admin() || !$this->ion_auth->is_admin()) : ?>
                                    <a href="<?php echo base_url($this->router->fetch_class()); ?>" class="btn btn-light">Voltar</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>