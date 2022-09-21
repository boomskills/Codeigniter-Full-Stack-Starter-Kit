<!-- Main content start -->
<?php echo $this->extend($admin_config->viewLayout); ?>
<?php echo $this->section('content'); ?>

<section id="main-content">
  <section class="wrapper">
    <!-- page start-->
    <div class="row">
      <div class="col-sm-12">
        <section class="panel">
          <header class="panel-heading">
            <i class="fa fa-edit"></i> <?php echo $edit_user->name; ?>
          </header>
          <div class="panel-body">
            <?php echo form_open('/admin/users/' . $edit_user->id, ['id' => 'social_config', 'class' => 'news-form']); ?>
            <input type="hidden" name="_method" value="PUT" />
            <?php echo view('Modules\Admin\Views\error\_error_block'); ?>
            <div class="row">
              <div class="col-sm-8">
                <div class="session clearfix">
                  <div class="form-group">
                    <label for="name" class="control-label">Name</label>
                    <input type="name" value="<?php
                                              if (set_value('name')) {
                                                echo set_value('name');
                                              } else {
                                                echo $edit_user->name;
                                              }
                                              ?>" class="form-control" name="name" />
                  </div>
                  <div class="form-group">
                    <label for="email" class="control-label">Email Address</label>
                    <input type="email" value="<?php
                                                if (set_value('email')) {
                                                  echo set_value('email');
                                                } else {
                                                  echo $edit_user->email;
                                                }
                                                ?>" class="form-control" name="email" />
                  </div>
                  <div class="form-group">
                    <label for="phone" class="control-label">Phone Number</label>
                    <input type="text" value="<?php
                                              if (set_value('phone')) {
                                                echo set_value('phone');
                                              } else {
                                                echo $edit_user->phone;
                                              }
                                              ?>" class="form-control" name="phone" />
                  </div>
                  <div class="form-group">
                    <label class="control-label">Role</label>
                    <?php foreach ($edit_user->getRoles() as $role) { ?>
                      <input type="text" value="<?php echo $role ?>" class="form-control" readonly />
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label class="control-label"> Active
                      <input type="checkbox" name="activate" <?php if ($edit_user->auth()->active == 1) echo ' checked'; ?> />
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="session clearfix">
                  <div class="form-group">
                    <label for="phone" class="control-label">Profile</label>
                    <p>First Name: <strong><?php echo $edit_user->profile()->first_name; ?></strong></p>
                    <p>Last Name: <strong><?php echo $edit_user->profile()->last_name; ?></strong></p>
                    <p>Birthday: <strong><?php echo $edit_user->profile()->birthday; ?></strong></p>
                    <p>Gender: <strong><?php echo toClassCase($edit_user->profile()->gender); ?></strong></p>
                    <p>Phone Number: <strong><?php echo $edit_user->profile()->phone_number; ?></strong></p>
                    <p>Email Address: <strong><?php echo $edit_user->profile()->email_address; ?></strong></p>
                    <p>Address: <strong><?php echo $edit_user->profile()->address; ?></strong></p>
                    <p>City: <strong><?php echo $edit_user->profile()->city; ?></strong></p>
                    <p>Region: <strong><?php echo $edit_user->profile()->state; ?></strong></p>
                    <p>Country: <strong><?php echo $edit_user->profile()->country; ?></strong></p>
                    <p>Postal Code: <strong><?php echo $edit_user->profile()->postal_code; ?></strong></p>
                    <p>Profile Number: <strong><?php echo $edit_user->profile()->profile_number; ?></strong></p>
                    <p>Communication Method: <strong><?php echo toClassCase($edit_user->profile()->communication_method); ?></strong></p>
                  </div>
                </div>
                <div class="session clearfix">
                  <div class="form-group">
                    <label class="control-label">Last online</label>
                    <p>
                      <strong>
                        <?php echo get_time_string_simple(convert_simple_time($edit_user->auth()->online_timestamp)) ?: "none"; ?>
                      </strong>
                    </p>
                  </div>
                </div>
                <div class="session clearfix">
                  <div class="form-group">
                    <label class="control-label">Joined</label>
                    <p><strong><?php echo date('Y/m/d', strtotime($edit_user->created_at)); ?></strong></p>
                  </div>
                </div>
                <div class="session clearfix">
                  <div class="form-group">
                    <label class="control-label">Membership Plan</label>
                    <p>Subscription: <strong><?php echo toClassCase($edit_user->membership()); ?></strong></p>
                    <p>Started At: <strong><?php echo date('Y/m/d', strtotime($edit_user->getSubscription()->starts_at)); ?></strong></p>
                    <p>Ends At: <strong><?php echo date('Y/m/d', strtotime($edit_user->getSubscription()->ends_at)); ?></strong></p>
                    <p>Status: <strong><?php echo $edit_user->getSubscription()->active() ?  'Active' : 'Inactive' ?></strong></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-4 col-md-offset-3">
                <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                <a href="<?php echo site_url('admin/users'); ?>" class="btn btn-default btn-large btn-back">Back</a>
              </div>
            </div>
            <!-- form close -->
            <?php form_close(); ?>
          </div>
        </section>
      </div>
    </div>
    <!-- page end-->
  </section>
</section>
<!-- Main Content Ends -->
<?php $this->endSection(); ?>
