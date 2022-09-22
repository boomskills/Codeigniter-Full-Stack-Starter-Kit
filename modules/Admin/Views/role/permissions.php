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
            <li class="breadcrumb-item active">Permissions</li>
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
              <h3 class="card-title">Permissions</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="dynamic-table" class="table table-striped table-bordered">
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
                        <div class="btn-group btn-group-sm">
                          <a href="<?php echo base_url('admin/permissions/' . $r->id); ?>/edit" data-id="<?php echo $r->id; ?>" class="btn btn-success">
                            <i class="fas fa-pencil-alt"> </i></a>

                          <a href="<?php echo base_url('admin/permissions/' . $r->id); ?>/delete" onclick="return confirm('Are you sure to delete this page?');" class="btn btn-danger">
                            <i class="fas fa-trash"></i> </a>
                        </div>
                      </td>
                    </tr>
                  <?php
                  } ?>
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
<script>
  function editPermission(permission) {

  }
</script>
<?php $this->endSection(); ?>
