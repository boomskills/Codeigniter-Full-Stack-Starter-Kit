<?php echo $this->extend($admin->viewLayout); ?>
<?php echo $this->section('content'); ?>

<section id="main-content">
  <section class="wrapper">
    <!-- page start-->
    <div class="row">
      <div class="col-sm-12">
        <section class="panel">
          <header class="panel-heading">
            <i class="fa fa-file"></i> Create New Page
          </header>
          <div class="panel-body">
            <?php echo form_open_multipart('admin/pages', ['class' => 'news-form', 'role' => 'form', 'method' => 'post']); ?>
            <div class="row">
              <div class="col-sm-8">
                <?php echo view('Modules\Admin\Views\error\_error_block'); ?>
                <div class="session clearfix">
                  <div class="form-group">
                    <label for="page_title" class="control-label">Page Title</label>
                    <input type="text" id="page_title" required class="form-control" name="page_title" required="required" />
                  </div>
                  <div class="form-group">
                    <label for="page_content" class="control-label">Page Content</label>
                    <textarea class="form-control" rows="5" id="page_content" name="page_content">
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
        </section>
      </div>
    </div>
    <!-- page end-->
  </section>
</section>
<script>
  // Replace the <textarea id="editor1"> with a CKEditor
  // instance, using default configuration.
  CKEDITOR.replace('page_content');
</script>
<!--main content end-->
<?php $this->endSection(); ?>
