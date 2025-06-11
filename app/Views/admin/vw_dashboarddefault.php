

<?= view('layoutAdmin/header.php'); ?>
      <?= view('layoutAdmin/sidebar.php'); ?>
      <?= view('layoutAdmin/navbar.php'); ?>
      <style>
       /* .fixed-canvas {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
        max-width: 230px;
        aspect-ratio: 1 / 1;
        height: auto !important;
        box-sizing: border-box;
      }

      .card {
        max-width: 100%; */
      /* } */



      </style>
    </div>
    <div class="pxp-dashboard-content">
            <div class="pxp-dashboard-content-header">
                <div class="pxp-nav-trigger navbar pxp-is-dashboard d-lg-none">
                    <a role="button" data-bs-toggle="offcanvas" data-bs-target="#pxpMobileNav" aria-controls="pxpMobileNav">
                        <div class="pxp-line-1"></div>
                        <div class="pxp-line-2"></div>
                        <div class="pxp-line-3"></div>
                    </a>
                    <div class="offcanvas offcanvas-start pxp-nav-mobile-container pxp-is-dashboard" tabindex="-1" id="pxpMobileNav">
                        <div class="offcanvas-header">
                            <div class="pxp-logo">
                                <a href="index.html" class="pxp-animate"><span style="color: var(--pxpMainColor)">A</span>NP</a>
                            </div>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <nav class="pxp-nav-mobile">
                                <ul class="navbar-nav justify-content-end flex-grow-1">
                                    <li class="pxp-dropdown-header">Admin tools</li>
                                    <li class="pxp-active"><a href="<?= base_url('admin/dashboard') ?>"><span class="fa fa-home"></span>Dashboard</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/newjobs')?>"><span class="fa fa-file-text-o"></span>New Job Offer</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/managejobs')?>"><span class="fa fa-briefcase"></span>Manage Jobs</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/candidate')?>"><span class="fa fa-user-circle-o"></span>Candidates</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/reports') ?>"><span class="fa fa-lock"></span>Reports</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/administrator') ?>"><span class="fa fa-lock"></span>Reports</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <nav class="pxp-user-nav pxp-on-light">
                    <a href="<?= base_url('admin/newjobs') ?>" class="btn rounded-pill pxp-nav-btn">Post a Job</a>
                    <div class="dropdown pxp-user-nav-dropdown">
                        <a role="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                          <div class="pxp-user-nav-avatar pxp-cover" 
                              style="background-image: url('<?= esc(session()->get('user_avatar') ?? base_url('assets/images/customer-4.png')) ?>');">
                          </div>
                          <div class="pxp-user-nav-name d-none d-md-block">
                              <?= esc(session()->get('name') ?? 'Guest User') ?>
                          </div>
                      </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= site_url('logout') ?>">Logout</a></li>
                        </ul>
                    </div>
                </nav>
            </div>





            </script>
