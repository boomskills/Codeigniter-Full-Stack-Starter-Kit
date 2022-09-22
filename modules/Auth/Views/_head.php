<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?php if (isset($head_title)) { ?><?php echo $head_title; ?> -
    <?php } ?><?php echo service('settings')->info->site_title; ?> </title>
  <meta name="description" content="<?php echo $meta_description; ?>">
  <meta name="keywords" content="<?php echo $meta_keywords; ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <meta property="og:site_name" content="<?php if (isset($head_title)) { ?><?php echo $head_title; ?> -
    <?php } ?><?php echo service('settings')->info->site_title; ?>">
  <meta property="og:title" content="<?php if (isset($head_title)) { ?><?php echo $head_title; ?> -
    <?php } ?><?php echo service('settings')->info->site_title; ?>" />
  <meta property="og:url" content="<?php echo base_url(); ?>" />
  <meta property="og:description" content="<?php if (isset($meta_description)) { ?><?php echo $meta_description;
                                                                                  } ?>" />
  <meta property="og:image" content="">
  <base href="<?php echo base_url(); ?>" />

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/adminlte/dist/css/adminlte.min.css">

</head>
