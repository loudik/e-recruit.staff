
<?= view('layoutAdmin/header.php'); ?>
        <?= view('layoutAdmin/sidebar.php'); ?>
        <?= view('layoutAdmin/navbar.php'); ?>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <style>
    .dropdown-checkbox {
        position: relative;
        width: 100%;
    }

    .dropdown-checkbox-toggle {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        background-color: #fff;
        cursor: pointer;
        font-size: 16px;
    }

    .dropdown-checkbox-list {
        display: none;
        position: absolute;
        background-color: #fff;
        width: 100%;
        max-height: 250px;
        overflow-y: auto;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: 1px solid #ccc;
        border-radius: 6px;
        z-index: 9999;
        margin-top: 5px;
        padding: 10px;
    }

    .dropdown-checkbox.open .dropdown-checkbox-list {
        display: block;
    }

    .dropdown-checkbox-list .form-check {
        display: flex;
        align-items: center;
        padding: 4px 0;
        gap: 10px;
    }

    .dropdown-checkbox-list .form-check-input {
        margin: 0;
        width: 18px;
        height: 18px;
        accent-color: #0d6efd;
    }

    .dropdown-checkbox-list .form-check-label {
        font-size: 16px;
        cursor: pointer;
        margin-bottom: 0;
    }
</style>



     

    </div>


    <!---------------------------------------- LAYOUT MAIN --------------------------------------------------------------- -->
        <div class="pxp-dashboard-content">
            <div class="pxp-dashboard-content-header">
                <div class="pxp-nav-trigger navbar pxp-is-dashboard d-lg-none">
                    <a role="button" data-bs-toggle="offcanvas" data-bs-target="#pxpMobileNav" aria-controls="pxpMobileNav">
                        <div class="pxp-line-1"></div>
                        <div class="pxp-line-2"></div>
                        <div class="pxp-line-3"></div>
                    </a>
                    <div class="offcanvas offcanvas-start pxp-nav-mobile-container pxp-is-dashboard" tabindex="-1" id="pxpMobileNav">
                        <div class="offcanvas-header">
                            <div class="pxp-logo">
                                <a href="index.html" class="pxp-animate"><span style="color: var(--pxpMainColor)">A</span>NP</a>
                            </div>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <nav class="pxp-nav-mobile">
                                <ul class="navbar-nav justify-content-end flex-grow-1">
                                   <?= view('layoutAdmin/partial/sidebar_menu') ?>

                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <nav class="pxp-user-nav pxp-on-light">
                    <a href="<?= base_url('admin/newjobs') ?>" class="btn rounded-pill pxp-nav-btn">Post a Job</a>
                 
                    <div class="dropdown pxp-user-nav-dropdown">
                        
                         <a role="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                          <div class="pxp-user-nav-avatar pxp-cover" 
                              style="background-image: url('<?= esc(session()->get('user_avatar') ?? base_url('assets/images/customer-4.png')) ?>');">
                          </div>
                          <div class="pxp-user-nav-name d-none d-md-block">
                              <?= esc(session()->get('name') ?? 'Guest User') ?>
                          </div>
                      </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end">
                           <li><a class="dropdown-item" href="<?= site_url('logout') ?>">Logout</a></li>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="pxp-dashboard-content-details">
    <h1>Administrator</h1>

    <!-- Button -->
    <button type="button" class="btn btn-primary mb-3" onclick="toggleForm()">+ Assign Access</button>
    <div id="accessFormContainer" style="display: none;" class="mb-4"> 
        <div class="col-md-6 col-xxl-3">
            <div class="mb-3">
                <label for="employee1" class="form-label" style="font-weight: bold;">Employee</label>
                <select id="employee1" name="employee1" class="form-select">
                    <?php foreach ($users as $u): ?>
                        <?php 
                                echo '<!-- ID: '.$u['id'].' | Name: '.$u['displayName'].' | Email: '.$u['userPrincipalName'].' -->';
                            ?>
                        <option 
                            value="<?= $u['id']; ?>" 
                            data-displayname="<?= esc($u['displayName']) ?>" 
                            data-email="<?= esc($u['userPrincipalName']) ?>"
                        >
                            <?= esc($u['displayName']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            </div>
        </div>           
        <div class="row mt-4">
            <!-- Department -->
            <div class="col-md-6 col-xxl-3">
                <div class="mb-3">
                    <label for="department" class="form-label" style="font-weight: bold;">Department</label>
                    <input type="text" id="department" name="department" class="form-control" readonly>
                </div>
            </div>

            <!-- Menu -->
            <div class="col-md-6 col-xxl-3">
                <label class="form-label fw-bold">Menu</label>
                <div class="dropdown-checkbox" id="menuDropdown">
                    <div class="dropdown-checkbox-toggle" onclick="toggleDropdown()">Select menu...</div>
                    <div class="dropdown-checkbox-list">
                        <?php foreach ($menus as $menu): ?>
                            <?php if ($menu['parent_id'] == 0): ?>
                            <!-- Parent menu -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    name="menuaccess[]" id="menu_<?= $menu['id'] ?>"
                                    value="<?= $menu['id'] ?>"
                                    <?= in_array($menu['id'], $selectedMenus ?? []) ? 'checked' : '' ?>>
                                <label class="form-check-label fw-semibold" for="menu_<?= $menu['id'] ?>">
                                <?= esc($menu['menuname']) ?>
                                </label>
                            </div>

                            <!-- Submenu jika ada -->
                            <?php foreach ($menus as $submenu): ?>
                                <?php if ($submenu['parent_id'] == $menu['id']): ?>
                                <div class="form-check" style="margin-left: 1.5rem;">
                                    <input class="form-check-input" type="checkbox"
                                        name="menuaccess[]" id="menu_<?= $submenu['id'] ?>"
                                        value="<?= $submenu['id'] ?>"
                                        <?= in_array($submenu['id'], $selectedMenus ?? []) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="menu_<?= $submenu['id'] ?>">
                                    → <?= esc($submenu['menuname']) ?>
                                    </label>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php endif; ?>
                        <?php endforeach; ?>
                        </div>

                </div>
            </div>

        </div>
            <div class="mt-2">
                <button type="button" class="btn btn-success" onclick="fn_publish()">Publish</button>
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        <!-- </form> -->
    </div>

          <!-- Table always visible -->
          <div class="table-responsive">
              <table class="table table-hover align-middle" id="tbladministrator">
                  <thead>
                      <tr>
                          <th style="width: 10%;">No</th>
                          <th style="width: 35%;">Name</th>
                          <th style="width: 30%;">Position</th>
                          <th style="width: 30%;">Menu</th>
                          <th style="width: 15%;">Status</th>
                          <th style="width: 30%;">Action</th>
                      </tr>
                  </thead>
                  <tbody></tbody>
              </table>
          </div>
      </div>


            

            <!---------------------------------------- LAYOUT MAIN --------------------------------------------------------------- -->

            <?= view('layoutAdmin/footer.php'); ?>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


            <script>
              $(document).ready(function () {
                  $('#menuaccess').select2({
                      placeholder: "Select one or more modules",
                       width: '100%'
                  });
                  fn_loadadministrator();
              });

              function fn_loadadministrator() {
                $.ajax({
                    url: '<?= base_url('admin/administrator/details') ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log("Response:", response);
                        if (response.status === 'success') {
                            if ($.fn.DataTable.isDataTable('#tbladministrator')) {
                                console.log($.fn.DataTable);

                                $('#tbladministrator').DataTable().clear().destroy();
                            }

                            let table = $('#tbladministrator').DataTable({
                                data: response.data,
                                columns: [
                                    { data: 'no' },
                                    { data: 'display_name' },
                                    { data: 'department' },
                                     { data: 'menu_names' },
                                    {
                                        data: 'isstatus',
                                        orderable: false,
                                        render: function (data, type, row) {
                                            const isActive = data == 0;
                                            const label = isActive ? 'Active' : 'Inactive';
                                            const spanClass = isActive ? 'badge bg-success' : 'badge bg-danger';
                                            const nextStatus = isActive ? 1 : 0;

                                            return `
                                                <span class="${spanClass} span-toggle-status"
                                                    data-id="${row.id}" data-status="${nextStatus}" style="cursor:pointer;">
                                                    ${label}
                                                </span>`;
                                        }
                                    },


                                    
                                    {
                                            data: null,
                                            render: function (data, type, row) {
                                                return `
                                                <div class="d-flex gap-1">
                                                    <span class="badge bg-danger text-white px-2 py-1"
                                                        style="cursor:pointer; font-size: 0.75rem;"
                                                        onclick="fn_delete(${row.id})">
                                                        Delete
                                                    </span>
                                                </div>`;
                                            }

                                        }


                                ],
                                responsive: true
                            });
                        } else {
                            console.error('Failed to load administrator data:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
                }

                $(document).on('click', '.span-toggle-status', function () {
                    const id = $(this).data('id');
                    const status = $(this).data('status');

                    $.ajax({
                        url: '<?= base_url('admin/updatestatusadmin') ?>',
                        type: 'POST',
                        data: {
                            id: id,
                            status: status
                        },
                        success: function (res) {
                            if (res.success) {
                                location.reload(); // Reload the page to reflect changes
                            } else {
                                alert(res.message || 'Failed to update status');
                            }
                        },
                        error: function () {
                            alert('AJAX request failed');
                        }
                    });
                });





                // <button class="btn btn-primary btn-sm" onclick="fn_edit(${row.id})">Edit</button>

                  function toggleDropdown() {
                    document.getElementById('menuDropdown').classList.toggle('open');
                }

                // Optional: tutup dropdown jika klik di luar
                window.addEventListener('click', function(e) {
                    const box = document.getElementById('menuDropdown');
                    if (!box.contains(e.target)) {
                        box.classList.remove('open');
                    }
                });


                function fn_delete(id) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '<?= base_url('admin/administrator/delete') ?>',
                                type: 'POST',
                                dataType: 'json',
                                data: { id: id },
                                success: function(response) {
                                    if (response.response === 'success') {
                                        Swal.fire(
                                            'Deleted!',
                                            'The administrator has been deleted.',
                                            'success'
                                        ).then(() => {
                                            fn_loadadministrator();
                                        });
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            response.message || 'Failed to delete the administrator.',
                                            'error'
                                        );
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('AJAX Error:', error);
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while deleting the administrator.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                }

              


              $(document).ready(function () {
                $('#employee1').select2({
                    placeholder: 'Select an employee1',
                    width: '100%',
                    allowClear: true,
                    ajax: {
                        url: "<?= base_url('admin/users-json') ?>",
                        dataType: 'json',
                        delay: 250,
                        xhrFields: {
                            withCredentials: true
                        },
                        data: function (params) {
                            console.log("Searching for:", params.term);
                            return {
                                search: params.term || ''
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: (data.users || []).map(function (user) {
                                    console.log("User data:", user);
                                    return {
                                        id: user.id,
                                        text: user.displayName,
                                        jobTitle: user.jobTitle || '',
                                        displayname: user.displayName,             
                                        email: user.userPrincipalName || '' 
                                    };
                                })
                            };
                        },
                        cache: true
                    },
                    templateResult: function (data) {
                        if (!data.id) return data.text;
                        return $('<span>' + data.text + '</span>');
                    },
                    templateSelection: function (data) {
                        return data.text;
                    }
                });

                // Saat user dipilih, isi field department dan ambil menu akses
                $('#employee1').on('select2:select', function (e) {
                    const selected = e.params.data;
                    $('#department').val(selected.jobTitle || '');
                    $.ajax({
                        url: "<?= base_url('admin/get-menuaccess') ?>",
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            microsoft_id: selected.id // id = microsoft_id
                        },
                        success: function (response) {
                            const selectedMenus = response.selectedMenus || [];

                            // Uncheck semua menu
                            $('input[name="menuaccess[]"]').prop('checked', false);

                            // Centang sesuai menu_ids
                            selectedMenus.forEach(function (id) {
                                $('#menu_' + id).prop('checked', true);
                            });
                        },
                        error: function () {
                            console.warn('Gagal memuat akses menu.');
                        }
                    });
                });

                // Saat dropdown di-clear, kosongkan department dan uncheck semua
                $('#employee1').on('select2:clear', function () {
                    $('#department').val('');
                    $('input[name="menuaccess[]"]').prop('checked', false);
                });
              });




              function toggleForm() {
                  const formContainer = document.getElementById('accessFormContainer');
                  formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
              }

              


                function fn_publish() {
                    var employee = $('#employee1').val();
                    var selectedUser = $('#employee1').select2('data')[0];
                    console.log("Email:", selectedUser.email);
                    var displayName = selectedUser.displayname;
                    var email = selectedUser.email;

                    var department = $('#department').val();
                    var menuaccess = [];
                    $('input[name="menuaccess[]"]:checked').each(function () {
                        menuaccess.push($(this).val());
                    });


                    $.ajax({
                        url: '<?= base_url('admin/addnewadmin') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            employee: employee,
                            displayname: displayName,
                            email: email,
                            department: department,
                            menuaccess: menuaccess
                        },
                        success: function(response) {
                            console.log("Display Name:", displayName);
                            console.log("Email:", email);

                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Access Published!',
                                    text: 'The access rights were successfully saved.',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed',
                                    text: response.message || 'Something went wrong'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Request Failed',
                                text: 'An error occurred while publishing access.'
                            });
                        }
                    });
                }
            </script>