<?php echo view('layout/head'); ?>
<?php $currentUrl = uri_string(); ?>

<body id="page">
  <div id="element" class="introLoading"></div>
  <div id="wrapper" class="wrapper">
    <header id="is-header" class="is-header header-container">
      <div class="header-top">
        <div class="container">
          <div class="row">
            <div class="col-sm-3">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myScrollspy">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <header class="header-home--default">
        <div class="container">
          <div class="content">
            <div class="row">
              <div class="banner-content">
                <div class="home-caption">
                  <div class="col-sm-3">
                    <div class="header-logo">
                      <a href="<?php echo base_url('/'); ?>">
                        <img src="<?php echo getImagePath(service('settings')->info->header_logo_right); ?>" alt="">
                      </a>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="header-action">
                      <div class="banner-content">
                        <h1 class="ml15">
                          <span class="word">City
                            Striders</span>
                          <span class="word"></span>
                        </h1>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="left-header header-logo--left">
                      <a href="<?php echo base_url('/'); ?>">
                        <img src="<?php echo getImagePath(service('settings')->info->header_logo_left); ?>" alt="">
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.banner-content -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.content -->
        </div>
        <!-- /.container -->
      </header>
      <div class="header-content">
        <div class="container">
          <nav id="nav" class="navbar navbar-default">
            <div class="navbar-collapse collapse" id="myScrollspy">
              <ul class="nav nav-sidebar">
                <li class="has-sub nav-item<?php if (false !== strpos($currentUrl, '/')) {
                                              echo ' active open';
                                            } ?>">
                  <a href="<?php echo base_url('/'); ?>">Home</a>
                </li>
                <li class="nav-item dropdown">
                  <a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">
                    About Us</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="<?php echo base_url('/about-us'); ?>" class="dropdown-item">
                        Profile
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="has-sub nav-item<?php if (false !== strpos($currentUrl, 'contact-us')) {
                                              echo ' active open';
                                            } ?>">
                  <a href="<?php echo base_url('/contact-us'); ?>">Contact Us</a>
                </li>
                <li class="nav-item dropdown">
                  <a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">
                    Club Info
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="<?php echo base_url('/clubs'); ?>" class="dropdown-item">
                        Clubs
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo base_url('/membership'); ?>" class="dropdown-item">
                        Memberships
                      </a>
                    </li>
                  </ul>
                </li>
                <!-- STORE START-->
                <li class="nav-item dropdown">
                  <a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">
                    Shop
                  </a>
                  <ul class="dropdown-menu">
                    <div class="store__nav">
                      <ul class="store__nav--items" id="shopNav">
                      </ul>
                    </div>
                  </ul>
                </li>
                <!-- STORE END -->
                <li class="nav-item dropdown">
                  <a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">
                    Events
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="<?php echo base_url('event/calendar'); ?>" class="dropdown-item">
                        CSC Events</a>
                    </li>
                    <li>
                      <a href="<?php echo base_url('national-event-calendar'); ?>" class="dropdown-item">
                        National Events
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="has-sub nav-item<?php if (false !== strpos($currentUrl, 'results')) {
                                              echo ' active open';
                                            } ?>">
                  <a href="<?php echo base_url('/results'); ?>">Results</a>
                </li>
                <li class="has-sub nav-item<?php if (false !== strpos($currentUrl, 'galleries')) {
                                              echo ' active open';
                                            } ?>">
                  <a href="<?php echo base_url('/galleries'); ?>">Galleries</a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </header>
    <!-- End .is-header -->
