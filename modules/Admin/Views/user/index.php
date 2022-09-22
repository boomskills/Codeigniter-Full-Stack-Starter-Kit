<!-- Main content start -->
<?php echo $this->extend($admin->viewLayout); ?>
<?php echo $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>User Management</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <?php echo view('Modules\Admin\Views\error\_error_block'); ?>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">All Users</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped" id="dynamic-table">
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
                  foreach ($users as $key => $r) { ?>
                    <tr>
                      <td>
                        <?php echo $key + 1; ?>
                      </td>
                      <td>
                        <?php echo htmlspecialchars($r->name, ENT_QUOTES, 'UTF-8'); ?>
                      </td>
                      <td class="hidden-sm">
                        <?php echo htmlspecialchars($r->email, ENT_QUOTES, 'UTF-8'); ?>
                      </td>
                      <td class="hidden-sm">
                        <?php foreach ($r->getRoles() as $role) { ?>
                          <?php if ("user" == $role) : ?>
                            <span class="badge badge-warning">
                              <?php echo toSpaceCase(toClassCase($role)); ?>
                            </span>
                          <?php else : ?>
                            <span class="badge badge-success">
                              <?php echo toSpaceCase(toClassCase($role)); ?>
                            </span>
                          <?php endif; ?>
                        <?php } ?>
                      </td>
                      <td>
                        <?php if (null != $r->auth()) { ?>
                          <?php if ($r->auth()->isActivated()) { ?>
                            <span class="badge badge-primary">
                              Active
                            </span>
                          <?php } ?>

                          <?php if (!$r->auth()->isActivated()) { ?>
                            <span class="badge badge-info">
                              Inactive
                            </span>
                          <?php } ?>
                        <?php }  ?>
                        <?php if (null == $r->auth()) { ?>
                          <span class="badge badge-danger">
                            N/A
                          </span>
                        <?php } ?>
                      </td>
                      <td><?php echo date('Y-m-d H:i:s', strtotime($r->created_at)); ?></td>
                      <td>
                        <div class="btn-group btn-group-sm">
                          <a href="<?php echo base_url('admin/users/' . $r->id); ?>/edit" data-id="<?php echo $r->id; ?>" class="btn btn-success">
                            <i class="fas fa-pencil-alt"> </i></a>

                          <a href="<?php echo base_url('admin/users/' . $r->id); ?>/delete" onclick="return confirm('Are you sure to delete this page?');" class="btn btn-danger">
                            <i class="fas fa-trash"></i> </a>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php $this->endSection(); ?>
