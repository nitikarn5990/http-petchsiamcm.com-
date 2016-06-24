<ul>

    <li class="">

        <a href="#">

            <!-- Icon Container -->

            <span class="da-nav-icon">

                <i class="icon-user"></i>

            </span>

            จัดการคณะกรรมการ

        </a>

        <ul>

            <li><a href="<?php echo ADDRESS_ADMIN_CONTROL?>คณะกรรมการ">จัดการคณะกรรมการ</a></li>

           
        </ul>

    </li>

    <li class="">

        <a href="#">

            <!-- Icon Container -->

            <span class="da-nav-icon">

                <i class="icon-notes"></i>

            </span>

           ข่าวสาร / ประชาสัมพันธ์

        </a>

        <ul>

        	<li><a href="<?php echo ADDRESS_ADMIN_CONTROL?>content_categories">หมวดหมู่ข่าวสาร</a></li>

            <li><a href="<?php echo ADDRESS_ADMIN_CONTROL?>contents">จัดการข่าวสาร</a></li>
<!--
            <li><a href="<?php //echo ADDRESS_ADMIN_CONTROL?>static_blocks">Static Block</a></li>
            
            <li><a href="<?php //echo ADDRESS_ADMIN_CONTROL?>news_sms">จัดการข่าวสาร SMS</a></li>
-->

        </ul>

    </li>

    <li class="">

        <a href="#">

            <!-- Icon Container -->

            <span class="da-nav-icon">

                <i class="icon-usd"></i>

            </span>

           Gallery

        </a>

        <ul>

            <li><a href="<?php echo ADDRESS_ADMIN_CONTROL?>gallery_categories">หมวดหมู่รูปภาพ</a></li>

            <li><a href="<?php echo ADDRESS_ADMIN_CONTROL?>gallery">จัดการรููปภาพ</a></li>

        </ul>

    </li>
    <li class="">

        <a href="#">

            <!-- Icon Container -->

            <span class="da-nav-icon">

                <i class="icon-usd"></i>

            </span>

           Slide

        </a>

        <ul>

            <li><a href="<?php echo ADDRESS_ADMIN_CONTROL?>slides">เพิ่มภาพสไลด์</a></li>


        </ul>

    </li>

	 <li class="">

        <a href="#">

            <!-- Icon Container -->

            <span class="da-nav-icon">

                <i class="icon-usd"></i>

            </span>

           Slide

        </a>

        <ul>
                           
            <li><a href="<?php echo ADDRESS_ADMIN_CONTROL?>image_head&action=edit&id=<?php echo $image_head->getLastID("id") ?>">ภาพ header</a></li>


        </ul>

    </li>
   
</ul>