

<?= view('layoutAdmin/header.php'); ?>
      <?= view('layoutAdmin/sidebar.php'); ?>
     

<div class="main px-lg-4 px-md-4">
 <?= view('layoutAdmin/navbar.php'); ?>

  <!-- Body: Body -->
  <div class="body d-flex py-3">
    <div class="container-xxl">
      <?= $this->renderSection('content') ?>
    </div>
  </div>

  <!-- Optional: tempat render modal setting -->
  <?= $this->renderSection('modals') ?>
</div>

  <?= view('layoutAdmin/footer.php'); ?>
