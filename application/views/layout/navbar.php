<header class="header-top" header-theme="light">
    <div class="container-fluid">
        <div class="d-flex float-right">
            <div class="top-menu">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="<?php echo base_url('public/img/user.jpg') ?>" alt=""></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a data-toggle="tooltip" data-placement="left" title="Gerenciar perfil" class="dropdown-item" href="<?php echo base_url('usuarios/core/' . $user->id); ?>"><i class="ik ik-user dropdown-icon"></i> Perfil</a>
                        <a data-toggle="tooltip" data-placement="left" title="Encerrar a sessão" class="dropdown-item" href="<?php echo base_url('login/logout');?>"><i class="ik ik-power dropdown-icon"></i> Sair</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>