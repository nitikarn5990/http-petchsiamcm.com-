<div id="da-header-top">

    <!-- Container -->
    <div class="da-container clearfix">

        <!-- Logo Container. All images put here will be vertically centere -->
        <div id="da-logo-wrap">
            <div id="da-logo">
                <div id="da-logo-img">
                    <!--<a href="dashboard.html">
                        <img src="assets/images/logo.png" alt="">
                    </a>-->
                </div>
            </div>
        </div>

        <!-- Header Toolbar Menu -->
        <div id="da-header-toolbar" class="clearfix">
            <div id="da-user-profile-wrap">
                <div id="da-user-profile" data-toggle="dropdown" class="clearfix">
                    <div id="da-user-avatar">
                        <img src="assets/images/pp.jpg" alt="">
                    </div>
                    <div id="da-user-info">
                        <?php echo $users->GetValue("name")?>
                        <span class="da-user-title">Administrator</span>
                    </div>
                </div>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo ADDRESS_ADMIN?>">หน้าหลัก</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo ADDRESS_ADMIN?>">ข้อมูลส่วนตัว</a></li>
                </ul>
            </div>
            <div id="da-header-button-container">
                <ul>
                    <li class="da-header-button-wrap">
                        <div class="da-header-button">
                            <a href="javascript:void(0)" onclick="window.location='<?php echo ADDRESS?>logout?group=admin'" title="ออกจากระบบ"><i class="icon-power"></i></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>