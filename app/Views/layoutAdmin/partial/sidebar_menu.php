<ul class="list-unstyled">
    <?php if (!empty($menu)): ?>
        <?php foreach ($menu as $item): ?>
            <li>
                <a href="<?= base_url($item['menuurl']) ?>">
                    <span class="<?= esc($item['menuicon']) ?>"></span>
                    <?= esc($item['menuname']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li><em>No access menu</em></li>
    <?php endif; ?>
</ul>