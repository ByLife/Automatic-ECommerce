
<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>Cursa | Dashboard</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.0.3">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.0.3">
</head>

<body class="nk-body bg-lighter npc-general has-sidebar dark-mode">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <?php include_once "./views/body/nav/nav-menu.php"; ?>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ms-n1">
                                <a  class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="./index.php" class="logo-link">
                                    <img class="logo-light logo-img" src="./images/logo.png" srcset="./images/logo2x.png 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                                </a>
                            </div><!-- .nk-header-brand -->
                            <div class="nk-header-news d-none d-xl-block">
                                <div class="nk-news-list">
                                    <a class="nk-news-item" >
                                        <div class="nk-news-icon">
                                            <em class="icon ni ni-card-view"></em>
                                        </div>
                                        <div class="nk-news-text">
                                           
                                            <em class="icon ni ni-external"></em>
                                        </div>
                                    </a>
                                </div>
                            </div><!-- .nk-header-news -->
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <?php include_once "./views/body/nav/nav-dropdown.php"; ?>
                                    <!-- .dropdown -->
                                </ul><!-- .nk-quick-nav -->
                            </div><!-- .nk-header-tools -->
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Dashboard</h3>
                                            <div class="nk-block-des text-soft">
                                                <p>Welcome to Cursa Dashboard.</p>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <div class="toggle-wrap nk-block-tools-toggle">
                                                <a  class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                                <div class="toggle-expand-content" data-content="pageMenu">
                                                </div>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="row g-gs">
                                        <div class="col-xxl-6">
                                            <div class="row g-gs">
                                                <div class="col-lg-6 col-xxl-12">
                                                    <div class="row g-gs">
                                                        <div class="col-sm-4 col-lg-6 col-xxl-4">
                                                            <div class="card card-bordered">
                                                                <div class="card-inner">
                                                                    <div class="card-title-group align-start mb-2">
                                                                        <div class="card-title">
                                                                            <h6 class="title">Services</h6>
                                                                        </div>
                                                                        <div class="card-tools">
                                                                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Total active subscription"></em>
                                                                        </div>
                                                                    </div>
                                                                    <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                                        <div class="nk-sale-data">
                                                                            <span class="amount"><?= $servers == false ? 0 : count($servers); ?> <em class="icon ni ni-server green-light"></em> </span>
                                                                            <span class="sub-title"><a href="./client/order"><span class="text-success"><em class="icon ni ni-plus"></em> Order a new service</span></a></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!-- .card -->
                                                        </div><!-- .col -->
                                                        <div class="col-sm-4 col-lg-6 col-xxl-4">
                                                            <div class="card card-bordered">
                                                                <div class="card-inner">
                                                                    <div class="card-title-group align-start mb-2">
                                                                        <div class="card-title">
                                                                            <h6 class="title">Ticket</h6>
                                                                        </div>
                                                                        <div class="card-tools">
                                                                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Open a ticket for any questions or problems"></em>
                                                                        </div>
                                                                    </div>
                                                                    <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                                                                        <div class="nk-sale-data">
                                                                            <span class="amount"><?= $tickets == false ? 0 : count($tickets);?><em class="icon ni ni-ticket green-light"></em></span>
                                                                            <span class="sub-title"><a href="./client/ticket"><span class="text-success"><em class="icon ni ni-plus"></em> Open a new ticket</span></a></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!-- .card -->
                                                        </div><!-- .col -->
                                                    </div><!-- .row -->
                                                </div><!-- .col -->
                                            </div><!-- .row -->
                                        </div><!-- .col -->
                                        <p></p>
                                        <div class="col-md-8 col-xxl-12">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal1">Create Plan</button>

                                                        <div class="modal fade" tabindex="-1" id="modal1">
                                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                                                                    <div class="modal-body modal-body-lg">
                                                                        <h5 class="title">Payment Protocole</h5>
                                                                        <ul class="nk-nav nav nav-tabs">
                                                                            <li class="nav-item">
                                                                                <a class="nav-link active" data-bs-toggle="tab" href="#personal">Pricing</a>
                                                                            </li>
                                                                            <li class="nav-item">
                                                                                <a class="nav-link" data-bs-toggle="tab" href="#options">Options</a>
                                                                            </li>
                                                                        </ul><!-- .nav-tabs -->
                                                                        <div class="tab-content">
                                                                            <div class="tab-pane active" id="personal">
                                                                                <div class="row gy-4">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="full-name">Name</label>
                                                                                            <input type="text"  name="fullname" class="form-control form-control-lg plan_name" id="full-name" placeholder="Enter plan name">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="display-name">Price</label>
                                                                                            <input type="number" name="displayname" class="form-control form-control-lg cr_no plan_price" id="display-name" placeholder="49.99">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="phone-no">Description</label>
                                                                                            <input type="text" name="number" class="form-control form-control-lg plan_description" id="phone-no" placeholder="Best RDP for games">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div><!-- .tab-pane -->
                                                                            <div class="tab-pane" id="options">
                                                                                <div class="row gy-4">
                                                                                    <div class="alert-container"></div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="full-name">RAM (Mo)</label>
                                                                                            <input type="number" name="fullname" class="form-control form-control-lg plan_ram" id="full-name" placeholder="4096 Mo">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="display-name">CPU Core</label>
                                                                                            <input type="number" name="displayname" class="form-control form-control-lg plan_cpu_core" id="display-name" placeholder="4 vCPU">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="phone-no">Disk Space (Mo)</label>
                                                                                            <input type="number" name="number" class="form-control form-control-lg plan_disk_space" id="phone-no" placeholder="10000 Mo">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="birth-day">Bandwidth (Mo/s)</label>
                                                                                            <input type="number" name="birthdate" class="form-control form-control-lg plan_bandwidth" id="birth-day" placeholder="1000 Mo/s">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12">
                                                                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                                                            <li>
                                                                                                <button type="submit" name="update_profile" class="btn btn-lg btn-primary btn-plan">Confirm</a>
                                                                                            </li>
                                                                                            <li>
                                                                                                <a href="#" data-bs-dismiss="modal" class="link link-light">Exit</a>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div><!-- .tab-pane -->
                                                                        </div><!-- .tab-content -->
                                                                    </div><!-- .modal-body -->
                                                                </div><!-- .modal-content -->
                                                            </div><!-- .modal-dialog -->
                                                        </div>
                                        </div>
                                        <div class="col-md-8 col-xxl-6">
                                        
                                            <div class="card card-bordered card-full">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title"><span class="me-2">Products & Services</span></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-inner p-0 border-top">
                                                    <div class="nk-tb-list nk-tb-orders">
                                                        <div class="nk-tb-item nk-tb-head">
                                                            <div class="nk-tb-col"><span>Server ID</span></div>
                                                            <div class="nk-tb-col tb-col-sm"><span>Customer</span></div>
                                                            <div class="nk-tb-col tb-col-md"><span>Plan</span></div>
                                                            <div class="nk-tb-col tb-col-lg"><span>Hostname</span></div>
                                                            <div class="nk-tb-col"><span>Password</span></div>
                                                            <div class="nk-tb-col"><span class="d-none d-sm-inline">Delete</span></div>
                                                        </div>
                                                        <?php if($servers !== false) foreach($servers as $val){ ?>
                                                        <div class="nk-tb-item">
                                                            <div class="nk-tb-col">
                                                                <span class="tb-lead"><a href="./client/server/id">#<?= $val['server_id'] ?></a></span>
                                                            </div>
                                                            <div class="nk-tb-col tb-col-sm">
                                                                <div class="user-card">
                                                                    <div class="user-avatar user-avatar-sm bg-purple">
                                                                        <span>User</span>
                                                                    </div>
                                                                    <div class="user-name">
                                                                        <span class="tb-lead"><?= $user['username'] == null ? $user['email'] : $user['username']; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="nk-tb-col tb-col-md">
                                                                <span class="tb-sub"><?= $val['plan_name']; ?></span>
                                                            </div>
                                                            <div class="nk-tb-col tb-col-lg">
                                                                <span class="tb-sub text-primary"> <?= $val['hostname']; ?></span>
                                                            </div>
                                                            <div class="nk-tb-col">
                                                                <span class="tb-sub tb-amount"><span><?= $val['root_password']; ?></span></span>
                                                            </div>
                                                            <div class="nk-tb-col">
                                                                <span class=""><button class="server-delete btn btn-lg btn-primary btn-block" value="<?= $val['server_id']; ?>">Delete</button></span>
                                                            </div>
                                                        </div><!-- .nk-tb-item -->
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        <div class="col-md-8 col-xxl-6">
                                            <div class="card card-bordered card-full">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title"><span class="me-2">Tickets</span></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-inner p-0 border-top">
                                                    <div class="nk-tb-list nk-tb-orders">
                                                        <div class="nk-tb-item nk-tb-head">
                                                            <div class="nk-tb-col"><span>Ticket No.</span></div>
                                                            <div class="nk-tb-col tb-col-sm"><span>Ticket Owner</span></div>
                                                            <div class="nk-tb-col tb-col-md"><span>Date</span></div>
                                                            <div class="nk-tb-col tb-col-lg"><span>Ref</span></div>
                                                            <div class="nk-tb-col"><span>Reason</span></div>
                                                            <div class="nk-tb-col"><span class="d-none d-sm-inline">Status</span></div>
                                                        </div>
                                                       
                                                        <?php if($tickets !== false) foreach($tickets as $val){ ?>
                                                        <div class="nk-tb-item">
                                                            <div class="nk-tb-col">
                                                                <span class="tb-lead"><a href="./client/ticket/<?= $val["ticket_id"]; ?>">#<?= strtoupper(substr($val["ticket_id"], 0, 3)); ?></a></span>
                                                            </div>
                                                            <div class="nk-tb-col tb-col-sm">
                                                                <div class="user-card">
                                                                    <div class="user-avatar user-avatar-sm bg-purple">
                                                                        <span>User</span>
                                                                    </div>
                                                                    <div class="user-name">
                                                                        <span class="tb-lead"><?= $user['username'] == null ? $user['email'] : $user['username']; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="nk-tb-col tb-col-md">
                                                                <span class="tb-sub"><?= $val['created_at']; ?></span>
                                                            </div>
                                                            <div class="nk-tb-col tb-col-lg">
                                                                <span class="tb-sub text-primary"><?= strtoupper(substr($val["ticket_id"], 3)); ?></span>
                                                            </div>
                                                            <div class="nk-tb-col">
                                                                <span class="tb-sub tb-amount"><span><?=  substr($val['message'], 0, 25); ?></span>
                                                            </div>
                                                            <div class="nk-tb-col">
                                                                <span class="badge badge-dot badge-dot-xs bg-success"><?= $val['status'] == false ? "Open" : "Closed" ?></span>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                    </div><!-- .row -->
                                </div><!-- .nk-block -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
                <!-- footer @s -->
                <div class="nk-footer">
                    <div class="container-fluid">
                        <div class="nk-footer-wrap">
                            <div class="nk-footer-copyright"> &copy; 2022 Cursa
                            </div>
                            <div class="nk-footer-links">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->

    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.0.3"></script>
    <script src="./assets/js/scripts.js?ver=3.0.3"></script>
    <script src="./assets/js/charts/gd-default.js?ver=3.0.3"></script>
    <script src="./assets/js/modules/cookies.js"></script>
    <script src="./assets/js/modules/admin_services.js"></script>
    
</body>

</html>