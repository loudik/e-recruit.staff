
<?= view('layoutAdmin/header.php'); ?>
        <?= view('layoutAdmin/sidebar.php'); ?>
        <?= view('layoutAdmin/navbar.php'); ?>
    </div>


    <!---------------------------------------- LAYOUT MAIN --------------------------------------------------------------- -->
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
                                    <li class="nav-item"><a href="<?= base_Url('admin/dashboard')?>"><span class="fa fa-home"></span>Dashboard</a></li>
                                    <!-- <li class="nav-item"><a href="</?= base_url('admin/profile') ?>l"><span class="fa fa-pencil"></span>Edit Profile</a></li> -->
                                    <li class="nav-item"><a href="<?= base_url('admin/newjobs')?>"><span class="fa fa-file-text-o"></span>New Job Offer</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/managejobs')?>"><span class="fa fa-briefcase"></span>Manage Jobs</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/candidate')?>"><span class="fa fa-user-circle-o"></span>Candidates</a></li>
                                    <li class="nav-item"><a href="<?= base_url('admin/reports') ?>"><span class="fa fa-lock"></span>Reports</a></li>
           
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
                <h1>New Job Offer</h1>
                <p class="pxp-text-light">Add a new job to your company's jobs list.</p>
                <form>
                    <div class="row mt-4 mt-lg-5">
                        <div class="col-xxl-6">
                            <div class="mb-3">
                                <label for="jobs" class="form-label">Job title</label>
                                <input type="text" id="jobs" name="jobs" class="form-control" placeholder="Add title">
                            </div>
                        </div>
                        <div class="col-md-6 col-xxl-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" id="location" name="location" class="form-control" placeholder="City 8, Canossa Has Laran">
                        </div>
                        <div class="col-md-6 col-xxl-3">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select id="category" class="form-select">
                                    <option>Select a category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id']; ?>"><?= $category['unitname']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6 col-xxl-3">
                            <div class="mb-3">
                                <label for="experience" class="form-label">Experience</label>
                                <input type="text" id="experience" class="form-control" placeholder="E.g. Minimum 3 years">
                            </div>
                        </div>
                        <div class="col-md-6 col-xxl-3">
                            <div class="mb-3">
                                <label for="level" class="form-label">Career level</label>
                                <select id="level" name="level" class="form-select">
                                    <option value="No Experience">No Experience</option>
                                    <option value="Entry-level">Entry-Level</option>
                                    <option value="Mid-Level">Mid-Level</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-xxl-3">
                            <div class="mb-3">
                                <label for="type" class="form-label">Employment type</label>
                                <select id="type" class="form-select">
                                    <option value="Full Time">Full Time</option>
                                    <option value="Part Time">Part Time</option>
                                    <option value="Remote">Remote</option>
                                    <option value="Internship">Internship</option>
                                    <option value="Contract">Contract</option>
                                    <option value="Training">Training</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-xxl-3">
                            <div class="mb-3">
                                <label for="applicants" class="form-label">Applicants</label>
                                <input type="text" id="applicants" class="form-control" placeholder="E.g. 3+">
                            </div>
                        </div>
                        <div class="col-md-6 col-xxl-3">
                            <div class="mb-3">
                                <label for="applicants" class="form-label">Date Apply</label>
                                <input type="date" id="applydate" name="applydate" class="form-control" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-xxl-3">
                            <div class="mb-3">
                                <label for="applicants" class="form-label">Date Expire</label>
                                <input type="date" id="dateexpire" name="dateexpire" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                        <label for="jobdescription" class="form-label">Job description</label>
                        <textarea class="form-control" id="jobdescription"  name="jobdescription" placeholder="Type the description here..."></textarea>
                    </div>

                    <div class="mt-4 mt-lg-5">
                        <button type="button" class="btn rounded-pill pxp-section-cta" onclick="fn_publish()">Publish Job</button>
                        <button class="btn rounded-pill pxp-section-cta-o ms-3">Save Draft</button>
                    </div>
                </form>
            </div>
            

            <!---------------------------------------- LAYOUT MAIN --------------------------------------------------------------- -->

            <?= view('layoutAdmin/footer.php'); ?>

            <script>
        
                function fn_publish() {
                    var jobs = $('#jobs').val();
                    var location = $('#location').val();
                    var category = $('#category').val();
                    var jobdescription = $('#jobdescription').val();
                    var experience = $('#experience').val();
                    var level = $('#level').val();
                    var type = $('#type').val();
                    var applicants = $('#applicants').val();
                    var applydate = $('#applydate').val();
                    var dateexpire = $('#dateexpire').val();

                    if (!jobs) {
                        alert('Please enter a job title.');
                        $('#jobs').focus();
                        return false;
                    }

                    if (!location) {
                        alert('Please enter a location.');
                        $('#location').focus();
                        return false;
                    }

                    if (!category) {
                        alert('Please select a category.');
                        $('#category').focus();
                        return false;
                    }

                    if (!jobdescription) {
                        alert('Please enter a job description.');
                        $('#jobdescription').focus();
                        return false;
                    }

                    if (!experience) {
                        alert('Please enter the experience required.');
                        $('#experience').focus();
                        return false;
                    }

                    if (!level) {
                        alert('Please select a career level.');
                        $('#level').focus();
                        return false;
                    }

                    if (!type) {
                        alert('Please select an employment type.');
                        $('#type').focus();
                        return false;
                    }

                    if (!applicants) {
                        alert('Please enter the number of applicants.');
                        $('#applicants').focus();
                        return false;
                    }

                

                    $.ajax({
                        url: '<?= base_url('admin/addnewjobs') ?>',
                        type: 'POST',
                        dataType: 'json',

                        data: {
                            jobs: jobs,
                            location: location,
                            category: category,
                            jobdescription: jobdescription,
                            experience: experience,
                            level: level,
                            type: type,
                            applicants: applicants,
                            applydate: applydate,
                            dateexpire: dateexpire
                        },
                        success: function(response) {
                            alert('Job published successfully!');
                            window.location.href = "<?= base_url('admin/managejobs') ?>";
                        },
                        error: function(xhr, status, error) {
                            alert('An error occurred while publishing the job.');
                        }
                    });

                }

            </script>