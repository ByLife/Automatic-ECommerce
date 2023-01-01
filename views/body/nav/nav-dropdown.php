<li class="dropdown user-dropdown">
    <a class="dropdown-toggle" data-bs-toggle="dropdown">
        <div class="user-toggle">
            <div class="user-avatar sm">
                <em class="icon ni ni-user-alt"></em>
            </div>
            <div class="user-info d-none d-md-block">
                <div class="user-status"><?= $user['rank'] == 0 ? "Normal User" : "Admin" ?></div>
                <div class="user-name user-cursa-mail dropdown-indicator"><?= $user['email'] == null ? "Not Set" :  $user['email']; ?></div>
            </div>
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1">
        <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
            <div class="user-card">
                <div class="user-avatar">
                    <span>User</span>
                </div>
                <div class="user-info">
                    <span class="lead-text"><?= $user['username'] == null ? "Not Set" :  $user['username']; ?></span>
                    <span class="sub-text"><?= $user['email'] == null ? "Not Set" :  $user['email']; ?></span>
                </div>
            </div>
        </div>
        <div class="dropdown-inner">
            <ul class="link-list">
                <li><a href="./client/profile"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                <li><a href="./client/activity"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li>
                <li><a class="dark-switch"><em class="icon ni ni-moon"></em><span>Dark Mode</span></a></li>
            </ul>
        </div>
        <div class="dropdown-inner">
            <a href="./logout">
                <button type="submit" name="disconnect" class="btn btn-primary">Sign out ></button>
            </a>
        </div>
    </div>
</li><!-- .dropdown -->