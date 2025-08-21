<?= $this->extend('layoutAdmin/template') ?>
<?= $this->section('content') ?>
<!-- main body area -->



<div class="main px-lg-4 px-md-4">
  <!-- Body: Body -->
  <div class="body d-flex py-3">
    <div class="container-xxl">
      <div class="row align-items-center">
        <div class="border-0 mb-4 w-100">
          <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
            <h3 class="fw-bold mb-0">Administrator List</h3>
            <button class="btn btn-primary py-2 px-4 btn-set-task w-sm-100" type="button" data-bs-toggle="collapse" data-bs-target="#assignAccessCollapse" aria-expanded="false" aria-controls="assignAccessCollapse">
              <i class="icofont-plus-circle me-2 fs-6"></i> Assign Access
            </button>
          </div>
        </div>
      </div>

      <!-- Assign Access (collapsible form) -->
      <div id="assignAccessCollapse" class="collapse mb-3">
        <div class="card">
          <div class="card-body">
            <div class="row g-3">
              <!-- Employee -->
              <div class="col-md-6">
                <label for="employee1" class="form-label fw-bold">Employee</label>
                <select id="employee1" name="employee1" class="form-select select2" style="width:100%"></select>
              </div>
              <!-- Department -->
              <div class="col-md-6">
                <label for="department" class="form-label fw-bold">Department</label>
                <input type="text" id="department" name="department" class="form-control" readonly style="height: 38px" />
              </div>
            </div>

            <div class="row g-3 mt-1">
              <!-- Menu (checkbox dropdown) -->
              <div class="col-md-12 col-lg-8">
                <label class="form-label fw-bold">Menu</label>
                <div class="dropdown-checkbox" id="menuDropdown">
                  <div class="dropdown-checkbox-toggle form-control" role="button" tabindex="0">Select menu...</div>
                  <div class="dropdown-checkbox-list">
                    <?php if (isset($menus) && is_array($menus)): ?>
                      <?php foreach ($menus as $menu): ?>
                        <?php if ((int)$menu['parent_id'] === 0): ?>
                          <!-- Parent menu -->
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="menuaccess[]" id="menu_<?= (int)$menu['id'] ?>" value="<?= (int)$menu['id'] ?>" <?= isset($selectedMenus) && in_array($menu['id'], $selectedMenus) ? 'checked' : '' ?>>
                            <label class="form-check-label fw-semibold" for="menu_<?= (int)$menu['id'] ?>">
                              <?= esc($menu['menuname']) ?>
                            </label>
                          </div>
                          <!-- Submenus -->
                          <?php foreach ($menus as $submenu): ?>
                            <?php if ((int)$submenu['parent_id'] === (int)$menu['id']): ?>
                              <div class="form-check ms-4">
                                <input class="form-check-input" type="checkbox" name="menuaccess[]" id="menu_<?= (int)$submenu['id'] ?>" value="<?= (int)$submenu['id'] ?>" <?= isset($selectedMenus) && in_array($submenu['id'], $selectedMenus) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="menu_<?= (int)$submenu['id'] ?>">→ <?= esc($submenu['menuname']) ?></label>
                              </div>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="mt-4 d-flex gap-2">
              <button type="button" class="btn btn-success" id="btnPublish">Publish</button>
              <button type="button" class="btn btn-secondary" id="btnCancel">Cancel</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Table -->
      <div class="row g-3 mb-3">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table id="tbladministrator" class="table table-hover align-middle w-100">
                  <thead>
                    <tr>
                      <th style="width: 8%">No</th>
                      <th style="width: 28%">Name</th>
                      <th style="width: 20%">Position</th>
                      <th style="width: 24%">Menu</th>
                      <th style="width: 10%">Status</th>
                      <th style="width: 10%">Action</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?= $this->endSection() ?>

