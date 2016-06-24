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



		$products_message->SetValues($arrData);



		if($products_message->GetPrimary() == ''){


			$products_message->SetValue('created_at', DATE_TIME);


			$products_message->SetValue('updated_at', DATE_TIME);


		}else{


			$products_message->SetValue('updated_at', DATE_TIME);


		}



	//	$products_message->Save();


		if($products_message->Save()){			


			SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ','success');


			//Redirect if needed


			


				if(isset($_FILES['file_array'])){


					$Allfile = "";


					$Allfile_ref = "";


					for($i= 0; $i < count($_FILES['file_array']['tmp_name']); $i++){


						if($_FILES["file_array"]["name"][$i] != ""){


							unset($arrData['webs_money_image']);


			


							$targetPath = DIR_ROOT_GALLERY . "/";


				


							$newImage = DATE_TIME_FILE . "_" . $_FILES['file_array']['name'][$i];


				


							$cdir = getcwd(); // Save the current directory


				


							chdir($targetPath);


				


							copy($_FILES['file_array']['tmp_name'][$i], $targetPath . $newImage);


				


							chdir($cdir); // Restore the old working directory   


							


							$product_files->SetValue('file_name', $newImage);


							


							if($_POST['alt_tag'][$i] == ''){


								


								//$Allfile_ref .= "|_|" . $newImage;


								//$product_files->SetValue('file_name', substr($Allfile, 3));


								$product_files->SetValue('alt_tag', $newImage);	


							}else{


								//$Allfile_ref .= "|_|" .   $functions->seoTitle($_POST['alt_tag'][$i]);


								$product_files->SetValue('alt_tag', $functions->seoTitle($_POST['alt_tag'][$i]));	


							}


							$product_files->SetValue('product_id', $products_message->GetPrimary());


							//$product_files->Save();


							if($product_files->Save()){	

								//SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ','success');


								$product_files->ResetValues();


							


							}else{


								SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


							}


						


						}


					}


					if($_POST['products_file_name_cover'] == ''){


						$arrOrder = array(


							'products_file_name_cover' => $product_files->getDataDesc("file_name", "product_id = '" .  $products_message->GetPrimary() . "' ORDER BY id ASC LIMIT 0,1"),


				


							'updated_at' => DATE_TIME


						);


						$arrOrderID = array('id' => $products_message->GetPrimary());


				


					 	$products_message->updateSQL($arrOrder, $arrOrderID);


						


					}


				


				}


				////////


				


				if ($redirect){


					header('location:' . ADDRESS_ADMIN_CONTROL . 'all_product');


					die();


				}else{


					header('location:' . ADDRESS_ADMIN_CONTROL . 'all_product&action=edit&id=' . $products_message->GetPrimary());


					die();


				}


			


		}else{


			SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


		}	


	}



	


	if ($_GET['id'] != '' && $_GET['action'] == 'edit'){


		// For Update


		$products_message->SetPrimary((int)$_GET['id']);


		// Try to get the information


		if (!$products_message->GetInfo()){


			SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


			$products_message->ResetValues();


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
            <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-<?php echo ($products_message->GetPrimary() != '') ? 'application-edit' : 'add'?>"></i> <?php echo ($products_message->GetPrimary() != '') ? 'แก้ไข' : 'เพิ่ม'?> ข้อความแสดงการรายทั้งหมด </span> </div>
            <div class="da-panel-content da-form-container">
                <form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL?>all_product<?php echo ($products_message->GetPrimary() != '') ? '&id=' . $products_message->GetPrimary() : ''; ?>" method="post" class="da-form">
                    <?php if($products_message->GetPrimary() != ''):?>
                    <input type="hidden" name="id" value="<?php echo $products_message->GetPrimary()?>" />
                    <input type="hidden" name="created_at" value="<?php echo $products_message->GetValue('created_at')?>" />
                    <?php endif;?>
                    <div class="da-form-inline">
                    <div class="da-form-row">
                        <label class="da-form-label">หัวข้อ <span class="required">*</span></label>
                        <div class="da-form-item large">
                            <input type="text" name="product_title" id="product_title" value="<?php echo ($products_message->GetPrimary() != '') ? $products_message->GetValue('product_title') : ''; ?>" class="span12 required" />
                        </div>
                    </div>
               
                    <div class="da-form-row">
                        <label class="da-form-label">รายละเอียด<span class="required">*</span></label>
                        <div class="da-form-item large">
                            <textarea name="product_detail" id="product_detail" class="span12 tinymce required"><?php echo ($products_message->GetPrimary() != '') ? $products_message->GetValue('product_detail') : ''; ?></textarea>
                            <label for="product_detail" generated="true" class="error" style="display:none;"></label>
                        </div>
                    </div>
                  
                 
                    
                   <div class="da-form-row">


                            <label class="da-form-label">Meta Title</label>


                            <div class="da-form-item large">


                                <textarea name="meta_title" id="meta_title" class="span12"><?php echo ($products_message->GetPrimary() != '') ? $products_message->GetValue('meta_title') : ''; ?></textarea>


                            </div>


                        </div>


                        <div class="da-form-row">


                            <label class="da-form-label">Meta Keywords</label>


                            <div class="da-form-item large">


                                <textarea name="meta_keywords" id="meta_keywords" class="span12"><?php echo ($products_message->GetPrimary() != '') ? $products_message->GetValue('meta_keywords') : ''; ?></textarea>


                            </div>


                        </div>    


                        <div class="da-form-row">


                            <label class="da-form-label">Meta Descriptions</label>


                            <div class="da-form-item large">


                                <textarea name="meta_descriptions" id="meta_descriptions" class="span12"><?php echo ($products_message->GetPrimary() != '') ? $products_message->GetValue('meta_descriptions') : ''; ?></textarea>


                            </div>


                        </div>
          
                    </div>
                    <div class="btn-row">
                       
                        <input type="submit" name="submit_bt" value="บันทึกข้อมูล และแก้ไขต่อ" class="btn btn-primary" />
                    
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
            <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-grid"></i> สินค้า ทั้งหมด </span> </div>
            <div class="da-panel-toolbar">
                <div class="btn-toolbar">
                    <div class="btn-group"> <a class="btn" href="<?php echo ADDRESS_ADMIN_CONTROL?>product&action=add"><i class="icol-add"></i> เพิ่มข้อมูล</a> </div>
                </div>
            </div>
            <div class="da-panel-content da-table-container">
                <table id="da-ex-datatable-sort" class="da-table" sort="0" order="asc" width="2000">
                    <thead>
                        <tr>
                            <th>รหัส</th>
                            <th>ชื่อสินค้า</th>
                            <th>กลุ่มสินค้า</th>
                            <th>หน้าปก</th>
                            <th>สถานะ</th>
                            <th>แก้ไขล่าสุด</th>
                        
                            <th>ตัวเลือก</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php


							$sql = "SELECT * FROM " . $products_message->getTbl();


							$query = $db->Query($sql);


							while ($row = $db->FetchArray($query)){


						?>
                        <tr>
                            <td class="center"><?php echo $row['id'];?></td>
                            <td><?php echo $row['product_name'];?></td>
                            <td><?php echo $category->getDataDesc("category_name","id = '" . $row['category_id'] . "'")?></td>
                            <td class="center"><img src="<?php echo ADDRESS_GALLERY . $products_message->getDataDesc("products_file_name_cover","id = '" . $row['id'] . "'")?>" style="height:70px; width:70px;"></td>
                            <td class="center"><i class="icol-<?php echo ($row['status'] == 'ใช้งาน') ? 'accept' : 'cross'?>" title="<?php echo $row['status']?>"></i></td>
                            <td class="center"><?php echo $functions->ShowDateThTime($row['updated_at'])?></td>
                          
                            <td class="center"><a href="<?php echo ADDRESS_ADMIN_CONTROL?>product&action=edit&id=<?php echo $row['id']?>" class="btn btn-primary btn-small">แก้ไข / ดู</a> <a href="#" onclick="if(confirm('คุณต้องการลบข้อมูลนี้หรือใม่?')==true){document.location.href='<?php echo ADDRESS_ADMIN_CONTROL?>product&action=del&id=<?php echo $row['id']?>'}" class="btn btn-danger btn-small">ลบ</a></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php }?>
<script type="text/javascript">


//$( document ).ready(function() {


	function addfile(){


  	 $("#filecopy:first").clone().insertAfter("div #filecopy:last");


	}


	function delfile(){


  	 //$("#filecopy").clone().insertAfter("div #filecopy:last");


	 var conveniancecount = $("div #filecopy").length;


	 if(conveniancecount > 2){


		 $("div #filecopy:last").remove();


	 }


	 


	 


	 


	 


	}


	$(document).ready(function() {


       


		$('input:radio[name="products_file_name_cover"][value="<?php echo $products_message->getDataDesc("products_file_name_cover", "id = '" .  $_GET['id'] . "'");?>"]').prop('checked', true);


		


    });


   


//});


     


</script> 
<script>


  $(function() {


   // $( "#datepicker" ).datepicker();


	 $("#activity_date").datepicker({ dateFormat: "yy-mm-dd" }).val()


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
