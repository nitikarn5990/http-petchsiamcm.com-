<?php
// If they are saving the Information	

if ($_POST['submit_bt'] == 'บันทึกข้อมูล' || $_POST['submit_bt'] == 'บันทึกข้อมูล และแก้ไขต่อ') {
    if ($_POST['submit_bt'] == 'บันทึกข้อมูล') {
        $redirect = true;
    } else {
        $redirect = false;
    }
	
    if ($_GET['id'] != '' && $_GET['action'] == 'edit') {
        $board->SetPrimary((int) $_GET['id']);
	/*	
        if ($board->GetPrimary() == '') {
            $board->SetValue('created_at', DATE_TIME);
            $board->SetValue('updated_at', DATE_TIME);
        } else {
            $board->SetValue('updated_at', DATE_TIME);
        }*/


        $arrOrder = array(
            'name' => $_POST['name'],
            'position' => $_POST['position'],
            'role' => $_POST['role'],
            'sort' => $_POST['sort'],
            'status' => $_POST['status'],
            'updated_at' => DATE_TIME
        );
        $arrOrderID = array('id' => $board->GetPrimary());

        $board->updateSQL($arrOrder, $arrOrderID);


        if ($_FILES["file_array"]["name"] != "") {
            //unset($arrData['webs_money_image']);

            $targetPath = DIR_ROOT_PERSONNEL . "/";

            $newImage = DATE_TIME_FILE . "_" . $_FILES['file_array']['name'];

            $cdir = getcwd(); // Save the current directory

            chdir($targetPath);

            copy($_FILES['file_array']['tmp_name'], $targetPath . $newImage);

            chdir($cdir); // Restore the old working directory   
            //echo $newImage;
            //exit();
            //$board->SetValue('img_name', $newImage);
        }


        if ($_FILES["file_array"]["name"] != "") {

            $arrOrder = array(
                'img_name' => $newImage,
                    //'updated_at' => DATE_TIME
            );
            $arrOrderID = array('id' => $board->GetPrimary());

            $board->updateSQL($arrOrder, $arrOrderID);
        } else {

            if ($board->GetValue('img_name') != '') {

                $arrOrder = array(
                    'img_name' => $board->GetValue('img_name'),
                        //'updated_at' => DATE_TIME
                );
                $arrOrderID = array('id' => $board->GetPrimary());

                $board->updateSQL($arrOrder, $arrOrderID);
            }
        }
    }
	 if ($_GET['action'] == 'add') {
		 
		 $arrData = array();
		$arrData = $functions->replaceQuote($_POST);
		$board->SetValues($arrData);
		//$board->SetValue('img_name', $newImage);	
	//$gallery->Save();
		$board->SetValue('created_at', DATE_TIME);
		//$board->Save();
		if($board->Save()){			
			SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ','success');
			echo $board->GetPrimary();
		}else{
			SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
			
		}
			if ($_FILES["file_array"]["name"] != "") {
            //unset($arrData['webs_money_image']);

            $targetPath = DIR_ROOT_PERSONNEL . "/";

            $newImage = DATE_TIME_FILE . "_" . $_FILES['file_array']['name'];

            $cdir = getcwd(); // Save the current directory

            chdir($targetPath);

            copy($_FILES['file_array']['tmp_name'], $targetPath . $newImage);

            chdir($cdir); // Restore the old working directory   
            //echo $newImage;
            //exit();
            //$board->SetValue('img_name', $newImage);
			

            $arrOrder = array(
                'img_name' => $newImage,
                    //'updated_at' => DATE_TIME
            );
            $arrOrderID = array('id' => $board->GetPrimary());

            $board->updateSQL($arrOrder, $arrOrderID);
        
        }
		

	 }



    if ($redirect) {
        header('location:' . ADDRESS_ADMIN_CONTROL . 'คณะกรรมการ');
        die();
    } else {
        header('location:' . ADDRESS_ADMIN_CONTROL . 'คณะกรรมการ&action=edit&id=' . $board->GetPrimary());
        die();
    }
}

	// If Deleting the Page
	if ($_GET['id'] != '' && $_GET['action'] == 'del'){
		// Get all the form data
		$arrDel = array('id' => $_GET['id']);
		$board->SetValues($arrDel);
		
		// Remove the info from the DB
		if ($board->Delete()){
			// Set alert and redirect
			SetAlert('Delete Data Success','success');
			header('location:' . ADDRESS_ADMIN_CONTROL . 'คณะกรรมการ');
			die();
		}else{
			SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
		}
	}
