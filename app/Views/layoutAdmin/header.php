<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title><?= esc($title ?? '::eBazar:: Dashboard') ?></title>
  <link rel="icon" href="<?= base_url('favicon.ico') ?>" type="image/x-icon">

  <!-- plugin css -->
  <link rel="stylesheet" href="<?= base_url('assets/plugin/datatables/responsive.dataTables.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugin/datatables/dataTables.bootstrap5.min.css') ?>">

  <!-- project css -->
  <link rel="stylesheet" href="<?= base_url('assets/css/ebazar.style.min.css') ?>">

  <?= $this->renderSection('styles') ?>
</head>
<body>
  <div id="ebazar-layout" class="theme-orange">
