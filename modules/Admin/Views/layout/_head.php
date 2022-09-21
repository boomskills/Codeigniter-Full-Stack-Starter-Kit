<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Holoog Techonologies, cc">
  <link rel="shortcut icon" href="images/favicon.png">
  <meta name="robots" content="noindex">
  <?= csrf_meta() ?>
  <base href="<?php echo base_url(); ?>" />
  <title>
    <?php if (isset($panel_title)) { ?><?php echo $panel_title; ?> -
    <?php } ?><?php echo service('settings')->info->site_title; ?>

  </title>

  <!--INCLUDED SCRIPTS -->
  <?php echo view('Modules\Admin\Views\layout/_scripts'); ?>

  <script type="text/javascript" src="<?php echo base_url(); ?>/static/admin/scripts/chosen/chosen.jquery.min.js">
  </script>

</head>
