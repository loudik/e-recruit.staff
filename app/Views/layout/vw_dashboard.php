<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Jobs – Apply</title>

  <link rel="icon" href="<?= $logoPath ?>" type="image/png">

  <!-- HEAD (CSS & Favicon) -->
  <link rel="icon" href="<?= base_url('favicon.ico') ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?= base_url('assets/plugin/nouislider/nouislider.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/ebazar.style.min.css') ?>">
  <style>
    .job-card .meta{gap:.75rem}
    .job-card .meta i{opacity:.8}
    .job-badge{font-size:.75rem}
    .filter-title .title{display:block;font-weight:700}

     .hero-img{max-height:380px;object-fit:cover;width:100%}
  </style>
</head>
<body>
<div id="ebazar-layout" class="theme-blue">

  <!-- sidebar -->
  <div class="sidebar px-4 py-4 py-md-4 me-0">
    <div class="d-flex flex-column h-100">
      <a href="<?= base_url() ?>" class="mb-0 brand-icon">
        <span class="logo-icon"><i class="bi bi-briefcase-fill fs-4"></i></span>
        <span class="logo-text">Careers</span>
      </a>

      <ul class="menu-list flex-grow-1 mt-3">
        <li><a class="m-link" href="<?= base_url() ?>"><i class="icofont-home fs-5"></i> <span>Dashboard</span></a></li>

        <!-- Jobs menu -->
        <li class="collapsed">
          <a class="m-link active" data-bs-toggle="collapse" data-bs-target="#menu-jobs" href="#">
            <i class="icofont-briefcase-2 fs-5"></i> <span>Jobs</span>
            <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span>
          </a>
          <ul class="sub-menu collapse show" id="menu-jobs">
            <li><a class="ms-link active" href="#">Open Positions</a></li>
            <li><a class="ms-link" href="#">My Applications</a></li>
            <li><a class="ms-link" href="#">FAQ</a></li>
          </ul>
        </li>

        <!-- Keep other menus if needed -->
        <li><a class="m-link" href="#"><i class="icofont-page fs-5"></i> <span>Other Pages</span></a></li>
      </ul>

      <button type="button" class="btn btn-link sidebar-mini-btn text-light">
        <span class="ms-2"><i class="icofont-bubble-right"></i></span>
      </button>
    </div>
  </div>

  <!-- main body area -->
  <div class="main px-lg-4 px-md-4">

    <!-- Header -->
    <div class="header">
      <nav class="navbar py-4">
        <div class="container-xxl">

          <div class="h-right d-flex align-items-center mr-5 mr-lg-0 order-1">
            <div class="d-flex">
              <a class="nav-link text-primary collapsed" href="#" title="Get Help">
                <i class="icofont-info-square fs-5"></i>
              </a>
            </div>

            <div class="dropdown zindex-popover">
              <a class="nav-link dropdown-toggle pulse" href="#" role="button" data-bs-toggle="dropdown">
                <img src="<?= base_url('assets/images/flag/GB.png') ?>" alt="">
              </a>
              <div class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-md-end p-0 m-0 mt-3">
                <div class="card border-0">
                  <ul class="list-unstyled py-2 px-3">
                    <li><a href="#"><img src="<?= base_url('assets/images/flag/GB.png') ?>" alt=""> English</a></li>
                    <li><a href="#"><img src="<?= base_url('assets/images/flag/DE.png') ?>" alt=""> German</a></li>
                    <li><a href="#"><img src="<?= base_url('assets/images/flag/FR.png') ?>" alt=""> French</a></li>
                    <li><a href="#"><img src="<?= base_url('assets/images/flag/IT.png') ?>" alt=""> Italian</a></li>
                    <li><a href="#"><img src="<?= base_url('assets/images/flag/RU.png') ?>" alt=""> Russian</a></li>
                  </ul>
                </div>
              </div>
            </div>

            <?php
              $displayName = session('fullname') ?? session('ms_name') ?? 'Guest';
              $avatar      = session('avatar_url') ?? base_url('assets/images/profile_av.svg');
              ?>
              <div class="dropdown user-profile ml-2 ml-sm-3 d-flex align-items-center zindex-popover">
                <div class="u-info me-2">
                  <p class="mb-0 text-end line-height-sm ">
                    <span class="font-weight-bold"><?= esc($displayName) ?></span>
                  </p>
                  <small>Candidate</small>
                </div>
                <a class="nav-link dropdown-toggle pulse p-0" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static">
                  <img class="avatar lg rounded-circle img-thumbnail" src="<?= esc($avatar) ?>" alt="profile">
                </a>
                <div class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-end p-0 m-0">
                  <div class="card border-0 w280">
                    <div class="list-group m-2 ">
                      <a href="#" class="list-group-item list-group-item-action border-0 ">
                        <i class="icofont-ui-user fs-5 me-3"></i>Profile
                      </a>
                      <a href="<?= site_url('logoutstaff') ?>" class="list-group-item list-group-item-action border-0 ">
                        <i class="icofont-logout fs-5 me-3"></i>Signout
                      </a>
                    </div>
                  </div>
                </div>
              </div>


            <div class="setting ms-2">
              <a href="#" data-bs-toggle="modal" data-bs-target="#Settingmodal"><i class="icofont-gear-alt fs-5"></i></a>
            </div>
          </div>

          <!-- menu toggler -->
          <button class="navbar-toggler p-0 border-0 menu-toggle order-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainHeader">
            <span class="fa fa-bars"></span>
          </button>

          <!-- main menu Search-->
          <div class="order-0 col-lg-4 col-md-4 col-sm-12 col-12 mb-3 mb-md-0 ">
            <div class="input-group flex-nowrap input-group-lg">
              <input type="search" class="form-control" id="q" placeholder="Search jobs (title, keywords, department)" aria-label="search">
              <button type="button" class="input-group-text" id="btnSearch"><i class="fa fa-search"></i></button>
            </div>
          </div>

        </div>
      </nav>
    </div>



    <div id="jobsHero" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#jobsHero" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#jobsHero" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#jobsHero" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#jobsHero" data-bs-slide-to="3" aria-label="Slide 4"></button>
  </div>

  <div class="carousel-inner rounded-3 overflow-hidden shadow-sm">
    <div class="carousel-item active">
      <img src="<?= site_url('assets/images/img1.png') ?>" class="d-block w-100 hero-img" alt="Join our team">
      <div class="carousel-caption text-start d-none d-md-block">
        <h5 class="fw-bold">We’re Hiring</h5>
        <p>Grow your career with us.</p>
        <a href="#jobsGrid" class="btn btn-primary btn-sm">Lihat Lowongan</a>
      </div>
    </div>

    <div class="carousel-item">
      <img src="<?= site_url('assets/images/img1.png') ?>" class="d-block w-100 hero-img" alt="Engineering">
      <div class="carousel-caption d-none d-md-block">
        <h5 class="fw-bold">Engineering & IT</h5>
        <p>Build products that matter.</p>
      </div>
    </div>

    <div class="carousel-item">
      <!-- perbaikan syntax slide ke-3 -->
      <img src="<?= site_url('assets/images/img1.png') ?>" class="d-block w-100 hero-img" alt="Culture">
      <div class="carousel-caption text-end d-none d-md-block">
        <h5 class="fw-bold">Great Culture</h5>
        <p>Flexible, collaborative, impactful.</p>
      </div>
    </div>

    <div class="carousel-item">
      <!-- PAKAI salah satu src di bawah -->
      <!-- Jika file sudah dipindah ke public: -->
      <img src="<?= site_url('assets/images/img1.png') ?>" class="d-block w-100 hero-img" alt="Remote">
      <!-- Jika masih di writable via route: -->
      <!-- <img src="<?= site_url('assets/images/img1.png') ?>" class="d-block w-100 hero-img" alt="Remote"> -->
      <div class="carousel-caption d-none d-md-block">
        <h5 class="fw-bold">Remote Friendly</h5>
        <p>Bekerja dari mana saja.</p>
      </div>
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#jobsHero" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#jobsHero" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span>
  </button>
