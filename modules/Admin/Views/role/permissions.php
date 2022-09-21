<?php echo $this->extend($admin_config->viewLayout); ?>
<?php echo $this->section('content'); ?>

<section id="main-content">
  <section class="wrapper">
    <!-- page start-->
    <div class="row">
      <div class="col-sm-12">
        <section class="panel">
          <header class="panel-heading">
            All System Permissions
          </header>
          <div class="panel-body">
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
                            foreach ($permissions as $r) {
                                ?>
                  <tr>
                    <td><?php echo $r->name; ?></td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown"
                          aria-expanded="false">Actions
                          <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li>
                            <a>
                              <i class="icon-docs"></i> Edit </a>
                          </li>
                          <li>
                            <a href="<?php echo base_url('admin/permissions/delete/'.$r->id); ?>"
                              onclick="return confirm('Are you sure to delete this slider?');">
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
<?php $this->endSection(); ?>