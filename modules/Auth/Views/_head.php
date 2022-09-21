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
  <meta property="og:image" content="<?php echo base_url(); ?>/static//static/assets/uploads/images/logo_green.png">
  <meta property="fb:app_id" content="<?php echo FACEBOOK_APP_ID; ?>">
  <meta property="og:type" content="website" />
  <meta property="og:updated_time" content="1536004946" />
  <base href="<?php echo base_url(); ?>" />

  <!-- FAVICONS -->
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>/static/assets/images/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>/static/assets/images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>/static/assets/images/favicon-16x16.png">
  <link rel="manifest" href="<?php echo base_url(); ?>/static/assets/images/site.webmanifest">
  <link rel="mask-icon" href="<?php echo base_url(); ?>/static/assets/images/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600,700,900" rel="stylesheet">

  <link href="<?php echo base_url(); ?>/static/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>/static/assets/global/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>/static/assets/global/css/baguetteBox.min.css" type="text/css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link href="<?php echo base_url(); ?>/static/assets/global/home/cityStridersMain.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>/static/assets/global/home/loader.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>/static/assets/global/home/carousel.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>/static/assets/global/home/category.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>/static/assets/global/home/animate.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>/static/assets/global/home/animations.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>/static/assets/global/home/responsive.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>/static/assets/global/home/nivo-slider.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>/static/assets/global/summernote.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>/static/assets/global/home/cookie-style.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>/static/assets/global/home/shop.css" rel="stylesheet" type="text/css" />


  <!--- Fancybox style-->
  <link href="<?php echo base_url(); ?>/static/assets/global/plugins/fancybox/jquery.fancybox.min.css" ref="stylesheet" type="text/css" />

  <link href="<?php echo base_url(); ?>/static/assets/global/home/font-awesome.css" rel="stylesheet" type="text/css" />

  <link href="<?php echo base_url(); ?>/static/assets/global/fonts/font-awesome.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>/static/assets/global/fonts/icomoon.css" rel="stylesheet" />


  <link rel="stylesheet" href="<?php echo base_url(); ?>/static/assets/global/css/flexslider.css" type="text/css" media="screen" />
  <!-- END THEME LAYOUT STYLES -->
  <link rel="shortcut icon" type='image/x-icon' href="favicon.ico" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>/static/assets/global/social-share-kit/css/social-share-kit.css" type="text/css" />

  <link href="<?php echo base_url(); ?>/static/assets/global/anim/css/introLoader.css" rel="stylesheet" type="text/css" />

  <link href="<?php echo base_url(); ?>/static/assets/global/anim/css/introLoader.css" rel="stylesheet" type="text/css" />

  <link href="<?php echo base_url(); ?>/static/assets/toastr/toastr.min.css" rel="stylesheet" type="text/css" />

  <?php echo $this->renderSection('pageStyles'); ?>

  <!-- SCRIPTS STARTS -->
  <script src="<?php echo base_url(); ?>/static/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>/static/assets/global/bootstrap/js/bootstrap.min.js" type="text/javascript">
  </script>
  <script src="<?php echo base_url(); ?>/static/assets/global/scripts/theme.js" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>/static/assets/global/scripts/baguetteBox.min.js" async>
  </script>

  <!--- Fancybox script-->
  <script type="text/javascript" src="<?php echo base_url(); ?>/static/assets/global/plugins/fancybox/jquery.fancybox.min.js"></script>

  <script type="text/javascript" src="<?php echo base_url(); ?>/static/assets/global/scripts/flexible-bootstrap-carousel.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>/static/assets/global/scripts/bootstrap-slider.js">
  </script>

  <script src="<?php echo base_url(); ?>/static/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript">
  </script>

  <script src="<?php echo base_url(); ?>/static/assets/global/scripts/jquery.flexslider.js" type="text/javascript">
  </script>
  <script src="<?php echo base_url(); ?>/static/assets/global/scripts/totop.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>/static/assets/global/scripts/jssor.slider-27.1.0.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>/static/assets/global/plugins/bootstrap-tabcollapse.js">
  </script>
  <!-- Summernote WYSIWYG-->
  <script src="<?php echo base_url(); ?>/static/assets/global/scripts/summernote.min.js" type="text/javascript">
  </script>

  <script type="text/javascript" src="<?php echo base_url(); ?>/static/assets/global/scripts/modernizr.js"></script>
  <script type="text/javascript" src='<?php echo base_url(); ?>/static/assets/global/social-share-kit/js/social-share-kit.js'></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>/static/assets/ckfinder/ckfinder.js"></script>

  <script type="text/javascript" src="<?php echo base_url(); ?>/static/assets/global/scripts/jquery.nivo.slider.js">
  </script>

  <script type="text/javascript" src="<?php echo base_url(); ?>/static/assets/global/anim/helpers/jquery.easing.1.3.js">
  </script>
  <script type="text/javascript" src="<?php echo base_url(); ?>/static/assets/global/anim/helpers/spin.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>/static/assets/global/anim/jquery.introLoader.js">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
  <script src="/static/assets/global/scripts/cookie-message.js" type="text/javascript"></script>
  <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js">
  </script>
  <script type="text/javascript" src="<?php echo base_url(); ?>/static/assets/global/plugins/moment.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>/static/assets/toastr/toastr.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip({
        placement: 'top',
        trigger: 'hover'
      });
    });
  </script>

  <?php echo $this->renderSection('pageScripts'); ?>
</head>
