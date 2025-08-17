<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Jobs – Apply</title>

  <link rel="icon" href="<?= base_url('favicon.ico') ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?= base_url('assets/css/ebazar.style.min.css') ?>">
  <style>
    #applySection .card-header{background:var(--bs-light)}
  </style>
</head>
<body>
<div id="ebazar-layout" class="theme-blue">
  <div class="main px-lg-4 px-md-4">

    <div class="header">
      <nav class="navbar py-4">
        <div class="container-xxl">
          <div class="h-right d-flex align-items-center mr-5 mr-lg-0 order-1">
            <div class="d-flex">
              <a class="nav-link text-primary collapsed" href="<?= base_url() ?>" title="Home">
                <i class="icofont-home fs-5"></i>
              </a>
            </div>
            <div class="dropdown user-profile ml-2 ml-sm-3 d-flex align-items-center zindex-popover">
              <div class="u-info me-2">
                <p class="mb-0 text-end line-height-sm"><span class="font-weight-bold">Guest</span></p>
                <small>Candidate</small>
              </div>
              <a class="nav-link dropdown-toggle pulse p-0" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static">
                <img class="avatar lg rounded-circle img-thumbnail" src="<?= base_url('assets/images/profile_av.svg') ?>" alt="profile">
              </a>
            </div>
          </div>
          <div class="order-0 col-lg-6 col-md-6 col-sm-12 col-12 mb-3 mb-md-0">
            <h3 class="fw-bold mb-0">Apply</h3>
            <div class="text-muted">Complete your application below.</div>
          </div>
        </div>
      </nav>
    </div>

    <section id="applySection" class="body d-flex py-3 pt-0">
      <div class="container-xxl">
        <div class="card">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div>
              <h5 class="mb-0">Apply Now</h5>
              <small class="text-muted">Isi form berikut untuk melamar.</small>
            </div>
            <div class="text-end">
              <div class="small text-muted">Position</div>
              <div class="fw-bold" id="applyPreviewTitle"><?= esc($jobTitle ?? '-') ?></div>
              <div class="small" id="applyPreviewMeta">
                Type: <?= esc($jobType ?? '–') ?> • Location: <?= esc($jobLoc ?? '–') ?>
              </div>
            </div>
          </div>

          <div class="card-body">
            <?php if (session()->getFlashdata('apply_success')): ?>
              <div class="alert alert-success"><?= session()->getFlashdata('apply_success') ?></div>
            <?php elseif (session()->getFlashdata('apply_error')): ?>
              <div class="alert alert-danger"><?= session()->getFlashdata('apply_error') ?></div>
            <?php endif; ?>

            <form id="applyForm" action="<?= site_url('jobs/apply') ?>" method="post" enctype="multipart/form-data" novalidate>
              <?= csrf_field() ?>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Full Name</label>
                  <input type="text" class="form-control" name="full_name" value="<?= esc(old('full_name')) ?>" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" value="<?= esc(old('email')) ?>" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Phone</label>
                  <input type="text" class="form-control" name="phone" value="<?= esc(old('phone')) ?>" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Location</label>
                  <input type="text" class="form-control" name="location" id="applyJobLoc"
                         value="<?= esc(old('location', $jobLoc ?? '')) ?>" required>
                </div>

                <div class="col-md-8">
                  <label class="form-label">Position</label>
                  <input type="text" class="form-control" name="job_title" id="applyJobTitle"
                         value="<?= esc(old('job_title', $jobTitle ?? '')) ?>" readonly required>
                </div>
                <div class="col-md-2">
                  <label class="form-label">Type</label>
                  <input type="text" class="form-control" name="job_type" id="applyJobType"
                         value="<?= esc(old('job_type', $jobType ?? '')) ?>" readonly>
                </div>
                <div class="col-md-2">
                  <label class="form-label">Ref (optional)</label>
                  <input type="text" class="form-control" name="reference" value="<?= esc(old('reference')) ?>">
                </div>

                <div class="col-md-12">
                  <label class="form-label">LinkedIn (optional)</label>
                  <input type="url" class="form-control" name="linkedin"
                         value="<?= esc(old('linkedin')) ?>" placeholder="https://linkedin.com/in/username">
                </div>

                <div class="col-md-12">
                  <label class="form-label">Resume / CV (PDF/DOC/DOCX)</label>
                  <input type="file" class="form-control" name="resume" accept=".pdf,.doc,.docx" required>
                </div>

                <div class="col-md-12">
                  <label class="form-label">Cover Letter</label>
                  <textarea class="form-control" rows="5" name="cover_letter"
                            placeholder="Singkatkan motivasi & pengalaman relevan…"><?= esc(old('cover_letter')) ?></textarea>
                </div>
              </div>

              <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Submit Application</button>
                <a href="<?= site_url('jobs') ?>" class="btn btn-white border">Kembali ke Jobs</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

  </div><!-- /main -->
</div><!-- /layout -->

<script src="<?= base_url('assets/bundles/libscripts.bundle.js') ?>"></script>
<script>
// scroll ke form saat page terbuka
window.addEventListener('load', function(){
  const target = document.getElementById('applySection');
  if(target){ target.scrollIntoView({behavior:'smooth'}); }
});

// fallback: kalau datang via query string dan controller tidak mengirim variabel
(function(){
  const t = document.getElementById('applyJobTitle');
  const l = document.getElementById('applyJobLoc');
  const y = document.getElementById('applyJobType');
  if (t && !t.value) {
    const p = new URLSearchParams(window.location.search);
    t.value = p.get('title') || '';
    l.value = p.get('loc')   || '';
    y.value = p.get('type')  || '';
    document.getElementById('applyPreviewTitle').textContent = t.value || '–';
    document.getElementById('applyPreviewMeta').textContent  =
      'Type: ' + (y.value || '–') + ' • Location: ' + (l.value || '–');
  }
})();
</script>
</body>
</html>
