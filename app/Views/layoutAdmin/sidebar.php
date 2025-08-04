
<nav class="mt-3 mt-lg-4 d-flex justify-content-between flex-column pb-100">
    <div class="pxp-dashboard-side-label">Admin tools</div>

    <?= session()->get('treemenu') ?? '' ?>

</nav>

<script>
    document.querySelectorAll('.menu-toggle').forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            const submenu = this.nextElementSibling;
            if (submenu && submenu.classList.contains('submenu')) {
                submenu.classList.toggle('d-none');
                this.classList.toggle('open'); // Untuk rotate chevron
            }
        });
    });
</script>




