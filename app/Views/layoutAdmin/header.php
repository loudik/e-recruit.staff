<!doctype html>
<html lang="en" class="pxp-root">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon"> -->
        <link rel="icon" href="<?= $logoPath ?>" type="image/png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet">
        <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/font-awesome.min.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/owl.carousel.min.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/owl.theme.default.min.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/animate.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet">

        <title>Pannel Access</title>

       <style>
    
    .menu {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      gap: 12px; /* Jarak antar item */
    }

.menu li {
  margin-bottom: 0;
}

.menu-toggle, .menu-link {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 16px;
  border-radius: 12px;
  background-color: #f4f3ff;
  color: #6c63ff;
  text-decoration: none;
  font-weight: 600;
  transition: background-color 0.2s ease;
  gap: 12px;
  margin-bottom: 10px;
}

.menu-toggle:hover,.menu-link:hover {
  background-color: #eae6ff;
  color: #3f51b5;
}

.menu-label {
  flex: 1;
  margin-left: 10px;
  white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.menu-toggle.active .toggle-icon {
  transform: rotate(90deg);
}

/* Submenu */
.submenu {
  list-style: none;
  margin-top: 8px;
  margin-left: 0;
  padding-left: 10px;
  border-left: 2px dotted #e0dffe;
  position: relative;
}

.submenu li {
  position: relative;
  padding-left: 10px;
  margin-bottom: 10px;
}

/* .submenu li::before {
  content: '';
  position: absolute;
  left: -14px;
  top: 6px;
  width: 6px;
  height: 6px;
  background-color: #d8cbff;
  border-radius: 50%;
} */

.submenu li a {
  font-size: 0.95rem;
  color: #6c757d; /* abu-abu soft */
  text-decoration: none;
  display: block;
  transition: all 0.2s ease;
}

.submenu li a:hover {
  color: #4a4a4a;
  /* text-decoration: underline; */
}

.d-none {
  display: none;
}

@media (min-width: 768px) {
  .toggle-icon {
    transition: transform 0.2s ease;
    margin-left: 10px;

  }
}



</style>




    </head>

    <body style="background-color: var(--pxpMainColorLight);">
        <div class="pxp-preloader"><span>Loading...</span></div>
        <div class="pxp-dashboard-side-panel d-none d-lg-block">
    <div class="pxp-logo">
       <a href="#" class="pxp-animate">
            <img src="<?= base_url('anplogo.png') ?>" alt="Logo" style="height: 60px;">
        </a>

    </div>