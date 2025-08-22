<!-- Body: Header / Navbar -->
<div class="header">
  <nav class="navbar py-4">
    <div class="container-xxl">
      <!-- rightbar -->
      <div class="h-right d-flex align-items-center mr-5 mr-lg-0 order-1">
        <div class="d-flex">
          <a class="nav-link text-primary collapsed" href="<?= site_url('help') ?>" title="Get Help">
            <i class="icofont-info-square fs-5"></i>
          </a>
        </div>

        <!-- language -->
        <div class="dropdown zindex-popover">
          <a class="nav-link dropdown-toggle pulse" href="#" role="button" data-bs-toggle="dropdown">
            <img src="<?= base_url('assets/images/flag/GB.png') ?>" alt="">
          </a>
          <div class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-md-end p-0 m-0 mt-3">
            <div class="card border-0">
              <ul class="list-unstyled py-2 px-3">
                <li><a href="#"><img src="<?= base_url('assets/images/flag/GB.png') ?>" alt=""> English</a></li>
                <li><a href="#"><img src="<?= base_url('assets/images/flag/DE.png') ?>" alt=""> German</a></li>
                <li><a href="#"><img src="<?= base_url('assets/images/flag/FR.png') ?>" alt=""> French</a></li>
                <li><a href="#"><img src="<?= base_url('assets/images/flag/IT.png') ?>" alt=""> Italian</a></li>
                <li><a href="#"><img src="<?= base_url('assets/images/flag/RU.png') ?>" alt=""> Russian</a></li>
              </ul>
            </div>
          </div>
        </div>

        <!-- notifications -->
        <div class="dropdown notifications">
          <a class="nav-link dropdown-toggle pulse" href="#" role="button" data-bs-toggle="dropdown">
            <i class="icofont-alarm fs-5"></i><span class="pulse-ring"></span>
          </a>
          <div id="NotificationsDiv" class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-md-end p-0 m-0 mt-3">
            <div class="card border-0 w380">
              <div class="card-header border-0 p-3">
                <h5 class="mb-0 font-weight-light d-flex justify-content-between">
                  <span>Notifications</span><span class="badge text-white">06</span>
                </h5>
              </div>
              <div class="tab-content card-body">
                <div class="tab-pane fade show active">
                  <ul class="list-unstyled list mb-0">
                    <!-- ... contoh item notifikasi ... -->
                  </ul>
                </div>
              </div>
              <a class="card-footer text-center border-top-0" href="#">View all notifications</a>
            </div>
          </div>
        </div>

        <?php
            $name     = session('name')      ?: '';               // tidak ada lagi 'John Quinn'
            $title    = session('jobtitle')  ?: '';
            $email    = session('email')     ?: '';
            $phone    = session('phone');
            $phoneTxt = is_array($phone) ? ($phone[0] ?? '') : ($phone ?: '');

            $rawAvatar     = session('avatar');                   // base64 atau data URI
            $defaultAvatar = base_url('assets/images/profile_av.svg');
            $avatarSrc     = $defaultAvatar;

            if (!empty($rawAvatar)) {
                if (str_starts_with($rawAvatar, 'data:')) {
                    $avatarSrc = $rawAvatar;
                } else {
                    $mime = 'image/png';
                    if (preg_match('/^\/9j\//', $rawAvatar)) $mime = 'image/jpeg';
                    elseif (preg_match('/^iVBORw0KGgo/', $rawAvatar)) $mime = 'image/png';
                    elseif (preg_match('/^R0lGOD/', $rawAvatar)) $mime = 'image/gif';
                    $avatarSrc = "data:{$mime};base64,{$rawAvatar}";
                }
            }
            ?>

            <div class="dropdown user-profile ml-2 ml-sm-3 d-flex align-items-center zindex-popover">
            <!-- teks nama + title di navbar (opsional: hapus div ini kalau mau avatar saja) -->
            <div class="u-info me-2 text-end">
                <?php if ($name): ?><p class="mb-0 line-height-sm"><span class="fw-bold"><?= esc($name) ?></span></p><?php endif; ?>
                <?php if ($title): ?><small><?= esc($title) ?></small><?php endif; ?>
            </div>

            <!-- trigger dropdown: avatar dari session -->
            <a class="nav-link dropdown-toggle pulse p-0" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static">
                <img class="avatar lg rounded-circle img-thumbnail"
                    src="<?= esc($avatarSrc) ?>" alt="profile"
                    onerror="this.src='<?= $defaultAvatar ?>'">
            </a>

        <!-- dropdown content -->
        <div class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-end p-0 m-0">
            <div class="card border-0 w280">
            <div class="card-body pb-0">
                <div class="d-flex py-1">
                <img class="avatar rounded-circle"
                    src="<?= esc($avatarSrc) ?>" alt="profile"
                    onerror="this.src='<?= $defaultAvatar ?>'">
                <div class="flex-fill ms-3">
                    <?php if ($name): ?><p class="mb-0"><span class="fw-bold"><?= esc($name) ?></span></p><?php endif; ?>
                    <?php if ($email): ?><small class="d-block"><?= esc($email) ?></small><?php endif; ?>
                    <?php if ($title): ?><small class="text-muted d-block"><?= esc($title) ?></small><?php endif; ?>
                    <?php if ($phoneTxt): ?><small class="text-muted d-block"><?= esc($phoneTxt) ?></small><?php endif; ?>
                </div>
                </div>
                <div><hr class="dropdown-divider border-dark"></div>
            </div>
            <div class="list-group m-2">
                <a href="<?= site_url('admin-profile') ?>" class="list-group-item list-group-item-action border-0">
                <i class="icofont-ui-user fs-5 me-3"></i>Profile Page
                </a>
                <a href="<?= site_url('logout') ?>" class="list-group-item list-group-item-action border-0">
                <i class="icofont-logout fs-5 me-3"></i>Signout
                </a>
            </div>
            </div>
        </div>
        </div>
      </div>

      <!-- menu toggler -->
      <button class="navbar-toggler p-0 border-0 menu-toggle order-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainHeader">
        <span class="fa fa-bars"></span>
      </button>

      <!-- search -->
      <div class="order-0 col-lg-4 col-md-4 col-sm-12 col-12 mb-3 mb-md-0">
        <div class="input-group flex-nowrap input-group-lg">
          <input type="search" class="form-control" placeholder="Search" aria-label="search" aria-describedby="addon-wrapping">
          <button type="button" class="input-group-text" id="addon-wrapping"><i class="fa fa-search"></i></button>
        </div>
      </div>
    </div>
  </nav>
</div>
