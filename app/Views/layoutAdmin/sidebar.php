<nav class="mt-3 mt-lg-4 d-flex justify-content-between flex-column pb-100">
    <div class="pxp-dashboard-side-label">Admin tools</div>
    <ul class="list-unstyled">
        <?= session()->get('treemenu') ?? '' ?>
    </ul>
</nav>