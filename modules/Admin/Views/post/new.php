<!-- Main content start -->
<?php echo $this->extend($admin->viewLayout); ?>
<?php echo $this->section('content'); ?>
<section id="main-content">
  <section class="wrapper">
    <!-- page start-->
    <div class="row">
      <div class="col-lg-12">
        <!--progress bar start-->
        <section class="panel">
          <header class="panel-heading">
            Create New Post
          </header>
          <div class="panel-body">
            <?php echo form_open_multipart('admin/posts', ['class' => 'news-form', 'role' => 'form', 'method' => 'post']); ?>
            <div class="row">
              <div class="col-sm-8">
                <div class="session clearfix">
                  <?php echo view('Modules\Admin\Views\error\_error_block'); ?>
                  <div class="form-group">
                    <label for="title" class="control-label">Title</label>
                    <input type="text" id="title" required class="form-control" name="title" value="<?php echo old("title") ?>" />
                  </div>
                  <div class="form-group">
                    <label for="short_description" class="control-label">Short Description</label>
                    <textarea class="form-control" id="short_description" name="short_description">
                    <?php echo old("short_description") ?>
                    </textarea>
                  </div>
                  <div class="form-group">
                    <label for="postDesc" class="control-label">Description
                    </label>
                    <textarea class="form-control" id="postDesc" name="description">
                    <?php echo old("body") ?>
                    </textarea>
                  </div>
                  <div class="form-group clearfix">
                    <label class="control-label">Category</label>
                    <div class="bg-white form-control clearfix" style="height:auto" tabindex="0">
                      <?php foreach ($categories as $r) { ?>
                        <div class="checkbox">
                          <label for="category<?php echo $r->id; ?>">
                            <input type="checkbox" name="categories[]" value="<?php echo $r->id; ?>">
                            <?php echo $r->title; ?>
                          </label>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="session clearfix">
                  <div class="form-group clearfix">
                    <label class="control-label">Status</label>
                    <select class="form-control" name="status">
                      <option value="draft">Draft </option>
                      <option value="pending">Pending</option>
                      <option value="published">Publish </option>
                    </select>
                  </div>
                  <div class="form-group clearfix">
                    <label class="control-label">Post Image</label><br>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                      <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                        <img class="thumbnail" alt="" src="" />
                      </div>
                      <div>
                        <label for="postImage" class="btn-success btn default btn-file ">
                          CHOOSE FILE <i class="fa fa-upload" aria-hidden="true"></i>
                          <input type="file" name="thumbnail" id="postImage" class="uploadfileinput">
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-5 col-md-offset-3">
                <input type="submit" name="submit" class="btn-primary btn btn-large" value="Create Post">
                <a href="<?php echo site_url('admin/posts'); ?>" class="btn btn-info btn-large">Back</a>
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
<!-- Main Content Ends -->
<script>
  CKEDITOR.replace('postDesc', {
    height: '300'
  });

  function readURL(ele, input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $(ele).attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $('#postImage').change(function() {
    readURL(".thumbnail", this);
  });
</script>

<?php $this->endSection(); ?>
