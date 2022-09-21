<?php echo $this->extend($config->viewLayout); ?>
<?php echo $this->section('content'); ?>

<div id="is-content" class="is-content" data-is-full-width="true">
  <div class="content-area ">
    <div class="section ">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="portlet-body">
              <div class="login-form">
                <form class="form-signin" action="<?php echo base_url('auth/reset-password'); ?>" method="post">
                  <?php echo csrf_field(); ?>
                  <h2 class="form-signin-heading"><?php echo lang('Auth.resetYourPassword'); ?></h2>
                  <div class="form-group">
                    <?php echo view('Modules\Auth\Views\_message_block'); ?>
                  </div>
                  <div class="form-group">
                    <label for="password" class="col-md-4 control-label">
                      <?php echo lang('Auth.newPassword'); ?>
                    </label>
                    <div class="col-md-8">
                      <input type="password" class="form-control <?php if (session('errors.password')) { ?>is-invalid<?php } ?>" name="password">
                      <div class="invalid-feedback">
                        <?php echo session('errors.password'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="passwordConfirm" class="col-md-4 control-label">
                      <?php echo lang('Auth.newPasswordRepeat'); ?>
                    </label>
                    <div class="col-md-8">
                      <input type="password" class="form-control <?php if (session('errors.pass_confirm')) { ?>is-invalid<?php } ?>" name="password_confirm">
                      <div class="invalid-feedback">
                        <?php echo session('errors.pass_confirm'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <input type="hidden" value="<?php echo $token; ?>" name="token">
                    <input type="hidden" value="<?php echo $identity; ?>" name="identity">
                    <button class="btn btn-lg btn-login btn-block" type="submit">
                      <?php echo lang('Auth.resetPassword'); ?>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php $this->endSection(); ?>
