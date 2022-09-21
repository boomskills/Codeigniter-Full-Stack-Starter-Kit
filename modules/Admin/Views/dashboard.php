<?php echo $this->extend($admin->viewLayout); ?>
<?php echo $this->section('content'); ?>

<!--main content start-->
<section id="main-content">
  <section class="wrapper">
    <!--state overview start-->
    <div class="session clearfix">
      <div class="row state-overview">
        <div class="col-lg-3 col-sm-6">
          <section class="panel">
            <div class="symbol terques">
              <i class="fa fa-user"></i>
            </div>
            <div class="value">
              <h1 class="count">
                <?php echo $users; ?>
              </h1>
              <p>Total Users</p>
            </div>
          </section>
        </div>
        <div class="col-lg-3 col-sm-6">
          <section class="panel">
            <div class="symbol red">
              <i class="fa fa-user"></i>
            </div>
            <div class="value">
              <h1 class=" count2">
                <?php echo $recent_users; ?>
              </h1>
              <p>Recent Users</p>
            </div>
          </section>
        </div>
        <div class="col-lg-3 col-sm-6">
          <section class="panel">
            <div class="symbol blue">
              <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
              <h1 class=" count4">
                <?php echo $weekly_users; ?>
              </h1>
              <p>This Week Users</p>
            </div>
          </section>
        </div>
      </div>
    </div>
  </section>
</section>
<!--main content end-->
<?php $this->endSection(); ?>
