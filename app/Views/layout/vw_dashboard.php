<!doctype html>
<html lang="en" class="pxp-root">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/owl.carousel.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/owl.theme.default.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/animate.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

        <title>Home Recruitment</title>
    </head>
    <body>
        <div class="pxp-preloader"><span>Loading...</span></div>

        <header class="pxp-header fixed-top">
            <div class="pxp-container">
                <div class="pxp-header-container">
                    <div class="pxp-logo">
                        <a href="index.html" class="pxp-animate"><span style="color: var(--pxpMainColor)">A</span>NP</a>
                    </div>
                    <div class="pxp-nav-trigger navbar d-xl-none flex-fill">
                        <a role="button" data-bs-toggle="offcanvas" data-bs-target="#pxpMobileNav" aria-controls="pxpMobileNav">
                            <div class="pxp-line-1"></div>
                            <div class="pxp-line-2"></div>
                            <div class="pxp-line-3"></div>
                        </a>
                        <div class="offcanvas offcanvas-start pxp-nav-mobile-container" tabindex="-1" id="pxpMobileNav">
                            <div class="offcanvas-header">
                                <div class="pxp-logo">
                                    <a href="index.html" class="pxp-animate"><span style="color: var(--pxpMainColor)">j</span>obster</a>
                                </div>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <nav class="pxp-nav-mobile">
                                    <ul class="navbar-nav justify-content-end flex-grow-1">
                                        <li class="nav-item dropdown">
                                            <a role="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Home</a>

                                        </li>
                                        <li class="nav-item dropdown">
                                            <a role="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Find Jobs</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <nav class="pxp-nav dropdown-hover-all d-none d-xl-block">
                        <ul>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">Home</a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">Find Jobs GIP</a>
                            </li>
                        </ul>
                    </nav>
                    <nav class="pxp-user-nav d-none d-sm-flex">
                        <a href="company-dashboard-new-job.html" class="btn rounded-pill pxp-nav-btn">Post a Job</a>
                        <a class="btn rounded-pill pxp-user-nav-trigger pxp-on-light" data-bs-toggle="modal" href="#pxp-signin-modal" role="button">Sign in</a>
                    </nav>
                </div>
            </div>
        </header>

        <section class="pxp-hero vh-100" style="background-color: var(--pxpMainColorLight);">
            <div class="pxp-hero-caption">
                <div class="pxp-container">
                    <div class="row pxp-pl-80 align-items-center justify-content-between">
                        <div class="col-12 col-xl-6 col-xxl-5">
                            <h1>Find the perfect<br><span style="color: var(--pxpMainColor);">job</span> for you</h1>
                            <div class="pxp-hero-form pxp-hero-form-round mt-3 mt-lg-4">
                                <form class="row gx-3 align-items-center" action="jobs-list-1.html">
                                    <div class="col-12 col-sm">
                                        <div class="mb-3 mb-sm-0">
                                            <input type="text" class="form-control" placeholder="Job Title or Keyword">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm pxp-has-left-border">
                                        <div class="mb-3 mb-sm-0">
                                            <input type="text" class="form-control" placeholder="Location">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-auto">
                                        <button><span class="fa fa-search"></span></button>
                                    </div>
                                </form>
                            </div>

                            <div class="pxp-hero-searches-container">
                                <div class="pxp-hero-searches-label">Popular Searches</div>
                                <div class="pxp-hero-searches">
                                    <div class="pxp-hero-searches-items">
                                        <a href="jobs-list-1.html">Work from home</a>
                                        <a href="jobs-list-1.html">Part-time</a>
                                        <a href="jobs-list-1.html">Administration</a>
                                        <a href="jobs-list-1.html">Finance</a>
                                        <a href="jobs-list-1.html">Retail</a>
                                        <a href="jobs-list-1.html">IT</a>
                                        <a href="jobs-list-1.html">Engineering</a>
                                        <a href="jobs-list-1.html">Sales</a>
                                        <a href="jobs-list-1.html">Manufacturing</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-none d-xl-block col-xl-5 position-relative">
                            <div class="pxp-hero-cards-container pxp-animate-cards pxp-mouse-move" data-speed="160">
                                <div class="pxp-hero-card pxp-cover pxp-cover-top" style="background-image: url('<?= base_url('assets/images/jobs1.jpg'); ?>');"></div>
                                <div class="pxp-hero-card-dark"></div>
                                <div class="pxp-hero-card-light"></div>
                            </div>

                            <div class="pxp-hero-card-info-container pxp-mouse-move" data-speed="60">
                                <div class="pxp-hero-card-info pxp-animate-bounce">
                                    <div class="pxp-hero-card-info-item">
                                        <div class="pxp-hero-card-info-item-number">286<span>job offers</span></div>
                                        <div class="pxp-hero-card-info-item-description">in Business Development</div>
                                    </div>
                                    <div class="pxp-hero-card-info-item">
                                        <div class="pxp-hero-card-info-item-number">154<span>job offers</span></div>
                                        <div class="pxp-hero-card-info-item-description">in Marketing & Communication</div>
                                    </div>
                                    <div class="pxp-hero-card-info-item">
                                        <div class="pxp-hero-card-info-item-number">319<span>job offers</span></div>
                                        <div class="pxp-hero-card-info-item-description">in Human Resources</div>
                                    </div>
                                    <div class="pxp-hero-card-info-item">
                                        <div class="pxp-hero-card-info-item-number">120<span>job offers</span></div>
                                        <div class="pxp-hero-card-info-item-description">in Project Management</div>
                                    </div>
                                    <div class="pxp-hero-card-info-item">
                                        <div class="pxp-hero-card-info-item-number">176<span>job offers</span></div>
                                        <div class="pxp-hero-card-info-item-description">in Customer Service</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="pxp-hero-right-bg-card pxp-has-animation"></div>
        </section>



        <section class="mt-100">
            <div class="pxp-container">
                <div class="row">
                    <div class="col-lg-5 col-xl-4 col-xxl-3">
                        <div class="pxp-jobs-list-side-filter">
                            <div class="pxp-list-side-filter-header d-flex d-lg-none">
                                <div class="pxp-list-side-filter-header-label">Filter Jobs</div>
                                <a role="button"><span class="fa fa-sliders"></span></a>
                            </div>
                            <div class="mt-4 mt-lg-0 d-lg-block pxp-list-side-filter-panel">
                                <h3>Search by Keywords</h3>
                                <div class="mt-2 mt-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><span class="fa fa-search"></span></span>
                                        <input type="text" class="form-control" placeholder="Job Title or Keyword">
                                    </div>
                                </div>
                                <h3 class="mt-3 mt-lg-4">Category</h3>
                                <div class="mt-2 mt-lg-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><span class="fa fa-folder-o"></span></span>
                                        <select class="form-select">
                                            <option selected="">All categories</option>
                                            <option>Business Development</option>
                                            <option>Construction</option>
                                            <option>Customer Service</option>
                                            <option>Finance</option>
                                            <option>Healthcare</option>
                                            <option>Human Resources</option>
                                            <option>Marketing &amp; Communication</option>
                                            <option>Project Management</option>
                                            <option>Software Engineering</option>
                                        </select>
                                    </div>
                                </div>

                                <h3 class="mt-3 mt-lg-4">Type of Employment</h3>
                                <div class="list-group mt-2 mt-lg-3">
                                    <label class="list-group-item d-flex justify-content-between align-items-center pxp-checked">
                                        <span class="d-flex">
                                            <input class="form-check-input me-2" type="checkbox" value="" checked>
                                            Full Time
                                        </span>
                                        <span class="badge rounded-pill">56</span>
                                    </label>
                                    <label class="list-group-item d-flex justify-content-between align-items-center mt-2 mt-lg-3">
                                        <span class="d-flex">
                                            <input class="form-check-input me-2" type="checkbox" value="">
                                            Part Time
                                        </span>
                                        <span class="badge rounded-pill">34</span>
                                    </label>
                                    <label class="list-group-item d-flex justify-content-between align-items-center mt-2 mt-lg-3">
                                        <span class="d-flex">
                                            <input class="form-check-input me-2" type="checkbox" value="">
                                            Remote
                                        </span>
                                        <span class="badge rounded-pill">24</span>
                                    </label>
                                    <label class="list-group-item d-flex justify-content-between align-items-center mt-2 mt-lg-3">
                                        <span class="d-flex">
                                            <input class="form-check-input me-2" type="checkbox" value="">
                                            Internship
                                        </span>
                                        <span class="badge rounded-pill">27</span>
                                    </label>
                                    <label class="list-group-item d-flex justify-content-between align-items-center mt-2 mt-lg-3">
                                        <span class="d-flex">
                                            <input class="form-check-input me-2" type="checkbox" value="">
                                            Contract
                                        </span>
                                        <span class="badge rounded-pill">76</span>
                                    </label>
                                    <label class="list-group-item d-flex justify-content-between align-items-center mt-2 mt-lg-3">
                                        <span class="d-flex">
                                            <input class="form-check-input me-2" type="checkbox" value="">
                                            Training
                                        </span>
                                        <span class="badge rounded-pill">28</span>
                                    </label>
                                </div>

                                <h3 class="mt-3 mt-lg-4">Experience Level</h3>
                                <div class="list-group mt-2 mt-lg-3">
                                    <label class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="d-flex">
                                            <input class="form-check-input me-2" type="checkbox" value="">
                                            No Experience
                                        </span>
                                        <span class="badge rounded-pill">98</span>
                                    </label>
                                    <label class="list-group-item d-flex justify-content-between align-items-center mt-2 mt-lg-3 pxp-checked">
                                        <span class="d-flex">
                                            <input class="form-check-input me-2" type="checkbox" value="" checked>
                                            Entry-Level
                                        </span>
                                        <span class="badge rounded-pill">44</span>
                                    </label>
                                    <label class="list-group-item d-flex justify-content-between align-items-center mt-2 mt-lg-3 pxp-checked">
                                        <span class="d-flex">
                                            <input class="form-check-input me-2" type="checkbox" value="" checked>
                                            Mid-Level
                                        </span>
                                        <span class="badge rounded-pill">35</span>
                                    </label>
                                    <label class="list-group-item d-flex justify-content-between align-items-center mt-2 mt-lg-3">
                                        <span class="d-flex">
                                            <input class="form-check-input me-2" type="checkbox" value="">
                                            Senior-Level
                                        </span>
                                        <span class="badge rounded-pill">45</span>
                                    </label>
                                    <label class="list-group-item d-flex justify-content-between align-items-center mt-2 mt-lg-3">
                                        <span class="d-flex">
                                            <input class="form-check-input me-2" type="checkbox" value="">
                                            Manager / Executive
                                        </span>
                                        <span class="badge rounded-pill">21</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-xl-8 col-xxl-9">
                        <div class="pxp-jobs-list-top mt-4 mt-lg-0">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h2><span class="pxp-text-light">Showing</span> 8,536 <span class="pxp-text-light">jobs</span></h2>
                                </div>
                                <div class="col-auto">
                                    <select class="form-select">
                                        <option value="0" selected>Most relevant</option>
                                        <option value="1">Newest</option>
                                        <option value="2">Oldest</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div>
                        <?php foreach ($jobs as $job): ?>
                            <div class="pxp-jobs-card-3 pxp-has-border mb-4">
                              <div class="row align-items-center justify-content-between">
                                <div class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-xxl-auto">
                                  <a href="#" class="pxp-jobs-card-3-company-logo" style="background-image: url('<?= base_url('assets/images/customer-1.png'); ?>');"></a>
                                </div>
                                <div class="col-sm-9 col-md-10 col-lg-9 col-xl-10 col-xxl-4">
                                  <a href="<?= base_url('job/' . $job['id']) ?>" class="pxp-jobs-card-3-title mt-3 mt-sm-0">
                                    <?= esc($job['jobs']) ?>
                                  </a>
                                  <div class="pxp-jobs-card-3-details">
                                    <a href="#" class="pxp-jobs-card-3-location">
                                      <span class="fa fa-globe"></span><?= esc($job['loc']) ?>
                                    </a>
                                  <div class="pxp-jobs-card-3-type"><?= esc($job['type']) ?></div>
                                </div>
                              </div>
                              <div class="col-sm-8 col-xl-6 col-xxl-4 mt-3 mt-xxl-0 d-flex flex-column align-items-start align-items-xxl-end">
                                <a href="#" class="pxp-jobs-card-3-category mb-2">
                                  <div class="pxp-jobs-card-3-category-label"><?= esc($job['category']) ?></div>
                                </a>
                              </div>
                              <div class="col-sm-4 col-xl-2 col-xxl-auto mt-3 mt-xxl-0 pxp-text-right">
                                <a href="<?= base_url('/getformregistration') ?>" class="btn rounded-pill pxp-card-btn">Apply</a>
                              </div>
                            </div>
                          </div>
                        <?php endforeach; ?>
                        </div>


                        <div class="row mt-4 mt-lg-5 justify-content-between align-items-center">
                            <div class="col-auto">
                                <nav class="mt-3 mt-sm-0" aria-label="Jobs list pagination">
                                    <ul class="pagination pxp-pagination">
                                        <li class="page-item active" aria-current="page">
                                            <span class="page-link">1</span>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-auto">
                                <a href="#" class="btn rounded-pill pxp-section-cta mt-3 mt-sm-0">Show me more<span class="fa fa-angle-right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <footer class="pxp-main-footer mt-100">
            <div class="pxp-main-footer-top pt-100 pb-100" style="background-color: var(--pxpMainColorLight);">
                <div class="pxp-container">
                    <div class="row">
                        <div class="col-lg-6 col-xl-5 col-xxl-4 mb-4">
                            <div class="pxp-footer-logo">
                                <a href="index.html" class="pxp-animate"><span style="color: var(--pxpMainColor)">j</span>obster</a>
                            </div>
                            <div class="pxp-footer-section mt-3 mt-md-4">
                                <h3>Call us</h3>
                                <div class="pxp-footer-phone">(123) 456-7890</div>
                            </div>
                            <div class="mt-3 mt-md-4 pxp-footer-section">
                                <div class="pxp-footer-text">
                                    90 Fifth Avenue, 3rd Floor<br>
                                    San Francisco, CA 1980<br>
                                    office@jobster.com
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-7 col-xxl-8">
                            <div class="row">
                                <div class="col-md-6 col-xl-4 col-xxl-3 mb-4">
                                    <div class="pxp-footer-section">
                                        <h3>For Candidates</h3>
                                        <ul class="pxp-footer-list">
                                            <li><a href="jobs-list-1.html">Find Jobs</a></li>
                                            <li><a href="candidate-dashboard.html">Candidate Dashboard</a></li>
                                            <li><a href="candidate-dashboard-applications.html">My Applications</a></li>
                                            <li><a href="candidate-dashboard-fav-jobs.html">Favourite Jobs</a></li>
                                            <li><a href="candidate-dashboard-inbox.html">My inbox</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4 col-xxl-3 mb-4">
                                    <div class="pxp-footer-section">
                                        <h3>For Employers</h3>
                                        <ul class="pxp-footer-list">
                                            <li><a href="candidates-list-1.html">Find Candidates</a></li>
                                            <li><a href="company-dashboard.html">Company Dashboard</a></li>
                                            <li><a href="company-dashboard-new-job.html">Post a Job</a></li>
                                            <li><a href="company-dashboard-jobs.html">Manage Jobs</a></li>
                                            <li><a href="company-dashboard-candidates.html">Candidates</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4 col-xxl-3 mb-4">
                                    <div class="pxp-footer-section">
                                        <h3>About Us</h3>
                                        <ul class="pxp-footer-list">
                                            <li><a href="about-us.html">About Us</a></li>
                                            <li><a href="pricing.html">Pricing</a></li>
                                            <li><a href="blog-list-1.html">Blog</a></li>
                                            <li><a href="blog-list-1.html">Contact Us</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4 col-xxl-3 mb-4">
                                    <div class="pxp-footer-section">
                                        <h3>Helpful Resources</h3>
                                        <ul class="pxp-footer-list">
                                            <li><a href="faqs.html">FAQs</a></li>
                                            <li><a href="sign-in.html">Sign In</a></li>
                                            <li><a href="sign-up.html">Sign Up</a></li>
                                            <li><a href="404.html">404 Page</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pxp-main-footer-bottom" style="background-color: var(--pxpMainColorLight);">
                <div class="pxp-container">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-auto">
                            <div class="pxp-footer-copyright pxp-text-light">© 2025 ANP. All Right Reserved.</div>
                        </div>
                        <div class="col-lg-auto">
                            <div class="pxp-footer-social mt-3 mt-lg-0">
                                <ul class="list-unstyled">
                                    <li><a href="#"><span class="fa fa-facebook"></span></a></li>
                                    <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fa fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fa fa-linkedin"></span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <div class="modal fade pxp-user-modal" id="pxp-signin-modal" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="pxp-user-modal-fig text-center">
                            <img src="<?= base_url('assets/images/signin-fig.png')?>" alt="Sign in">
                        </div>
                        <h5 class="modal-title text-center mt-4" id="signinModal">Welcome back!</h5>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" placeholder="Email address">
                                <label for="pxp-signin-email">Email address</label>
                                <span class="fa fa-envelope-o"></span>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" placeholder="Password">
                                <label for="pxp-signin-password">Password</label>
                                <span class="fa fa-lock"></span>
                            </div>
                              <button type="submit" class="btn rounded-pill pxp-modal-cta w-100" onclick="fn_login()">Login</button>
                            <div class="mt-4 text-center pxp-modal-small">
                                <a href="#" class="pxp-modal-link">Forgot password</a>
                            </div>
                            <div class="mt-4 text-center pxp-modal-small">
                                New to Account? <a role="button" class="" data-bs-target="#pxp-signup-modal" data-bs-toggle="modal" data-bs-dismiss="modal">Create an account</a>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade pxp-user-modal" id="pxp-signup-modal" aria-hidden="true" aria-labelledby="signupModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="pxp-user-modal-fig text-center">
                            <img src="images/signup-fig.png" alt="Sign up">
                        </div>
                        <h5 class="modal-title text-center mt-4" id="signupModal">Create an account</h5>
                        <form class="mt-4">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="pxp-signup-email" placeholder="Email address">
                                <label for="pxp-signup-email">Email address</label>
                                <span class="fa fa-envelope-o"></span>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="pxp-signup-password" placeholder="Create password">
                                <label for="pxp-signup-password">Create password</label>
                                <span class="fa fa-lock"></span>
                            </div>
                            <a href="#" class="btn rounded-pill pxp-modal-cta">Continue</a>
                            <div class="mt-4 text-center pxp-modal-small">
                                Already have an account? <a role="button" class="" data-bs-target="#pxp-signin-modal" data-bs-toggle="modal">Sign in</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?= base_url('assets/js/jquery-3.4.1.min.js') ?>"></script>
      <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
      <script src="<?= base_url('assets/js/owl.carousel.min.js') ?>"></script>
      <script src="<?= base_url('assets/js/nav.js') ?>"></script>
      <script src="<?= base_url('assets/js/main.js') ?>"></script>

      <script>
          function fn_login ()
        {
          var email = ('#email').val();
          var password = ('#password').val();
          
        }

    async function fn_login() {
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;

      const formData = new FormData();
      formData.append('email', email);
      formData.append('password', password);

      try {
        const response = await fetch('admin/login', {
          method: 'POST',
          body: formData,
        });
        const data = await response.json();
        if (response.ok) {
          document.getElementById('result').innerText = 'Login berhasil!';
          window.location.href = '<?= base_url('admin/dashboard') ?>';
        } else {
          document.getElementById('result').innerText = data.message || 'Login gagal';
        }
      } catch (err) {
        document.getElementById('result').innerText = 'Error: ' + err.message;
      }
    }
  </script>
    </body>
</html>