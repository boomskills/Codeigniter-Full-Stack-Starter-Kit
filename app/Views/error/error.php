<?php echo view('error/_error_header'); ?>
<div id="is-content" class="is-content" data-is-full-width="true">
  <div class="content-area ">
    <div class="section ">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="portlet-body">
              <div class="error-page--global">
                <div class="error-page--description">
                  <h4>Uh!</h4>
                  <p><?php echo $message; ?></p> <br />
                  <p><input type="button" value="<<< Back" onclick="window.history.back()" class="btn btn-default btn-sm" /> </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo view('error/_error_footer'); ?>
