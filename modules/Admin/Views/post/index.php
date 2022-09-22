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
          <h1>Posts</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Posts</li>
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
              <h3 class="card-title">All Posts</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="dynamic-table" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Create At</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($posts as $r) { ?>
                    <tr>
                      <td><?php echo date('Y-m-d H:i:s', strtotime($r->created_at)); ?></td>
                      <td><?php echo $r->title; ?>
                      </td>
                      <td>
                        <?php if (strlen($r->short_description) > 140) {
                          echo strip_tags(substr($r->short_description, 0, 140) . '...');
                        } else {
                          echo strip_tags(substr($r->short_description, 0, 140));
                        } ?>
                      </td>
                      <td>
                        <div class="btn-group btn-group-sm">
                          <a href="<?php echo base_url('admin/posts/' . $r->id . '/edit'); ?>" class="btn btn-success">
                            <i class="fas fa-pencil-alt"> </i></a>
                          <?php if (!$r->isPublished()) { ?>
                            <a href="<?php echo base_url('admin/posts/' . $r->id . '/status'); ?>" onclick="return confirm('Are you sure to publish this event?');" class="btn btn-primary">
                              <i class="fas fa-check"> </i>
                              Publish
                            </a>
                          <?php } ?>
                          <?php if ($r->isPublished()) { ?>
                            <a href="<?php echo base_url('admin/posts/' . $r->id . '/status'); ?>" onclick="return confirm('Are you sure to unpublish this event?');" class="btn btn-secondary">
                              <i class="fas fa-check"> </i>
                              Unpublish
                            </a>
                          <?php } ?>
                          <a href="<?php echo base_url('admin/posts/' . $r->id); ?>/delete" onclick="return confirm('Are you sure to delete this page?');" class="btn btn-danger">
                            <i class="fas fa-trash"></i></a>
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
