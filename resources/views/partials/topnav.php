<?php
// Top navigation bar for authenticated pages
$user = Auth::user();
$userName = Auth::userName();
?>
<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl bg-primary" id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page"><?php echo htmlspecialchars($pageTitle); ?></li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0"><?php echo htmlspecialchars($pageTitle); ?></h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" placeholder="Type here...">
                </div>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>
                <li class="nav-item dropdown d-flex align-items-center pe-2">
                    <a href="#" class="nav-link text-white font-weight-bold px-0 dropdown-toggle" id="settingsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none"><?php echo htmlspecialchars($userName); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
                        <li>
                            <a class="dropdown-item" href="<?php echo url('change-password'); ?>">
                                <i class="fa fa-key me-2"></i>Change Password
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="<?php echo url('logout'); ?>" onclick="event.preventDefault(); confirmLogout();">
                                <i class="fa fa-sign-out me-2"></i>Log out
                            </a>
                        </li>
                    </ul>
                    <form role="form" method="post" action="<?php echo url('logout'); ?>" id="logout-form" style="display: none;">
                        <input type="hidden" name="csrf_token" value="<?php echo Session::token(); ?>">
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    window.confirmLogout = function() {
        Swal.fire({
            title: 'Confirm Logout',
            text: 'Are you sure you want to log out?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#5e72e4',
            cancelButtonColor: '#f5365c',
            confirmButtonText: 'Yes, log out',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the logout form
                var f = document.getElementById('logout-form');
                if (f) f.submit();
            }
        });
    }
});
</script>
