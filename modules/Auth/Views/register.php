<?php echo $this->extend($config->viewLayout); ?>
<?php echo $this->section('content'); ?>

<div id="is-content" class="is-content" data-is-full-width="true">
  <div class="content-area ">
    <div class="breadcrumb bg-category">
      <div class="container">
        <h3 class="headding-title">
          Sign Up
        </h3>
      </div>
    </div>
    <div class="section ">
      <div class="container">
        <div class="row">
          <div class="col-sm-8">
            <div class="sign-up-info">
              <div class="before-sign-up">
                <div id="_info" class="alert alert-info alert-dismissible" role="alert">
                  <span class="closebtn" data-dismiss="alert" aria-label="close">&times;</span>
                  <?php if ($page) {
                    echo $page->content;
                  } ?>
                </div>
              </div>
            </div>
            <?php echo view('Modules\Auth\Views\_message_block'); ?>
            <div class="social-login text-center">
              <a href="<?php echo $googleLoginUrl; ?>" class="google-plus">
                <i class="fa fa-google-plus"></i>
                <?php echo lang('App.google'); ?>
              </a>
            </div>
            <h4 class="headding-title">Or sign up with your email address</h4>
            <div class="signup-form">
              <form id="registerForm" action="<?php echo base_url('auth/register'); ?>" method="post" accept-charset="utf-8">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                  <?php
                  $club_id['0'] = '(Select Club)';
                  foreach ($clubs as $key => $club) {
                    $club_id[$key] = $club->name;
                  }
                  echo form_dropdown("club_id", $club_id, set_value("club_id"), "id='club_id' class='form-control select2'");
                  ?>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6">
                      <input id="firstName" type="text" class="form-control <?php if (session('errors.firstName')) { ?>is-invalid<?php } ?>" name="firstName" placeholder="First Name" required>
                    </div>
                    <div class="col-xs-6">
                      <input id="lastName" type="text" class="form-control <?php if (session('errors.lastName')) { ?>is-invalid<?php } ?>" name="lastName" placeholder="Last Name" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3">Date of Birth</label>
                  <input type="date" id="birthday" name="birthday" class="form-control <?php if (session('errors.birthday')) { ?>is-invalid<?php } ?>" placeholder="mm/dd/yyy" required>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3 <?php if (session('errors.gender')) { ?>is-invalid<?php } ?>">
                    Gender
                  </label>
                  <div class="row">
                    <div class="col-sm-4">
                      <label class="radio-inline">
                        <input type="radio" id="gender" name="gender" value="Male">Male
                      </label>
                    </div>
                    <div class="col-sm-4">
                      <label class="radio-inline">
                        <input type="radio" id="gender" name="gender" value="Female">Female
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <input type="phone" class="form-control <?php echo session('errors.phone') ? 'is-invalid' : ''; ?>" name="phone" placeholder="Phone Number" value="<?php echo old('phone'); ?>">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <input id="identity" class="form-control <?php if (session('errors.identity')) { ?>is-invalid<?php } ?>" type="text" placeholder="<?php echo lang('Auth.username'); ?>" name="identity" required value="<?php echo old('identity'); ?>" />
                </div>
                <div class="form-group">
                  <input id="email" class="form-control <?php if (session('errors.email')) { ?>is-invalid<?php } ?>" type="email" aria-describedby="emailHelp" pattern="[^ @]*@[^ @]*" placeholder="<?php echo lang('Auth.email'); ?>" required name="email" value="<?php echo old('email'); ?>" />
                  <small id="emailHelp" class="form-text text-muted"><?php echo lang('Auth.weNeverShare'); ?></small>
                </div>
                <div class=" form-group">
                  <input id="password" class="form-control <?php if (session('errors.password')) { ?>is-invalid<?php } ?>" type="password" minlength="8" placeholder="<?php echo lang('Auth.password'); ?>" required name="password" onkeyup="checkPass(); return false;" autocomplete="off" />
                </div>
                <div class="form-group">
                  <input id="password_confirm" class="form-control <?php if (session('errors.password_confirm')) { ?>is-invalid<?php } ?>" type="password" minlength="8" placeholder="<?php echo lang('Auth.repeatPassword'); ?>" required name="password_confirm" onkeyup="checkPass(); return false;" autocomplete="off" />
                </div>

                <div class="form-group">
                  <label class="checkbox-inline"><input type="checkbox" required="required"> I accept the <a href="<?php echo base_url('privacy-policy'); ?>" target="_blank">Privacy Policy</a> &amp;
                    <a href="<?php echo base_url('disclaimer'); ?>" target="_blank">Disclaimer</a></label>
                </div>
                <div class="form-group">
                  <p class="text-center" style="color: #2c2f72;font-weight: bold;">
                    <?php echo lang('Auth.alreadyRegistered'); ?>
                    <a href="<?php echo base_url('auth/login'); ?>" style="color: #000;font-weight: bold;">
                      <?php echo lang('Auth.signIn'); ?>
                    </a>
                  </p>
                </div>
                <div class="form-actions form-submit">
                  <input type="submit" name="submit" value="<?php echo lang('Auth.register'); ?>" class="btn btn-login btn-block" />
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
