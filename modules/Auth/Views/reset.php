<?php echo $this->extend($config->viewLayout); ?>
<?php echo $this->section('content'); ?>

<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?php echo base_url('/'); ?>" class="h1"><b>CI</b> Full-Stack Starter Kit</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
      <?php echo view('Modules\Auth\Views\_message_block'); ?>
      <form action="login.html" method="post">
        <?php echo csrf_field(); ?>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control <?php if (session('errors.password')) { ?>is-invalid<?php } ?>" placeholder="<?php echo session('errors.password'); ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password_confirm" class="form-control <?php if (session('errors.pass_confirm')) { ?>is-invalid<?php } ?>" placeholder="<?php echo lang('Auth.newPasswordRepeat'); ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <input type="hidden" value="<?php echo $token; ?>" name="token">
            <input type="hidden" value="<?php echo $username; ?>" name="username">
            <button type="submit" class="btn btn-primary btn-block">
              <?php echo lang('Auth.resetPassword'); ?>
            </button>
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
