<?php echo view('Modules\Admin\layout\_head'); ?>

<body class="skin-blue fuelux">
  <div class="se-pre-con"></div>
  <section id="container">
    <!--header start-->
    <header class="header white-bg">
      <div class="sidebar-toggle-box">
        <i class="fa fa-bars">
        </i>
      </div>
      <!--logo start-->
      <a href="<?php echo base_url(); ?>" class="logo">
        <?php echo service('settings')->info->site_title; ?>
      </a>
      <!--logo end-->
      <div class="top-nav ">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
          <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <span class="username">
                <?php echo $user->info->username; ?>
              </span>
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
              <div class="log-arrow-up">
              </div>
              <li><a href="<?php echo base_url(); ?>/auth/logout">
                  <i class="fa fa-key"></i> Logout</a>
              </li>
            </ul>
          </li>
          <!-- user login dropdown end -->
        </ul>
        <!--search & user info end-->
      </div>
    </header>
    <!--header end-->
