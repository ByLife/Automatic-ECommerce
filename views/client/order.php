

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
    <title>Cursa | Order a new service</title>
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
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="html/index.html" class="logo-link">
                                    <img class="logo-light logo-img" src="./images/logo.png" srcset="./images/logo2x.png 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                                </a>
                            </div><!-- .nk-header-brand -->
                            <div class="nk-header-news d-none d-xl-block">
                                <div class="nk-news-list">
                                    <a class="nk-news-item" href="#">
                                        <div class="nk-news-icon">
                                            <em class="icon ni ni-card-view"></em>
                                        </div>
                                        <div class="nk-news-text">
                                            <p>Do you know the latest update of 2022? <span> A overview of our is now available on YouTube</span></p>
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
                    <div class="container">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block nk-block-lg">
                                    <div class="nk-block-head">
                                        <div class="nk-block-between g-3">
                                            <div class="nk-block-head-content">
                                                <h3 class="nk-block-title page-title">RDP</h3>
                                                <div class="nk-block-des text-soft">
                                                    <p>Choose your pricing plan and start enjoying our service.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head -->
                                    <div class="row g-gs">
                                            <div class="nk-block-head">
                                                <div class="nk-block-between g-3">
                                                    <div class="nk-block-head-content">
                                                        <h3 class="nk-block-title page-title">NAME</h3>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-block-head -->
                                        <?php if($plans !== false) foreach($plans as $val){ ?>
                                        <div class="col-md-6 col-xxl-3">
                                            <div class="card card-bordered pricing text-center">
                                                <div class="pricing-body">
                                                    <div class="pricing-media">
                                                        <img src="./images/icons/plan-s1.svg" alt="">
                                                        IMG LINK
                                                    </div>
                                                    <div class="pricing-title w-220px mx-auto">
                                                        <h5 class="title">VALEUR</h5>
                                                        <span class="sub-text">DESCRIPTION</span>
                                                    </div>
                                                
                                                    <div class="pricing-amount">
                                                        <div class="amount">PRIX 69 <span>€</span></div>
                                                        <span class="bill">Billed Monthly</span>
                                                    </div>
                                                    <div class="pricing-action">
                                                        <!-- Modal Trigger Code -->
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal1">Select Plan</button>
                                                        
                                                        <!-- Modal Content Code -->
                                                        <div class="modal fade" tabindex="-1" id="modal1">
                                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                                                                    <div class="modal-body modal-body-lg">
                                                                        <h5 class="title">Payment Protocole</h5>
                                                                        <ul class="nk-nav nav nav-tabs">
                                                                            <li class="nav-item">
                                                                                <a class="nav-link active" data-bs-toggle="tab" href="#personal">Payment</a>
                                                                            </li>
                                                                        </ul><!-- .nav-tabs -->
                                                                        <div class="tab-content">
                                                                            <div class="tab-pane active" id="personal">
                                                                                <div class="row gy-4">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="full-name">Full Name</label>
                                                                                            <input type="text"  name="fullname" class="form-control form-control-lg" id="full-name" value="<?= $user['fullname']; ?>" placeholder="Enter Full name">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="display-name">Card Number</label>
                                                                                            <input type="text" name="displayname" class="form-control form-control-lg cr_no" id="display-name" placeholder="0000 0000 0000 0000" size="18" minlength="18" maxlength="18">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="phone-no">CVV/CVC</label>
                                                                                            <input type="text" name="number" class="form-control form-control-lg" id="phone-no" placeholder="000" minlength="3" maxlength="3">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="birth-day">Expiry Date</label>
                                                                                            <input type="text" name="birthdate" placeholder="MM/YY" class="form-control form-control-lg exp" id="birth-day" placeholder="Enter your birth date" minlength="5" maxlength="5">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12">
                                                                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                                                            <li>
                                                                                                <button type="submit" name="update_profile" class="btn btn-lg btn-primary btn-order" data-bs-toggle="tab" href="#personal">Confirm Payment</a>
                                                                                            </li>
                                                                                            <li>
                                                                                                <a href="#" data-bs-dismiss="modal" class="link link-light">Cancel</a>
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
                                                </div>
                                            </div><!-- .pricing -->
                                        </div><!-- .col -->
                                        <?php } ?>
                                    </div>
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
    <script src="./assets/js/card.js"></script>
    <script src="./assets/js/modules/order.js"></script>
</body>

</html>
