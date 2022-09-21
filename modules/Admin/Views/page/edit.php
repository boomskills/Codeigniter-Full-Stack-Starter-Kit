<?php echo $this->extend($admin->viewLayout); ?>
<?php echo $this->section('content'); ?>

<section id="main-content">
  <section class="wrapper">
    <!-- page start-->
    <div class="row">
      <div class="col-sm-12">
        <section class="panel">
          <header class="panel-heading">
            <i class="fa fa-file"></i> <?php echo $page->title; ?>
          </header>
          <div class="panel-body">
            <?php echo form_open_multipart('admin/pages/' . $page->id, ['class' => 'news-form', 'role' => 'form']); ?>
            <div class="row">
              <div class="col-sm-8">
                <div class="session clearfix">
                  <input type="hidden" name="_method" value="PUT" />
                  <?php echo view('Modules\Admin\Views\error\_error_block'); ?>
                  <div class="form-group">
                    <label for="page_title" class="control-label">Page Title</label>
                    <input type="text" id="page_title" required value="<?php
                                                                        if (set_value('page_title')) {
                                                                          echo set_value('page_title');
                                                                        } else {
                                                                          echo $page->title;
                                                                        }
                                                                        ?>" class="form-control" name="page_title" required="required" />
                  </div>
                  <div class="form-group">
                    <label for="pageDesc" class="control-label">Page Content</label>
                    <textarea class="form-control" rows="5" id="pageDesc" name="page_content"><?php
                                                                                              if (set_value('page_content')) {
                                                                                                echo set_value('page_content');
                                                                                              } else {
                                                                                                echo $page->content;
                                                                                              }
                                                                                              ?>
									</textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-5 col-md-offset-3">
                <input type="submit" name="submit" class="btn-primary btn btn-large" value="Submit">
                <a href="<?php echo site_url('api/pages/delete/' . $page->id); ?>" class="btn btn-danger btn-large">Delete</a>
                <a href="<?php echo site_url('admin/pages'); ?>" class="btn btn-info btn-large">Back</a>
              </div>
            </div>
            <?php form_close(); ?>
            <!-- // end form -->
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
<?php $this->endSection(); ?>
