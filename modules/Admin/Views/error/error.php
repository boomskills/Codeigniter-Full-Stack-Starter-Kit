<!-- Main content start -->
<?php echo $this->extend(config('Admin')->viewLayout); ?>
<?php echo $this->section('content'); ?>

<section id="main-content">
  <section class="wrapper">
    <!-- page start-->
    <div class="row">
      <div class="col-sm-12">
        <section class="panel">
          <div class="panel-body">
            <div class="error-page">
              <h4>Error</h4>
              <b><?php echo $message; ?><br /><br />
                <p><input type="button" value="Back" onclick="window.history.back()" class="btn btn-default btn-sm" />
                </p>
            </div>
          </div>
        </section>
      </div>
    </div>
    <!-- page end-->
  </section>
</section>
<?php $this->endSection(); ?>
