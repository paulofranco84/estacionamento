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
                                    <a data-toggle="tooltip" data-placement="bottom" title="Home" href="<?php echo base_url('/') ?>"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $titulo ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <?php
            if ($message = $this->session->flashdata('error')) :
            ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert bg-danger alert-danger text-white alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <span><i class="ik ik-alert-octagon"></i></i>&nbsp;&nbsp;<?php echo $message; ?></span>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

            <?php
            if ($message = $this->session->flashdata('sucesso')) :
            ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert bg-success alert-success text-white alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <span><i class="fas fa-check-circle"></i>&nbsp;&nbsp;<?php echo $message; ?></span>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-primary" href="#">+&nbsp;Novo</a>
                        </div>
                        <div class="card-body">
                            <table class="data-table table dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th class="pl-25">#</th>
                                        <th>Usuário</th>
                                        <th>Email</th>
                                        <th>Nome</th>
                                        <th>Perfil</th>
                                        <th>Ativo</th>
                                        <th class="nosort text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($usuarios as $user) : ?>
                                        <tr>
                                            <td class="pl-25"><?php echo $user->id ?></td>
                                            <td><?php echo $user->username ?></td>
                                            <td><?php echo $user->email ?></td>
                                            <td><?php echo $user->first_name ?></td>
                                            <td><?php echo $this->ion_auth->is_admin($user->id) ? 'Administrador' : 'Atendente'; ?></td>
                                            <td><?php echo ($user->active == 1 ? '<span class="badge badge-pill badge-success mb-1">Sim</span>' : '<span class="badge badge-pill badge-danger mb-1">Não</span>') ?></td>
                                            <td>
                                                <div class="table-actions text-center">
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Editar" class="btn btn-icon btn-primary text-white" href="<?php echo base_url('usuarios/core/' . $user->id); ?>"><i class="ik ik-edit-2"></i></a>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Excluir" class="btn btn-icon btn-danger text-white" href="<?php echo base_url('usuarios/del/' . $user->id); ?>"><i class="ik ik-trash-2"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>