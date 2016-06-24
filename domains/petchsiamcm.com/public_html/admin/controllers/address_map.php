<?php  //google map

if ($_POST['submit_bt'] == 'บันทึกข้อมูล' || $_POST['submit_bt'] == 'บันทึกข้อมูล และแก้ไขต่อ'){

		$arrData = array();


		$arrData = $functions->replaceQuote($_POST);


		$google_map->SetValues($arrData);



		if($google_map->GetPrimary() == ''){


			$google_map->SetValue('created_at', DATE_TIME);


			$google_map->SetValue('updated_at', DATE_TIME);


		}else{


			$google_map->SetValue('updated_at', DATE_TIME);


		}

		$google_map->SetPrimary((int)$_GET['id']);
		if($google_map->Save()){		
		
			SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ','success');
		}else{
			SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
			
		}
}


	if ($_GET['id'] != '' && $_GET['action'] == 'edit'){


		// For Update


		$google_map->SetPrimary((int)$_GET['id']);


		// Try to get the information


		if (!$google_map->GetInfo()){


			SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


			$google_map->ResetValues();


		}


	}


if($_GET['controllers'] == "address_map" && $_GET['action'] == "edit"){?>

<div class="row-fluid">
<div class="span12">
<div class="da-panel collapsible">
<div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-<?php echo ($google_map->GetPrimary() != '') ? 'application-edit' : 'add'?>"></i> <?php echo ($google_map->GetPrimary() != '') ? '' : ''?> ADDRESS MAP</span> </div>
<div class="da-panel-content da-form-container">
<form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL ?>address_map&action=edit&id=1" method="post" class="da-form">

<div class="da-form-inline">
    <div class="da-form-row">
        <label class="da-form-label">ADDRESS MAP<span class="required">*</span></label>
        <div class="da-form-item large">
          <textarea name="google_iframe"><?php echo $google_map->getValue("google_iframe")?></textarea>
          
        </div>
    </div>
</div>
<div class="btn-row">
    <input type="submit" name="submit_bt" value="บันทึกข้อมูล และแก้ไขต่อ" class="btn btn-primary" />
</div>
</form>
</div>
</div>
</div>
<?php } ?>

<style>
<!--
textarea{
  width: 100%;

}
-->
</style>
