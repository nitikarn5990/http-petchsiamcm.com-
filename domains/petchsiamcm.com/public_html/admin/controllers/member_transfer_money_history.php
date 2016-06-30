
<?php
//$transfer_money_id = $transfer_money->getDataDesc("id", "status = 'รอโอน' AND customer_id =" . $_SESSION['admin_id']);
//$arrData = array(
//    'updated_at' => DATE_TIME,
//    'total' => 888
//);
//
//$transfer_money->updateSQL($arrData, array('id' => $transfer_money_id));
//die();
if ($_POST['submit_bt'] == 'บันทึกข้อมูล' || $_POST['submit_bt'] == 'บันทึกข้อมูล และแก้ไขต่อ') {



    if ($_POST['submit_bt'] == 'บันทึกข้อมูล') {


        $redirect = true;
    } else {


        $redirect = false;
    }


    $arrData = array();


    $arrData = $functions->replaceQuote($_POST);



    //   $customer->SetValues($arrData);
//    if ($customer->GetPrimary() == '') {
//
//        $customer->SetValue('created_at', DATE_TIME);
//
//        $customer->SetValue('updated_at', DATE_TIME);
//    } else {
//
//        $customer->SetValue('updated_at', DATE_TIME);
//    }
//
//    $customer->SetValue('login_password', $functions->encode_login($_POST['login_password']));
//
//    $customer->SetValue('precode', 'pcsc');
//    $customer->SetValue('customer_refer_id', $customer_id);


    $customer_id = $_POST['customer_id'];
    $total = $_POST['total'];

    if ($total != '-') {
        if ($total < 500) {
            SetAlert('ถอนขั้นต่ำ 500 บาท');
            header('location:' . ADDRESS_ADMIN_CONTROL . 'member_transfer_money_history&action=edit&id=' . $customer_id);
            die();
        }


        $count = $transfer_money->CountDataDesc("id", "status = 'รอโอน' AND customer_id =" . $customer_id);

        if ($count > 0) {
            //update
            $transfer_money_id = $transfer_money->getDataDesc("id", "status = 'รอโอน' AND customer_id =" . $customer_id);

            $arrData = array(
                'updated_at' => DATE_TIME,
                'total' => $total
            );


            if ($transfer_money->updateSQL($arrData, array('id' => $transfer_money_id))) {

                SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success');

                header('location:' . ADDRESS_ADMIN_CONTROL . 'member_transfer_money_history&action=edit&id=' . $customer_id);

                die();
            } else {

                SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
                header('location:' . ADDRESS_ADMIN_CONTROL . 'member_transfer_money_history&action=edit&id=' . $customer_id);
                die();
            }
        } else {

            //add new
            //  $transfer_money->SetValue('id', $transfer_money_id);
            $transfer_money->SetValue('customer_id', $customer_id);
            $transfer_money->SetValue('created_at', DATE_TIME);
            $transfer_money->SetValue('updated_at', DATE_TIME);
            $transfer_money->SetValue('total', $total);
            $transfer_money->SetValue('status', 'รอโอน');


            if ($transfer_money->Save()) {

                SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success');

                header('location:' . ADDRESS_ADMIN_CONTROL . 'member_transfer_money_history&action=edit&id=' . $customer_id);

                die();
            } else {

                SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
                header('location:' . ADDRESS_ADMIN_CONTROL . 'member_transfer_money_history&action=edit&id=' . $customer_id);
                die();
            }
        }
    } else {
        //ลบคำขอ
        $transfer_money_id = $transfer_money->getDataDesc("id", "status = 'รอโอน' AND customer_id =" . $customer_id);

        $transfer_money->SetValue('id', $transfer_money_id);
        $transfer_money->Delete();
    }
}




if ($_SESSION['admin_id'] != '') {

// For Update
// 
    $customer->SetPrimary((int) $_SESSION['admin_id']);

    // Try to get the information

    if (!$customer->GetInfo()) {

        SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');

        $customer->ResetValues();
    }

    $sql = "SELECT * FROM " . $transfer_money->getTbl() . " WHERE status = 'โอนแล้ว' AND customer_id = " . $_SESSION['admin_id'] . " ORDER BY id DESC";

    $query_history = $db->Query($sql);
    $query_history2 = $db->Query($sql);

    $total_transfer = $transfer_money->getDataDesc("total", "status = 'รอโอน' AND customer_id =" . $_SESSION['admin_id']);


    $total_transfer_last = $transfer_money->getDataDesc("total", "status = 'รอโอน' AND customer_id =" . $_SESSION['admin_id']);
    $status_transfer_last = $transfer_money->getDataDesc("status", "status = 'รอโอน' AND customer_id =" . $_SESSION['admin_id']);

    if ($total_transfer_last == '' && $status_transfer_last == '') {

        $status_transfer_last = $transfer_money->CountDataDesc("id", "status = 'โอนแล้ว' AND customer_id =" . $_SESSION['admin_id']);
        if ($status_transfer_last > 0) {

            $total_transfer_last = $transfer_money->getDataDescLastID("total", "status = 'โอนแล้ว' AND customer_id =" . $_SESSION['admin_id']);
            $status_transfer_last = $transfer_money->getDataDescLastID("status", "status = 'โอนแล้ว' AND customer_id =" . $_SESSION['admin_id']);
        }else{
            $total_transfer_last = '';
            $status_transfer_last= '';
            
        }
    }

    if ($status_transfer_last == 'โอนแล้ว') {
        $bg = "background: rgba(194, 224, 64, 0.48)";
        
    }else if($status_transfer_last == 'รอโอน'){
        $bg = "background: rgba(217, 220, 0, 0.28)";
    }else{
        $bg ='';
    }
}
?>

    <!--detail-->

    <div class="row-fluid">
        <div class="span12">
    <?php
