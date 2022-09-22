<?php echo $this->extend($config->viewLayout); ?>
<?php echo $this->section('content'); ?>

<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="<?php echo base_url('/'); ?>" class="h1"><b>CI</b> Full-Stack Starter Kit</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg"><?php echo lang('Auth.loginTitle'); ?></p>
            <?php echo view('Modules\Auth\Views\_message_block'); ?>
            <form action="<?php echo base_url('auth/login'); ?>" method="post" autocomplete="off">
                <?php echo csrf_field(); ?>
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control <?php if (session('errors.username')) { ?>is-invalid<?php } ?>" placeholder="<?php echo lang('Auth.username'); ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control <?php if (session('errors.password')) { ?>is-invalid<?php } ?>" placeholder="<?php echo lang('Auth.password'); ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php if ($config->allowRemembering) { ?>
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember" <?php if (old('remember')) { ?> checked <?php } ?>>
                                <label for="remember">
                                    <?php echo lang('Auth.rememberMe'); ?>
                                </label>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block"><?php echo lang('Auth.loginAction'); ?></button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <div class="social-auth-links text-center mt-2 mb-3">
                <a href="" class="btn btn-block btn-danger">
                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                </a>
            </div>
            <!-- /.social-auth-links -->
            <?php if ($config->activeResetter) { ?>
                <p class="mb-1">
                    <a href="<?php echo base_url('auth/forgot'); ?>"><?php echo lang('Auth.forgotYourPassword'); ?></a>
                </p>
            <?php } ?>

            <?php if ($config->allowRegistration) { ?>
                <p class="mb-0">
                    <a href="<?php echo base_url('auth/register'); ?>">
                        <?php echo lang('Auth.needAnAccount'); ?>
                    </a>
                </p>
            <?php } ?>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

<?php echo $this->endSection(); ?>
