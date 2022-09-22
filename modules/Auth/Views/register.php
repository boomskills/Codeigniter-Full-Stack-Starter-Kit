<?php echo $this->extend($config->viewLayout); ?>
<?php echo $this->section('content'); ?>

<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="<?php echo base_url('/'); ?>" class="h1"><b>CI</b> Full-Stack Starter Kit</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Register a new membership</p>
            <?php echo view('Modules\Auth\Views\_message_block'); ?>
            <form action="<?php echo base_url('auth/register'); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control <?php if (session('errors.name')) { ?>is-invalid<?php } ?>" placeholder="Full name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control <?php if (session('errors.username')) { ?>is-invalid<?php } ?>" placeholder="<?php echo lang('Auth.username'); ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control <?php if (session('errors.email')) { ?>is-invalid<?php } ?>" placeholder="<?php echo lang('Auth.email'); ?>">
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
                <div class="input-group mb-3">
                    <input type="password" name="password_confirm" class="form-control <?php if (session('errors.password_confirm')) { ?>is-invalid<?php } ?>" placeholder="<?php echo lang('Auth.repeatPassword'); ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                            <label for="agreeTerms">
                                I agree to the <a href="#">terms</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <div class="social-auth-links text-center">
                <a href="" class="btn btn-block btn-danger">
                    <i class="fab fa-google-plus mr-2"></i>
                    Sign up using Google+
                </a>
            </div>

            <a href="login.html" class="text-center">I already have a membership</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->

<?php $this->endSection(); ?>
