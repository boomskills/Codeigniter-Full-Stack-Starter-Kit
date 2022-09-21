<!-- Main content start -->
<?php echo $this->extend($admin_config->viewLayout); ?>
<?php echo $this->section('content'); ?>

<section id="main-content">
  <section class="wrapper">
    <!-- page start-->
    <div class="row">
      <div class="col-sm-12">
        <section class="panel">
          <header class="panel-heading">
            <i class="fa fa-users"></i> Users Management
          </header>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="display table table-bordered table-striped table-responsive" id="dynamic-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($users as $key => $user) { ?>
                    <tr>
                      <td>
                        <?php echo $key + 1; ?>
                      </td>
                      <td>
                        <?php echo htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8'); ?>
                      </td>
                      <td class="hidden-sm">
                        <?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?>
                      </td>
                      <td class="hidden-sm">
                        <?php foreach ($user->getRoles() as $role) { ?>
                          <?php if ("member" == $role) : ?>
                            <span class="label label-warning">
                              <?php echo toSpaceCase(toClassCase($role)); ?>
                            </span>
                          <?php else : ?>
                            <span class="label label-success">
                              <?php echo toSpaceCase(toClassCase($role)); ?>
                            </span>
                          <?php endif; ?>
                        <?php } ?>
                      </td>
                      <td>
                        <?php if (null != $user->auth()) { ?>
                          <?php if ($user->auth()->isActivated()) { ?>
                            <span class="label label-success">
                              Active
                            </span>
                          <?php } ?>

                          <?php if (!$user->auth()->isActivated()) { ?>
                            <span class="label label-info">
                              Inactive
                            </span>
                          <?php } ?>
                        <?php }  ?>
                        <?php if (null == $user->auth()) { ?>
                          <span class="label label-info">
                            N/A
                          </span>
                        <?php } ?>
                      </td>
                      <td><?php echo date('Y-m-d H:i:s', strtotime($user->created_at)); ?></td>
                      <td>
                        <div class="btn-group">
                          <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Actions
                            <i class="fa fa-angle-down"></i>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li>
                              <a href="<?php echo base_url('/admin/users/' . $user->id . '/edit'); ?>">
                                <i class="icon-docs"></i> Edit
                              </a>
                            </li>
                            <li>
                              <a href="<?php echo base_url('/admin/users/' . $user->id . '/wallet'); ?>">
                                <i class="icon-docs"></i> FitPocket
                              </a>
                            </li>
                            <li>
                              <a href="<?php echo base_url('admin/users/' . $user->id); ?>/delete" onclick="return confirm('Are you sure to delete this?');">
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
<!-- Main Content Ends -->
<?php $this->endSection(); ?>
