<?php
	
	
	//die();
	
	if ($_GET['id'] != '' && $_GET['action'] == 'edit'){


		$contact_message->SetPrimary((int)$_GET['id']);
		//$contact_message->SetValue('updated_at', DATE_TIME);
		

		if (!$contact_message->GetInfo()){


			SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


			$contact_message->ResetValues();


		}
		$arrOrder = array(
				'status' => 'อ่านแล้ว',
				
				'updated_at' => DATE_TIME
		);
		$arrOrderID = array('id' => $contact_message->GetPrimary());
				
		$contact_message->updateSQL($arrOrder, $arrOrderID);

	}
	
	
	if ($_GET['id'] != '' && $_GET['action'] == 'del'){

		if ($contact_message->DeleteMultiID($_GET['id'])){

			SetAlert('Delete Data Success','success');


			header('location:' . ADDRESS_ADMIN_CONTROL . 'contact_message'); 

			die();


		}else{
			SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');

		}
	}

?>
<?php if($_GET['action'] == "add" || $_GET['action'] == "edit"){

	?>

<div class="row-fluid">
    <div class="span12">
        <?php


			// Report errors to the user


			Alert(GetAlert('error'));


			Alert(GetAlert('success'),'success');


		?>
        <div class="da-panel collapsible">
            <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-<?php echo ($contact_message->GetPrimary() != '') ? 'application-edit' : 'add'?>"></i> <?php echo ($contact_message->GetPrimary() != '') ? '' : ''?> Message </span> </div>
            <div class="da-panel-content da-form-container">
                <form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL?>contact_message<?php echo ($contact_message->GetPrimary() != '') ? '&id=' . $contact_message->GetPrimary() : ''; ?>" method="post" class="da-form">
                    <?php if($contact_message->GetPrimary() != ''):?>
                    <input type="hidden" name="id" value="<?php echo $contact_message->GetPrimary()?>" />
                    <input type="hidden" name="created_at" value="<?php echo $contact_message->GetValue('created_at')?>" />
                    <?php endif;?>
                    <div class="da-form-inline">
                    <div class="da-form-row">
                        <label class="da-form-label">ชื่อ <span class="required">*</span></label>
                        <div class="da-form-item large">
                            <input type="text" name="txt_name" id="txt_name" value="<?php echo ($contact_message->GetPrimary() != '') ? $contact_message->GetValue('txt_name') : ''; ?>" class="span12 required" />
                        </div>
                    </div>
                    <div class="da-form-row">
                        <label class="da-form-label">Subject <span class="required">*</span></label>
                        <div class="da-form-item large">
                            <input type="text" name="txt_subject" id="txt_subject" value="<?php echo ($contact_message->GetPrimary() != '') ? $contact_message->GetValue('txt_subject') : ''; ?>" class="span12 required" />
                        </div>
                    </div>
                    <div class="da-form-row">
                        <label class="da-form-label">Message</label>
                        <div class="da-form-item large">
                            <textarea name="txt_message" id="txt_message" class="span12"><?php echo ($contact_message->GetPrimary() != '') ? $contact_message->GetValue('txt_message') : ''; ?></textarea>
                        </div>
                    </div>
                    <div class="da-form-row">
                        <label class="da-form-label">Email <span class="required">*</span></label>
                        <div class="da-form-item large">
                            <input type="text" name="txt_email" id="txt_email" value="<?php echo ($contact_message->GetPrimary() != '') ? $contact_message->GetValue('txt_email') : ''; ?>" class="span12 required" />
                        </div>
                    </div>
                    <div class="da-form-row">
                        <label class="da-form-label">Tel <span class="required">*</span></label>
                        <div class="da-form-item large">
                            <input type="text" name="txt_tel" id="txt_tel" value="<?php echo ($contact_message->GetPrimary() != '') ? $contact_message->GetValue('txt_tel') : ''; ?>" class="span12 required" />
                        </div>
                    </div>
                    <div class="btn-row"> <a href="<?php echo ADDRESS_ADMIN_CONTROL?>contact_message" class="btn btn-primary">Back</a> </div>
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
            <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-grid"></i> All Message </span> </div>
            <div class="da-panel-toolbar">
                <div class="btn-toolbar">
                    <div class="btn-group"> 
                  		<a class="btn" onClick="multi_delete()"><img src="http://icons.iconarchive.com/icons/awicons/vista-artistic/24/delete-icon.png" height="16" width="16"> Delete</a> 
                    </div>
                </div>
            </div>
            <div class="da-panel-content da-table-container">
                <table id="da-ex-datatable-sort" class="da-table" sort="1" order="desc" width="2000">
                    <thead>
                        <tr>
                        	<th><input type="checkbox" id="checkAll"></th>
                            <th>รหัส</th>
                            <th>สถานะ</th>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Email</th>
                            <th>Tel</th>
                            <th>วันเวลาที่ส่ง</th>
                            <th>ตัวเลือก</th>
                        </tr>
                    </thead>
                    <tbody>
                    <script>
					
					$("#checkAll").click(function(e) {
                         $('input:checkbox').prop('checked', this.checked);  
                    });
					
					function multi_delete(){
					
						 var msg_id = "";
						 var res = "";
						 
						 $('input:checkbox[id^="chkboxID"]:checked').each(function(){
					  
						   
							 msg_id += ','+$(this).val(); 
							 res = msg_id.substring(1);
							
						  
						  }); 
						  if(res != ''){
							  if(confirm('คุณต้องการลบข้อมูลนี้หรือใม่?')== true){
									document.location.href='<?php echo ADDRESS_ADMIN_CONTROL?>contact_message&action=del&id='+res;
							  }
						  }
					 
					}
					
					</script>
                        <?php


							$sql = "SELECT * FROM " . $contact_message->getTbl() . " ORDER BY id DESC";


							$query = $db->Query($sql);


							while ($row = $db->FetchArray($query)){

						?>
                        <tr onmouseover="this.className='yellowThing';"
    onmouseout="this.className='whiteThing';">
    						<td class="center" width="5%"><input type="checkbox" value="<?php echo $row['id'];?>" id="chkboxID"></td>
                            <td class="center" width="5%" class="sorting_desc"><?php echo $row['id'];?></td>
                            <td width="5%" class="center"><?php echo $row['status'] == 'ยังไม่ได้อ่าน' ? '<img src="../images/email-new.png" width="35" height="35">' : '<img src="../images/email-old.png" width="35" height="35">';?></td>
                            <td><?php echo $row['txt_name'];?></td>
                            <td><?php echo $row['txt_subject'];?></td>
                            <td width="18%"><?php echo $row['txt_email'];?></td>
                            <td><?php echo $row['txt_tel'];?></td>
                            <td width="10%"><?php echo $row['created_at'];?></td>
                            <td width="10%" class="center"><a href="<?php echo ADDRESS_ADMIN_CONTROL?>contact_message&action=edit&id=<?php echo $row['id']?>" class="btn btn-primary btn-small"> เปิดดู</a> <a href="#" onclick="if(confirm('คุณต้องการลบข้อมูลนี้หรือใม่?')==true){document.location.href='<?php echo ADDRESS_ADMIN_CONTROL?>contact_message&action=del&id=<?php echo $row['id']?>'}" class="btn btn-danger btn-small">ลบ</a></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php }?>
<style>


/*Colored Label Attributes*/
.yellowThing {
background: #FF9 !important;
cursor:pointer;

}
.whiteThing {
background: #FFF !important;
}
.redThing {
background: #F00 !important;
}

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
