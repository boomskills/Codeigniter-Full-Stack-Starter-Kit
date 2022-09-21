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
            Edit <?php echo $post->title ?>
          </header>
          <div class="panel-description">
            <?php echo form_open_multipart('admin/posts/' . $post->id, ['class' => 'news-form', 'role' => 'form']); ?>
            <input type="hidden" name="_method" value="PUT" />
            <?php echo view('Modules\Admin\Views\error\_error_block'); ?>
            <div class="row">
              <div class="col-sm-8">
                <div class="session clearfix">
                  <div class="form-group">
                    <label for="title" class="control-label">Title-</label>
                    <input type="text" id="title" required value="<?php
                                                                  if (set_value('title')) {
                                                                    echo set_value('title');
                                                                  } else {
                                                                    echo $post->title;
                                                                  }
                                                                  ?>" class="form-control" name="title" />
                  </div>
                  <div class="form-group">
                    <label for="short_description" class="control-label">Short Description</label>
                    <textarea class="form-control" id="short_description" name="short_description"><?php
                                                                                                    if (set_value('short_description')) {
                                                                                                      echo set_value('short_description');
                                                                                                    } else {
                                                                                                      echo $post->short_description;
                                                                                                    }
                                                                                                    ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="postDesc" class="control-label">Description</label>
                    <textarea class="form-control" id="postDesc" name="body"><?php
                                                                              if (set_value('description')) {
                                                                                echo set_value('description');
                                                                              } else {
                                                                                echo $post->description;
                                                                              }
                                                                              ?>

                            </textarea>
                  </div>
                  <div class="form-group clearfix">
                    <label class="control-label">Category</label>
                    <div class="bg-white form-control clearfix" style="height:auto" tabindex="0">
                      <?php foreach ($categories as $r) { ?>
                        <div class="checkbox">
                          <label for="category<?php echo $r->id; ?>">
                            <input type="checkbox" name="categories[]" id="category<?php echo $r->id; ?>" value="<?php echo $r->id; ?>" <?php if (in_array($r->id, $category_ids)) {
                                                                                                                                          echo ' checked="checked"';
                                                                                                                                        } ?>>
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
                  <div class="form-group">
                    <label class="control-label">Status</label>
                    <select class="form-control" name="status">
                      <option value="draft" <?php if ('draft' == $post->status) {
                                              echo 'selected';
                                            } ?>>Draft </option>
                      <option value="pending" <?php if ('pending' == $post->status) {
                                                echo 'selected';
                                              } ?>>Pending </option>
                      <option value="published" <?php if ('published' == $post->status) {
                                                  echo 'selected';
                                                } ?>>Published</option>
                    </select>
                  </div>
                  <div class="form-group clearfix">
                    <label for="postImage" class="control-label">Thumbnail
                      :-</label>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                      <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                        <img class="thumbnail" src="<?php echo renderImage($post->thumbnail); ?>" alt="" />
                      </div>
                      <div>
                        <label for="postImage" class="btn-success btn default btn-file ">
                          Choose file<i class="fa fa-upload" aria-hidden="true"></i>
                          <input type="file" name="thumbnail" id="postImage" class="uploadfileinput" value="<?php echo renderImage($post->thumbnail) ?>">
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-5 col-md-offset-3">
                <input type="submit" name="submit" class="btn btn-large green btn-success" value="Create">
                <a href="<?php echo site_url('admin/posts'); ?>" class="btn btn-default btn-large btn-back">Back</a>
              </div>
            </div>
            </form>
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