// Report errors to the user
    Alert2(GetAlert('error'));

    Alert2(GetAlert('success'), 'success');
    ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">

            <div class="da-panel collapsible">
                <div class="da-panel-header"> <span class="da-panel-title"> <img width="20" height="20" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDU2IDU2IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1NiA1NjsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxnIGlkPSJYTUxJRF8xNF8iPgoJPGcgaWQ9IlhNTElEXzEyN18iPgoJCTxwYXRoIGlkPSJYTUxJRF8xNDdfIiBzdHlsZT0iZmlsbDojRTlFOEQzOyIgZD0iTTIxLjA5NCwzMS41QzE3LjQzOCwyOS4xOTksMTUsMjUuMTM5LDE1LDIwLjVjMC00LjYzOSwyLjQzOC04LjY5OSw2LjA5NC0xMSAgICBIMTAuOTc1QzEwLjk5LDkuNjY1LDExLDkuODMxLDExLDEwYzAsMy4wMzgtMi40NjMsNS41LTUuNSw1LjVjLTAuMTY5LDAtMC4zMzUtMC4wMS0wLjUtMC4wMjV2MTAuMDUgICAgQzUuMTY1LDI1LjUxLDUuMzMxLDI1LjUsNS41LDI1LjVjMy4wMzcsMCw1LjUsMi40NjIsNS41LDUuNWMwLDAuMTY5LTAuMDEsMC4zMzUtMC4wMjUsMC41SDIxLjA5NHoiLz4KCQk8cGF0aCBpZD0iWE1MSURfMTQ2XyIgc3R5bGU9ImZpbGw6I0U5RThEMzsiIGQ9Ik01MC41LDE1LjVjLTMuMDM4LDAtNS41LTIuNDYyLTUuNS01LjVjMC0wLjE2OSwwLjAxLTAuMzM1LDAuMDI1LTAuNUgzNC45MDYgICAgQzM4LjU2MSwxMS44MDEsNDEsMTUuODYxLDQxLDIwLjVjMCw0LjYzOS0yLjQzOSw4LjY5OS02LjA5NCwxMWgxMC4xMTlDNDUuMDEsMzEuMzM1LDQ1LDMxLjE2OSw0NSwzMWMwLTMuMDM4LDIuNDYyLTUuNSw1LjUtNS41ICAgIGMwLjE2OSwwLDAuMzM1LDAuMDEsMC41LDAuMDI1di0xMC4wNUM1MC44MzUsMTUuNDksNTAuNjY5LDE1LjUsNTAuNSwxNS41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzE0NV8iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNS41LDEyLjVDNC4xMjEsMTIuNSwzLDExLjM3OSwzLDEwczEuMTIxLTIuNSwyLjUtMi41QzYuODc5LDcuNSw4LDguNjIxLDgsMTAgICAgUzYuODc5LDEyLjUsNS41LDEyLjUiLz4KCQk8cGF0aCBpZD0iWE1MSURfMTQ0XyIgc3R5bGU9ImZpbGw6I0U5RThEMzsiIGQ9Ik01MC41LDEyLjVjLTEuMzc5LDAtMi41LTEuMTIxLTIuNS0yLjVzMS4xMjEtMi41LDIuNS0yLjUgICAgYzEuMzc5LDAsMi41LDEuMTIxLDIuNSwyLjVTNTEuODc5LDEyLjUsNTAuNSwxMi41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzE0M18iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNS41LDMzLjVDNC4xMjEsMzMuNSwzLDMyLjM3OSwzLDMxYzAtMS4zNzksMS4xMjEtMi41LDIuNS0yLjUgICAgQzYuODc5LDI4LjUsOCwyOS42MjEsOCwzMUM4LDMyLjM3OSw2Ljg3OSwzMy41LDUuNSwzMy41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzE0Ml8iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNTAuNSwzMy41Yy0xLjM3OSwwLTIuNS0xLjEyMS0yLjUtMi41YzAtMS4zNzksMS4xMjEtMi41LDIuNS0yLjUgICAgYzEuMzc5LDAsMi41LDEuMTIxLDIuNSwyLjVDNTMsMzIuMzc5LDUxLjg3OSwzMy41LDUwLjUsMzMuNSIvPgoJCTxwYXRoIGlkPSJYTUxJRF8xNDFfIiBzdHlsZT0iZmlsbDojNkU4QzYxOyIgZD0iTTIyLDguOTc1Yy00LjE1NywyLjE2OS03LDYuNTEyLTcsMTEuNTI2YzAsNS4wMTMsMi44NDMsOS4zNTcsNywxMS41MjVWOC45NzV6Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzE0MF8iIHN0eWxlPSJmaWxsOiM2RThDNjE7IiBkPSJNMzQsOC45NzV2MjMuMDUxYzQuMTU3LTIuMTY4LDctNi41MTIsNy0xMS41MjVDNDEsMTUuNDg2LDM4LjE1NywxMS4xNDQsMzQsOC45NzUiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTM5XyIgeT0iNDguNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzOF8iIHg9IjM0IiB5PSI0OC41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTM3XyIgeT0iNDUuNSIgc3R5bGU9ImZpbGw6IzU0Njk0OTsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzNl8iIHg9IjM0IiB5PSI0NS41IiBzdHlsZT0iZmlsbDojNTQ2OTQ5OyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTM1XyIgeT0iNDIuNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzNF8iIHg9IjM0IiB5PSI0Mi41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTMzXyIgeT0iMzkuNSIgc3R5bGU9ImZpbGw6IzU0Njk0OTsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzMl8iIHg9IjM0IiB5PSIzOS41IiBzdHlsZT0iZmlsbDojNTQ2OTQ5OyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTMxXyIgeT0iMzYuNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzMF8iIHg9IjM0IiB5PSIzNi41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTI5XyIgeD0iMjIiIHk9IjQuNSIgc3R5bGU9ImZpbGw6I0QxRDREMjsiIHdpZHRoPSIxMiIgaGVpZ2h0PSIzMiIvPgoJCTxyZWN0IGlkPSJYTUxJRF8xMjhfIiB4PSIyMiIgeT0iMzYuNSIgc3R5bGU9ImZpbGw6I0E1QTVBNDsiIHdpZHRoPSIxMiIgaGVpZ2h0PSIxNSIvPgoJPC9nPgoJPHJlY3QgaWQ9IlhNTElEXzEyNl8iIHk9IjQuNSIgc3R5bGU9ImZpbGw6IzZFOEM2MTsiIHdpZHRoPSI1NiIgaGVpZ2h0PSIzMiIvPgoJPGcgaWQ9IlhNTElEXzEwNV8iPgoJCTxwYXRoIGlkPSJYTUxJRF8xMjVfIiBzdHlsZT0iZmlsbDojRTlFOEQzOyIgZD0iTTIxLjA5NCwzMS41QzE3LjQzOCwyOS4xOTksMTUsMjUuMTM5LDE1LDIwLjVjMC00LjYzOSwyLjQzOC04LjY5OSw2LjA5NC0xMSAgICBIMTAuOTc1QzEwLjk5LDkuNjY1LDExLDkuODMxLDExLDEwYzAsMy4wMzgtMi40NjMsNS41LTUuNSw1LjVjLTAuMTY5LDAtMC4zMzUtMC4wMS0wLjUtMC4wMjV2MTAuMDUgICAgQzUuMTY1LDI1LjUxLDUuMzMxLDI1LjUsNS41LDI1LjVjMy4wMzcsMCw1LjUsMi40NjIsNS41LDUuNWMwLDAuMTY5LTAuMDEsMC4zMzUtMC4wMjUsMC41SDIxLjA5NHoiLz4KCQk8cGF0aCBpZD0iWE1MSURfMTI0XyIgc3R5bGU9ImZpbGw6I0U5RThEMzsiIGQ9Ik01MC41LDE1LjVjLTMuMDM4LDAtNS41LTIuNDYyLTUuNS01LjVjMC0wLjE2OSwwLjAxLTAuMzM1LDAuMDI1LTAuNUgzNC45MDYgICAgQzM4LjU2MSwxMS44MDEsNDEsMTUuODYxLDQxLDIwLjVjMCw0LjYzOS0yLjQzOSw4LjY5OS02LjA5NCwxMWgxMC4xMTlDNDUuMDEsMzEuMzM1LDQ1LDMxLjE2OSw0NSwzMWMwLTMuMDM4LDIuNDYyLTUuNSw1LjUtNS41ICAgIGMwLjE2OSwwLDAuMzM1LDAuMDEsMC41LDAuMDI1di0xMC4wNUM1MC44MzUsMTUuNDksNTAuNjY5LDE1LjUsNTAuNSwxNS41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzEyM18iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNS41LDEyLjVDNC4xMjEsMTIuNSwzLDExLjM3OSwzLDEwczEuMTIxLTIuNSwyLjUtMi41QzYuODc5LDcuNSw4LDguNjIxLDgsMTAgICAgUzYuODc5LDEyLjUsNS41LDEyLjUiLz4KCQk8cGF0aCBpZD0iWE1MSURfMTIyXyIgc3R5bGU9ImZpbGw6I0U5RThEMzsiIGQ9Ik01MC41LDEyLjVjLTEuMzc5LDAtMi41LTEuMTIxLTIuNS0yLjVzMS4xMjEtMi41LDIuNS0yLjUgICAgYzEuMzc5LDAsMi41LDEuMTIxLDIuNSwyLjVTNTEuODc5LDEyLjUsNTAuNSwxMi41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzEyMV8iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNS41LDMzLjVDNC4xMjEsMzMuNSwzLDMyLjM3OSwzLDMxYzAtMS4zNzksMS4xMjEtMi41LDIuNS0yLjUgICAgQzYuODc5LDI4LjUsOCwyOS42MjEsOCwzMUM4LDMyLjM3OSw2Ljg3OSwzMy41LDUuNSwzMy41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzEyMF8iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNTAuNSwzMy41Yy0xLjM3OSwwLTIuNS0xLjEyMS0yLjUtMi41YzAtMS4zNzksMS4xMjEtMi41LDIuNS0yLjUgICAgYzEuMzc5LDAsMi41LDEuMTIxLDIuNSwyLjVDNTMsMzIuMzc5LDUxLjg3OSwzMy41LDUwLjUsMzMuNSIvPgoJCTxwYXRoIGlkPSJYTUxJRF8xMTlfIiBzdHlsZT0iZmlsbDojNkU4QzYxOyIgZD0iTTIyLDguOTc1Yy00LjE1NywyLjE2OS03LDYuNTEyLTcsMTEuNTI2YzAsNS4wMTMsMi44NDMsOS4zNTcsNywxMS41MjVWOC45NzV6Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzExOF8iIHN0eWxlPSJmaWxsOiM2RThDNjE7IiBkPSJNMzQsOC45NzV2MjMuMDUxYzQuMTU3LTIuMTY4LDctNi41MTIsNy0xMS41MjVDNDEsMTUuNDg2LDM4LjE1NywxMS4xNDQsMzQsOC45NzUiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTE3XyIgeT0iNDguNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzExNl8iIHg9IjM0IiB5PSI0OC41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTE1XyIgeT0iNDUuNSIgc3R5bGU9ImZpbGw6IzU0Njk0OTsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzExNF8iIHg9IjM0IiB5PSI0NS41IiBzdHlsZT0iZmlsbDojNTQ2OTQ5OyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTEzXyIgeT0iNDIuNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzExMl8iIHg9IjM0IiB5PSI0Mi41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTExXyIgeT0iMzkuNSIgc3R5bGU9ImZpbGw6IzU0Njk0OTsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzExMF8iIHg9IjM0IiB5PSIzOS41IiBzdHlsZT0iZmlsbDojNTQ2OTQ5OyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTA5XyIgeT0iMzYuNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEwOF8iIHg9IjM0IiB5PSIzNi41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTA3XyIgeD0iMjIiIHk9IjQuNSIgc3R5bGU9ImZpbGw6I0QxRDREMjsiIHdpZHRoPSIxMiIgaGVpZ2h0PSIzMiIvPgoJCTxyZWN0IGlkPSJYTUxJRF8xMDZfIiB4PSIyMiIgeT0iMzYuNSIgc3R5bGU9ImZpbGw6I0E1QTVBNDsiIHdpZHRoPSIxMiIgaGVpZ2h0PSIxNSIvPgoJPC9nPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" /><b> ข้อมูลสมาชิกรหัส <?= $customer->GetValue('precode') . $customer->GetValue('id') ?> </b></span> </div>
                <div class="da-panel-content da-form-container">
                    <div class="da-form">
    <?php if ($customer->GetPrimary() != ''): ?>

                            <input type="hidden" name="customer_id" value="<?php echo $customer->GetValue('id') ?>" />

    <?php endif; ?>
                        <?php
                        $total_tranfer = 0;
                        $total_income = 0;
                        //  $total_balance = 0;

                        while ($row = $db->FetchArray($query_history)) {

                            if ($row['status'] == 'โอนแล้ว') {
                                $total_tranfer = $total_tranfer + $row['total'];
                            } else if ($row['status'] == 'รับปันผล') {
                                $total_income = $total_income + $row['total'];
                            }
                        }


                        $total_balance = $total_income - $total_tranfer;
                        ?>
                        <div class="da-form-inline">


                            <div class="span12">
                                <div class="da-form-row">
                                    <label class="da-form-label">รหัส<span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <input type="text" disabled="" value="<?php echo $customer->GetValue('precode') . $customer->GetValue('id') ?>" class="span12"/>
                                        <label class=" help-block"></label>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">ชื่อ-สกุล <span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <input type="text" disabled="" value="<?php echo $customer->GetValue('customer_name') . " " . $customer->GetValue('customer_lastname') ?>" class="span12">
                                    </div>
                                </div>
                            </div>
                            <fieldset>
                                <legend><b>ยอดเงินคงเหลือ</b></legend>

                                <div class="da-form-row">
                                    <label class="da-form-label">จำนวน (บาท) <span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <input type="text"  disabled="" id="main_money_balance" value="" class="span12"/>
                                        <label class=" help-block"></label>
                                    </div>
                                </div>
                            </fieldset>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="span6">

            <div class="da-panel collapsible">
                <div class="da-panel-header"> <span class="da-panel-title"> <img width="20" height="20" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDU2IDU2IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1NiA1NjsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxnIGlkPSJYTUxJRF8xNF8iPgoJPGcgaWQ9IlhNTElEXzEyN18iPgoJCTxwYXRoIGlkPSJYTUxJRF8xNDdfIiBzdHlsZT0iZmlsbDojRTlFOEQzOyIgZD0iTTIxLjA5NCwzMS41QzE3LjQzOCwyOS4xOTksMTUsMjUuMTM5LDE1LDIwLjVjMC00LjYzOSwyLjQzOC04LjY5OSw2LjA5NC0xMSAgICBIMTAuOTc1QzEwLjk5LDkuNjY1LDExLDkuODMxLDExLDEwYzAsMy4wMzgtMi40NjMsNS41LTUuNSw1LjVjLTAuMTY5LDAtMC4zMzUtMC4wMS0wLjUtMC4wMjV2MTAuMDUgICAgQzUuMTY1LDI1LjUxLDUuMzMxLDI1LjUsNS41LDI1LjVjMy4wMzcsMCw1LjUsMi40NjIsNS41LDUuNWMwLDAuMTY5LTAuMDEsMC4zMzUtMC4wMjUsMC41SDIxLjA5NHoiLz4KCQk8cGF0aCBpZD0iWE1MSURfMTQ2XyIgc3R5bGU9ImZpbGw6I0U5RThEMzsiIGQ9Ik01MC41LDE1LjVjLTMuMDM4LDAtNS41LTIuNDYyLTUuNS01LjVjMC0wLjE2OSwwLjAxLTAuMzM1LDAuMDI1LTAuNUgzNC45MDYgICAgQzM4LjU2MSwxMS44MDEsNDEsMTUuODYxLDQxLDIwLjVjMCw0LjYzOS0yLjQzOSw4LjY5OS02LjA5NCwxMWgxMC4xMTlDNDUuMDEsMzEuMzM1LDQ1LDMxLjE2OSw0NSwzMWMwLTMuMDM4LDIuNDYyLTUuNSw1LjUtNS41ICAgIGMwLjE2OSwwLDAuMzM1LDAuMDEsMC41LDAuMDI1di0xMC4wNUM1MC44MzUsMTUuNDksNTAuNjY5LDE1LjUsNTAuNSwxNS41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzE0NV8iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNS41LDEyLjVDNC4xMjEsMTIuNSwzLDExLjM3OSwzLDEwczEuMTIxLTIuNSwyLjUtMi41QzYuODc5LDcuNSw4LDguNjIxLDgsMTAgICAgUzYuODc5LDEyLjUsNS41LDEyLjUiLz4KCQk8cGF0aCBpZD0iWE1MSURfMTQ0XyIgc3R5bGU9ImZpbGw6I0U5RThEMzsiIGQ9Ik01MC41LDEyLjVjLTEuMzc5LDAtMi41LTEuMTIxLTIuNS0yLjVzMS4xMjEtMi41LDIuNS0yLjUgICAgYzEuMzc5LDAsMi41LDEuMTIxLDIuNSwyLjVTNTEuODc5LDEyLjUsNTAuNSwxMi41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzE0M18iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNS41LDMzLjVDNC4xMjEsMzMuNSwzLDMyLjM3OSwzLDMxYzAtMS4zNzksMS4xMjEtMi41LDIuNS0yLjUgICAgQzYuODc5LDI4LjUsOCwyOS42MjEsOCwzMUM4LDMyLjM3OSw2Ljg3OSwzMy41LDUuNSwzMy41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzE0Ml8iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNTAuNSwzMy41Yy0xLjM3OSwwLTIuNS0xLjEyMS0yLjUtMi41YzAtMS4zNzksMS4xMjEtMi41LDIuNS0yLjUgICAgYzEuMzc5LDAsMi41LDEuMTIxLDIuNSwyLjVDNTMsMzIuMzc5LDUxLjg3OSwzMy41LDUwLjUsMzMuNSIvPgoJCTxwYXRoIGlkPSJYTUxJRF8xNDFfIiBzdHlsZT0iZmlsbDojNkU4QzYxOyIgZD0iTTIyLDguOTc1Yy00LjE1NywyLjE2OS03LDYuNTEyLTcsMTEuNTI2YzAsNS4wMTMsMi44NDMsOS4zNTcsNywxMS41MjVWOC45NzV6Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzE0MF8iIHN0eWxlPSJmaWxsOiM2RThDNjE7IiBkPSJNMzQsOC45NzV2MjMuMDUxYzQuMTU3LTIuMTY4LDctNi41MTIsNy0xMS41MjVDNDEsMTUuNDg2LDM4LjE1NywxMS4xNDQsMzQsOC45NzUiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTM5XyIgeT0iNDguNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzOF8iIHg9IjM0IiB5PSI0OC41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTM3XyIgeT0iNDUuNSIgc3R5bGU9ImZpbGw6IzU0Njk0OTsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzNl8iIHg9IjM0IiB5PSI0NS41IiBzdHlsZT0iZmlsbDojNTQ2OTQ5OyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTM1XyIgeT0iNDIuNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzNF8iIHg9IjM0IiB5PSI0Mi41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTMzXyIgeT0iMzkuNSIgc3R5bGU9ImZpbGw6IzU0Njk0OTsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzMl8iIHg9IjM0IiB5PSIzOS41IiBzdHlsZT0iZmlsbDojNTQ2OTQ5OyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTMxXyIgeT0iMzYuNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzMF8iIHg9IjM0IiB5PSIzNi41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTI5XyIgeD0iMjIiIHk9IjQuNSIgc3R5bGU9ImZpbGw6I0QxRDREMjsiIHdpZHRoPSIxMiIgaGVpZ2h0PSIzMiIvPgoJCTxyZWN0IGlkPSJYTUxJRF8xMjhfIiB4PSIyMiIgeT0iMzYuNSIgc3R5bGU9ImZpbGw6I0E1QTVBNDsiIHdpZHRoPSIxMiIgaGVpZ2h0PSIxNSIvPgoJPC9nPgoJPHJlY3QgaWQ9IlhNTElEXzEyNl8iIHk9IjQuNSIgc3R5bGU9ImZpbGw6IzZFOEM2MTsiIHdpZHRoPSI1NiIgaGVpZ2h0PSIzMiIvPgoJPGcgaWQ9IlhNTElEXzEwNV8iPgoJCTxwYXRoIGlkPSJYTUxJRF8xMjVfIiBzdHlsZT0iZmlsbDojRTlFOEQzOyIgZD0iTTIxLjA5NCwzMS41QzE3LjQzOCwyOS4xOTksMTUsMjUuMTM5LDE1LDIwLjVjMC00LjYzOSwyLjQzOC04LjY5OSw2LjA5NC0xMSAgICBIMTAuOTc1QzEwLjk5LDkuNjY1LDExLDkuODMxLDExLDEwYzAsMy4wMzgtMi40NjMsNS41LTUuNSw1LjVjLTAuMTY5LDAtMC4zMzUtMC4wMS0wLjUtMC4wMjV2MTAuMDUgICAgQzUuMTY1LDI1LjUxLDUuMzMxLDI1LjUsNS41LDI1LjVjMy4wMzcsMCw1LjUsMi40NjIsNS41LDUuNWMwLDAuMTY5LTAuMDEsMC4zMzUtMC4wMjUsMC41SDIxLjA5NHoiLz4KCQk8cGF0aCBpZD0iWE1MSURfMTI0XyIgc3R5bGU9ImZpbGw6I0U5RThEMzsiIGQ9Ik01MC41LDE1LjVjLTMuMDM4LDAtNS41LTIuNDYyLTUuNS01LjVjMC0wLjE2OSwwLjAxLTAuMzM1LDAuMDI1LTAuNUgzNC45MDYgICAgQzM4LjU2MSwxMS44MDEsNDEsMTUuODYxLDQxLDIwLjVjMCw0LjYzOS0yLjQzOSw4LjY5OS02LjA5NCwxMWgxMC4xMTlDNDUuMDEsMzEuMzM1LDQ1LDMxLjE2OSw0NSwzMWMwLTMuMDM4LDIuNDYyLTUuNSw1LjUtNS41ICAgIGMwLjE2OSwwLDAuMzM1LDAuMDEsMC41LDAuMDI1di0xMC4wNUM1MC44MzUsMTUuNDksNTAuNjY5LDE1LjUsNTAuNSwxNS41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzEyM18iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNS41LDEyLjVDNC4xMjEsMTIuNSwzLDExLjM3OSwzLDEwczEuMTIxLTIuNSwyLjUtMi41QzYuODc5LDcuNSw4LDguNjIxLDgsMTAgICAgUzYuODc5LDEyLjUsNS41LDEyLjUiLz4KCQk8cGF0aCBpZD0iWE1MSURfMTIyXyIgc3R5bGU9ImZpbGw6I0U5RThEMzsiIGQ9Ik01MC41LDEyLjVjLTEuMzc5LDAtMi41LTEuMTIxLTIuNS0yLjVzMS4xMjEtMi41LDIuNS0yLjUgICAgYzEuMzc5LDAsMi41LDEuMTIxLDIuNSwyLjVTNTEuODc5LDEyLjUsNTAuNSwxMi41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzEyMV8iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNS41LDMzLjVDNC4xMjEsMzMuNSwzLDMyLjM3OSwzLDMxYzAtMS4zNzksMS4xMjEtMi41LDIuNS0yLjUgICAgQzYuODc5LDI4LjUsOCwyOS42MjEsOCwzMUM4LDMyLjM3OSw2Ljg3OSwzMy41LDUuNSwzMy41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzEyMF8iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNTAuNSwzMy41Yy0xLjM3OSwwLTIuNS0xLjEyMS0yLjUtMi41YzAtMS4zNzksMS4xMjEtMi41LDIuNS0yLjUgICAgYzEuMzc5LDAsMi41LDEuMTIxLDIuNSwyLjVDNTMsMzIuMzc5LDUxLjg3OSwzMy41LDUwLjUsMzMuNSIvPgoJCTxwYXRoIGlkPSJYTUxJRF8xMTlfIiBzdHlsZT0iZmlsbDojNkU4QzYxOyIgZD0iTTIyLDguOTc1Yy00LjE1NywyLjE2OS03LDYuNTEyLTcsMTEuNTI2YzAsNS4wMTMsMi44NDMsOS4zNTcsNywxMS41MjVWOC45NzV6Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzExOF8iIHN0eWxlPSJmaWxsOiM2RThDNjE7IiBkPSJNMzQsOC45NzV2MjMuMDUxYzQuMTU3LTIuMTY4LDctNi41MTIsNy0xMS41MjVDNDEsMTUuNDg2LDM4LjE1NywxMS4xNDQsMzQsOC45NzUiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTE3XyIgeT0iNDguNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzExNl8iIHg9IjM0IiB5PSI0OC41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTE1XyIgeT0iNDUuNSIgc3R5bGU9ImZpbGw6IzU0Njk0OTsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzExNF8iIHg9IjM0IiB5PSI0NS41IiBzdHlsZT0iZmlsbDojNTQ2OTQ5OyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTEzXyIgeT0iNDIuNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzExMl8iIHg9IjM0IiB5PSI0Mi41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTExXyIgeT0iMzkuNSIgc3R5bGU9ImZpbGw6IzU0Njk0OTsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzExMF8iIHg9IjM0IiB5PSIzOS41IiBzdHlsZT0iZmlsbDojNTQ2OTQ5OyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTA5XyIgeT0iMzYuNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEwOF8iIHg9IjM0IiB5PSIzNi41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTA3XyIgeD0iMjIiIHk9IjQuNSIgc3R5bGU9ImZpbGw6I0QxRDREMjsiIHdpZHRoPSIxMiIgaGVpZ2h0PSIzMiIvPgoJCTxyZWN0IGlkPSJYTUxJRF8xMDZfIiB4PSIyMiIgeT0iMzYuNSIgc3R5bGU9ImZpbGw6I0E1QTVBNDsiIHdpZHRoPSIxMiIgaGVpZ2h0PSIxNSIvPgoJPC9nPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" />  ฟอร์มขอถอนเงิน </span> </div>
                <div class="da-panel-content da-form-container">
                    <form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL ?>member_transfer_money_history<?php echo ($customer->GetPrimary() != '') ? '&action=edit&id=' . $customer->GetPrimary() : ''; ?>" method="post" class="da-form">
    <?php if ($customer->GetPrimary() != ''): ?>


                            <input type="hidden" name="customer_id" value="<?php echo $customer->GetValue('id') ?>" />

    <?php endif; ?>
                        <div class="da-form-inline">

                            <fieldset>
                                <legend><b>ถอนเงิน</b></legend>
                                <div class="span12">
                                    <div class="da-form-row">
                                        <label class="da-form-label">ถอนเงินจำนวน (บาท) <span class="required">*</span></label>
                                        <div class="da-form-item large">

                                            <input type="text" name="total" value="<?= $total_transfer ?>" class="span12 number required"/>
                                            <p><label class=" help-block"> ยอดถอนเงินขั้นต่ำ 500.00 บาทขึ้นไป </label></p>
                                            <p><em>*</em><label class=" help-block"> <b> ถ้าไม่ต้องการถอนเงินหรือจะยกเลิกการถอนเงินให้ใส่เครื่องหมาย (-) เฉพาะกรณีที่ admin ยังไม่ได้โอนให้</b></label></p>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>
                            <fieldset>
                                <legend><b><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCIgdmlld0JveD0iMCAwIDQyMC44MjcgNDIwLjgyNyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDIwLjgyNyA0MjAuODI3OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTIxMC4yOSwwQzE1NiwwLDEwNC40MywyMC42OTMsNjUuMDc3LDU4LjI2OUMyNS44NTksOTUuNzE1LDIuNzk0LDE0Ni4wMjIsMC4xMzQsMTk5LjkyMSAgICBjLTAuMTM1LDIuNzM0LDAuODU3LDUuNDA0LDIuNzQ0LDcuMzg4YzEuODg5LDEuOTgzLDQuNTA3LDMuMTA1LDcuMjQ0LDMuMTA1aDQ1LjIxMWM1LjI3NSwwLDkuNjQ0LTQuMDk4LDkuOTc5LTkuMzYyICAgIGM0Ljg3MS03Ni4yMTQsNjguNTUzLTEzNS45MTQsMTQ0Ljk3OS0xMzUuOTE0YzgwLjEwNSwwLDE0NS4yNzUsNjUuMTcxLDE0NS4yNzUsMTQ1LjI3NmMwLDgwLjEwNS02NS4xNywxNDUuMjc2LTE0NS4yNzUsMTQ1LjI3NiAgICBjLTE4LjEwOSwwLTM1Ljc3Mi0zLjI4Ny01Mi41MDEtOS43NzFsMTcuMzY2LTE1LjQyNWMyLjY4Ni0yLjM1NCwzLjkxMi01Ljk2NCwzLjIxNy05LjQ2OGMtMC42OTYtMy41MDYtMy4yMDktNi4zNzEtNi41OTItNy41MjEgICAgbC0xMTMtMzIuNTUyYy0zLjM4Ny0xLjE0OS03LjEyMi0wLjQwNy05LjgxLDEuOTQ4Yy0yLjY4NiwyLjM1NC0zLjkxMyw1Ljk2My0zLjIxOCw5LjQ2N0w2OS43MSw0MDMuMTU3ICAgIGMwLjY5NiwzLjUwNSwzLjIwOSw2LjM3Miw2LjU5MSw3LjUyMWMzLjM4MywxLjE0Nyw3LjEyMiwwLjQwOCw5LjgxLTEuOTQ2bDE4LjU5OS0xNi4yOTggICAgYzMxLjk0NiwxOC41NzQsNjguNDU2LDI4LjM5NCwxMDUuNTgxLDI4LjM5NGMxMTYuMDIxLDAsMjEwLjQxNC05NC4zOTIsMjEwLjQxNC0yMTAuNDE0QzQyMC43MDUsOTQuMzkxLDMyNi4zMTIsMCwyMTAuMjksMHoiIGZpbGw9IiMwMDAwMDAiLz4KCQk8cGF0aCBkPSJNMTk1LjExMiwyMzcuOWgxMTguNWMyLjc1NywwLDUtMi4yNDIsNS01di0zMGMwLTIuNzU3LTIuMjQzLTUtNS01aC04My41di05MWMwLTIuNzU3LTIuMjQzLTUtNS01aC0zMCAgICBjLTIuNzU3LDAtNSwyLjI0My01LDV2MTI2QzE5MC4xMTIsMjM1LjY1OCwxOTIuMzU1LDIzNy45LDE5NS4xMTIsMjM3Ljl6IiBmaWxsPSIjMDAwMDAwIi8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" width="20" height="20"/>&nbsp;&nbsp;สถานะการขอถอนเงิน ล่าสุด</b></legend>
                                <div class="da-form-row">
                                    <label class="da-form-label">จำนวน (บาท) <span class="required"></span></label>
                                    <div class="da-form-item large">
                                        <label><b><?= $total_transfer_last ?></b></label>
                                    </div>
                                </div>
                                <div class="da-form-row " style="<?=$bg?>">
                                    <label class="da-form-label">สถานะ <span class="required"></span></label>
                                    <div class="da-form-item large">
                                        <label><b><?= $status_transfer_last ?></b></label>
                                    </div>
                                </div>
                            </fieldset>

                        </div>
                        <div class="btn-row">


                            <button type="submit" name="submit_bt" class="btn btn-success" value="บันทึกข้อมูล">บันทึกข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="row-fluid">
        <div class="span6">
    <?php
    // Report errors to the user
    Alert2(GetAlert('error'));

    Alert2(GetAlert('success'), 'success');
    ?>
            <div class="da-panel collapsible">
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-grid"></i> เงินที่ได้รับ </span> </div>
                <div class="da-panel-toolbar">
                    <div class="btn-toolbar">
                        <div class="btn-group">

                        </div>
                    </div>
                </div>
                <div class="da-panel-content da-table-container">
                    <table id="da-ex-datatable-sort" class="da-table" sort="0" order="asc" width="100%">
                        <thead>
                            <tr style="font-size: 12px">
                                <th>ลำดับ</th>

                                <th>ดำเนินการ</th>
                                <th>จำนวน (บาท)</th>
                                <th>วันที่ดำเนินการ</th>

                            </tr>
                        </thead> 
                        <tbody>
    <?php
    //   $sql = "SELECT * FROM " . $orders->getTbl() . " WHERE status ='ชำระเงินแล้ว' AND customer_id = " . $_SESSION['admin_id'];
    $sql = "SELECT * FROM " . $orders->getTbl() . " WHERE status ='ชำระเงินแล้ว' ORDER BY id DESC";
    $query_income = $db->Query($sql);

    $total_receive_money = 0;
    $no = 1;
    while ($row = $db->FetchArray($query_income)) {
        // $bg = $row['status'] == 'รับปันผล' ? 'background-color: rgba(165, 240, 105, 0.42);' : 'background-color: rgba(240, 105, 105, 0.42);';

        $customer_id = $row['customer_id'];
//$arr = array();
        if ($customer_id != 0) {


            for ($i = 1; $i <= 10; $i++) {

                if ($i == 1) {

                    $customer_refer_id = $customer->getDataDesc("customer_refer_id", "id = " . $customer_id);
                    $customer_head_id = $customer_refer_id;
                    if ($customer_head_id != 0) {

                        $arr[] = $customer_head_id;
                    }
                } else {

                    if ($customer_head_id != '') {

                        $customer_refer_id = $customer->getDataDesc("customer_refer_id", "id = " . $customer_head_id);
                        $customer_head_id = $customer_refer_id;
                        if ($customer_head_id != 0) {
                            $arr[] = $customer_head_id;
                        }
                    }
                }
            }


            // $res_income = array_search($_SESSION['admin_id'], $arr); // $key = 2; 
//$key = array_search('red', $arr);   // $key = 1;
            //   print_r($arr);
            //  die();
            if (in_array($_SESSION['admin_id'], $arr)) {

                if ($arr[0] == $_SESSION['admin_id']) {
                    $receive_money = 200;
                } else {
                    $receive_money = 100;
                }
            }

            $receive_money = 0;


            if (in_array($_SESSION['admin_id'], $arr)) {

                if ($arr[0] == $_SESSION['admin_id']) {
                    //ได้ 200 ชั้น แรก
                    $receive_money = 200;
                } else {
                    //ได้ 100 
                    $receive_money = 100;
                }

                $total_receive_money = $total_receive_money + $receive_money;
                ?>

                                        <tr class="" style="background-color: rgba(165, 240, 105, 0.42);">
                                            <td class="center" width="" style="font-size: 12px;"><?= $no++ ?></td>
                                            <td class="center" style="font-size: 12px">รับเงิน</td>
                                            <td class="center" style="font-size: 12px"><?= $receive_money ?></td>

                                            <td class="center"  style="font-size: 12px"><?= $row['paid_date'] ?></td>
                                        </tr>                   

            <?php } ?>

                                <?php } ?>

                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <div class="span6">
    <?php
    // Report errors to the user
    Alert2(GetAlert('error'));

    Alert2(GetAlert('success'), 'success');
    ?>
            <div class="da-panel collapsible">
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-grid"></i> ประวัติการถอนเงิน</span> </div>
                <div class="da-panel-toolbar">
                    <div class="btn-toolbar">
                        <div class="btn-group">

                        </div>
                    </div>
                </div>
                <div class="da-panel-content da-table-container">
                    <table id="da-ex-datatable-sort" class="da-table" sort="0" order="asc" width="100%">
                        <thead>
                            <tr style="font-size: 12px">
                                <th>ลำดับ</th>

                                <th>ดำเนินการ</th>
                                <th>จำนวน (บาท)</th>
                                <th>วันที่ดำเนินการ</th>

                            </tr>
                        </thead> 
                        <tbody>
    <?php
    $i = 1;
    $draw_money = 0;
    while ($row = $db->FetchArray($query_history2)) {
        //  $bg = $row['status'] == 'รับปันผล' ? 'background-color: rgba(165, 240, 105, 0.42);' : 'background-color: rgba(240, 105, 105, 0.42);';
        $draw_money = $draw_money + $row['total'];
        ?> 
                                <tr class="" style="background-color: rgba(240, 105, 105, 0.42);">
                                    <td class="center" width="" style="font-size: 12px;"><?= $i++ ?></td>
                                    <td class="center" style="font-size: 12px"><?php echo $row['status'] == 'โอนแล้ว' ? 'ถอนเงิน' : $row['status'] ?></td>
                                    <td class="center" style="font-size: 12px"><?php echo $row['status'] == 'โอนแล้ว' ? '- ' : '' ?><?php echo $row['total'] ?></td>

                                    <td class="center"  style="font-size: 12px"><?php echo $row['transfer_date'] ?></td>
                                </tr>

    <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <input type="hidden" id="money_balance" value="<?= $total_receive_money - $draw_money ?>">

<script>
    $('document').ready(function () {

        var money_balance = $('#money_balance').val();
        $('#main_money_balance').val(money_balance);

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
    .bg-xx{
        background-color: rgba(255, 10, 2, 0.34);
    }
</style>

