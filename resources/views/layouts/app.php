<?php
// Check if user is authenticated, redirect to login if not
// But only redirect once to prevent infinite loops - use a session flag
if (!Auth::check()) {
    // Set a flag to prevent infinite redirect loops on unstable sessions (IIS)
    if (!isset($_SESSION['_auth_redirect_attempt'])) {
        $_SESSION['_auth_redirect_attempt'] = true;
        redirect('login');
        exit;
    } else {
        // We've already tried to redirect - don't try again
        // This prevents redirect loops on systems with session issues
        unset($_SESSION['_auth_redirect_attempt']);
        echo "Authentication required. Please <a href='" . url('login') . "'>log in</a>.";
        exit;
    }
}

// Clear the redirect attempt flag on successful auth
unset($_SESSION['_auth_redirect_attempt']);

// Prevent browser caching of protected pages
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo asset('images/apple-icon.png'); ?>">
  <link rel="icon" type="image/png" href="<?php echo asset('images/favicon.png'); ?>">
  <title>
    <?php echo isset($title) ? htmlspecialchars($title) : 'Dashboard'; ?> - Lbrix Admin
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
  <link href="<?php echo asset('css/sidenav-custom.css'); ?>" rel="stylesheet" />
  <!-- Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <?php include __DIR__ . '/../partials/sidenav.php'; ?>
  <main class="main-content position-relative border-radius-lg">
    <?php include __DIR__ . '/../partials/topnav.php'; ?>
    <?php echo $content; ?>
  </main>
  <?php include __DIR__ . '/../partials/fixed-plugin.php'; ?>
  <!--   Core JS Files   -->
  <script src="<?php echo asset('js/core/popper.min.js'); ?>"></script>
  <script src="<?php echo asset('js/core/bootstrap.min.js'); ?>"></script>
  <script src="<?php echo asset('js/plugins/perfect-scrollbar.min.js'); ?>"></script>
  <script src="<?php echo asset('js/plugins/smooth-scrollbar.min.js'); ?>"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Argon Dashboard -->
  <script src="<?php echo asset('js/argon-dashboard.js'); ?>"></script>

  <!-- Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
