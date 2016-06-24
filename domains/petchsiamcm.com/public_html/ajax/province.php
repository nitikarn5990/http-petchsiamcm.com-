<?php  include_once($_SERVER["DOCUMENT_ROOT"] .dirname($_SERVER['SCRIPT_NAME']). '/lib/application.php');


$result = $_GET['result'];
$select_id = $_GET['select_id'];
 ?>


<?php if($result=='amphur_id'){ 
	$rstTemp=mysql_query("select * from amphur Where PROVINCE_ID ='".$select_id."' Order By AMPHUR_ID ASC");
	echo "<option value=''>กรุณาเลือก</option>";
	while($arr_2=mysql_fetch_array($rstTemp)){
?>

<option value="<?=$arr_2['AMPHUR_ID']?>">
<?php  echo $arr_2['AMPHUR_NAME']?>
</option>
<?php }

        }?>


<?php if($result=='district_id'){ ?>
<select name='district' id='district'>
    <?php
	$rstTemp=mysql_query("select * from district Where AMPHUR_ID ='".$select_id."'  Order By DISTRICT_ID ASC");
	echo "<option value=''>กรุณาเลือก</option>";
	while($arr_2=mysql_fetch_array($rstTemp)){
	?>
    <option value="<?=$arr_2['DISTRICT_ID']?>">
    <?php  echo $arr_2['DISTRICT_NAME']?>
    </option>
    <?php }?>
</select>
<?php }?>
