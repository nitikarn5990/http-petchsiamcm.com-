<?php  //google map

if ($_POST['submit_bt'] == 'บันทึกข้อมูล' || $_POST['submit_bt'] == 'บันทึกข้อมูล และแก้ไขต่อ'){

		


		$arrData = array();


		$arrData = $functions->replaceQuote($_POST);


		$contact_footer->SetValues($arrData);



		if($contact_footer->GetPrimary() == ''){


			$contact_footer->SetValue('created_at', DATE_TIME);


			$contact_footer->SetValue('updated_at', DATE_TIME);


		}else{


			$contact_footer->SetValue('updated_at', DATE_TIME);


		}


		if($contact_footer->Save()){		
		
			SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ','success');
		}else{
			SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
			
		}
}


	if ($_GET['id'] != '' && $_GET['action'] == 'edit'){


		// For Update


		$contact_footer->SetPrimary((int)$_GET['id']);


		// Try to get the information


		if (!$contact_footer->GetInfo()){


			SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


			$contact_footer->ResetValues();


		}


	}


if($_GET['controllers'] == "address" && $_GET['action'] == "edit"){?>

<div class="row-fluid">
<div class="span12">
<div class="da-panel collapsible">
<div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-<?php echo ($contact_footer->GetPrimary() != '') ? 'application-edit' : 'add'?>"></i> <?php echo ($contact_footer->GetPrimary() != '') ? '' : ''?> ADDRESS </span> </div>
<div class="da-panel-content da-form-container">
<form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL ?>address&action=edit&id=1" method="post" class="da-form">
<?php if($contact_footer->GetPrimary() != ''):?>
<input type="hidden" name="id" value="<?php echo $contact_footer->GetPrimary()?>" />
<input type="hidden" name="created_at" value="<?php echo $contact_footer->GetValue('created_at')?>" />
<?php endif;?>
<div class="da-form-inline">
    <div class="da-form-row">
        <label class="da-form-label">ADDRESS<span class="required">*</span></label>
        <div class="da-form-item large">
            <textarea name="txt_address" id="txt_address" class="span12 tinymce required"><?php echo ($contact_footer->GetPrimary() != '') ? $contact_footer->GetValue('txt_address') : ''; ?></textarea>
            <label for="txt_address" generated="true" class="error" style="display:none;"></label>
        </div>
    </div>
</div>
<div class="btn-row">
    <input type="submit" name="submit_bt" value="บันทึกข้อมูล และแก้ไขต่อ" class="btn btn-primary" />
</div>
</div>
</div>
</div>
<?php } ?>
