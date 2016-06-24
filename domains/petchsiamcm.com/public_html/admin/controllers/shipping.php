<?php
// If they are saving the Information
if ($_GET['controllers'] == 'shipping'){
	if ($_POST ['submit_bt'] == 'บันทึกข้อมูล' || $_POST ['submit_bt'] == 'บันทึกข้อมูล และแก้ไขต่อ') {
		
		$shipping->deleteAll ();
		for($i = 0; $i < count ( $_POST ['shipping_rate_min'] ); $i ++) {
			
			if ($_POST ['shipping_rate_min'] [$i] != '' && $_POST ['shipping_rate_max'] [$i] != '' && $_POST ['shipping_cost'] [$i] != '') {
				$arr_rate = array (
						"shipping_rate_min" => $_POST ['shipping_rate_min'] [$i],
						"shipping_rate_max" => $_POST ['shipping_rate_max'] [$i],
						"shipping_cost" => $_POST ['shipping_cost'] [$i] 
				);
				
				$shipping->SetValues ( $arr_rate );
				if ($shipping->save ()) {
					$save_res = true;
				} else {
					SetAlert ( 'ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง' );
					$save_res = false;
				}
			}
		}
		
		$arr_data = array (
				"shipping_type" => $_POST ['radio'],
				"shipping_cost_total" => $_POST ['shipping_cost_total'] 
		)
		;
		$arr_key = array (
				"id" => "1" 
		);
		if ($shipping_total->updateSQL ( $arr_data, $arr_key )) {
			if ($save_res) {
				SetAlert ( 'เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success' );
				// header('location:' . ADDRESS_ADMIN_CONTROL . 'shipping');
			} else {
				
				SetAlert ( 'ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง' );
			}
		} else {
			
			SetAlert ( 'ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง' );
		}
	}
}
?>

