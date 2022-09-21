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
                <form class="form-signin" id="login_form" action="<?php echo base_url('auth/login'); ?>" method="post">
                  <?php echo csrf_field(); ?>
                  <h2 class="form-signin-heading">
                    <?php echo lang('Auth.loginTitle'); ?>
                  </h2>
                  <div class="login-wrap">
                    <?php echo view('Modules\Auth\Views\_message_block'); ?>
                    <div class="social-login">
                      <a href="<?php echo $googleLoginUrl; ?>" class="google-plus">
                        <i class="fa fa-google-plus"></i> <?php echo lang('App.google'); ?>
                      </a>
                    </div>
                    <br>
                    <p>Or sign in with your email address</p>
                    <br>
                    <?php if ($config->validFields === ['email']) { ?>
                      <input type="email" class="form-control <?php if (session('errors.identity')) { ?>is-invalid<?php } ?>" name="identity" placeholder="<?php echo lang('Auth.email'); ?>">
                      <div class="invalid-feedback">
                        <?php echo session('errors.login'); ?>
                      </div>
                    <?php } else { ?>
                      <input type="text" class="form-control <?php if (session('errors.identity')) { ?>is-invalid<?php } ?>" name="identity" placeholder="<?php echo lang('Auth.emailOrUsername'); ?>" autofocus>
                    <?php } ?>
                    <input type="password" name="password" class="form-control <?php if (session('errors.password')) { ?>is-invalid<?php } ?>" placeholder="<?php echo lang('Auth.password'); ?>">
                    <div class="invalid-feedback">
                      <?php echo session('errors.password'); ?>
                    </div>
                    <label class="checkbox">
                      <?php if ($config->allowRemembering) { ?>
                        <input type="checkbox" name="remember" id="remember" <?php if (old('remember')) { ?> checked <?php } ?>>
                        <?php echo lang('Auth.rememberMe'); ?>
                      <?php } ?>
                      <?php if ($config->activeResetter) { ?>
                        <span class="pull-right">
                          <a href="<?php echo base_url('auth/forgot'); ?>" title="Forgot your password">
                            <?php echo lang('Auth.forgotYourPassword'); ?>
                          </a>
                        </span>
                      <?php } ?>
                    </label>
                    <button class="btn btn-lg btn-login btn-block" type="submit">
                      <?php echo lang('Auth.loginAction'); ?>
                    </button>
                    <?php if ($config->allowRegistration) { ?>
                      <div class="registration">
                        <a href="<?php echo base_url('auth/register'); ?>">
                          <?php echo lang('Auth.needAnAccount'); ?>
                        </a>
                      </div>
                    <?php } ?>
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
<?php echo $this->endSection(); ?>
