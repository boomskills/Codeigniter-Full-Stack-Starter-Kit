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

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/adminlte/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/css/dashboard.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/adminlte/plugins/summernote/summernote-bs4.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- jQuery -->
  <script src="<?php echo base_url(); ?>/assets/adminlte/plugins/jquery/jquery.min.js"></script>

</head>
