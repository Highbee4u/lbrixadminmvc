<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo asset('images/apple-icon.png'); ?>">
  <link rel="icon" type="image/png" href="<?php echo asset('images/favicon.png'); ?>">
  <title>
    <?php echo isset($title) ? htmlspecialchars($title) : 'Login'; ?> - Lbrix Admin
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="<?php echo asset('css/nucleo-icons.css'); ?>" rel="stylesheet" />
  <link href="<?php echo asset('css/nucleo-svg.css'); ?>" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- CSS Files -->
  <link id="pagestyle" href="<?php echo asset('css/argon-dashboard.css'); ?>" rel="stylesheet" />
</head>

<body class="bg-gray-100">
  <?php echo $content; ?>
  <!--   Core JS Files   -->
  <script src="<?php echo asset('js/core/popper.min.js'); ?>"></script>
  <script src="<?php echo asset('js/core/bootstrap.min.js'); ?>"></script>
  <!-- Argon Dashboard -->
  <script src="<?php echo asset('js/argon-dashboard.js'); ?>"></script>
  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
