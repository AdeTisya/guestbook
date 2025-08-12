<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSRF Token -->
    <meta name="csrf-token-name" content="<?= csrf_token() ?>">
    <meta name="csrf-token-hash" content="<?= csrf_hash() ?>">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>/dokumen/AdminLTE3/plugins/fontawesome-free/css/all.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    
    <!-- iCheck Bootstrap -->
    <link rel="stylesheet" href="<?= base_url(); ?>/dokumen/AdminLTE3/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>/dokumen/AdminLTE3/dist/css/adminlte.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Custom CSS -->
    <?php if (isset($cssFile)): ?>
        <link rel="stylesheet" href="<?= base_url('css/' . $cssFile) ?>?v=<?= time() ?>">
    <?php endif; ?>

    <!-- Load jQuery hanya sekali di head -->
    <script src="<?= base_url(); ?>/dokumen/AdminLTE3/plugins/jquery/jquery.min.js"></script>
</head>

<body class="hold-transition login-page">
    <?= $this->renderSection('content-admin'); ?>
    <?= $this->renderSection('content-auth'); ?>

    <!-- Bootstrap 4 -->
    <script src="<?= base_url(); ?>/dokumen/AdminLTE3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>/dokumen/AdminLTE3/dist/js/adminlte.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Pastikan Bootstrap Modal terload sebelum script kamera -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>