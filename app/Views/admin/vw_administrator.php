
<?= view('layoutAdmin/header.php'); ?>
        <?= view('layoutAdmin/sidebar.php'); ?>
        <?= view('layoutAdmin/navbar.php'); ?>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

     

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
                                   <?= view('layoutAdmin/partial/sidebar_menu') ?>

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
    <h1>Administrator</h1>

    <!-- Button -->
    <button type="button" class="btn btn-primary mb-3" onclick="toggleForm()">+ Assign Access</button>
    <div id="accessFormContainer" style="display: none;" class="mb-4"> 
        <div class="col-md-6 col-xxl-3">
            <div class="mb-3">
                <label for="employee1" class="form-label">Employee</label>
                <select id="employee1" name="employee1[]" class="form-select">
                    <?php foreach ($users as $u): ?>
                        <option value="<?= $u['id']; ?>">
                            <?= esc($u['displayName']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>           
        <div class="row mt-4">
            <!-- Department -->
            <div class="col-md-6 col-xxl-3">
                <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <input type="text" id="department" name="department" class="form-control" readonly>
                </div>
            </div>

            <!-- Menu -->
            <div class="col-md-6 col-xxl-3">
                <div class="mb-3">
                    <label for="menuaccess" class="form-label">Menu</label>
                    <select id="menuaccess" name="menuaccess[]" class="form-select" multiple>
                        <?php foreach ($menus as $menu): ?>
                            <option value="<?= $menu['id'] ?>">
                                <?= esc($menu['menuname']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>


            <div class="mt-2">
                <button type="button" class="btn btn-success" onclick="fn_publish()">Publish</button>
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        <!-- </form> -->
    </div>

          <!-- Table always visible -->
          <div class="table-responsive">
              <table class="table table-hover align-middle" id="tblmanagejobs">
                  <thead>
                      <tr>
                          <th style="width: 10%;">No</th>
                          <th style="width: 35%;">Job</th>
                          <th style="width: 30%;">Group</th>
                          <th style="width: 30%;">Category</th>
                          <th style="width: 12%;">Type</th>
                          <th style="width: 15%;">Applications</th>
                          <th style="width: 15%;">Status</th>
                          <th style="width: 30%;">Action</th>
                      </tr>
                  </thead>
                  <tbody></tbody>
              </table>
          </div>
      </div>


            

            <!---------------------------------------- LAYOUT MAIN --------------------------------------------------------------- -->

            <?= view('layoutAdmin/footer.php'); ?>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

            <script>

              $(document).ready(function () {
                  $('#menuaccess').select2({
                      placeholder: "Select one or more modules",
                       width: '100%'
                  });
                  
              });


               $(document).ready(function () {
                $('#employee1').select2({
                    placeholder: 'Select an Employee',
                    width: '100%',
                    allowClear: true,
                    ajax: {
                        url: "<?= base_url('admin/users-json') ?>",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            console.log("Searching for:", params.term);
                            return {
                                search: params.term || '' // kirim term pencarian
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: (data.users || []).map(function (user) {
                                    return {
                                        id: user.id,
                                        text: user.displayName,
                                        jobTitle: user.jobTitle || '' 
                                    };
                                })
                            };
                        },
                        cache: true
                    },
                    templateResult: function (data) {
                        if (!data.id) return data.text;
                        return $('<span>' + data.text + '</span>');
                    },
                    templateSelection: function (data) {
                        return data.text;
                    }
                });

                // Saat user dipilih, isi field department
                $('#employee1').on('select2:select', function (e) {
                    const selected = e.params.data;
                    $('#department').val(selected.jobTitle || '');
                });

                // Kosongkan department saat opsi di-clear
                $('#employee1').on('select2:clear', function () {
                    $('#department').val('');
                });
            });



              function toggleForm() {
                  const formContainer = document.getElementById('accessFormContainer');
                  formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
              }


        
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

                    if (!applydate) {
                        alert('Please select an apply date.');
                        $('#applydate').focus();
                        return false;
                    }

                    if (!dateexpire) {
                        alert('Please select an expiration date.');
                        $('#dateexpire').focus();
                        return false;
                    }

                    const startDate = new Date(applydate);
                    const endDate = new Date(dateexpire);

                    if (endDate.getTime() <= startDate.getTime()) {
                        alert('Expiration date must be later than apply date.');
                        $('#dateexpire').focus();
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