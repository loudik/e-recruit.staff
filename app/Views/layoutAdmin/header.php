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
    ul.list-unstyled {
        padding-left: 0;
    }

    ul.list-unstyled li {
        margin-bottom: 6px;
    }

    ul.list-unstyled li a {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #111;
        text-decoration: none;
        font-weight: 500;
        padding: 8px 12px;
        border-radius: 6px;
        transition: background-color 0.2s ease;
    }

    ul.list-unstyled li a:hover {
        background-color: #f0f0f0;
        color: #007bff;
    }

    ul.list-unstyled li a span.fa {
        min-width: 20px;
        text-align: center;
    }

    /* Submenu styling */
    ul.list-unstyled .submenu {
        padding-left: 20px;
        border-left: 1px dotted #ccc;
        margin-top: 6px;
    }

    ul.list-unstyled .submenu li a {
        font-size: 0.95rem;
        color: #555;
        padding: 6px 12px;
        margin-bottom: 4px;
    }

    /* Hide by default */
    .d-none {
        display: none;
    }

    /* Submenu indent */
    ul ul {
        margin-left: 20px;
        padding-left: 10px;
        border-left: 1px dashed #ccc;
    }

    ul li {
        margin-bottom: 5px;
    }

    .submenu {
        margin-left: 20px;
    }

    .menu-toggle {
    display: flex;
    align-items: center;
    justify-content: space-between; /* ini yang meratakan kiri-kanan */
    width: 100%;
    padding: 8px 12px;
    border-radius: 8px;
    gap: 10px;
    text-decoration: none;
    color: #111;
    transition: background-color 0.2s ease;
    }

    .menu-toggle:hover {
        background-color: #f0f0f0;
        color: #007bff;
    }

    .menu-toggle .menu-label {
        flex-grow: 1; /* Dorong toggle-icon ke kanan */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .toggle-icon {
        font-size: 0.9rem;
        margin-left: auto; 
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