<script>
  (function() {
    let adminTable = null;

    $(document).ready(function () {
      // Dropdown checkbox open/close
      const $menuBox = $('#menuDropdown');
      $menuBox.on('click keydown', '.dropdown-checkbox-toggle', function(e) {
        if (e.type === 'click' || e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          $menuBox.toggleClass('open');
        }
      });
      $(document).on('click', function(e) {
        if (!$.contains($menuBox[0], e.target)) $menuBox.removeClass('open');
      });

      // Employee select2 (AJAX to users-json)
      $('#employee1').select2({
        placeholder: 'Select an employee', width: '100%', allowClear: true,
        ajax: {
          url: '<?= base_url('admin/users-json') ?>', dataType: 'json', delay: 250, cache: true,
          data: params => ({ search: params.term || '' }),
          processResults: data => ({
            results: (data.users || []).map(u => ({ id: u.id, text: u.displayName, jobTitle: u.jobTitle || '', email: u.userPrincipalName || '' }))
          })
        }
      }).on('select2:select', function (e) {
        const s = e.params.data || {};
        $('#department').val(s.jobTitle || '');
        $.get('<?= base_url('admin/get-menuaccess') ?>', { microsoft_id: s.id })
          .done(function(resp) {
            const selectedMenus = resp.selectedMenus || [];
            $('input[name="menuaccess[]"]').prop('checked', false);
            selectedMenus.forEach(id => $('#menu_' + id).prop('checked', true));
          })
          .fail(function(){ console.warn('Failed to load menu access'); });
      }).on('select2:clear', function(){
        $('#department').val('');
        $('input[name="menuaccess[]"]').prop('checked', false);
      });

      // Buttons
      $('#btnPublish').on('click', fn_publish);
      $('#btnCancel').on('click', function(){
        // reset and collapse
        $('#employee1').val(null).trigger('change');
        $('#department').val('');
        $('input[name="menuaccess[]"]').prop('checked', false);
        const $collapse = $('#assignAccessCollapse');
        if ($collapse.hasClass('show')) $collapse.collapse('hide');
      });

      // DataTable load
      fn_loadadministrator();
      $(document).on('click', '.span-toggle-status', function () {
        const id = $(this).data('id');
        const status = $(this).data('status'); // next status
        $.post('<?= base_url('admin/updatestatusadmin') ?>', { id, status })
          .done(function(res){
            if (res && (res.success || res.status === 'success')) {
              fn_loadadministrator(true); // soft reload table
            } else {
              Swal.fire('Failed', (res && (res.message || res.error)) || 'Failed to update status', 'error');
            }
          })
          .fail(function(){ Swal.fire('Error', 'AJAX request failed', 'error'); });
      });

      // Delete
      $(document).on('click', '.btn-delete-admin', function(){
        const id = $(this).data('id');
        Swal.fire({
          title: 'Are you sure?', text: 'This action cannot be undone!', icon: 'warning', showCancelButton: true,
          confirmButtonColor: '#d33', cancelButtonColor: '#3085d6', confirmButtonText: 'Yes, delete it!'
        }).then((r) => {
          if (!r.isConfirmed) return;
          $.post('<?= base_url('admin/administrator/delete') ?>', { id: id })
            .done(function(resp){
              if (resp && (resp.response === 'success' || resp.status === 'success')) {
                Swal.fire('Deleted!', 'The administrator has been deleted.', 'success');
                fn_loadadministrator(true);
              } else {
                Swal.fire('Error', (resp && (resp.message || resp.error)) || 'Failed to delete the administrator.', 'error');
              }
            })
            .fail(function(){ Swal.fire('Error', 'An error occurred while deleting the administrator.', 'error'); });
        });
      });
    });

    function fn_loadadministrator(softReload) {
      $.ajax({ url: '<?= base_url('admin/administrator/details') ?>', type: 'GET', dataType: 'json' })
        .done(function(resp){
          if (!(resp && resp.status === 'success')) {
            console.error('Failed to load administrator data:', resp && resp.message);
            return;
          }
          const rows = resp.data || [];

          if (adminTable && softReload) {
            adminTable.clear();
            adminTable.rows.add(rows).draw();
            return;
          }

          if (adminTable) { adminTable.destroy(); $('#tbladministrator').empty(); }

          adminTable = $('#tbladministrator').DataTable({
            data: rows,
            columns: [
              { data: 'no' },
              { data: 'display_name' },
              { data: 'department' },
              { data: 'menu_names' },
              {
                data: 'isstatus', orderable: false,
                render: function (data, type, row) {
                  const isActive = (parseInt(data, 10) === 0); // 0 => Active
                  const label = isActive ? 'Active' : 'Inactive';
                  const spanClass = isActive ? 'badge bg-success' : 'badge bg-danger';
                  const nextStatus = isActive ? 1 : 0;
                  return `<span class="${spanClass} span-toggle-status" data-id="${row.id}" data-status="${nextStatus}" style="cursor:pointer;">${label}</span>`;
                }
              },
              {
                data: null, orderable: false,
                render: function (data, type, row) {
                  return `<button type="button" class="btn btn-outline-secondary btn-sm btn-delete-admin" data-id="${row.id}"><i class="icofont-ui-delete text-danger"></i></button>`;
                }
              }
            ],
            responsive: true
          });
        })
        .fail(function(err){ console.error('AJAX Error:', err); });
    }

    function fn_publish() {
      const selected = $('#employee1').select2('data')[0];
      const employee = selected ? selected.id : '';
      const displayName = selected ? (selected.text || '') : '';
      const email = selected ? (selected.email || '') : '';
      const department = $('#department').val();

      const menuaccess = [];
      $('input[name="menuaccess[]"]:checked').each(function(){ menuaccess.push($(this).val()); });

      if (!employee) {
        Swal.fire('Required', 'Please select an employee.', 'warning');
        return;
      }

      $.ajax({
        url: '<?= base_url('admin/addnewadmin') ?>', type: 'POST', dataType: 'json',
        data: { employee, displayname: displayName, email, department, menuaccess }
      })
      .done(function(response){
        if (response && response.status === 'success') {
          Swal.fire({ icon: 'success', title: 'Access Published!', text: 'The access rights were successfully saved.', timer: 1400, showConfirmButton: false });
          fn_loadadministrator(true);
          // collapse & reset
          $('#btnCancel').trigger('click');
        } else {
          Swal.fire('Failed', (response && (response.message || response.error)) || 'Something went wrong', 'error');
        }
      })
      .fail(function(){
        Swal.fire('Request Failed', 'An error occurred while publishing access.', 'error');
      });
    }

  })();
</script>
