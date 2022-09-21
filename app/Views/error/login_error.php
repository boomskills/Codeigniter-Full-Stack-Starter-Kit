<!DOCTYPE html>
<html>

<head>
  <title>Error!</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <!-- FAVICONS -->
  <link rel="apple-touch-icon" sizes="180x180" href="assets/favicons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/favicons/favicon-16x16.png">
  <link rel="manifest" href="assets/favicons/site.webmanifest">
  <link rel="mask-icon" href="assets/favicons/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  <base href="<?php echo base_url(); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/error.css">
  <!-- SCRIPTS STARTS -->
  <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
</head>

<body>
  <div class="error-page--global">
    <div class="error-page--description">
      <h4>Woo Hoo!</h4>
      <p><?php echo $message; ?></p> <br />
      <p><input type="button" onclick="window.history.back()" value="<<< Back" class="btn btn-default btn-sm" /> </p>
    </div>
  </div>
</body>

</html>