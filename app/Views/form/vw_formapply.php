<!doctype html>
<html lang="en" class="pxp-root">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/owl.carousel.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/owl.theme.default.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>">
        <title>Form Recruitment GIP</title>
        <style>

        .pxp-dashboard-content {
          width: 100%;
          max-width: 850px;
          margin: 60px auto; 
          padding: 20px;
        }

        .pxp-dashboard-content-details {
          width: 100%;
          max-width: 800px;
          margin: 0 auto; 
          padding: 40px;
        }

        </style>
        
    </head>
    <body style="background-color: var(--pxpMainColorLight);">
      <div class="pxp-preloader"><span>Loading...</span></div>
        <div class="pxp-dashboard-content">
          <div class="pxp-dashboard-content-details">
            <h3>Form Of Candidate GIP</h3>
            <p class="pxp-text-light">Please Complete All Required</p>
            <div class="row mt-4 mt-lg-5">
              <div class="col-xxl-6">
                <div class="mb-3">
                  <label for="pxp-company-job-title" class="form-label">Jobs</label>
                  <input type="text" id="jobs" name="jobs" class="form-control rounded-pill"
                  <?php foreach ($data['jobs'] as $job): ?>
                      <option value="<?= esc($job['jobs']) ?>" readonly></option>
                    <?php endforeach; ?>
                </div>
              </div>
              <div class="col-md-6 col-xxl-6">
                <label for="pob" class="form-label">Fullname</label>
                <input type="text" id="fullname" name="fullname" class="form-control rounded-pill">
              </div>
              <div class="col-md-6 col-xxl-6">
                <label for="pob" class="form-label">Graduation Year</label>
                <input type="text" id="graduation" name="graduation" class="form-control rounded-pill">
              </div>
              <div class="col-md-6 col-xxl-6">
                <div class="mb-3">
                  <label for="sexo" class="form-label">education Level</label>
                  <select id="educationlevel" name="educationlevel" class="form-select rounded-pill">
                    <option value="D3">D3</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-xxl-6">
                <div class="mb-3">
                  <label for="sexo" class="form-label">Languague Skills</label>
                  <select id="languague" name="languague" class="form-select rounded-pill">
                    <option value="Goog">Good</option>
                    <option value="Average">Average</option>
                    <option value="Bad">Bad</option>
                    <option value="Very Bad">Very Bad</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-xxl-6">
                <label for="pob" class="form-label">GPA</label>
                <input type="text" id="gpa" name="gpa" class="form-control rounded-pill">
              </div>                        
              <div class="col-md-6 col-xxl-6">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" id="dob" name="dob" class="form-control rounded-pill" value="<?= date('Y-m-d') ?>">
              </div>
              <div class="col-md-6 col-xxl-6">
                <label for="pob" class="form-label">Place of Birth</label>
                <input type="text" id="pob" name="pob" class="form-control rounded-pill">
              </div>
              <div class="col-md-6 col-xxl-6">
                <div class="mb-3">
                  <label for="sexo" class="form-label">Sexo</label>
                  <select id="sexo" name="sexo" class="form-select rounded-pill">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-xxl-6">
                <label for="pob" class="form-label">Address</label>
                <input type="text" id="address" name="address" class="form-control rounded-pill">
              </div>
              <div class="col-md-6 col-xxl-6">
                <label for="pob" class="form-label">Phone</label>
                <input type="text" id="phone" name="phone" class="form-control rounded-pill">
              </div>
              <div class="col-md-6 col-xxl-6">
                <label for="pob" class="form-label">Curriculum Vitae(CV)</label>
                <input type="file" id="cv" name="cv" class="form-control rounded-pill">
              </div>
              <div class="col-md-6 col-xxl-6">
                <label for="pob" class="form-label">Diploma</label>
                <input type="file" id="diploma" name="diploma" class="form-control rounded-pill">
              </div>
              <div class="col-md-6 col-xxl-6">
                <label for="pob" class="form-label">Transkrip</label>
                <input type="file" id="transcript" name="transcript" class="form-control rounded-pill">
              </div>
              <div class="col-md-6 col-xxl-6">
                <label for="pob" class="form-label">Cover Letter</label>
                <input type="file" id="coverletter" name="coverletter" class="form-control rounded-pill">
              </div>
            </div>
            <div class="mt-4 mt-lg-5">
              <button class="btn rounded-pill pxp-section-cta" onclick="fn_savedata()">Submit Data</button>
              <button class="btn rounded-pill pxp-section-cta-o ms-3">Save Draft</button>
            </div>
          </div>
 
          <!-- Modal Sign In -->
          <div class="modal fade pxp-user-modal" id="modalemail" aria-hidden="true" aria-labelledby="signinModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="pxp-user-modal-fig text-center">
                    <img src="images/signin-fig.png" alt="Sign in">
                  </div>
                  <h5 class="modal-title text-center mt-4" id="signinModal">Welcome back!</h5>
                  <form class="mt-4">
                    <div class="form-floating mb-3">
                      <input type="email" class="form-control" id="pxp-signin-email" placeholder="Email address">
                      <label for="pxp-signin-email">Email address</label>
                      <span class="fa fa-envelope-o"></span>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control" id="pxp-signin-password" placeholder="Password">
                      <label for="pxp-signin-password">Password</label>
                      <span class="fa fa-lock"></span>
                    </div>
                    <a href="#" class="btn rounded-pill pxp-modal-cta">Continue</a>
                    <div class="mt-4 text-center pxp-modal-small">
                      <a href="#" class="pxp-modal-link">Forgot password</a>
                    </div>
                    <div class="mt-4 text-center pxp-modal-small">
                      New to Jobster? <a role="button" class="" data-bs-target="#pxp-signup-modal" data-bs-toggle="modal" data-bs-dismiss="modal">Create an account</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <footer>
            <div class="pxp-footer-copyright pxp-text-light">© 2021 Jobster. All Right Reserved.</div>
          </footer>
        </div>

        <script src="<?= base_url('assets/js/jquery-3.4.1.min.js') ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <script src="<?= base_url('assets/js/owl.carousel.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/nav.js') ?>"></script>
        <script src="<?= base_url('assets/js/Chart.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/main.js') ?>"></script>
        <script>

            
          function fn_savedata() 
          {
            var formData = new FormData();
            formData.append('jobs', $('#jobs').val());
            formData.append('fullname', $('#fullname').val());
            formData.append('email', $('#email').val());
            formData.append('dob', $('#dob').val());
            formData.append('pob', $('#pob').val());
            formData.append('sexo', $('#sexo').val());
            formData.append('address', $('#address').val());
            formData.append('phone', $('#phone').val());
            formData.append('educationlevel', $('#educationlevel').val());
            formData.append('graduation', $('#graduation').val());
            formData.append('gpa', $('#gpa').val());
            formData.append('languague', $('#languague').val());
            formData.append('application', $('#application').val());
            formData.append('cv', $('#cv')[0].files[0]);
            formData.append('diploma', $('#diploma')[0].files[0]); 
            formData.append('transcript', $('#transcript')[0].files[0]);
            formData.append('coverletter', $('#coverletter')[0].files[0]);

            if (!$('#fullname').val()) {
                alert('Please enter your fullname!');
                return;
            }
            if (!$('#email').val()) {
                alert('Please enter your email!');
                return;
            }
            if (!$('#dob').val()) {
                alert('Please enter your date of birth!');
                return;
            }
            if (!$('#pob').val()) {
                alert('Please enter your place of birth!');
                return;
            }

            $.ajax({
                url: '<?= base_url('submitdataregistration') ?>',
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData: false, 
                contentType: false, 
                success: function(response) {
                  if (response.status === 'success') {
                  // Tampilkan modal login
                  var myModal = new bootstrap.Modal(document.getElementById('modalemail'));
                  myModal.show();
                  } else {
                      alert('Failed: ' + response.message);
                  }
                },
                error: function(xhr, status, error) {
                    alert('Error saving data!');
                }
            });
          }

    </script>
  </body>
</html>