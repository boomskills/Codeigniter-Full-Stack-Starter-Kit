<!-- Main content start -->
<?php echo $this->extend($admin->viewLayout); ?>
<?php echo $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>User Management</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/users'); ?>">Users</a></li>
            <li class="breadcrumb-item active"><?php echo $edit_user->name ?></li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><?php echo $edit_user->name ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <?php echo form_open('/admin/users/' . $edit_user->id, ['id' => 'social_config', 'class' => 'news-form']); ?>
              <?php echo view('Modules\Admin\Views\error\_error_block'); ?>
              <input type="hidden" name="_method" value="PUT" />
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
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-4 col-md-offset-3">
                <?= csrf_field() ?>
                <input type="submit" name="submit" class="btn btn-primary" value="Save Changes">
                <a href="<?php echo site_url('admin/users'); ?>" class="btn btn-default btn-large btn-back">Back</a>
              </div>
            </div>
            <!-- form close -->
            <?php form_close(); ?>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.container-fluid -->
<?php $this->endSection(); ?>
