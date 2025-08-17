<!-- Modal Custom Settings-->
<div class="modal fade right" id="Settingmodal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Custom Settings</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body custom_setting">
        <!-- ====== (isi setting sama seperti template Anda) ====== -->
      </div>

      <div class="modal-footer justify-content-start">
        <button type="button" class="btn btn-white border lift" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary lift">Save Changes</button>
      </div>
    </div>
  </div>
</div>

</div><!-- /#ebazar-layout -->

<!-- Core JS -->
<script src="<?= base_url('assets/bundles/libscripts.bundle.js') ?>"></script>

<!-- Plugins -->
<script src="<?= base_url('assets/bundles/apexcharts.bundle.js') ?>"></script>
<script src="<?= base_url('assets/bundles/dataTables.bundle.js') ?>"></script>

<!-- Page JS -->
<script src="<?= base_url('assets/js/template.js') ?>"></script>
<script src="<?= base_url('assets/js/page/index.js') ?>"></script>

<!-- Google Maps (pastikan fungsi myMap tersedia) -->
<script>
  function myMap() {
    if (!document.getElementById('googleMap')) return;
    var mapProp = {
      center: new google.maps.LatLng(-8.5586, 125.5736), // Dili (contoh)
      zoom: 5,
    };
    new google.maps.Map(document.getElementById('googleMap'), mapProp);
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= esc(env('google.maps.key') ?? 'YOUR_GOOGLE_MAPS_KEY') ?>&callback=myMap" async defer></script>

<!-- DataTable init (opsional) -->
<script>
  (function(){
    var el = document.getElementById('myDataTable');
    if (el && typeof window.jQuery !== 'undefined') {
      $('#myDataTable').addClass('nowrap').DataTable({
        responsive: true,
        columnDefs: [{ targets: [-1, -3], className: 'dt-body-right' }]
      });
    }
  })();
</script>

<?= $this->renderSection('scripts') ?>

</body>
</html>
