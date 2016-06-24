<?php

	// If they are saving the Information	

	if ($_POST['submit_bt'] == 'บันทึกข้อมูล' || $_POST['submit_bt'] == 'บันทึกข้อมูล และแก้ไขต่อ'){

		if($_POST['submit_bt'] == 'บันทึกข้อมูล'){

			$redirect = true;

		}else{

			$redirect = false;

		}

		$arrData = array();

		$arrData = $functions->replaceQuote($_POST);

				

		$hash_key = $functions->genCodeRandom(30);

		unset($arrData['password']);
		unset($arrData['trade_password']);

		if($arrData['fpassword'] != ""){

			$arrData['hash_key'] = $hash_key;

			$arrData['password'] = $functions->enCrypted($arrData['fpassword'], $hash_key);

		}else{

			$arrData['hash_key'] = $_POST['hash_key'];

			$arrData['password'] = $_POST['password'];

		}
		
		if($arrData['ftrade_password'] != ""){

			$arrData['hash_key'] = $hash_key;

			$arrData['trade_password'] = $functions->enCrypted($arrData['ftrade_password'], $hash_key);

		}else{

			$arrData['hash_key'] = $_POST['hash_key'];

			$arrData['trade_password'] = $_POST['trade_password'];

		}

		if($arrData['trade_active'] == "ยืนยันเรียบร้อย" && $arrData['trade_check'] != "ยืนยันเรียบร้อย"){
			$smscus = "ท่านผ่านการตรวจสอบ ข้อมูลเข้าระบบเล่นหุ่น Username: " . $arrData['trade_username'] . " Password: " . $arrData['ftrade_password'];
			$functions->sentSMS($smscus,$users->GetValue('tel'));
		}

		// Get all the Form Data

		$users->SetValues($arrData);

		if($users->GetPrimary() == ''){

			$users->SetValue('created_at', DATE_TIME);

			$users->SetValue('updated_at', DATE_TIME);

		}else{

			$users->SetValue('updated_at', DATE_TIME);

		}


		if($users->Save()){
			
			$lastUserId = $users->GetPrimary();

			$numWeb = count($arrData['webs_money_id']);

			for($a = 0; $a < $numWeb; $a++){

				$arrAcc = array(

					'id' => $arrData['user_webs_money_id'][$a],

					'user_id' => $lastUserId,

					'webs_money_id' => $arrData['webs_money_id'][$a],

					'webs_money_acc' => $arrData['webs_money_acc'][$a],

				);

				$user_webs_money->SetValues($arrAcc);

				$user_webs_money->SetValue('created_at', DATE_TIME);

				$user_webs_money->SetValue('updated_at', DATE_TIME);

				$user_webs_money->Save();

			} 	

			SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ','success');

			//Redirect if needed

			if ($redirect){

				header('location:' . ADDRESS_ADMIN_CONTROL . 'users');

				die();

			}else{

				header('location:' . ADDRESS_ADMIN_CONTROL . 'users&action=edit&id=' . $users->GetPrimary());

				die();

			}

		}else{

			SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');

		}		

	}

	

	// If Deleting the Page

	if ($_GET['id'] != '' && $_GET['action'] == 'del'){

		// Get all the form data

		$arrDel = array('id' => $_GET['id']);

		$users->SetValues($arrDel);

		

		// Remove the info from the DB

		if ($users->Delete()){

			// Set alert and redirect

			SetAlert('Delete Data Success','success');

			header('location:' . ADDRESS_ADMIN_CONTROL . 'users');

			die();

		}else{

			SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');

		}

	}

	

	if ($_GET['id'] != '' && $_GET['action'] == 'edit'){

		// For Update

		$users->SetPrimary((int)$_GET['id']);

		// Try to get the information

		if (!$users->GetInfo()){

			SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');

			$users->ResetValues();

		}

	}

	

?>



