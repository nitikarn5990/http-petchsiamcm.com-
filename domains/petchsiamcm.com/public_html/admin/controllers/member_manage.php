
<?php
/*
 * return an array whose elements are shuffled in random order.
 */


if ($_POST['submit_bt'] == 'บันทึกข้อมูล' || $_POST['submit_bt'] == 'บันทึกข้อมูล และแก้ไขต่อ') {
    if ($_POST['submit_bt'] == 'บันทึกข้อมูล') {

        $redirect = true;
    } else {
        $redirect = false;
    }

    $arrData = array();


    $arrData = $functions->replaceQuote($_POST);


    $member->SetValues($arrData);



    $member->SetValue('password', $functions->encode_login($_POST['password']));


    if ($member->GetPrimary() == '') {


        $member->SetValue('created_at', DATE_TIME);

        $start_date = strtotime(DATE_TIME);
        $end_date_at = date('Y-m-d 23:59:59', strtotime("+7 day", $start_date));
        $member->SetValue('end_date_at', $end_date_at);
    } else {

        $member->SetValue('updated_at', DATE_TIME);
    }


    $member_parent = $functions->replaceQuote($_POST['member_name']);

    $member->SetValue('member_parent', json_encode($member_parent));
    //$member->updateSQL(array('member_parent' => json_encode($member_parent)), array('id' => $member->GetValue('id')));



    if ($member->Save()) {



        if ($redirect) {


            header('location:' . ADDRESS_ADMIN_CONTROL . 'member');


            die();
        } else {


            header('location:' . ADDRESS_ADMIN_CONTROL . 'member&action=edit&id=' . $member->GetPrimary());


            die();
        }
    } else {


        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}

if ($_SESSION['admin_id'] != '') {


    // For Update

    $member->SetPrimary((int) $_SESSION['admin_id']);

    // Try to get the information


    if (!$member->GetInfo()) {


        SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


        $member->ResetValues();
    }
}
?>
<?php if ($_SESSION['admin_id'] != '') { ?>
    <div class="row-fluid">
        <div class="span12">
            <?php
            // Report errors to the user
            Alert(GetAlert('error'));
            Alert(GetAlert('success'), 'success');
            ?>

            <div class="da-panel collapsible">
                <div class="da-panel-header"> 
                    <span class="da-panel-title"> <i class="icol-<?php echo ($member->GetPrimary() != '') ? 'application-edit' : 'add' ?>"></i> <?php echo ($member->GetPrimary() != '') ? '' : '' ?> หน้าจัดการโฆษณา 

                    </span> 



                </div>
                <div class="da-panel-content da-form-container">
                    <form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL ?>member<?php echo ($member->GetPrimary() != '') ? '&action=edit&id=' . $member->GetPrimary() : ''; ?>" method="post" class="da-form">
                        <?php if ($member->GetPrimary() != ''): ?>
                            <input type="hidden" name="id" value="<?php echo $member->GetPrimary() ?>" />
                            <input type="hidden" name="time_limit" id="time_limit" value="<?php echo $member->GetValue('time_limit') ?>" />
                            <input type="hidden" name="created_at" value="<?php echo $member->GetValue('created_at') ?>" />
                            <input type="hidden" name="" id="end_date_at" value="" />

                        <?php endif; ?>
                        <div class="da-form-inline">
                            <div class="da-form-row">
                                <div class="span6">
                                    <label class="da-form-label">Username : <span class="required"></span></label>
                                    <div class="da-form-item large">
                                        <input type="text" disabled="" value="<?php echo ($member->GetPrimary() != '') ? $member->GetValue('username') : ''; ?>" class="span12" />
                                    </div><br>
                                    <label class="da-form-label">Password : <span class="required"></span></label>
                                    <div class="da-form-item large">
                                        <input type="password" disabled="" value="<?php echo ($member->GetPrimary() != '') ? $functions->decode_login($member->GetValue('password')) : ''; ?>" class="span8" />
                                        <div class="span4"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>member_profile" class="btn btn-mini btn-inverse"><i class="fa fa-key"></i> เปลี่ยนรหัสผ่าน</a></div>
                                    </div>
                                </div>
                                <div class="span6">


                                    <label class="da-form-label"><i class="fa fa-money fa-2x"></i> ยอดเงิน : <span class="required"></span></label>
                                    <div class="da-form-item large">
                                        <input type="text" readonly="" value="<?php echo ($member->GetPrimary() != '') ? $member->GetValue('balance') : '0'; ?>" class="span12"  data-validation="number"/>
                                    </div>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <div class="span6">
                                    <label class="da-form-label">รหัสสมาชิก : <span class="required"></span></label>
                                    <div class="da-form-item large">
                                        <input type="text" readonly="" value="<?php echo ($member->GetPrimary() != '') ? $member->GetValue('member_id') : ''; ?>" class="span12" />
                                    </div><br>

                                </div>
                                <div class="span6">
                                    <label class="da-form-label">บัญชีและรหัสถอนเงิน : <span class="required"></span></label>
                                    <div class="da-form-item large">
                                        <textarea rows="12" readonly="" class="span12"><?php echo ($member->GetPrimary() != '') ? $member->GetValue('member_groups_id') : ''; ?></textarea>
                                    </div><br>

                                </div>

                            </div>
                            <div class="da-form-row">
                                <div class="span6">
                                    <label class="da-form-label">ชื่อ-สกุล : <span class="required"></span></label>
                                    <div class="da-form-item large">
                                        <input type="text" readonly="" value="<?php echo ($member->GetPrimary() != '') ? $member->GetValue('name') : ''; ?>" class="span12" />
                                    </div><br>

                                </div>
                                <div class="span6">
                                    <label class="da-form-label">เบอร์โทร : <span class="required"></span></label>
                                    <div class="da-form-item large">
                                        <input type="text" readonly="" value="<?php echo ($member->GetPrimary() != '') ? $member->GetValue('tel') : ''; ?>" class="span12" />
                                    </div>
                                </div>
                            </div>

                            <div class="da-form-row">

                                <label class="da-form-label"><img src="../images/icon-ads.png" width="32" height="32"> คลิ้กโฆษณา </label>
                                <div class="da-form-item large">
                                    <div class="span6" id="html_ad" style="background-color: #F0F0F0;padding: 15px;border-radius: 5px;border: 1px solid #D4D4D4;">
                                        <?php
                                        if ($member->GetPrimary() != '') {

                                            $number_of_ad = $member->GetValue('number_of_ad');
                                            $sqlImg = "SELECT * FROM " . $user_banner->getTbl() . " WHERE member_id = " . $member->GetPrimary() . "  AND status = 'unclick' AND current_show = 1";
                                            $queryImg = $db->Query($sqlImg);
                                            if ($db->NumRows($queryImg) > 0) {
                                                while ($row = $db->FetchArray($queryImg)) {
                                                    ?>
                                                    
                                                        <img src="<?= ADDRESS ?>img/<?= $row['image'] ?>" class="img-responsive click-ad" onclick="click_ad('<?=$row['id']?>', this)" style="max-width: 100%;">
                                                        <p>&nbsp;</p>
                                                        

                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>

                                    </div>

                                    <div class="span6" style="padding: 15px;border-radius: 5px;border: 1px solid #D4D4D4;">
                                        <p><label><i class="fa fa-clock-o fa-2x"></i> เวลาหาสมาชิก :</label></p>

                                        <div id="getting-started" style="font-size: 18px;"></div>

                                    </div>
                                </div>

                            </div>

                            <div class="da-form-row">
                                <?php
                                if ($member->GetPrimary() != '') {
                                    $arr_member_parent = json_decode($member->GetValue('member_parent'));
                                }
                                ?>
                                <label class="da-form-label"><i class="fa fa-users fa-2x "></i> สมาชิกที่หาได้</label>
                                <div class="da-form-item large" id="">
                                    <label class="span1">1.</label>  
                                    <input type="text" readonly="" value="<?php echo ($member->GetPrimary() != '') ? $arr_member_parent[0] : ''; ?>" class="span6" data-validation=""/>

                                </div><br>
                                <div class="da-form-item large" id="">
                                    <label class="span1 ">2.</label>  
                                    <input type="text" readonly="" value="<?php echo ($member->GetPrimary() != '') ? $arr_member_parent[1] : ''; ?>" class="span6" data-validation=""/>

                                </div><br>
                                <div class="da-form-item large" id="">
                                    <label class="span1">3.</label>  

                                    <input type="text" readonly="" value="<?php echo ($member->GetPrimary() != '') ? $arr_member_parent[2] : ''; ?>" class="span6" data-validation=""/>

                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label"><i class="fa fa-commenting-o fa-2x "></i> หมายเหตุ : <span class="required"></span></label>
                                <div class="da-form-item large">
                                    <textarea rows="12" class="span12" readonly=""><?php echo ($member->GetPrimary() != '') ? $member->GetValue('comment') : ''; ?></textarea>
                                </div>
                            </div>


                        </div>
                        <div class="btn-row">

                            <button type="submit" name="submit_bt" value="บันทึกข้อมูล และแก้ไขต่อ" class="hidden btn btn-primary" /><i class="fa fa-save"></i> บันทึกข้อมูล</div>

                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>



<script type="text/javascript">

    var end_date_at = '';
    var date_time = '';
    var end_date_at2 = '';

    $(document).ready(function () {
        ajax_get_new();
        ajax_get_new2();
        var iCountDown = setInterval("countDown()", 1000);

    });

    function RunTime(dt) {

        var timeA = new Date(end_date_at2); // วันเวลาปัจจุบัน

        var timeB = new Date(dt); // วันเวลาสิ้นสุด รูปแบบ เดือน/วัน/ปี ชั่วโมง:นาที:วินาที

        //	var timeB = new Date(2012,1,24,0,0,1,0); 
        // วันเวลาสิ้นสุด รูปแบบ ปี,เดือน;วันที่,ชั่วโมง,นาที,วินาที,,มิลลิวินาที    เลขสองหลักไม่ต้องมี 0 นำหน้า
        // เดือนต้องลบด้วย 1 เดือนมกราคมคือเลข 0
        var timeDifference = timeB.getTime() - timeA.getTime();
        //  console.log(timeB.getTime());
        if (timeDifference >= 0) {
            timeDifference = timeDifference / 1000;
            timeDifference = Math.floor(timeDifference);
            var wan = Math.floor(timeDifference / 86400);
            var l_wan = timeDifference % 86400;
            var hour = Math.floor(l_wan / 3600);
            var l_hour = l_wan % 3600;
            var minute = Math.floor(l_hour / 60);
            var second = l_hour % 60;
            var showPart = document.getElementById('getting-started');

            if (wan === 0 && hour === 0 && minute === 0 && second === 0) {
                //clearInterval(iCountDown); // ยกเลิกการนับถอยหลังเมื่อครบ
                // เพิ่มฟังก์ชันอื่นๆ ตามต้องการ
            } else {
                //เหลือวันสุดท้ายโชว์สีแดง
                if (wan <= 1) {
                    showPart.innerHTML = "<span class='text-red'>" + wan + " วัน " + hour + " ชั่วโมง "
                            + minute + " นาที " + second + " วินาที" + "</span>";
                } else {
                    showPart.innerHTML = wan + " วัน " + hour + " ชั่วโมง "
                            + minute + " นาที " + second + " วินาที";

                }
            }

        } else {
            var showParts = document.getElementById('getting-started');
            showParts.innerHTML = "<span class='text-red'>หมดเวลา!</span>";
            end_date_at = '';

        }
    }
    function countDown() {
        ajax_get_new2();

        if (end_date_at === '') {
            ajax_get_new('7');

        } else {
            RunTime(end_date_at);

        }

    }
// การเรียกใช้
    //  var iCountDown = setInterval("countDown()", 1000);
</script>

<script type="text/javascript">


    function click_ad(id, ele) {
      
        $.ajax({
            method: "GET",
            url: "../admin/ajax/ajax_user_banner.php",
            data: {id: id}
        }).done(function (msg) {
            if (msg === 'success') {
                if ($(ele).remove()) {
                    notie.alert(1, 'ทำรายการสำเร็จ!', 3);
                }
            }
        });

    }
   
    function ajax_get_new(day) {
        /// end_date_at = '';

        if (day !== '') {
            $.ajax({
                method: "GET",
                url: "../admin/ajax/ajax_get_end_date.php",
                data: {day: day},
                success: function (data) {
                    var obj1 = $.parseJSON(data);
                    end_date_at = obj1.data;

                    //  if (obj1.html !== '') {
                    $('#html_ad').html(obj1.html);


                    //  console.log(end_date_at);
                    notie.alert(4, 'เริ่มนับเวลา!', 3);

                }
            });
        } else {

            $.ajax({
                method: "GET",
                url: "../admin/ajax/ajax_get_end_date.php",
                data: {},
                success: function (data) {
                    // $('#end_date_at').val(data);

                    var obj1 = $.parseJSON(data);
                    end_date_at = obj1.data;
                    // end_date_at2 = obj1.data;
                    //alert(end_date_at);
                    //  fn(obj1.data);
                }
            });
        }



    }


    function ajax_get_new2() {

        $.ajax({
            method: "GET",
            url: "../admin/ajax/ajax_get_end_date.php",
            data: {dt_now: 'dt_now'},
            success: function (data) {
                var obj1 = $.parseJSON(data);

                end_date_at2 = obj1.data;

                // console.log(end_date_at2);
            }
        });

    }



</script>

<style>


    /*Colored Label Attributes*/
    .click-ad{
        cursor: pointer;
    }
    .text-red{
        color: #D32B26;
        text-align: left;
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
