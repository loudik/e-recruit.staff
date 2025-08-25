<?= $this->extend('layoutAdmin/template') ?>
<?= $this->section('content') ?>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Position Description (PD)</h5>
    <div>
      <!-- Jika masuk dari halaman vacancy, biasanya link create diberi ?idvaca=xxx -->
      <a href="<?= site_url('vacancy-approval') ?>" class="btn btn-secondary btn-sm">Back</a>
    </div>
  </div>
  <div class="card-body">
    <?php if (session()->getFlashdata('msg')): ?>
      <div class="alert alert-success"><?= esc(session()->getFlashdata('msg')) ?></div>
    <?php endif; ?>

    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Doc No / Date</th>
            <th>Position Title</th>
            <th>Vacancy</th>
            <th>Status</th>
            <th>PDF</th>
            <th>By / At</th>
            <th style="width:160px">Action</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $i => $r): ?>
          <tr>
            <td><?= $i+1 ?></td>
            <td>
              <div class="fw-semibold"><?= esc($r['doc_no'] ?? '-') ?></div>
              <small class="text-muted"><?= esc($r['doc_date'] ?? '-') ?></small>
            </td>
            <td>
              <div class="fw-semibold"><?= esc($r['position_title']) ?></div>
              <small class="text-muted"><?= esc($r['unit_name'] ?? '-') ?><?= $r['subunit_name']? ' / '.esc($r['subunit_name']) : '' ?></small>
            </td>
            <td>
              <div>ID: <?= esc($r['idvaca']) ?></div>
              <small class="text-muted"><?= esc($r['vacancy_position'] ?? '-') ?></small>
            </td>
            <td>
              <?php if ((int)$r['status'] === 2): ?>
                <span class="badge bg-success">Final</span>
              <?php else: ?>
                <span class="badge bg-secondary">Draft</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if (!empty($r['pdf_path'])): ?>
                <a class="btn btn-outline-primary btn-sm" href="<?= site_url('vacancy-pd/pdf/'.$r['idpd']) ?>">Download</a>
              <?php else: ?>
                <span class="text-muted">-</span>
              <?php endif; ?>
            </td>
            <td>
              <small><?= esc($r['iby'] ?? '-') ?></small><br>
              <small class="text-muted"><?= esc($r['idt'] ?? '-') ?></small>
            </td>
            <td class="d-flex gap-1">
              <a class="btn btn-sm btn-info" href="<?= site_url('vacancy-pd/show/'.$r['idpd']) ?>">View</a>
              <a class="btn btn-sm btn-warning" href="<?= site_url('vacancy-pd/edit/'.$r['idpd']) ?>">Edit</a>
              <a class="btn btn-sm btn-outline-primary" href="<?= site_url('vacancy-pd/pdf/'.$r['idpd']) ?>">PDF</a>
              <form action="<?= site_url('vacancy-pd/delete/'.$r['idpd']) ?>" method="post" onsubmit="return confirm('Delete this PD?')">
                <?= csrf_field() ?>
                <button class="btn btn-sm btn-danger">Del</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
