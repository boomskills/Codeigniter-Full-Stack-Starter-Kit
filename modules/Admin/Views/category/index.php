<!-- Main content start -->
<?php echo $this->extend($admin->viewLayout); ?>
<?php echo $this->section('content'); ?>

<section id="main-content">
  <section class="wrapper">
    <!-- page start-->
    <div class="row">
      <div class="col-sm-12">
        <section class="panel">
          <header class="panel-heading">
            <i class="fa fa-newspaper"></i> Categories
          </header>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <a href="<?php echo base_url('admin/categories/new'); ?>" class="btn btn-default add">
                  <i class="fa fa-plus"></i> Create New Category
                </a>
              </div>
            </div>
            <?php echo view('Modules\Admin\Views\error\_error_block'); ?>
            <div class="table-responsive">
              <table id="dynamic-table" class="table table-striped table-bordered" cellspacing="0">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($categories as $r) {
                  ?>
                    <tr>
                      <td><?php echo $r->title; ?></td>

                      <td>
                        <div class="btn-group">
                          <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Actions
                            <i class="fa fa-angle-down"></i>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li>
                              <a href="<?php echo base_url('admin/categories/' . $r->id); ?>/edit" data-id="<?php echo $r->id; ?>">
                                <i class="icon-docs"></i> Edit </a>
                            </li>
                            <li>
                              <a href="<?php echo base_url('admin/categories/' . $r->id); ?>/delete" onclick="return confirm('Are you sure to delete this page?');">
                                <i class="icon-tag"></i> Delete </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                  <?php
                  } ?>
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
<!-- Main Content Ends -->
<?php $this->endSection(); ?>