if ($_GET['id'] != '' && $_GET['action'] == 'edit') {
    // For Update
    $board->SetPrimary((int) $_GET['id']);
    // Try to get the information
    if (!$board->GetInfo()) {
        SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
        $board->ResetValues();
    }
 }
?>
<?php if ($_GET['action'] == "add" || $_GET['action'] == "edit") { ?>

<div class="row-fluid">
	<div class="span12">
		<?php
            // Report errors to the user
            Alert(GetAlert('error'));
            Alert(GetAlert('success'), 'success');
            ?>
		<div class="da-panel collapsible">
			<div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-<?php echo ($board->GetPrimary() != '') ? 'application-edit' : 'add' ?>"></i> <?php echo ($board->GetPrimary() != '') ? 'แก้ไข' : 'เพิ่ม' ?> รูปภาพ </span> </div>
			<div class="da-panel-content da-form-container">
				<form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL ?>คณะกรรมการ<?php echo ($board->GetPrimary() != '') ? '&action=edit&id=' . $board->GetPrimary() : '&action=add'; ?>" method="post" class="da-form">
					<?php if ($board->GetPrimary() != ''): ?>
					<input type="hidden" name="id" value="<?php echo $board->GetPrimary() ?>" />
					<input type="hidden" name="created_at" value="<?php echo $board->GetValue('created_at') ?>" />
					<?php endif; ?>
					<div class="da-form-inline">
					<div class="da-form-row">
						<label class="da-form-label">ชื่อ <span class="required">*</span></label>
						<div class="da-form-item large">
							<input type="text" name="name" id="name" value="<?php echo ($board->GetPrimary() != '') ? $board->GetValue('name') : ''; ?>" class="span12 required" />
						</div>
					</div>
					<div class="da-form-row">
						<label class="da-form-label">ตำแหน่ง<span class="required">*</span></label>
						<div class="da-form-item large">
							<input type="text" name="position" id="position" value="<?php echo ($board->GetPrimary() != '') ? $board->GetValue('position') : ''; ?>" class="span12" />
						</div>
					</div>
					<div class="da-form-row">
						<label class="da-form-label">หน้าที่หลัก <span class="required">*</span></label>
						<div class="da-form-item large">
							<input type="text" name="role" id="role" value="<?php echo ($board->GetPrimary() != '') ? $board->GetValue('role') : ''; ?>" class="span12" />
						</div>
					</div>
					<div class="da-form-row">
					<label class="da-form-label">ไฟล์ที่อัพโหลด</label>
					<div class="da-form-item large">
					<ul style=" list-style-type: none;" class="da-form-list">
					<?php
                                        $sql = "SELECT * FROM " . $board->getTbl() . " WHERE id = '" . $board->GetPrimary() . "'";
                                        $query = $db->Query($sql);
                                        if ($db->NumRows($query) > 0) {

                                            while ($row = $db->FetchArray($query)) {
                                                ?>
					<img src="<?php echo ADDRESS_PERSONNEL . $board->GetValue('img_name') ?>" />
					<?php } ?>
					<?php } ?>
					</div>
					</div>
					<div class="da-form-row">
						<label class="da-form-label">อัพโหลดไฟล์</label>
						<div class="da-form-item large" id="filecopy">
							<input type="file" name="file_array" id="image"  class="span4"/>
						</div>
					</div>
					<div class="da-form-row">
						<label class="da-form-label">จัดลำดับ <span class="required">*</span></label>
						<div class="da-form-item large">
							<input type="text" name="sort" id="sort" value="<?php echo ($board->GetPrimary() != '') ? $board->GetValue('sort') : ''; ?>" class="span12" />
						</div>
					</div>
					<div class="da-form-row">
						<label class="da-form-label">สถานะ <span class="required">*</span></label>
						<div class="da-form-item large">
							<ul class="da-form-list">
								<?php
                                        $getStatus = $board->get_enum_values('status');
                                        $i = 1;
                                        foreach ($getStatus as $status) {
                                            ?>
								<li>
									<input type="radio" name="status" id="status" value="<?php echo $status ?>" <?php echo ($board->GetPrimary() != "") ? ($board->GetValue('status') == $status) ? "checked=\"checked\"" : "" : ($i == 1) ? "checked=\"checked\"" : "" ?> class="required"/>
									<label><?php echo $status ?></label>
								</li>
								<?php
                                            $i++;
                                        }
                                        ?>
							</ul>
						</div>
					</div>
					</div>
					<div class="btn-row">
						<input type="submit" name="submit_bt" value="บันทึกข้อมูล" class="btn btn-success" />
						<input type="submit" name="submit_bt" value="บันทึกข้อมูล และแก้ไขต่อ" class="btn btn-primary" />
						<a href="<?php echo ADDRESS_ADMIN_CONTROL ?>คณะกรรมการ" class="btn btn-danger">ยกเลิก</a> </div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php } else { ?>
<div class="row-fluid">
	<div class="span12">
		<?php
            // Report errors to the user
            Alert(GetAlert('error'));
            Alert(GetAlert('success'), 'success');
            ?>
		<div class="da-panel collapsible">
			<div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-grid"></i> รูปภาพ ทั้งหมด </span> </div>
			<div class="da-panel-toolbar">
				<div class="btn-toolbar">
					<div class="btn-group"> <a class="btn" href="<?php echo ADDRESS_ADMIN_CONTROL ?>คณะกรรมการ&action=add"><i class="icol-add"></i> เพิ่มข้อมูล</a> </div>
				</div>
			</div>
			<div class="da-panel-content da-table-container">
				<table id="da-ex-datatable-sort" class="da-table" sort="0" order="asc" width="2000">
					<thead>
						<tr>
							<th>รหัส</th>
							<th>ชื่อ</th>
							<th>ตำแหน่ง</th>
							<th>หน้าที่หลัก</th>
							<th>ภาพ</th>
							<th>สถานะ</th>
							<th>แก้ไขล่าสุด</th>
							<th>ลำดับ</th>
							<th>ตัวเลือก</th>
						</tr>
					</thead>
					<tbody>
						<?php
                            $sql = "SELECT * FROM " . $board->getTbl() ." ORDER BY sort ASC";
                            $query = $db->Query($sql);
                            while ($row = $db->FetchArray($query)) {
                                ?>
						<tr>
							<td class="center"><?php echo $row['sort']; ?></td>
							<td><?php echo $row['name']; ?></td>
							<td><?php echo $row['position']; ?></td>
							<td><?php echo $row['role']; ?></td>
							<?php 
							if($row['img_name'] != ''){ ?>
								<td class="center"><img src="<?php echo ADDRESS_PERSONNEL . $row['img_name']; ?>" style="height:100px; width:100px;"></td>
							
							<?php }else{ ?>
									
									<td class="center"><img src="http://themes.doitmax.de/wordpress/invictus/wp-content/themes/invictus_3.3.1/images/dummy-image.jpg" style="height:70px; width:150px;"></td>
							<?php }	?>
							
							<td class="center"><i class="icol-<?php echo ($row['status'] == 'ใช้งาน') ? 'accept' : 'cross' ?>" title="<?php echo $row['status'] ?>"></i></td>
							<td class="center"><?php echo $functions->ShowDateThTime($row['updated_at']) ?></td>
							<td class="center"><?php echo $row['sort']; ?></td>
							<td class="center"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>คณะกรรมการ&action=edit&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-small">แก้ไข / ดู</a> <a href="#" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>คณะกรรมการ&action=del&id=<?php echo $row['id'] ?>'
                                                        }" class="btn btn-danger btn-small">ลบ</a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<script type="text/javascript">
//$( document ).ready(function() {
    function addfile() {
        $("#filecopy:first").clone().insertAfter("div #filecopy:last");
    }
    function delfile() {
        //$("#filecopy").clone().insertAfter("div #filecopy:last");
        var conveniancecount = $("div #filecopy").length;
        if (conveniancecount > 2) {
            $("div #filecopy:last").remove();
        }




    }

//});

</script> 
<script>
    $(function() {
        // $( "#datepicker" ).datepicker();
        $("#activity_date").datepicker({dateFormat: "yy-mm-dd"}).val()
    });
</script>
<style>
    /*Colored Label Attributes*/
    .label {
        background-color: #BFBFBF;
        border-bottom-left-radius: 3px;
        border-bottom-right-radius: 3px;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        color: #FFFFFF;
        font-size: 9.75px;
        font-weight: bold;
        padding-bottom: 2px;
        padding-left: 4px;
        padding-right: 4px;
        padding-top: 2px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .label:hover {
        opacity: 80;
    }

    .label.success {
        background-color: #46A546;
    }
    .label.success2 {
        background-color: #CCC;
    }
    .label.success3 {
        background-color: #61a4e4;

    }

    .label.warning {
        background-color: #FC9207;
    }

    .label.failure {
        background-color: #D32B26;
    }

    .label.alert {
        background-color: #33BFF7;
    }

    .label.good-job {
        background-color: #9C41C6;
    }


</style>
