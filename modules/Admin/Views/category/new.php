<?php echo $this->extend($admin->viewLayout); ?>
<?php echo $this->section('content'); ?>

<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-file"></i>
                        Create New Category
                    </header>
                    <div class="panel-body">
                        <?php echo form_open_multipart('admin/categories', ['class' => 'news-form', 'role' => 'form']); ?>
                        <div class="row">
                            <?php echo view('Modules\Admin\Views\error\_error_block'); ?>
                            <div class="col-sm-8">
                                <div class="session clearfix">
                                    <div class="form-group">
                                        <label class="control-label">Type</label>
                                        <input type="text" id="title" class="form-control" name="title" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="control-label">Description</label>
                                        <textarea class="form-control" id="description" name="description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-5 col-md-offset-3">
                                <input type="submit" name="submit" id="btnSubmit" class="btn btn-large green btn-success" value="Create" />
                                <a href="<?php echo base_url('admin/categories'); ?>" class="btn btn-default btn-back">Back</a>
                            </div>
                        </div>
                        <?php form_close(); ?>
                        <!-- // end form -->
                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>
<?php $this->endSection(); ?>