<div class="row-fluid">
	<div class="span12">
        <?php
								// Report errors to the user
								
								Alert ( GetAlert ( 'error' ) );
								
								Alert ( GetAlert ( 'success' ), 'success' );
								?>
        <div class="da-panel collapsible">
			<div class="da-panel-header">
				<span class="da-panel-title"> <i
					class="icol-<?php echo ($shipping->GetPrimary() != '') ? 'application-edit' : 'add' ?>"></i> <?php echo ($shipping->GetPrimary() != '') ? '' : '' ?> ค่าขนส่ง </span>
			</div>
			<div class="da-panel-content da-form-container">
				<div style="display: none;">
					<div class="da-form-inline filecopy" id="filecopy_model">
						<div class="da-form-row">
							<div class="span2">
								<label class="da-form-label"> </label>

							</div>
							<div class="span3">
								<label class="da-form-label">น้ำหนักตั้งแต่ (กรัม)</label> <input
									type="number" name="shipping_rate_min[]" id="shipping_rate_min"
									placeholder="น้ำหนัก (กรัม)" class="span12 required" />
							</div>
							<div class="span3">
								<label class="da-form-label">ถึง (กรัม)</label> <input type="number"
									name="shipping_rate_max[]" id="shipping_rate_max"
									placeholder="น้ำหนัก (กรัม)" class="span12 required" />
							</div>
							<div class="span3">
								<label class="da-form-label">ราคาขนส่ง (บาท)</label> <input
									type="number" name="shipping_cost[]" id="shipping_cost"
									placeholder="ราคา (บาท)" class="span12 required" />
							</div>
							<div class="span1" style="padding-top: 30px;">
								<a class="text-success" href="javascript:addfile_model();"><i class="icon-circle-plus" style="font-size: 16px;"></i></a> <a
									class="text-error"
									href="javascript:delfile_model();"><i class="icon-circle-remove" style="font-size: 16px;"></i></a>
							</div>
						</div>
					</div>
				</div>

				<form id="validate" enctype="multipart/form-data"
					action="<?php echo ADDRESS_ADMIN_CONTROL ?>shipping"
					method="post" class="da-form">

					<div class="da-form-row" id="all_rate">
						<label class="radio"> <input type="radio" name="radio" id="radio"
							value="rate_total"
							<?php echo $shipping_total->getDataDesc("shipping_type", "id > 0 ORDER BY id DESC LIMIT 0,1") == 'rate_total' ? 'checked' : '' ?>>
                                                    ราคาแบบเหมาทุกน้ำหนัก (บาท)
						</label>
						<div class="da-form-item large">
							<input type="number" name="shipping_cost_total"
								id="shipping_cost_total" placeholder="ระบุค่าขนส่ง"
								value="<?php echo $shipping_total->getDataDesc("shipping_cost_total","id > 0 ORDER BY id DESC LIMIT 0,1") ?>"
								class="span12 " required="required" />
						</div>
					</div>

                       <?php
																							
																							$sql = "SELECT * FROM " . $shipping->getTbl ();
																							
																							$query = $db->Query ( $sql );
																							
																							$k = 0;
																							while ( $row = $db->FetchArray ( $query ) ) {
																								$k ++;
																								?>
								
								
								  <div class="da-form-inline filecopy"
						id="filecopy_<?php echo $k?>">
						<div class="da-form-row">
							<div class="span2">
			                            
			                            	<?php if($k == 1){ ?>
			                                <label class="radio"> <input
									type="radio" name="radio" id="radio" value="rate_custom"
									<?php echo $shipping_total->getDataDesc("shipping_type", "id > 0 ORDER BY id DESC LIMIT 0,1") == 'rate_custom' ? 'checked' : '' ?>>
                                                               ตามช่วงน้ำหนัก
								</label>
			                                        
			                                 <?php }?>
			
			                            </div>
							<div class="span3">
								<label class="da-form-label">น้ำหนักตั้งแต่ (กรัม)</label> <input
									type="number" name="shipping_rate_min[]" id="shipping_rate_min"
									placeholder="น้ำหนัก (กรัม)"
									value="<?php echo  $row['shipping_rate_min'] ?>"
									class="span12 required" />
							</div>
							<div class="span3">
								<label class="da-form-label">ถึง (กรัม)</label> <input type="number"
									name="shipping_rate_max[]" id="shipping_rate_max"
									placeholder="น้ำหนัก (กรัม)"
									value="<?php echo  $row['shipping_rate_max'] ?>"
									class="span12 required" />
							</div>
							<div class="span3">
								<label class="da-form-label">ราคาขนส่ง (บาท)</label> <input
									type="number" name="shipping_cost[]" id="shipping_cost"
									placeholder="ราคา (บาท)"
									value="<?php echo $row['shipping_cost'] ?>"
									class="span12 required" />
							</div>
							<div class="span1" style="padding-top: 30px;">
								<a class="text-success" href="javascript:addfile_model();"><i class="icon-circle-plus" style="font-size: 16px;"></i></a> <a
									class="text-error"
									href="javascript:delfile2('filecopy_<?php echo $k?>');"><i class="icon-circle-remove" style="font-size: 16px;"></i></a>
							</div>
						</div>
					</div>
						
						
						<?php }?>
                  



                    <div class="btn-row">
						<input type="submit" name="submit_bt" value="บันทึกข้อมูล"
							class="btn btn-success" /> <a
							href="<?php echo ADDRESS_ADMIN_CONTROL ?>shipping"
							class="btn btn-danger">ยกเลิก</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">


    function addfile_model() {


    	   $("#filecopy_model:first").clone().insertAfter("div.filecopy:last");


    }


    function delfile2(ele) {


        //$("#filecopy").clone().insertAfter("div #filecopy:last");


      // var conveniancecount = $("div #filecopy").length;

	if (ele != 'filecopy_1') {


            // $(ele).remove();
             var elem = document.getElementById(ele);
             elem.parentNode.removeChild(elem);


        }

}
    function delfile_model() {
    	// if(ele == 'filecopy_modal'){

      	   var count_model = $("div #filecopy_model").length;

      	   if(count_model > 1){

      		   $("div #filecopy_model:last").remove();
             }

      //   } 

    }




</script>
<script>


    $(function () {


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

.error {
	color: #d44d24;
}
</style>
