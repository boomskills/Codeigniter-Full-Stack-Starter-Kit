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
            <i class="fa fa-newspapre"></i> All Posts
          </header>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <a href="<?php echo base_url('admin/posts/new'); ?>" class="btn btn-default add">
                  <i class="fa fa-plus"></i> Create New Post
                </a>
              </div>
            </div>
            <div class="table-responsive">
              <table id="dynamic-table" class="table table-striped table-bordered" cellspacing="0">
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
                        <div class="btn-group">
                          <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Actions
                            <i class="fa fa-angle-down"></i>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li>
                              <a href="<?php echo base_url('admin/posts/' . $r->id . '/edit'); ?>">
                                <i class="icon-docs"></i> Edit </a>
                            </li>
                            <?php if (!$r->isPublished()) { ?>
                              <li>
                                <a href="<?php echo base_url('admin/posts/' . $r->id . '/status'); ?>" onclick="return confirm('Are you sure to publish this event?');">
                                  <i class="icon-docs">
                                  </i>
                                  Publish
                                </a>
                              </li>
                            <?php } ?>
                            <?php if ($r->isPublished()) { ?>
                              <li>
                                <a href="<?php echo base_url('admin/posts/' . $r->id . '/status'); ?>" onclick="return confirm('Are you sure to unpublish this event?');">
                                  <i class="icon-docs">
                                  </i>
                                  Unpublish
                                </a>
                              </li>
                            <?php } ?>
                            <li>
                              <a href="<?php echo base_url('admin/posts/' . $r->id); ?>/delete" onclick="return confirm('Are you sure to delete this page?');">
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
<?php $this->endSection(); ?>
