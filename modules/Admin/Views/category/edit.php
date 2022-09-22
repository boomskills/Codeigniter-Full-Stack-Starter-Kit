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
                    <h1>Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/categories'); ?>">Categories</a></li>
                        <li class="breadcrumb-item active"><?php echo $category->name ?></li>
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
                            <h3 class="card-title"><?php echo $category->name ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php echo form_open('admin/categories/' . $category->id, ['class' => 'news-form', 'role' => 'form']); ?>
                            <?= csrf_field() ?>
                            <div class="row">
                                <input type="hidden" name="_method" value="PUT" />
                                <div class="col-sm-8">
                                    <div class="session clearfix">
                                        <div class="form-group">
                                            <label class="control-label">Title</label>
                                            <input type="text" id="title" value="<?php
                                                                                    if (set_value('title')) {
                                                                                        echo set_value('title');
                                                                                    } else {
                                                                                        echo $category->title;
                                                                                    }
                                                                                    ?>" class="form-control" name="title">
                                        </div>
                                        <div class="form-group">
                                            <label for="description" class="control-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" required>
                                             <?php echo $category->description; ?>
                                        </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-5 col-md-offset-3">
                                    <input type="submit" name="submit" id="btnSubmit" class="btn btn-large green btn-success" value="Save Changes" />
                                    <a href="<?php echo base_url('admin/categories'); ?>" class="btn btn-default btn-back">Back</a>
                                </div>
                            </div>
                            <?php form_close(); ?>
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
