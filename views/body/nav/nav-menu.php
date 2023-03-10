<div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-menu-trigger">
            <a class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
            <a style="right: 6px;" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><img src="assets/images/icon_green.png" /></a>
        </div>
        <div class="nk-sidebar-brand">
            <a href="./" class="logo-link nk-sidebar-logo" style="margin-left: 2em; right: 35px;">
                <img class="logo-light logo-img" src="assets/images/logo-text.png" srcset="assets/images/logo-text.png" alt="logo">
                <img class="logo-dark logo-img" src="assets/images/logo-text.png"  srcset="assets/images/logo-text.png" alt="logo-dark">
            </a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element nk-sidebar-body">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <?php if($user['rank'] > 0){ ?>
                    <li class="nk-menu-heading">
                        <h6 class="overline-title text-primary-alt">Administration</h6>
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item">
                        <a href="./admin/users" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
                            <span class="nk-menu-text">Users</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item">
                        <a href="./admin/services" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-server"></em></span>
                            <span class="nk-menu-text">Services</span>
                        </a>
                    </li>
                    <?php } ?>
                    <!-- .nk-menu-item / admin -->
                    <li class="nk-menu-heading">
                        <h6 class="overline-title text-primary-alt">Main</h6>
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item">
                        <a href="./client/dashboard" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-block-over"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item">
                        <a href="./client/order" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-plus"></em></span>
                            <span class="nk-menu-text">Orders</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item has-sub">
                        <a class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-server"></em></span>
                            <span class="nk-menu-text">Services</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <?php if($servers !== false) foreach($servers as $val){ ?>
                            <li class="nk-menu-item">
                                <a href="./client/server/<?= $val['server_id']; ?>" class="nk-menu-link"><span class="nk-menu-text">Server #<?= $val['server_id']; ?></span></a>
                            </li>
                            <?php } ?>
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-heading">
                        <h6 class="overline-title text-primary-alt">Utils</h6>
                    </li><!-- .nk-menu-heading -->
                    <li class="nk-menu-item has-sub">
                        <a class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-tile-thumb"></em></span>
                            <span class="nk-menu-text">Tickets</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="./client/ticket" class="nk-menu-link"><span class="nk-menu-text">Open a new ticket</span></a>
                            </li>
                            <?php if($tickets !== false) foreach($tickets as $val){ if($val['status'] == 0) {?>
                            <li class="nk-menu-item">
                                <a href="./client/ticket/<?= $val['ticket_id']; ?>" class="nk-menu-link"><span class="nk-menu-text">Ticket #<?= $val['ticket_id']; ?></span></a>
                            </li>
                            <?php }}?>
                        </ul><!-- .nk-menu-sub -->
                    </li>

                    <!-- .nk-menu-item / client -->
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>