<?php if($_GET['action'] == "add" || $_GET['action'] == "edit"){?>

<div class="row-fluid">

    <div class="span12">

        <?php

			// Report errors to the user

			Alert(GetAlert('error'));

			Alert(GetAlert('success'),'success');

		?> 

        <div class="da-panel collapsible">

            <div class="da-panel-header">

                <span class="da-panel-title">

                    <i class="icol-<?php echo ($users->GetPrimary() != '') ? 'application-edit' : 'add'?>"></i> <?php echo ($users->GetPrimary() != '') ? 'แก้ไข' : 'เพิ่ม'?> สมาชิก

                </span>

            </div>

            <div class="da-panel-content da-form-container">

                <form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL?>users<?php echo ($users->GetPrimary() != '') ? '&id=' . $users->GetPrimary() : ''; ?>" method="post" class="da-form">

                	<?php if($users->GetPrimary() != ''):?>

                    	<input type="hidden" name="id" value="<?php echo $users->GetPrimary()?>" />

                        <input type="hidden" name="last_login" value="<?php echo $users->GetValue('last_login')?>" />

                  		<input type="hidden" name="created_at" value="<?php echo $users->GetValue('created_at')?>" />

                        <input type="hidden" name="hash_key" value="<?php echo $users->GetValue('hash_key')?>" />

                        <input type="hidden" name="password" value="<?php echo $users->GetValue('password')?>" />
                        
                        <input type="hidden" name="trade_password" value="<?php echo $users->GetValue('trade_password')?>" />
                        
                        <input type="hidden" name="trade_check" value="<?php echo $users->GetValue('trade_active')?>" />
                        
                        <input type="hidden" name="trade_regis" value="<?php echo $users->GetValue('trade_regis')?>" />

               		<?php endif;?>

                    <div class="da-form-inline">

                    	<fieldset class="da-form-inline">

                    	<legend>ข้อมูลสมาชิก</legend>

                        <div class="da-form-row">

                            <label class="da-form-label">ชื่อ-นามสกุล <span class="required">*</span></label>

                            <div class="da-form-item large">

                                <input type="text" name="name" id="name" value="<?php echo ($users->GetPrimary() != '') ? $users->GetValue('name') : ''; ?>" class="span12 required" />

                            </div>

                        </div>

                        <div class="da-form-row">

                            <label class="da-form-label">กลุ่มสมาชิก <span class="required">*</span></label>

                            <div class="da-form-item large">

                                <select id="user_groups_id" name="user_groups_id" class="span12 select2 required">

                                    <option value=""></option>

                                    <?php $user_groups->CreateDataList("id","user_groups","",($users->GetPrimary() != "") ? $users->GetValue('user_groups_id') : "")?> 

                                </select>

                            </div>

                        </div>

                        <div class="da-form-row">

                            <label class="da-form-label">รหัสบัตรประชาชน <span class="required">*</span></label>

                            <div class="da-form-item large">

                                <input type="text" name="idcard" id="idcard" value="<?php echo ($users->GetPrimary() != '') ? $users->GetValue('idcard') : ''; ?>" class="span12 required" />

                            </div>

                        </div>

                        <div class="da-form-row">

                            <label class="da-form-label">ที่อยู่บัจจุบัน <span class="required">*</span></label>

                            <div class="da-form-item large">

                                <textarea name="address" id="address" class="span12 required"><?php echo ($users->GetPrimary() != '') ? $users->GetValue('address') : ''; ?></textarea>

                            </div>

                        </div>

                        <div class="da-form-row">

                            <label class="da-form-label">จังหวัด <span class="required">*</span></label>

                            <div class="da-form-item large">

                                <select id="province_id" name="province_id" class="span12 select2 required">

                                    <option value=""></option>

                                    <?php $provinces->CreateDataList("id","name","",($users->GetPrimary() != "") ? $users->GetValue('province_id') : "")?> 

                                </select>

                            </div>

                        </div>

                        <div class="da-form-row">

                            <label class="da-form-label">รหัสไปรษณีย์ <span class="required">*</span></label>

                            <div class="da-form-item large">

                                <input type="text" name="postcode" id="postcode" value="<?php echo ($users->GetPrimary() != '') ? $users->GetValue('postcode') : ''; ?>" class="span12 required" />

                            </div>

                        </div>

                        <div class="da-form-row">

                            <label class="da-form-label">อีเมล์ติดต่อ <span class="required">*</span></label>

                            <div class="da-form-item large">

                                <input type="text" name="email" id="email" value="<?php echo ($users->GetPrimary() != '') ? $users->GetValue('email') : ''; ?>" class="span12 required" />

                            </div>

                        </div>

                        <div class="da-form-row">

                            <label class="da-form-label">เบอร์ติดต่อ <span class="required">*</span></label>

                            <div class="da-form-item large">

                                <input type="text" name="tel" id="tel" value="<?php echo ($users->GetPrimary() != '') ? $users->GetValue('tel') : ''; ?>" class="span12 required" />

                            </div>

                        </div>

                        <div class="da-form-row">

                            <label class="da-form-label">สถานะ <span class="required">*</span></label>

                            <div class="da-form-item large">

                                <ul class="da-form-list">

                                	<?php

										$getStatus = $users->get_enum_values('status');

										$i = 1;

										foreach ($getStatus as $status) {

									?>

                                    <li><input type="radio" name="status" id="status" value="<?php echo $status?>" <?php echo ($users->GetPrimary() != "") ? ($users->GetValue('status') == $status) ? "checked=\"checked\"" : "" : ($i == 1) ? "checked=\"checked\"" : ""?> class="required"/> <label><?php echo $status?></label></li>

                                    <?php $i++; }?>

                                </ul>

                            </div>

                        </div>

                        </fieldset>

                        <fieldset class="da-form-inline">

                        <legend>ข้อมูลเข้าใช้ระบบ</legend>

                        <div class="da-form-row">

                            <label class="da-form-label">ชื่อผู้ใช้ <span class="required">*</span></label>

                            <div class="da-form-item large">

                                <input type="text" name="username" id="username" value="<?php echo ($users->GetPrimary() != '') ? $users->GetValue('username') : ''; ?>" class="span12 required" />

                            </div>

                        </div>

                        <div class="da-form-row">

                            <label class="da-form-label">รหัสผ่าน <span class="required">*</span></label>

                            <div class="da-form-item large">

                                <input type="text" name="fpassword" id="fpassword" value="<?php echo ($users->GetPrimary() != '') ? $functions->deCrypted($users->GetValue('password'),$users->GetValue('hash_key')) : ''; ?>" class="span12 required" />

                            </div>

                        </div>

                        <div class="da-form-row">

                            <label class="da-form-label">ยืนยันรหัสผ่าน <span class="required">*</span></label>

                            <div class="da-form-item large">

                                <input type="text" name="cpassword" id="cpassword" value="<?php echo ($users->GetPrimary() != '') ? $functions->deCrypted($users->GetValue('password'),$users->GetValue('hash_key')) : ''; ?>" class="span12 required" />

                            </div>

                        </div>

                        </fieldset>

                        <fieldset class="da-form-inline">

                        <legend>ข้อมูลบัญชีออนไลน์</legend>

                        <?php

							$arrType = array("รูปแบบดิจิตอล","รูปแบบทั่วไป");

							foreach($arrType as $value){

                        	$sweb = "SELECT * FROM " . $webs_money->getTbl() . " WHERE type = '" . $value . "' AND status = 'ใช้งาน' ORDER BY sort ASC";

							$qweb = $db->Query($sweb);

							$num = $db->NumRows($qweb);

							if($num > 0){

						?>

                        <?php

							while($rweb = $db->FetchArray($qweb)){

						?> 

                        <?php if($users->GetPrimary() != ''):?>

                    		<input type="hidden" id="user_webs_money_id_<?php echo $rweb['id']?>" name="user_webs_money_id[]" value="<?php echo $user_webs_money->getDataDesc("id","user_id = '" . $users->GetPrimary() . "' AND webs_money_id = '" . $rweb['id'] . "'")?>" />

                       	<?php endif;?>

                  		<input type="hidden" name="webs_money_id[]" value="<?php echo $rweb['id']?>">

                        <div class="da-form-row">

                            <label class="da-form-label" style="padding:0px !important"><img src="<?php echo DIR_ADMIN_IMAGES . $rweb['webs_money_image']?>" style="height:30px"/></label>

                            <div class="da-form-item large">                            	

                                <input type="text" id="webs_money_acc_<?php echo $rweb['id']?>" name="webs_money_acc[]" value="<?php echo ($users->GetPrimary() != '') ? $user_webs_money->getDataDesc("webs_money_acc","user_id = '" . $users->GetPrimary() . "' AND webs_money_id = '" . $rweb['id'] . "'") : ''; ?>" class="span12" />

                            </div>

                        </div>

                        <?php } } }?>

                        </fieldset>
                        
                        <fieldset class="da-form-inline">

                        <legend>สมัครเล่นหุ่น BTC Online</legend>

                        <div class="da-form-row">

                            <label class="da-form-label">สถานะการสมัคร <span class="required">*</span></label>

                            <div class="da-form-item large">

                                <ul class="da-form-list">

                                	<?php

										$getActive = $users->get_enum_values('trade_active');

										$i = 1;

										foreach ($getActive as $active) {

									?>

                                    <li><input type="radio" name="trade_active" id="trade_active" value="<?php echo $active?>" <?php echo ($users->GetPrimary() != "") ? ($users->GetValue('trade_active') == $active) ? "checked=\"checked\"" : "" : ($i == 1) ? "checked=\"checked\"" : ""?> class="required"/> <label><?php echo $active?></label></li>

                                    <?php $i++; }?>

                                </ul>

                            </div>

                        </div>
                        
                        <div class="da-form-row">

                            <label class="da-form-label">ชื่อผู้ใช้ Trade</label>

                            <div class="da-form-item large">

                                <input type="text" name="trade_username" id="trade_username" value="<?php echo ($users->GetPrimary() != '') ? $users->GetValue('trade_username') : ''; ?>" class="span12" />

                            </div>

                        </div>

                        <div class="da-form-row">

                            <label class="da-form-label">รหัสผ่าน Trade</label>

                            <div class="da-form-item large">

                                <input type="text" name="ftrade_password" id="ftrade_password" value="<?php echo ($users->GetPrimary() != '' && $users->GetValue('trade_password') != '') ? $functions->deCrypted($users->GetValue('trade_password'),$users->GetValue('hash_key')) : ''; ?>" class="span12" />

                            </div>

                        </div>
                        
                        </fieldset>

                    </div>

                    <div class="btn-row">

                        <input type="submit" name="submit_bt" value="บันทึกข้อมูล" class="btn btn-success" />

                        <input type="submit" name="submit_bt" value="บันทึกข้อมูล และแก้ไขต่อ" class="btn btn-primary" />

                        <a href="<?php echo ADDRESS_ADMIN_CONTROL?>users" class="btn btn-danger">ยกเลิก</a>

                    </div>

                </form>

            </div>

        </div>

  	</div>

</div>

<?php }else{?> 

<div class="row-fluid">

    <div class="span12">         

        <div class="da-panel collapsible">

            <div class="da-panel-header">

                <span class="da-panel-title">

                    <i class="icol-grid"></i> สมาชิก ทั้งหมด

                </span>

            </div>

            <div class="da-panel-toolbar">

                <div class="btn-toolbar">

                    <div class="btn-group">

                        <a class="btn" href="<?php echo ADDRESS_ADMIN_CONTROL?>users&action=add"><i class="icol-add"></i> เพิ่มข้อมูล</a>

                    </div>

                </div>

            </div> 

            <div class="da-panel-content da-table-container">

                <table id="da-ex-datatable-sort" class="da-table" sort="0" order="desc">

                    <thead>

                        <tr>

                            <th>รหัส</th>

                            <th>ชื่อผู้ใช้งาน</th>

                            <th>ชื่อ-นามสกุล</th>
                            
                            <th>เบอร์โทร</th>

                            <th>กลุ่มสมาชิก</th>    

                            <th>สมัครเล่นหุ่น</th>

                            <th>สถานะ</th>                      

                            <th>แก้ไขล่าสุด</th>

                            <th>ตัวเลือก</th>

                        </tr>

                    </thead>

                    <tbody>

                    	<?php

							$sql = "SELECT * FROM " . $users->getTbl();

							$query = $db->Query($sql);

							while ($row = $db->FetchArray($query)){

						?>

                        <tr>

                            <td class="center"><?php echo $row['id'];?></td>

                            <td><?php echo $row['username'];?></td>

                            <td><?php echo $row['name'];?></td>
                            
                            <td><?php echo $row['tel'];?></td>

                            <td><?php echo $user_groups->getDataDesc("user_groups","id = '" . $row['user_groups_id'] . "'")?></td>

                            <td class="center">
                            	<font color="<?php echo ($row['trade_regis'] == 'สมัครเล่นหุ่น') ? "#009900" : "#FF0000"?>"><strong><?php echo $row['trade_regis'];?></strong></font>
                           		<i class="icol-<?php echo ($row['trade_regis'] == 'สมัครเล่นหุ่น') ? ($row['trade_active'] == 'ยืนยันเรียบร้อย') ? 'accept' : 'cross' : ""?>" title="<?php echo $row['trade_active']?>"></i>
                            </td>

                            <td class="center"><i class="icol-<?php echo ($row['status'] == 'ใช้งาน') ? 'accept' : 'cross'?>" title="<?php echo $row['status']?>"></i></td>

                            <td class="center"><?php echo $functions->ShowDateThTime($row['updated_at'])?></td>

                            <td class="center">

								<a href="<?php echo ADDRESS_ADMIN_CONTROL?>users&action=edit&id=<?php echo $row['id']?>" class="btn btn-primary btn-small">แก้ไข / ดู</a>

                                <a href="#" onclick="if(confirm('คุณต้องการลบข้อมูลนี้หรือใม่?')==true){document.location.href='<?php echo ADDRESS_ADMIN_CONTROL?>users&action=del&id=<?php echo $row['id']?>'}" class="btn btn-danger btn-small">ลบ</a>

							</td>

                        </tr>  

                        <?php }?>                      

                    </tbody>

                </table>

            </div>

        </div>        

    </div>                           	

</div>

<?php }?>