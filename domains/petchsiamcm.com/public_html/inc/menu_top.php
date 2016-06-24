<nav class="navbar navbar-default">

        <div class="container">

            <div class="navbar-header">

                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                </button>

            </div>

            <div id="navbar" class="navbar-collapse collapse">
				
                 <ul class="nav navbar-nav navbar-left">
                 <li><a href="<?php echo ADDRESS ?>cart.html"><i class="fa fa-cart-arrow-down"></i> ตระกร้าสินค้า <?php echo count($_SESSION["strProductID"])?> รายการ </a></li>
                 </ul>
                <ul class="nav navbar-nav navbar-right">

                  
				<?php 
		
					if($_SESSION['customer_id'] != ''){ ?>
           
                    	<li><a href="<?php echo ADDRESS ?>member.html">ข้อมูลสมาชิก </a></li>
						 <li><a href="<?php echo ADDRESS ?>signin.html">ยินดีต้อนรับคุณ <?php echo $_SESSION['customer_name'] ?></a></li>
                          <li><a href="<?php echo ADDRESS ?>signout.html">ออกจากระบบ</a></li>
                        
			<?php }else{?>
                    <li><a href="<?php echo ADDRESS ?>signin.html">สมาชิกเข้าสู่ระบบ</a></li>

                    <li><a href="<?php echo ADDRESS ?>register.html">สมัครสมาชิก</a></li>
                    
			  <?php }?>
                </ul>

                <!--<ul class="nav navbar-nav navbar-right">

                    <li>

                        <a href="../navbar/" class="navbar-flag">

                            <img src="http://www.luceluxuryskin.com/skin/frontend/base/default/images/flag_English.png" alt="English"></a>

                    </li>

                    <li>

                        <a href="../navbar-static-top/" class="navbar-flag"><img src="http://www.luceluxuryskin.com/skin/frontend/base/default/images/flag_Thai.png" alt="English"></a>

                    </li>

                </ul>-->

            </div>

        </div>

    </nav>