<?php if (session()->has('success')) { ?>
<div class="alert alert-success">
  <?php echo session('success'); ?>
</div>
<?php } ?>

<?php if (session()->has('error')) { ?>
<div class="alert alert-danger">
  <?php echo session('error'); ?>
</div>
<?php } ?>

<?php if (session()->has('errors')) { ?>
<ul class="alert alert-danger">
  <?php foreach (session('errors') as $error) { ?>
  <li><?php echo $error; ?></li>
  <?php } ?>
</ul>
<?php } ?>