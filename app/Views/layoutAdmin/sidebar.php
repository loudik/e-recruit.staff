<!-- sidebar -->
<div class="sidebar px-4 py-4 py-md-4 me-0">
  <div class="d-flex flex-column h-100">
    <a href="<?= site_url('/') ?>" class="mb-0 brand-icon">
      <span class="logo-icon"><i class="bi bi-bag-check-fill fs-4"></i></span>
      <span class="logo-text">ANP</span>
    </a>

    <!-- Menu: main ul -->
    <ul class="menu-list flex-grow-1 mt-3">
       <?= session()->get('treemenu') ?? '' ?>
    </ul>

    <!-- Menu: collapse btn -->
    <button type="button" class="btn btn-link sidebar-mini-btn text-light">
      <span class="ms-2"><i class="icofont-bubble-right"></i></span>
    </button>
  </div>
</div>
