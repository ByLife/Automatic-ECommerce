<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="<?= isset($id) ? "../../" : "../" ?>">
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
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="./index.php" class="logo-link">
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
                        <div class="nk-content-inner">
                        
                                    <!-- .nk-msg-aside -->
                                    <?php if(!isset($id)){ ?>
                                        <h2 class="nk-block-title fw-normal">Cursa - Submit a ticket</h2>
                                        <div class="input-group" style="margin-top: 10em;   ">
                                            <div class="input-group-append">
                                            <div class="row g-gs">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="fv-full-name">Full Name</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" id="fv-full-name" value="<?= $user['fullname'] == null ? "Not Set" : $user['fullname']?>" name="fv-full-name" required="" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="fv-email">Email address</label>
                                                                <div class="form-control-wrap">
                                                                    <div class="form-icon form-icon-right">
                                                                        <em class="icon ni ni-mail"></em>
                                                                    </div>
                                                                    <input type="text" class="form-control" id="fv-email" value="<?= $user['email']; ?>" name="fv-email" required="" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="fv-message">Subject</label>
                                                                <div class="form-control-wrap">
                                                                    <textarea class="form-control form-control-sm textarea-cursa-ticket-subject" maxlength="75" id="fv-message" name="fv-message" placeholder="Why do you need help (max 75)" required="required"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-lg btn-primary cursa-input-create-ticket">Create a ticket</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <script src="./assets/js/modules/cookies.js"></script>
                                        <script src="./assets/js/modules/ticket.js"></script>
                                    <?php } else { ?>
                                        <div class="nk-msg">
                                        <div class="nk-msg-body bg-white show-message">
                                        <div class="nk-msg-head">
                                            <h4 class="title cursa-support-title d-none d-lg-block">Loading...</h4>
                                            <div class="nk-msg-head-meta">
                                                <div class="d-none d-lg-block">
                                                    <ul class="nk-msg-tags">
                                                        <li><span class="label-tag"><em class="icon ni ni-flag-fill"></em> <span>Cursa - Support</span></span></li>
                                                    </ul>
                                                </div>
                                                
                                                <ul class="nk-msg-actions">
                                                    <li><button type="submit" class="btn btn-dim btn-sm btn-outline-light cursa-close-ticket-input"><em class="icon ni ni-check"></em><span>Mark as Closed</span></button></li>
                                                </ul>
                                            </div>
                                            
                                        </div><!-- .nk-msg-head -->
                                        <div class="nk-msg-reply nk-reply" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                                        <div class="simplebar-content cursa-chatbox" style="padding: 0px;">
                                            <div class="nk-msg-head py-4 d-lg-none">
                                                <h4 class="title">Unable to select currency when order</h4>
                                                <ul class="nk-msg-tags">
                                                    <li><span class="label-tag"><em class="icon ni ni-flag-fill"></em> <span>Cursa - Support</span></span></li>
                                                </ul>
                                            </div>
                                            <div class="nk-reply-form">
                                                <div class="nk-reply-form-header">
                                                    <ul class="nav nav-tabs-s2 nav-tabs nav-tabs-sm">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" data-bs-toggle="tab" href="#reply-form">Reply</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="tab-content">
                                                        <div class="tab-pane active form-cursa" id="reply-form">
                                                            <div class="nk-reply-form-editor">
                                                                <div class="nk-reply-form-field">
                                                                    <textarea class="form-control form-control-simple no-resize form-textarea-cursa" placeholder="Hello"></textarea>
                                                                </div>
                                                                <div class="nk-reply-form-tools">
                                                                    <ul class="nk-reply-form-actions g-1">
                                                                        <li class="me-2"><button class="btn btn-primary form-input-cursa" type="submit">Reply</button></li>
                                                                    </ul>
                                                                </div><!-- .nk-reply-form-tools -->
                                                            </div><!-- .nk-reply-form-editor -->
                                                        </div>
                                                </div>
                                            </div><!-- .nk-reply-form -->
                                        </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 1329px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 297px; transform: translate3d(0px, 331px, 0px); display: block;"></div></div></div><!-- .nk-reply -->
                                        <div class="nk-msg-profile" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden;"><div class="simplebar-content" style="padding: 0px;">
                                        </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 718px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="height: 0px; display: none;"></div></div></div><!-- .nk-msg-profile -->
                                        </div>
                                        <span style="display: none;" class="ticket_id"><?= $id ?></span>
                                        <script src="./assets/js/modules/cookies.js"></script>
                                        <script src="./assets/js/modules/chat.js"></script>
                                    <?php } ?>
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
</body>

</html>