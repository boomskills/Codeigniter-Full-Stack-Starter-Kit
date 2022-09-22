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
          <h1>Pages</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Create Page</li>
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
          <?php echo view('Modules\Admin\Views\error\_error_block'); ?>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Create Page</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <?php echo form_open('admin/pages', ['class' => 'news-form', 'role' => 'form', 'method' => 'post']); ?>
              <?= csrf_field() ?>
              <div class="row">
                <div class="col-sm-8">
                  <div class="session clearfix">
                    <div class="form-group">
                      <label for="page_title" class="control-label">Page Title</label>
                      <input type="text" id="page_title" required class="form-control" name="page_title" required="required" />
                    </div>
                    <div class="form-group">
                      <label for="summernote" class="control-label">Page Content</label>
                      <textarea class="form-control" rows="5" id="summernote" name="page_content">
									</textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-5 col-md-offset-3">
                  <input type="submit" name="submit" class="btn-primary btn btn-large" value="Create">
                  <a href="<?php echo site_url('admin/pages'); ?>" class="btn btn-info btn-large">Back</a>
                </div>
              </div>
              <?php form_close(); ?>
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
