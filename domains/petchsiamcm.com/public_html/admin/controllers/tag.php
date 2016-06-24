<?php
// If they are saving the Information
if ($_POST ['submit_bt'] == 'บันทึกข้อมูล' || $_POST ['submit_bt'] == 'บันทึกข้อมูล และแก้ไขต่อ') {

    $tag->deleteAll();
    for ($i = 0; $i < count($_POST ['tag_title']); $i ++) {

        if ($_POST ['tag_title'] [$i] != '' && $_POST ['link_to'] [$i] != '') {
            $arr_tag= array(
                "tag_title" => $_POST ['tag_title'] [$i],
                "link_to" => $_POST ['link_to'] [$i]
            );

            $tag->SetValues($arr_tag);
            if ($tag->save()) {
                $save_res = true;
            } else {
                SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
                $save_res = false;
            }
        }
    }

        if ($save_res) {
            SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success');
            // header('location:' . ADDRESS_ADMIN_CONTROL . 'shipping');
        } else {

            SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
        }
   
}
?>

<div class="row-fluid">
    <div class="span12">
        <?php
        // Report errors to the user

        Alert(GetAlert('error'));

        Alert(GetAlert('success'), 'success');
        ?>
        <div class="da-panel collapsible">
            <div class="da-panel-header">
                <span class="da-panel-title"> <i
                        class="icol-<?php echo ($shipping->GetPrimary() != '') ? 'application-edit' : 'add' ?>"></i> <?php echo ($shipping->GetPrimary() != '') ? '' : '' ?> Tag </span>
            </div>
            <div class="da-panel-content da-form-container">
                <div style="display: none;">
                    <div class="da-form-inline filecopy"
                         id="filecopy_model">
                        <div class="da-form-row">
                            <div class="span2">
                                <label class="da-form-label"></label>

                            </div>
                            <div class="span4">
                                <div class="span3">
                                    <label class="da-form-label">ชื่อ Tag</label>
                                </div>
                                <div class="span9">
                                    <input type="text" name="tag_title[]"
                                           id="tag_title" placeholder="เช่น กาแฟลดน้ำหนัก"
                                           class="span12 required" />
                                </div>
                            </div>
                            <div class="span4">
                                <div class="span3">
                                    <label class="da-form-label">ไปยังหน้า</label>
                                </div>
                                <div class="span9">
                                    <select id="link_to" name="link_to[]" class="span12 select" required="required" >
                                        <option value="">ddasd</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="span2">
                                <label class="da-form-label">
                                    <a class="text-success" href="javascript:addfile_model();"><i class="icon-circle-plus" style="font-size: 16px;"></i></a>
                                    <a class="text-error"
                                       href="javascript:delfile_model();"><i class="icon-circle-remove" style="font-size: 16px;"></i></a>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="validate" enctype="multipart/form-data"
                      action="<?php echo ADDRESS_ADMIN_CONTROL ?>tag<?php echo ($shipping->GetPrimary() != '') ? '&id=' . $shipping->GetPrimary() : ''; ?>"
                      method="post" class="da-form">


<?php
$sql = "SELECT * FROM " . $tag->getTbl();

$query_tag = $db->Query($sql);

$k = 0;

while ($row_tag = $db->FetchArray($query_tag)) {
    $k ++;
  
    ?>


                        <div class="da-form-inline filecopy"
                             id="filecopy_<?php echo $k ?>">
                            <div class="da-form-row">
                                <div class="span2">
                                <?php if($k == 1){?>
                                    <label class="da-form-label">Tag title<span class="required">*</span></label>
								<?php }?>
                                </div>
                                <div class="span4">
                                    <div class="span3">
                                        <label class="da-form-label">ชื่อ Tag</label>
                                    </div>
                                    <div class="span9">
                                        <input type="text" name="tag_title[]"
                                               id="tag_title" placeholder="เช่น กาแฟลดน้ำหนัก" value="<?php echo $row_tag['tag_title']?>"
                                               class="span12 required" />
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="span3">
                                        <label class="da-form-label">ไปยังหน้า</label>
                                    </div>
                                    <div class="span9">
                                        <select id="link_to" name="link_to[]" class="span12 select" required="required">
                                            <option value="">เลือกรายการ</option>
    <?php
    // split string
     $link_to =$row_tag['link_to'];
     $arr_link_to = explode("-", $link_to);
    ?>
                                            <?php
                                            $sql = "SELECT * FROM " . $category->getTbl() . " WHERE status = 'ใช้งาน'";

                                            $query = $db->Query($sql);
                                            while ($row = $db->FetchArray($query)) {

                                                if ($arr_link_to [0] == 'category') {
                                                    ?>
                                                    <option
                                                    <?php echo $row['id'] == $arr_link_to[1] ? ' selected="selected"' : ''; ?>
                                                        value="<?php echo "category" . "-" . $row['id'] ?>"><?php echo $row['category_name'] ?></option>
                                                <?php } else { ?>
                                                    <option
                                                        value="<?php echo "category" . "-" . $row['id'] ?>"><?php echo $row['category_name'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    $sql2 = "SELECT * FROM " . $products->getTbl() . " WHERE status = 'ใช้งาน' AND category_id = " . $row ['id'] . "";
                                                    $query2 = $db->Query($sql2);
                                                    while ($row2 = $db->FetchArray($query2)) {
                                                        if ($arr_link_to [0] == 'product') {
                                                            ?>
                                                        <option
                                                            <?php echo $row2['id'] == $arr_link_to[1] ? ' selected="selected"' : ''; ?>
                                                            value="<?php echo "product" . "-" . $row2['id'] ?>"> ---- <?php echo $row2['product_name'] ?> </option>
                                                        <?php } else { ?>


                                                        <option value="<?php echo "product" . "-" . $row2['id'] ?>"> ---- <?php echo $row2['product_name'] ?></option>
                                                            <?php } ?>

                                                    <?php } ?>
    											<?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="span2">
                                    <label class="da-form-label">
                                        <a class="text-success" href="javascript:addfile_model();"><i class="icon-circle-plus" style="font-size: 16px;"></i></a>
                                        <a class="text-error"
                                           href="javascript:delfile2('filecopy_<?php echo $k ?>');"><i class="icon-circle-remove" style="font-size: 16px;"></i></a>
                                    </label>
                                </div>
                            </div>
                           
                        </div>
                        <?php } ?>

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

        if (count_model > 1) {

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
<script language="javascript">
// Start XmlHttp Object
function uzXmlHttp(){
    var xmlhttp = false;
    try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){
        try{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch(e){
            xmlhttp = false;
        }
    }
 
    if(!xmlhttp && document.createElement){
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}
// End XmlHttp Object

function data_show(){

	var url = '../ajax/select_ajax.php';
	//alert(url);
	
    xmlhttp = uzXmlHttp();
    xmlhttp.open("GET", url, false);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
    xmlhttp.send(null);
	//alert(xmlhttp.responseText);
	//alert(xmlhttp.responseText);
	document.getElementById('link_to').innerHTML =  xmlhttp.responseText;
}



//window.onLoad=data_show(5,'amphur'); 
</script>

<script type="text/javascript">
$(document).ready(function() {
	data_show();
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
