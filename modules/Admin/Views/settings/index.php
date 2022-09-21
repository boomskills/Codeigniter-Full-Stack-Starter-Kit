<?php echo $this->extend($admin_config->viewLayout); ?>
<?php echo $this->section('content'); ?>

<section id="main-content">
  <section class="wrapper">
    <!-- page start-->
    <div class="row">
      <div class="col-lg-12">
        <!--progress bar start-->
        <section class="panel">
          <header class="panel-heading">
            Site Setting
          </header>
          <div class="panel-body">
            <?php echo form_open_multipart('admin/site_settings', ['class' => 'video-form', 'role' => 'form']); ?>
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
                        <div class="form-group clearfix">
                          <label class="control-label">Header Logo</label>
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                              <div class="image-box">
                                <img id="image_preview_logo" src="<?php echo getImagePath($settings->info->header_logo_right); ?>" alt="" />
                              </div>
                            </div>
                            <div class="select-img">
                              <label for="uploadfilelogo" class="btn-success btn default btn-file ">
                                CHOOSE FILE <i class="fa fa-upload" aria-hidden="true"></i>
                                <input type="file" name="header_logo_right" id="uploadfilelogo" class="uploadfileinput" value="<?php echo $settings->info->header_logo_right; ?>">
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group clearfix">
                          <label class="control-label">Header left Logo</label>
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                              <div class="image-box">
                                <img id="image_preview_left_logo" src="<?php echo getImagePath($settings->info->header_logo_left); ?>" alt="" />
                              </div>
                            </div>
                            <div class="select-img">
                              <label for="uploadfilelogoLeft" class="btn-success btn default btn-file ">
                                CHOOSE FILE <i class="fa fa-upload" aria-hidden="true"></i>
                                <input type="file" name="header_logo_left" id="uploadfilelogoLeft" class="uploadfileinput" value="<?php echo $settings->info->header_logo_left; ?>">
                              </label>
                            </div>
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
            <!-- // end form -->
          </div>
        </section>
      </div>
    </div>
    <!-- page end-->
  </section>
</section>
<script type="text/javascript">
  $(document).ready(function() {
    function readURL(input, preview) {
      if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
          $(preview).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    $('#uploadfilelogoLeft').change(function() {
      readURL(this, "#image_preview_left_logo");
    });

    $('#uploadfilelogo').change(function() {
      readURL(this, "#image_preview_logo");
    });
  });
</script>
<!-- Main Content Ends -->
<?php $this->endSection(); ?>
