

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
                    <div class="col-xl-6">
                      <h2>Job Applications Activity</h2>
                      <div class="mt-3 mt-lg-4 pxp-dashboard-chart-container">
                          <div class="row justify-content-between align-content-center mb-4">
                              <div class="col-auto">
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
                          <canvas id="applicationChart" height="240px"></canvas>
                      </div>
                  </div>

                   <div class="col-xl-6">
                    <h2>Gender</h2>
                    <div class="mt-3 mt-lg-4 pxp-dashboard-chart-container">
                      <div class="row justify-content-between align-content-center mb-4">
                        <div class="col-auto">
                          <span class="pxp-dashboard-chart-vs">Total by gender</span>
                        </div>
                      </div>


                      <canvas id="genderDonutChart" width= "100%" height="auto"></canvas>
                    </div>
                  </div>
                </div>

              <div class="mt-4 mt-lg-5">
                  <h2>Recent Candidates</h2>
                  <div class="table-responsive">
                      <table class="table align-middle">
                          <?php foreach ($candidates as $candidate): ?>
                          <tr>
                              <td style="width: 3%;">
                                  <div class="pxp-company-dashboard-candidate-avatar pxp-cover" style="background-image: url(<?= esc($candidate['avatar'] ?? 'images/ph-small.jpg') ?>);"></div>
                              </td>
                              <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-name"><?= esc($candidate['fullname']) ?></div></td>
                              <td style="width: 25%;"><div class="pxp-company-dashboard-candidate-title"><?= esc($candidate['application']) ?></div></td>
                              <td><div class="pxp-company-dashboard-candidate-location"><span class="fa fa-globe"></span> <?= esc($candidate['email']) ?></div></td>
                              <td>
                                  <div class="pxp-dashboard-table-options">
                                      <ul class="list-unstyled">
                                          <li><button title="View profile"><span class="fa fa-eye"></span></button></li>
                                          <li><button title="Send message"><span class="fa fa-envelope-o"></span></button></li>
                                          <li><button title="Delete"><span class="fa fa-trash-o"></span></button></li>
                                      </ul>
                                  </div>
                              </td>
                          </tr>
                          <?php endforeach; ?>
                      </table>
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
                let applicationChart, genderChart;

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
                                        backgroundColor: ['#9ea855', '#a8bdd4'],
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

                // Trigger dari satu dropdown
                const selector = document.getElementById('rangeSelector');
                if (selector) {
                    selector.value = selectedRange;
                    selector.addEventListener('change', function () {
                        const range = this.value;
                        loadChartData(range);
                        loadGenderData(range);
                    });
                }
            });




            </script>