</div>


    <!-- Body -->
    <div class="body d-flex py-3">
      <div class="container-xxl">

        <!-- Title -->
        <div class="row align-items-center">
          <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
              <h3 class="fw-bold mb-0">Open Positions</h3>
              <div class="text-muted">Find a role and apply in minutes.</div>
            </div>
          </div>
        </div>

        <div class="row g-3 mb-3">
          <!-- Filters -->
          <div class="col-md-12 col-lg-4 col-xl-4 col-xxl-3">
            <div class="sticky-lg-top">
              <div class="card mb-3">
                <div class="reset-block d-flex justify-content-between align-items-center p-3">
                  <div class="filter-title"><h4 class="title mb-0">Filter</h4></div>
                  <button class="btn btn-primary" id="btnReset">Reset</button>
                </div>
              </div>

              <!-- Department -->
              <div class="card mb-3">
                <div class="p-3">
                  <div class="filter-title"><a class="title" data-bs-toggle="collapse" href="#fDept" aria-expanded="true">Department</a></div>
                  <div class="collapse show" id="fDept">
                    <div class="mt-2">
                      <div class="form-check"><input class="form-check-input f-dept" type="checkbox" value="IT" id="d-it"><label class="form-check-label" for="d-it">IT</label></div>
                      <div class="form-check"><input class="form-check-input f-dept" type="checkbox" value="Finance" id="d-fin"><label class="form-check-label" for="d-fin">Finance</label></div>
                      <div class="form-check"><input class="form-check-input f-dept" type="checkbox" value="HR" id="d-hr"><label class="form-check-label" for="d-hr">HR</label></div>
                      <div class="form-check"><input class="form-check-input f-dept" type="checkbox" value="Procurement" id="d-proc"><label class="form-check-label" for="d-proc">Procurement</label></div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Job Type -->
              <div class="card mb-3">
                <div class="p-3">
                  <div class="filter-title"><a class="title" data-bs-toggle="collapse" href="#fType" aria-expanded="true">Job Type</a></div>
                  <div class="collapse show" id="fType">
                    <div class="mt-2">
                      <div class="form-check"><input class="form-check-input f-type" type="checkbox" value="Full-time" id="t-ft"><label class="form-check-label" for="t-ft">Full-time</label></div>
                      <div class="form-check"><input class="form-check-input f-type" type="checkbox" value="Part-time" id="t-pt"><label class="form-check-label" for="t-pt">Part-time</label></div>
                      <div class="form-check"><input class="form-check-input f-type" type="checkbox" value="Contract" id="t-ct"><label class="form-check-label" for="t-ct">Contract</label></div>
                      <div class="form-check"><input class="form-check-input f-type" type="checkbox" value="Internship" id="t-int"><label class="form-check-label" for="t-int">Internship</label></div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Location -->
              <div class="card mb-3">
                <div class="p-3">
                  <div class="filter-title"><a class="title" data-bs-toggle="collapse" href="#fLoc" aria-expanded="true">Location</a></div>
                  <div class="collapse show" id="fLoc">
                    <div class="mt-2">
                      <div class="form-check"><input class="form-check-input f-loc" type="checkbox" value="Dili" id="l-dili"><label class="form-check-label" for="l-dili">Dili</label></div>
                      <div class="form-check"><input class="form-check-input f-loc" type="checkbox" value="Baucau" id="l-baucau"><label class="form-check-label" for="l-baucau">Baucau</label></div>
                      <div class="form-check"><input class="form-check-input f-loc" type="checkbox" value="Remote" id="l-remote"><label class="form-check-label" for="l-remote">Remote</label></div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Experience -->
              <div class="card mb-3">
                <div class="p-3">
                  <div class="filter-title"><a class="title" data-bs-toggle="collapse" href="#fExp" aria-expanded="true">Experience</a></div>
                  <div class="collapse show" id="fExp">
                    <div class="mt-2">
                      <select id="exp" class="form-select">
                        <option value="">Any</option>
                        <option>Junior (0–2y)</option>
                        <option>Mid (2–5y)</option>
                        <option>Senior (5y+)</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Salary Range -->
              <div class="card mb-3">
                <div class="p-3">
                  <div class="filter-title"><a class="title" data-bs-toggle="collapse" href="#fSalary" aria-expanded="true">Salary Range (USD)</a></div>
                  <div class="collapse show" id="fSalary">
                    <div class="price-range">
                      <div class="price-amount d-flex gap-2 flex-wrap">
                        <div class="flex-fill">
                          <label class="fw-bold">Min</label>
                          <input type="text" id="minAmount2" class="form-control">
                        </div>
                        <div class="flex-fill">
                          <label class="fw-bold">Max</label>
                          <input type="text" id="maxAmount2" class="form-control">
                        </div>
                      </div>
                      <div id="slider-range2" class="slider-range mt-3"></div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- Jobs list -->
          <div class="col-md-12 col-lg-8 col-xl-8 col-xxl-9">
            <div id="jobsGrid" class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-3">

              <!-- Job card -->
              <div class="col">
                <div class="card job-card h-100">
                  <div class="p-3">
                    <div class="d-flex justify-content-between align-items-start">
                      <h5 class="mb-1">Full-Stack Developer</h5>
                      <span class="badge bg-success job-badge">Full-time</span>
                    </div>
                    <div class="text-muted mb-2">IT • Dili</div>
                    <div class="meta d-flex flex-wrap text-muted mb-2">
                      <span><i class="icofont-money-bag"></i> $1,200–$1,800</span>
                      <span><i class="icofont-ui-calendar"></i> Posted Aug 10</span>
                    </div>
                    <p class="mb-3 small">Build and maintain web apps (Go/CI4, React). Work with PostgreSQL, Docker, Azure.</p>
                    <button class="btn btn-primary btn-sm btn-apply-job"
                            data-job-title="Full-Stack Developer"
                            data-job-loc="Dili"
                            data-job-type="Full-time">View &amp; Apply</button>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="card job-card h-100">
                  <div class="p-3">
                    <div class="d-flex justify-content-between align-items-start">
                      <h5 class="mb-1">Database Support (GIP)</h5>
                      <span class="badge bg-success job-badge">Full-time</span>
                    </div>
                    <div class="text-muted mb-2">Procurement • Dili</div>
                    <div class="meta d-flex flex-wrap text-muted mb-2">
                      <span><i class="icofont-money-bag"></i> $900–$1,300</span>
                      <span><i class="icofont-ui-calendar"></i> Posted Aug 05</span>
                    </div>
                    <p class="mb-3 small">Manage MySQL/PostgreSQL, troubleshoot user issues, support e-procurement workflows.</p>
                    <button class="btn btn-primary btn-sm btn-apply-job"
                            data-job-title="Database Support (GIP)"
                            data-job-loc="Dili"
                            data-job-type="Full-time">View &amp; Apply</button>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="card job-card h-100">
                  <div class="p-3">
                    <div class="d-flex justify-content-between align-items-start">
                      <h5 class="mb-1">HR Officer (Recruitment)</h5>
                      <span class="badge bg-warning text-dark job-badge">Contract</span>
                    </div>
                    <div class="text-muted mb-2">HR • Remote</div>
                    <div class="meta d-flex flex-wrap text-muted mb-2">
                      <span><i class="icofont-money-bag"></i> $700–$1,000</span>
                      <span><i class="icofont-ui-calendar"></i> Posted Aug 01</span>
                    </div>
                    <p class="mb-3 small">Run job postings, shortlist candidates, coordinate interviews, maintain ATS.</p>
                    <button class="btn btn-primary btn-sm btn-apply-job"
                            data-job-title="HR Officer (Recruitment)"
                            data-job-loc="Remote"
                            data-job-type="Contract">View &amp; Apply</button>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card job-card h-100">
                  <div class="p-3">
                    <div class="d-flex justify-content-between align-items-start">
                      <h5 class="mb-1">HR Officer (Recruitment)</h5>
                      <span class="badge bg-warning text-dark job-badge">Contract</span>
                    </div>
                    <div class="text-muted mb-2">HR • Remote</div>
                    <div class="meta d-flex flex-wrap text-muted mb-2">
                      <span><i class="icofont-money-bag"></i> $700–$1,000</span>
                      <span><i class="icofont-ui-calendar"></i> Posted Aug 01</span>
                    </div>
                    <p class="mb-3 small">Run job postings, shortlist candidates, coordinate interviews, maintain ATS.</p>
                    <button class="btn btn-primary btn-sm btn-apply-job"
                            data-job-title="HR Officer (Recruitment)"
                            data-job-loc="Remote"
                            data-job-type="Contract">View &amp; Apply</button>
                  </div>
                </div>
              </div>
              
              <div class="col">
                <div class="card job-card h-100">
                  <div class="p-3">
                    <div class="d-flex justify-content-between align-items-start">
                      <h5 class="mb-1">HR Officer (Recruitment)</h5>
                      <span class="badge bg-warning text-dark job-badge">Contract</span>
                    </div>
                    <div class="text-muted mb-2">HR • Remote</div>
                    <div class="meta d-flex flex-wrap text-muted mb-2">
                      <span><i class="icofont-money-bag"></i> $700–$1,000</span>
                      <span><i class="icofont-ui-calendar"></i> Posted Aug 01</span>
                    </div>
                    <p class="mb-3 small">Run job postings, shortlist candidates, coordinate interviews, maintain ATS.</p>
                    <button class="btn btn-primary btn-sm btn-apply-job"
                            data-job-title="HR Officer (Recruitment)"
                            data-job-loc="Remote"
                            data-job-type="Contract">View &amp; Apply</button>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="card job-card h-100">
                  <div class="p-3">
                    <div class="d-flex justify-content-between align-items-start">
                      <h5 class="mb-1">HR Officer (Recruitment)</h5>
                      <span class="badge bg-warning text-dark job-badge">Contract</span>
                    </div>
                    <div class="text-muted mb-2">HR • Remote</div>
                    <div class="meta d-flex flex-wrap text-muted mb-2">
                      <span><i class="icofont-money-bag"></i> $700–$1,000</span>
                      <span><i class="icofont-ui-calendar"></i> Posted Aug 01</span>
                    </div>
                    <p class="mb-3 small">Run job postings, shortlist candidates, coordinate interviews, maintain ATS.</p>
                    <button class="btn btn-primary btn-sm btn-apply-job"
                            data-job-title="HR Officer (Recruitment)"
                            data-job-loc="Remote"
                            data-job-type="Contract">View &amp; Apply</button>
                  </div>
                </div>
              </div>

            </div>

            <!-- Pagination (dummy) -->
            <div class="row g-3 mb-3">
              <div class="col-md-12">
                <nav class="justify-content-end d-flex">
                  <ul class="pagination">
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    





    


  </div><!-- /main -->
