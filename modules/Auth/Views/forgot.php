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
                <form id="forgotpw-form" action="<?php echo base_url('auth/forgot'); ?>" role="form" autocomplete="off"
                  class="form-signin" method="post">
                  <?php echo csrf_field(); ?>
                  <h2 class="form-signin-heading"><?php echo lang('Auth.forgotPassword'); ?></h2>
                  <div class="login-wrap">
                    <?php echo view('Modules\Auth\Views\_message_block'); ?>
                    <div class="form-group">
                      <label for="reset_password" class="col-md-4 control-label">
                        <?php echo lang('Auth.identity'); ?>
                      </label>
                      <div class="col-md-8">
                        <input type="text"
                          class="form-control <?php if (session('errors.identity')) { ?>is-invalid<?php } ?>"
                          name="identity" placeholder="<?php echo lang('Auth.identity'); ?>" autofocus
                          aria-describedby="emailHelp">
                        <div class="invalid-feedback">
                          <?php echo session('errors.identity'); ?>
                        </div>
                      </div>
                      <input type="hidden" class="hide" name="token" id="token" value="">
                      <button class="btn btn-lg btn-login btn-block" type="submit">
                        <?php echo lang('Auth.sendInstructions'); ?>
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
</div>
<?php $this->endSection(); ?>