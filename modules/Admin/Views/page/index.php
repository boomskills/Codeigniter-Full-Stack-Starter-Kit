<?php echo $this->extend($admin->viewLayout); ?>
<?php echo $this->section('content'); ?>

<section id="main-content">
  <section class="wrapper">
    <!-- page start-->
    <div class="row">
      <div class="col-sm-12">
        <section class="panel">
          <header class="panel-heading">
            Pages
          </header>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <a href="<?php echo base_url('admin/pages/new'); ?>" class="btn btn-default add">
                  <i class="fa fa-plus"></i> Create new Page
                </a>
              </div>
            </div>
            <div class="table-responsive">
              <table id="dynamic-table" class="table table-striped table-bordered" cellspacing="0">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($pages as $page) { ?>
                    <tr>
                      <td><?php echo $page->title; ?></td>
                      <td>
                        <div class="btn-group">
                          <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            Actions
                            <i class="fa fa-angle-down"></i>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li>
                              <a href="<?php echo base_url('admin/pages/' . $page->id . '/edit'); ?>">
                                <i class="icon-docs"></i>
                                Edit
                              </a>
                            </li>
                            <li>
                              <a href="<?php echo base_url('admin/pages/' . $page->id); ?>" onclick="return confirm('Are you sure to delete this?');">
                                <i class="icon-tag"></i> Delete </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </div>
    </div>
    <!-- page end-->
  </section>
</section>
<!--main content end-->
<?php $this->endSection(); ?>
