<?= $this->extend('layoutAdmin/template') ?>
<?= $this->section('content') ?>

<!-- Contoh 4 kartu kecil -->
<div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
  <div class="col">
    <div class="alert-success alert mb-0">
      <div class="d-flex align-items-center">
        <div class="avatar rounded no-thumbnail bg-success text-light"><i class="fa fa-dollar fa-lg"></i></div>
        <div class="flex-fill ms-3 text-truncate">
          <div class="h6 mb-0">Revenue</div>
          <span class="small">$18,925</span>
        </div>
      </div>
    </div>
  </div>
  <!-- ...lanjutkan kartu lain sesuai template... -->
</div>

<!-- Contoh chart container -->
<div class="card mt-3">
  <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
    <h6 class="m-0 fw-bold">Sales Status</h6>
  </div>
  <div class="card-body">
    <div id="apex-GenderOverview"></div>
  </div>
</div>

<?= $this->endSection() ?>
