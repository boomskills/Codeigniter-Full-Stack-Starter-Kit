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
          <h1>Settings</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Site Settings</li>
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
              <h3 class="card-title">Manage Site Sittings</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <?php echo form_open_multipart('admin/site_settings', ['class' => 'video-form', 'role' => 'form']); ?>
              <?= csrf_field() ?>
              <?php echo view('Modules\Admin\Views\error\_error_block'); ?>
              <input type="hidden" name="_method" value="PUT" />
              <?php echo view('Modules\Admin\Views\error\_error_block'); ?>
              <div class="session clearfix ">
                <div class="form-setting">
                  <div class="row">
                    <!-- Nav tabs -->
                    <div class="col-sm-2">
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="<?php if (1 == $tab_position) {
                                                          echo 'active';
                                                        } ?>"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General Setting</a></li>
                      </ul>
                    </div>
                    <div class="col-sm-10">
                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane <?php if (1 == $tab_position) {
                                                                echo 'active';
                                                              } ?>" id="general">
                          <div class="row form-group">
                            <div class="col-sm-2">
                              <label class="control-label">Site Title</label>
                            </div>
                            <div class="col-sm-6">
                              <input type="text" value="<?php echo $settings->info->site_title; ?>" class="form-control" name="site_title" required="required" />
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-sm-2">
                              <label class="control-label">Site Heading</label>
                            </div>
                            <div class="col-sm-6">
                              <input type="text" value="<?php echo $settings->info->site_heading; ?>" class="form-control" name="site_heading" required="required" />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="margiv-top-10">
                  <input type="submit" name="submit" id="btnSubmit" class="btn green btn-success" value="Save Settings" />
                </div>
              </div>
              <?php echo form_close(); ?>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php $this->endSection(); ?>
