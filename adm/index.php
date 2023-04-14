<?php
session_start();
include_once('../php/m/SQLConexion.php');
$sql = new SQLConexion();
$_SESSION['id_usuario_constructora'] = '1';

$row_usuario = $sql->obtenerResultado("CALL sp_select_administrador2('".$_SESSION['id_usuario_constructora']."')");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Constructora - Panel de control</title>
    <link rel="shortcut icon" href="../img//favicon.ico" type="image/x-icon">
    <link rel="icon" href="../img//favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="css/app.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/iziToast.css" />
    <link rel="stylesheet" href="css/cropper.css" />
    <link rel="stylesheet" href="css/cdn_datatables.css" />
    <link rel="stylesheet" href="css/fancybox.min.css" />
    <link rel="stylesheet" href="css/slimselect.css" />
    <link rel="stylesheet" href="css/flatpickr.css" />
    <link rel="stylesheet" href="css/slick.min.css" />
    <link rel="stylesheet" href="css/magnific-popup.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body id="body" class="dark-sidebar">
    <div class="left-sidebar">
        <div class="brand">
            <a href="#propiedades" class="logo">
                <span>
                    <img src="img/logo-sm.png" class="logo-sm">
                </span>
                <span>
                    <img src="img/logo.png" class="logo-lg logo-light">
                </span>
            </a>
        </div>
        <div class="sidebar-user-pro media border-end">
            <div class="position-relative mx-auto">
                <img src="img/usuario.png" alt="user" class="rounded-circle thumb-md">
                <span class="online-icon position-absolute end-0"><i class="mdi mdi-record text-success"></i></span>
            </div>
            <div class="media-body ms-2 user-detail align-self-center text-truncate">
                <h5 class="font-14 m-0 fw-bold"><?php echo $row_usuario[0]['nombre_administrador']; ?></h5>
                <p class="opacity-50 mb-0"><?php echo $row_usuario[0]['correo_usuario']; ?></p>
            </div>
        </div>
        <div class="menu-content h-100" data-simplebar>
            <?php 
            include_once('../php/v/1/menu.php');  
            ?>
        </div>
    </div>
    <div class="topbar">
        <nav class="navbar-custom" id="navbar-custom">
            <ul class="list-unstyled topbar-nav float-end mb-0">
                <!-- <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-bell"></i>
                        <span class="alert-badge" id="dot_notification"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0">
                        <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">Notificaciones</h6>
                        <div class="notification-menu" id="content_notificaciones" data-simplebar>
                            <?php
                            if($total_row_informes>0){
                                for ($i=0; $i < $total_row_informes; $i++) { 
                                    echo
                                    '<a href="#informe_'.$row_informes[$i]['id_informe'].'" class="dropdown-item py-3">
                                        <small class="float-end text-muted ps-2">'.$row_informes[$i]['fecha_informe'].'</small>
                                        <div class="media">
                                            <div class="avatar-md bg-soft-warning">
                                                <i class="fa-solid fa-person-circle-exclamation"></i>
                                            </div>
                                            <div class="media-body align-self-center ms-2 text-truncate">
                                                <h6 class="my-0 fw-normal text-dark">'.$row_informes[$i]['nombre_cliente'].' solicita informes</h6>
                                                <small class="text-muted mb-0">'.$row_informes[$i]['direccion_propiedad'].'</small>
                                            </div>
                                        </div>
                                    </a>';
                                }
                            }
                            else{
                                echo
                                '<div class="card">
                                    <div class="card-body">
                                        <div class="ex-page-content text-center">
                                            <img src="img/error.png" alt="0" class="" height="100">
                                            <h5 class="font-16 text-muted mb-5">No tienes nuevas notificaciones</h5>
                                        </div>
                                    </div>
                                </div>';
                            }
                            ?>
                        </div>
                        <a href="#informes" class="dropdown-item text-center text-primary">Ver todo <i class="fi-arrow-right"></i></a>
                    </div>
                </li> -->
                <li class="dropdown">
                    <a class="nav-link dropdown-toggle nav-user" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <img src="img/usuario.png" alt="profile-user" class="rounded-circle me-2 thumb-sm" />
                            <div>
                                <small class="d-none d-md-block font-11">Admin</small>
                                <span class="d-none d-md-block fw-semibold font-12"><?php echo $row_usuario[0]['nombre_administrador']; ?> <i class="mdi mdi-chevron-down"></i></span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#perfil"><i class="ti ti-user font-16 me-1 align-text-bottom"></i> Perfil</a>
                        <div class="dropdown-divider mb-0"></div>
                        <a class="dropdown-item" href="#logout"><i class="ti ti-power font-16 me-1 align-text-bottom"></i> Cerrar sesión</a>
                    </div>
                </li>
            </ul>
            <ul class="list-unstyled topbar-nav mb-0">
                <li>
                    <button class="nav-link button-menu-mobile nav-icon" id="togglemenu">
                        <i class="ti ti-menu-2"></i>
                    </button>
                </li>
            </ul>
        </nav>
    </div>
    <div class="page-wrapper">
        <div class="page-content-tab">
            <div class="container-fluid" id="main"></div>
            <footer class="footer text-center text-sm-start">
                &copy; <?php echo date("Y"); ?> Border Bytes
            </footer>
        </div>
    </div>
    <script src="js/JQuery_3.6.1.js"></script>
    <script src="js/fn_<?php echo '1';?>.js?v=1.1"></script>
    <script src="js/funciones<?php echo '1';?>.js?v=1.1"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/iziToast.min.js"></script>
    <script src="js/cropper.js"></script>
    <script src="js/cdn_datatables.js"></script>
    <script src="js/datatables.js"></script>
    <script src="js/fancybox.js"></script>
    <script src="js/app.js"></script>
    <script src="js/slimselect.js"></script>
    <script src="js/flatpickr.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.inputmask.bundle.min.js"></script>


</body>

</html>