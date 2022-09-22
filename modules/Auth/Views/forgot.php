<?php echo $this->extend($config->viewLayout); ?>
<?php echo $this->section('content'); ?>

<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="<?php echo base_url('/'); ?>" class="h1"><b>CI</b> Full-Stack Starter Kit</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
            <?php echo view('Modules\Auth\Views\_message_block'); ?>
            <form action="<?php echo base_url('auth/forgot'); ?>" method="post" autocomplete="off">
                <?php echo csrf_field(); ?>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control <?php if (session('errors.email')) { ?>is-invalid<?php } ?>" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Request new password</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <p class="mt-3 mb-1">
                <a href="login.html">Login</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<?php $this->endSection(); ?>
