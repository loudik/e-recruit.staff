

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
                               <a href="#" class="pxp-animate">
                                    <img src="<?= base_url('anplogo.png') ?>" alt="Logo" style="height: 60px;">
                                </a>
                            </div>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <nav class="pxp-nav-mobile">
                                <ul class="navbar-nav justify-content-end flex-grow-1">
                                    <li class="pxp-dropdown-header">Admin tools</li>
                                  <?= session()->get('treemenu') ?? '' ?>
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

            <div class="pxp-dashboard-content-details">
                <h1>Dashboard</h1>
                <p class="pxp-text-light">Welcome to ANP!</p>
                <div class="row mt-4 mt-lg-5 align-items-center">
                    <div class="col-sm-6 col-xxl-3">
                        <div class="pxp-dashboard-stats-card bg-primary bg-opacity-10 mb-3 mb-xxl-0">
                            <div class="pxp-dashboard-stats-card-icon text-primary">
                                <span class="fa fa-file-text-o"></span>
                            </div>
                            <div class="pxp-dashboard-stats-card-info">
                                <div class="pxp-dashboard-stats-card-info-number"><?= esc($jobs) ?></div>
                                <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Jobs posted</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xxl-3">
                        <div class="pxp-dashboard-stats-card bg-primary bg-opacity-10 mb-3 mb-xxl-0">
                            <div class="pxp-dashboard-stats-card-icon text-success">
                                <span class="fa fa-user-circle-o"></span>
                            </div>
                            <div class="pxp-dashboard-stats-card-info">
                                <div class="pxp-dashboard-stats-card-info-number"><?= esc($applications) ?></div>
                                <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Applications</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xxl-3">
                        <div class="pxp-dashboard-stats-card bg-primary bg-opacity-10 mb-3 mb-xxl-0">
                            <div class="pxp-dashboard-stats-card-icon text-warning">
                                <span class="fa fa-envelope-o"></span>
                            </div>
                            <div class="pxp-dashboard-stats-card-info">
                                <div class="pxp-dashboard-stats-card-info-number"><?= esc($candidateapprove) ?></div>
                                <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Successful Applicants</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xxl-3">
                        <div class="pxp-dashboard-stats-card bg-primary bg-opacity-10 mb-3 mb-xxl-0">
                            <div class="pxp-dashboard-stats-card-icon text-danger">
                                <span class="fa fa-bell-o"></span>
                            </div>
                            <div class="pxp-dashboard-stats-card-info">
                                <div class="pxp-dashboard-stats-card-info-number"><?= esc($candidatesreject) ?></div>
                                <div class="pxp-dashboard-stats-card-info-text pxp-text-light">Rejected Candidates</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4 mt-lg-5">
                  

                   <div class="col-12 col-sm-6 col-lg-4 col-xl-6 mb-4">
                    <div class="mt-3 mt-lg-4 pxp-dashboard-chart-container">
                      <div class="row justify-content-between align-content-center mb-4">
                        <div class="col-auto">
                          <span class="pxp-dashboard-chart-vs">Total gender</span>
                        </div>
                      </div>
                      <canvas id="genderDonutChart" width= "100%" height="auto"></canvas>
                    </div>
                  </div>

                   <div class="col-12 col-sm-6 col-lg-4 col-xl-6 mb-4">
                    <div class="mt-3 mt-lg-4 pxp-dashboard-chart-container">
                      <div class="row justify-content-between align-content-center mb-4">
                        <div class="col-auto">
                          <span class="pxp-dashboard-chart-vs">Total Career Level</span>
                        </div>
                      </div>
                      <canvas id="totallevel" width= "100%" height="auto"></canvas>
                    </div>
                  </div>


                   <div class="col-12 col-sm-6 col-lg-4 col-xl-6 mb-4">
                    <div class="mt-3 mt-lg-4 pxp-dashboard-chart-container">
                      <div class="row justify-content-between align-content-center mb-4">
                        <div class="col-auto">
                          <span class="pxp-dashboard-chart-vs">Total Candidates</span>
                        </div>
                      </div>
                      <canvas id="totalcandidates" width= "100%" height="auto"></canvas>
                    </div>
                  </div>

                  <div class="col-12 col-sm-6 col-lg-4 col-xl-6 mb-4">
                    <div class="mt-3 mt-lg-4 pxp-dashboard-chart-container">
                      <div class="row justify-content-between align-content-center mb-4">
                        <div class="col-auto">
                          <span class="pxp-dashboard-chart-vs">Job Applications Activity</span><br><br>
                          <span class="pxp-dashboard-chart-value"><?= esc($applicationsCount) ?></span>
                          <span class="pxp-dashboard-chart-percent <?= $isGrowthUp ? 'text-success' : 'text-danger' ?>">
                          <span class="fa <?= $isGrowthUp ? 'fa-long-arrow-up' : 'fa-long-arrow-down' ?>"></span>
                            <?= esc(abs($growthPercent)) ?>%
                          </span>
                          <span class="pxp-dashboard-chart-vs">vs last <?= esc($selectedDays) ?> days</span>
                        </div>
                        <div class="col-auto">
                          <form method="get">
                            <select class="form-select" name="range" id="rangeSelector">
                              <option value="7" <?= $selectedDays == 7 ? 'selected' : '' ?>>Last 7 days</option>
                              <option value="30" <?= $selectedDays == 30 ? 'selected' : '' ?>>Last 30 days</option>
                              <option value="60" <?= $selectedDays == 60 ? 'selected' : '' ?>>Last 60 days</option>
                              <option value="90" <?= $selectedDays == 90 ? 'selected' : '' ?>>Last 90 days</option>
                              <option value="365" <?= $selectedDays == 365 ? 'selected' : '' ?>>Last 12 months</option>
                            </select>
                          </form>
                        </div>
                      </div>
                      <canvas id="applicationChart" width= "100%" height="60px"></canvas>
                    </div>
                  </div>
                </div>
            </div>

            <?= view('layoutAdmin/footer.php'); ?>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>

                document.addEventListener('DOMContentLoaded', function () {
                const selectedRange = <?= json_encode($selectedDays ?? 7) ?>;

                const chartCtx = document.getElementById('applicationChart').getContext('2d');
                const genderCtx = document.getElementById('genderDonutChart').getContext('2d');
                const levelCtx = document.getElementById('totallevel').getContext('2d');
                const candidateCtx = document.getElementById('totalcandidates').getContext('2d');
                let applicationChart, genderChart, levelChart, candidateChart;

                function loadChartData(range) {
                    fetch(`/admin/dashboard/getApplicationChartData?range=${range}`)
                        .then(res => res.json())
                        .then(result => {
                            if (applicationChart) applicationChart.destroy();
                            applicationChart = new Chart(chartCtx, {
                                type: 'line',
                                data: {
                                    labels: result.labels,
                                    datasets: [{
                                        label: 'Applications',
                                        data: result.data,
                                        borderWidth: 2,
                                        borderColor: 'rgba(75,192,192,1)',
                                        tension: 0.3,
                                        fill: false
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    // maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            precision: 0
                                        }
                                    }
                                }
                            });
                        });
                }

                function loadGenderData(range = 30) {
                    fetch(`/admin/dashboard/getGenderStats?range=${range}`)
                        .then(res => res.json())
                        .then(data => {
                            if (!data.labels.length || !data.values.length) {
                                document.getElementById('genderDonutChart').style.display = 'none';
                                return;
                            }
                            document.getElementById('genderDonutChart').style.display = 'block';

                            if (genderChart) genderChart.destroy();
                            genderChart = new Chart(genderCtx, {
                                type: 'doughnut',
                                data: {
                                    labels: data.labels,
                                    datasets: [{
                                        data: data.values,
                                        backgroundColor: ['#6FA8DC', '#C9D96F'],
                                        borderWidth: 1,
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    cutout: '60%',
                                    // maintainAspectRatio: false,
                                    plugins: {
                                        legend: { position: 'bottom' }
                                    }
                                }
                            });
                        });
                }

                // Level Chart
                function loadlevelData(range = 30) {
                    fetch(`/admin/dashboard/getLevelStats?range=${range}`)
                        .then(res => res.json())
                        .then(data => {
                            if (!data.labels.length || !data.values.length) {
                                document.getElementById('totallevel').style.display = 'none';
                                return;
                            }
                            document.getElementById('totallevel').style.display = 'block';

                            if (levelChart) levelChart.destroy();
                            levelChart = new Chart(levelCtx, {
                                type: 'doughnut',
                                data: {
                                    labels: data.labels,
                                    datasets: [{
                                        data: data.values,
                                        backgroundColor: ['#93C47D', '#6FA8DC', '#F6B26B'],
                                        borderWidth: 1,
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    cutout: '60%',
                                    // maintainAspectRatio: false,
                                    plugins: {
                                        legend: { position: 'bottom' }
                                    }
                                }
                            });
                        });
                }

                // Chart for Total Candidates
                function loadcandidateData(range = 30) {
                    fetch(`/admin/dashboard/getCandidateStats?range=${range}`)
                        .then(res => res.json())
                        .then(data => {
                            if (!data.labels.length || !data.values.length) {
                                document.getElementById('totalcandidates').style.display = 'none';
                                return;
                            }
                            document.getElementById('totalcandidates').style.display = 'block';

                            if (candidateChart) candidateChart.destroy();
                            candidateChart = new Chart(candidateCtx, {
                                type: 'doughnut',
                                data: {
                                    labels: data.labels,
                                    datasets: [{
                                        data: data.values,
                                        backgroundColor: ['#93C47D', '#6D9EEB'],
                                        borderWidth: 1,
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    cutout: '60%',
                                    // maintainAspectRatio: false,
                                    plugins: {
                                        legend: { position: 'bottom' }
                                    }
                                }
                            });
                        });
                }

                // Inisialisasi awal
                loadChartData(selectedRange);
                loadGenderData(selectedRange);
                loadlevelData(selectedRange);
                loadcandidateData(selectedRange);

                // Trigger dari satu dropdown
                const selector = document.getElementById('rangeSelector');
                if (selector) {
                    selector.value = selectedRange;
                    selector.addEventListener('change', function () {
                        const range = this.value;
                        loadChartData(range);
                        loadGenderData(range);
                        loadlevelData(range);
                        loadcandidateData(range);
                    });
                }
            });




            </script>
