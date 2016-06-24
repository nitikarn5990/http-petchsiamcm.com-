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


		

		if($arrData['ref'] != ""){

			$arrData['category_name_ref'] = $functions->seoTitle($arrData['ref']);

		}else{

			$arrData['category_name_ref'] = $functions->seoTitle($arrData['category_name']);

		}

		// Get all the Form Data

		$category->SetValues($arrData);

		if($category->GetPrimary() == ''){

			$category->SetValue('created_at', DATE_TIME);

			$category->SetValue('updated_at', DATE_TIME);

		}else{

			$category->SetValue('updated_at', DATE_TIME);

		}

 

		//$category->Save();

		if($category->Save()){			

			SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ','success');

			//Redirect if needed

			if ($redirect){

				header('location:' . ADDRESS_ADMIN_CONTROL . 'category');

				die();

			}else{

				header('location:' . ADDRESS_ADMIN_CONTROL . 'category&action=edit&id=' . $category->GetPrimary());

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

		$category->SetValues($arrDel);
		

		

		// Remove the info from the DB

		if ($category->Delete()){

			// Set alert and redirect

			SetAlert('Delete Data Success','success');

			header('location:' . ADDRESS_ADMIN_CONTROL . 'category');

			die();

		}else{

			SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');

		}

	}

	

	if ($_GET['id'] != '' && $_GET['action'] == 'edit'){

		// For Update

		$category->SetPrimary((int)$_GET['id']);
		

		// Try to get the information

		if (!$category->GetInfo()){

			SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');

			$category->ResetValues();

		}

	}

	

?>
<?php if($_GET['action'] == "add" || $_GET['action'] == "edit"){?>

<div class="row-fluid">
    <div class="span12">
        <div class="da-panel collapsible">
            <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-<?php echo ($category->GetPrimary() != '') ? 'application-edit' : 'add'?>"></i> <?php echo ($category->GetPrimary() != '') ? 'แก้ไข' : 'เพิ่ม'?> หมวดหมู่สินค้า </span> </div>
            <div class="da-panel-content da-form-container">
                <form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL?>category<?php echo ($category->GetPrimary() != '') ? '&id=' . $category->GetPrimary() : ''; ?>" method="post" class="da-form">
                    <?php if($category->GetPrimary() != ''):?>
                    <input type="hidden" name="id" value="<?php echo $category->GetPrimary()?>" />
                    <input type="hidden" name="created_at" value="<?php echo $category->GetValue('created_at')?>" />
                    <?php endif;?>
                    <div class="da-form-inline">
                        <div class="da-form-row">
                            <label class="da-form-label">ชื่อหมวดหมู่ <span class="required">*</span></label>
                            <div class="da-form-item large">
                                <input type="text" name="category_name" id="category" value="<?php echo ($category->GetPrimary() != '') ? $category->GetValue('category_name') : ''; ?>" class="span12 required" />
                            </div>
                        </div>
                         <div class="da-form-row">
                            <label class="da-form-label">ชื่อใช้อ้างอิง / URL</label>
                            <div class="da-form-item large">
                                <input type="text" name="ref" id="ref" value="<?php echo ($category->GetPrimary() != '') ? $category->GetValue('category_name_ref') : ''; ?>" class="span12" />
                                <label class="help-block">ว่างไว้ถ้าต้องการให้สร้างชื่ออ้างอิงอัตโนมัติ</label>
                            </div>
                        </div>
                        <div class="da-form-row">
                            <label class="da-form-label">หัวข้อ <span class="required">*</span></label>
                            <div class="da-form-item large">
                                <input type="text" name="category_title" id="category_title" value="<?php echo ($category->GetPrimary() != '') ? $category->GetValue('category_title') : ''; ?>" class="span12 required" />
                            </div>
                        </div>
                        <div class="da-form-row">
                            <label class="da-form-label">รายละเอียด<span class="required">*</span></label>
                            <div class="da-form-item large">
                                <textarea name="category_detail" id="category_detail" class="span12 tinymce required"><?php echo ($category->GetPrimary() != '') ? $category->GetValue('category_detail') : ''; ?></textarea>
                                <label for="category_detail" generated="true" class="error" style="display:none;"></label>
                            </div>
                        </div>
                        <div class="da-form-row">
                            <label class="da-form-label">Meta Title</label>
                            <div class="da-form-item large">
                                <textarea name="meta_title" id="meta_title" class="span12"><?php echo ($category->GetPrimary() != '') ? $category->GetValue('meta_title') : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="da-form-row">
                            <label class="da-form-label">Meta Keywords</label>
                            <div class="da-form-item large">
                                <textarea name="meta_keywords" id="meta_keywords" class="span12"><?php echo ($category->GetPrimary() != '') ? $category->GetValue('meta_keywords') : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="da-form-row">
                            <label class="da-form-label">Meta Descriptions</label>
                            <div class="da-form-item large">
                                <textarea name="meta_descriptions" id="meta_descriptions" class="span12"><?php echo ($category->GetPrimary() != '') ? $category->GetValue('meta_descriptions') : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="da-form-row">
                            <label class="da-form-label">สถานะ <span class="required">*</span></label>
                            <div class="da-form-item large">
                                <ul class="da-form-list">
                                    <?php

										$getStatus = $category->get_enum_values('status');

										$i = 1;

										foreach ($getStatus as $status) {

									?>
                                    <li>
                                        <input type="radio" name="status" id="status" value="<?php echo $status?>" <?php echo ($category->GetPrimary() != "") ? ($category->GetValue('status') == $status) ? "checked=\"checked\"" : "" : ($i == 1) ? "checked=\"checked\"" : ""?> class="required"/>
                                        <label><?php echo $status?></label>
                                    </li>
                                    <?php $i++; }?>
                                </ul>
                                <label for="status" class="error" generated="true" style="display:none;"></label>
                            </div>
                        </div>
                    </div>
                    <div class="btn-row">
                        <input type="submit" name="submit_bt" value="บันทึกข้อมูล" class="btn btn-success" />
                        <input type="submit" name="submit_bt" value="บันทึกข้อมูล และแก้ไขต่อ" class="btn btn-primary" />
                        <a href="<?php echo ADDRESS_ADMIN_CONTROL?>category" class="btn btn-danger">ยกเลิก</a> </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php }else{?>
<div class="row-fluid">
    <div class="span12">
        <?php

			// Report errors to the user

			Alert(GetAlert('error'));

			Alert(GetAlert('success'),'success');

		?>
        <div class="da-panel collapsible">
            <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-grid"></i> หมวดหมู่สินค้า ทั้งหมด </span> </div>
            <div class="da-panel-toolbar">
                <div class="btn-toolbar">
                    <div class="btn-group"> <a class="btn" href="<?php echo ADDRESS_ADMIN_CONTROL?>category&action=add"><i class="icol-add"></i> เพิ่มข้อมูล</a> </div>
                </div>
            </div>
            <div class="da-panel-content da-table-container">
                <table id="da-ex-datatable-numberpaging" class="da-table">
                    <thead>
                        <tr>
                            <th>รหัส</th>
                            <th>หมวดหมู่</th>
                            <th>สถานะ</th>
                            <th>แก้ไขล่าสุด</th>
                            <th>ตัวเลือก</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

							$sql = "SELECT * FROM " . $category->getTbl();

							$query = $db->Query($sql);

							while ($row = $db->FetchArray($query)){

						?>
                        <tr>
                            <td class="center"><?php echo $row['id'];?></td>
                            <td><?php echo $row['category_name'];?></td>
                            <td class="center"><i class="icol-<?php echo ($row['status'] == 'ใช้งาน') ? 'accept' : 'cross'?>" title="<?php echo $row['status']?>"></i></td>
                            <td class="center"><?php echo $functions->ShowDateThTime($row['updated_at'])?></td>
                            <td class="center"><a href="<?php echo ADDRESS_ADMIN_CONTROL?>category&action=edit&id=<?php echo $row['id']?>" class="btn btn-primary btn-small">แก้ไข / ดู</a> <a href="#" onclick="if(confirm('คุณต้องการลบข้อมูลนี้หรือใม่?')==true){document.location.href='<?php echo ADDRESS_ADMIN_CONTROL?>category&action=del&id=<?php echo $row['id']?>'}" class="btn btn-danger btn-small">ลบ</a></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php }?>
