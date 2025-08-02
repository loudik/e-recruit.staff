<nav class="mt-3 mt-lg-4 d-flex justify-content-between flex-column pb-100">
    <div class="pxp-dashboard-side-label">Admin tools</div>

    <?= session()->get('treemenu') ?? '' ?>

</nav>

<script>
    // Jika kamu ingin collapsible submenu
    document.querySelectorAll('a.menu-toggle').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const submenu = this.nextElementSibling;
            if (submenu && submenu.tagName === "UL") {
                submenu.classList.toggle('d-none');
            }
        });
    });
</script>