</div><!-- /layout -->

<!-- JS -->
<script src="<?= base_url('assets/bundles/libscripts.bundle.js') ?>"></script>
<script src="<?= base_url('assets/plugin/nouislider/nouislider.min.js') ?>"></script>
<script src="<?= base_url('assets/js/template.js')?>"></script>
<script>
  // Salary slider
  (function(){
    var stepsSlider2 = document.getElementById('slider-range2');
    var inputMin = document.getElementById('minAmount2');
    var inputMax = document.getElementById('maxAmount2');
    if(stepsSlider2){
      noUiSlider.create(stepsSlider2, {
        start: [600, 2000],
        connect: true,
        step: 50,
        range: {'min': 0, 'max': 5000}
      });
      stepsSlider2.noUiSlider.on('update', function (values, handle) {
        (handle ? inputMax : inputMin).value = Math.round(values[handle]);
      });
      // manual input -> slider
      function setFromInputs(){
        var min = parseInt(inputMin.value||0,10);
        var max = parseInt(inputMax.value||0,10);
        if(!isNaN(min) && !isNaN(max) && min <= max){
          stepsSlider2.noUiSlider.set([min, max]);
        }
      }
      inputMin.addEventListener('change', setFromInputs);
      inputMax.addEventListener('change', setFromInputs);
    }
  })();

  // Reset filters
  document.getElementById('btnReset').addEventListener('click', function(){
    document.querySelectorAll('.f-dept,.f-type,.f-loc').forEach(el=>{el.checked=false;});
    const exp = document.getElementById('exp'); if(exp) exp.value='';
    const q = document.getElementById('q'); if(q) q.value='';
    const min = document.getElementById('minAmount2'), max = document.getElementById('maxAmount2');
    if(min) min.value=600; if(max) max.value=2000;
    const slider = document.getElementById('slider-range2');
    if(slider && slider.noUiSlider){ slider.noUiSlider.set([600,2000]); }
  });

  // Open Apply modal with job data
  const applyModalEl = document.getElementById('applyJobModal');
  const applyModal = new bootstrap.Modal(applyModalEl);
  document.querySelectorAll('.btn-apply-job').forEach(btn=>{
    btn.addEventListener('click', function(){
      const title = this.dataset.jobTitle || 'Job';
      const loc = this.dataset.jobLoc || '';
      const type = this.dataset.jobType || '';
      document.getElementById('applyJobTitle').textContent = title;
      document.getElementById('applyJobLoc').value = loc;
      document.getElementById('applyHiddenJobTitle').value = title;
      document.getElementById('applyHiddenJobType').value = type;
      applyModal.show();
    });
  });

  // Submit application (POST to CI4 endpoint)
  document.getElementById('applyForm').addEventListener('submit', async function(e){
    e.preventDefault();
    const form = e.target;
    const fd = new FormData(form);
    try{
      const res = await fetch("<?= site_url('jobs/apply') ?>", {
        method: 'POST',
        body: fd
      });
      if(!res.ok) throw new Error('Network error');
      // Expect JSON {success:true,message:"..."}
      const data = await res.json().catch(()=>({success:true}));
      alert(data.message || 'Application submitted. Thank you!');
      form.reset();
      applyModal.hide();
    }catch(err){
      console.error(err);
      alert('Failed to submit application. Please try again.');
    }
  });
</script>
</body>
</html>
