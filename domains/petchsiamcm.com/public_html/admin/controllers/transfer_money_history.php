
<?php
if ($_POST['submit_bt'] == 'บันทึกข้อมูล' || $_POST['submit_bt'] == 'บันทึกข้อมูล และแก้ไขต่อ') {



    if ($_POST['submit_bt'] == 'บันทึกข้อมูล') {


        $redirect = true;
    } else {


        $redirect = false;
    }


    $arrData = array();


    $arrData = $functions->replaceQuote($_POST);

    if ($arrData['ref'] != "") {

        $arrData['product_name_ref'] = $functions->seoTitle($arrData['ref']);
    } else {

        $arrData['product_name_ref'] = $functions->seoTitle($arrData['product_name']);
    }

    $customer->SetValues($arrData);

    if ($customer->GetPrimary() == '') {

        $customer->SetValue('created_at', DATE_TIME);

        $customer->SetValue('updated_at', DATE_TIME);
    } else {

        $customer->SetValue('updated_at', DATE_TIME);
    }

    $customer->SetValue('login_password', $functions->encode_login($_POST['login_password']));

    $customer->SetValue('precode', 'pcsc');
    $customer->SetValue('customer_refer_id', $customer_id);


    if ($customer->Save()) {



        SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success');

        if ($redirect) {

            header('location:' . ADDRESS_ADMIN_CONTROL . 'customer');

            die();
        } else {

            header('location:' . ADDRESS_ADMIN_CONTROL . 'customer&action=edit&id=' . $customer->GetPrimary());

            die();
        }
    } else {

        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}


if ($_GET['id'] != '' && $_GET['action'] == 'del') {


    // Get all the form data
    ///$arrDel = array('id' => $_GET['id']);
    //$customer->SetValues($arrDel);
    // Remove the info from the DB


    if ($customer->DeleteMultiID($_GET['id'])) {


        // Set alert and redirect


        SetAlert('Delete Data Success', 'success');


        header('location:' . ADDRESS_ADMIN_CONTROL . 'customer');


        die();
    } else {


        SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}


if ($_GET['id'] != '' && $_GET['action'] == 'edit') {

// For Update
// 
    $customer->SetPrimary((int) $_GET['id']);

    // Try to get the information

    if (!$customer->GetInfo()) {

        SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');

        $customer->ResetValues();
    }

    $sql = "SELECT * FROM " . $transfer_money->getTbl() . " WHERE status = 'โอนแล้ว' AND customer_id = " . $_GET['id'] . " ORDER BY id DESC";

    $query_history = $db->Query($sql);
    $query_history2 = $db->Query($sql);
}
?>
<?php if ($_GET['action'] == "add" || $_GET['action'] == "edit") { ?>
    <!--detail-->

    <div class="row-fluid">
        <div class="span12">
            <?php
// Report errors to the user
            Alert2(GetAlert('error'));

            Alert2(GetAlert('success'), 'success');
            ?>
            <div class="da-panel collapsible">
                <div class="da-panel-header"> <span class="da-panel-title"> <img width="20" height="20" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDU2IDU2IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1NiA1NjsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxnIGlkPSJYTUxJRF8xNF8iPgoJPGcgaWQ9IlhNTElEXzEyN18iPgoJCTxwYXRoIGlkPSJYTUxJRF8xNDdfIiBzdHlsZT0iZmlsbDojRTlFOEQzOyIgZD0iTTIxLjA5NCwzMS41QzE3LjQzOCwyOS4xOTksMTUsMjUuMTM5LDE1LDIwLjVjMC00LjYzOSwyLjQzOC04LjY5OSw2LjA5NC0xMSAgICBIMTAuOTc1QzEwLjk5LDkuNjY1LDExLDkuODMxLDExLDEwYzAsMy4wMzgtMi40NjMsNS41LTUuNSw1LjVjLTAuMTY5LDAtMC4zMzUtMC4wMS0wLjUtMC4wMjV2MTAuMDUgICAgQzUuMTY1LDI1LjUxLDUuMzMxLDI1LjUsNS41LDI1LjVjMy4wMzcsMCw1LjUsMi40NjIsNS41LDUuNWMwLDAuMTY5LTAuMDEsMC4zMzUtMC4wMjUsMC41SDIxLjA5NHoiLz4KCQk8cGF0aCBpZD0iWE1MSURfMTQ2XyIgc3R5bGU9ImZpbGw6I0U5RThEMzsiIGQ9Ik01MC41LDE1LjVjLTMuMDM4LDAtNS41LTIuNDYyLTUuNS01LjVjMC0wLjE2OSwwLjAxLTAuMzM1LDAuMDI1LTAuNUgzNC45MDYgICAgQzM4LjU2MSwxMS44MDEsNDEsMTUuODYxLDQxLDIwLjVjMCw0LjYzOS0yLjQzOSw4LjY5OS02LjA5NCwxMWgxMC4xMTlDNDUuMDEsMzEuMzM1LDQ1LDMxLjE2OSw0NSwzMWMwLTMuMDM4LDIuNDYyLTUuNSw1LjUtNS41ICAgIGMwLjE2OSwwLDAuMzM1LDAuMDEsMC41LDAuMDI1di0xMC4wNUM1MC44MzUsMTUuNDksNTAuNjY5LDE1LjUsNTAuNSwxNS41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzE0NV8iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNS41LDEyLjVDNC4xMjEsMTIuNSwzLDExLjM3OSwzLDEwczEuMTIxLTIuNSwyLjUtMi41QzYuODc5LDcuNSw4LDguNjIxLDgsMTAgICAgUzYuODc5LDEyLjUsNS41LDEyLjUiLz4KCQk8cGF0aCBpZD0iWE1MSURfMTQ0XyIgc3R5bGU9ImZpbGw6I0U5RThEMzsiIGQ9Ik01MC41LDEyLjVjLTEuMzc5LDAtMi41LTEuMTIxLTIuNS0yLjVzMS4xMjEtMi41LDIuNS0yLjUgICAgYzEuMzc5LDAsMi41LDEuMTIxLDIuNSwyLjVTNTEuODc5LDEyLjUsNTAuNSwxMi41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzE0M18iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNS41LDMzLjVDNC4xMjEsMzMuNSwzLDMyLjM3OSwzLDMxYzAtMS4zNzksMS4xMjEtMi41LDIuNS0yLjUgICAgQzYuODc5LDI4LjUsOCwyOS42MjEsOCwzMUM4LDMyLjM3OSw2Ljg3OSwzMy41LDUuNSwzMy41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzE0Ml8iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNTAuNSwzMy41Yy0xLjM3OSwwLTIuNS0xLjEyMS0yLjUtMi41YzAtMS4zNzksMS4xMjEtMi41LDIuNS0yLjUgICAgYzEuMzc5LDAsMi41LDEuMTIxLDIuNSwyLjVDNTMsMzIuMzc5LDUxLjg3OSwzMy41LDUwLjUsMzMuNSIvPgoJCTxwYXRoIGlkPSJYTUxJRF8xNDFfIiBzdHlsZT0iZmlsbDojNkU4QzYxOyIgZD0iTTIyLDguOTc1Yy00LjE1NywyLjE2OS03LDYuNTEyLTcsMTEuNTI2YzAsNS4wMTMsMi44NDMsOS4zNTcsNywxMS41MjVWOC45NzV6Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzE0MF8iIHN0eWxlPSJmaWxsOiM2RThDNjE7IiBkPSJNMzQsOC45NzV2MjMuMDUxYzQuMTU3LTIuMTY4LDctNi41MTIsNy0xMS41MjVDNDEsMTUuNDg2LDM4LjE1NywxMS4xNDQsMzQsOC45NzUiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTM5XyIgeT0iNDguNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzOF8iIHg9IjM0IiB5PSI0OC41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTM3XyIgeT0iNDUuNSIgc3R5bGU9ImZpbGw6IzU0Njk0OTsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzNl8iIHg9IjM0IiB5PSI0NS41IiBzdHlsZT0iZmlsbDojNTQ2OTQ5OyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTM1XyIgeT0iNDIuNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzNF8iIHg9IjM0IiB5PSI0Mi41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTMzXyIgeT0iMzkuNSIgc3R5bGU9ImZpbGw6IzU0Njk0OTsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzMl8iIHg9IjM0IiB5PSIzOS41IiBzdHlsZT0iZmlsbDojNTQ2OTQ5OyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTMxXyIgeT0iMzYuNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzMF8iIHg9IjM0IiB5PSIzNi41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTI5XyIgeD0iMjIiIHk9IjQuNSIgc3R5bGU9ImZpbGw6I0QxRDREMjsiIHdpZHRoPSIxMiIgaGVpZ2h0PSIzMiIvPgoJCTxyZWN0IGlkPSJYTUxJRF8xMjhfIiB4PSIyMiIgeT0iMzYuNSIgc3R5bGU9ImZpbGw6I0E1QTVBNDsiIHdpZHRoPSIxMiIgaGVpZ2h0PSIxNSIvPgoJPC9nPgoJPHJlY3QgaWQ9IlhNTElEXzEyNl8iIHk9IjQuNSIgc3R5bGU9ImZpbGw6IzZFOEM2MTsiIHdpZHRoPSI1NiIgaGVpZ2h0PSIzMiIvPgoJPGcgaWQ9IlhNTElEXzEwNV8iPgoJCTxwYXRoIGlkPSJYTUxJRF8xMjVfIiBzdHlsZT0iZmlsbDojRTlFOEQzOyIgZD0iTTIxLjA5NCwzMS41QzE3LjQzOCwyOS4xOTksMTUsMjUuMTM5LDE1LDIwLjVjMC00LjYzOSwyLjQzOC04LjY5OSw2LjA5NC0xMSAgICBIMTAuOTc1QzEwLjk5LDkuNjY1LDExLDkuODMxLDExLDEwYzAsMy4wMzgtMi40NjMsNS41LTUuNSw1LjVjLTAuMTY5LDAtMC4zMzUtMC4wMS0wLjUtMC4wMjV2MTAuMDUgICAgQzUuMTY1LDI1LjUxLDUuMzMxLDI1LjUsNS41LDI1LjVjMy4wMzcsMCw1LjUsMi40NjIsNS41LDUuNWMwLDAuMTY5LTAuMDEsMC4zMzUtMC4wMjUsMC41SDIxLjA5NHoiLz4KCQk8cGF0aCBpZD0iWE1MSURfMTI0XyIgc3R5bGU9ImZpbGw6I0U5RThEMzsiIGQ9Ik01MC41LDE1LjVjLTMuMDM4LDAtNS41LTIuNDYyLTUuNS01LjVjMC0wLjE2OSwwLjAxLTAuMzM1LDAuMDI1LTAuNUgzNC45MDYgICAgQzM4LjU2MSwxMS44MDEsNDEsMTUuODYxLDQxLDIwLjVjMCw0LjYzOS0yLjQzOSw4LjY5OS02LjA5NCwxMWgxMC4xMTlDNDUuMDEsMzEuMzM1LDQ1LDMxLjE2OSw0NSwzMWMwLTMuMDM4LDIuNDYyLTUuNSw1LjUtNS41ICAgIGMwLjE2OSwwLDAuMzM1LDAuMDEsMC41LDAuMDI1di0xMC4wNUM1MC44MzUsMTUuNDksNTAuNjY5LDE1LjUsNTAuNSwxNS41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzEyM18iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNS41LDEyLjVDNC4xMjEsMTIuNSwzLDExLjM3OSwzLDEwczEuMTIxLTIuNSwyLjUtMi41QzYuODc5LDcuNSw4LDguNjIxLDgsMTAgICAgUzYuODc5LDEyLjUsNS41LDEyLjUiLz4KCQk8cGF0aCBpZD0iWE1MSURfMTIyXyIgc3R5bGU9ImZpbGw6I0U5RThEMzsiIGQ9Ik01MC41LDEyLjVjLTEuMzc5LDAtMi41LTEuMTIxLTIuNS0yLjVzMS4xMjEtMi41LDIuNS0yLjUgICAgYzEuMzc5LDAsMi41LDEuMTIxLDIuNSwyLjVTNTEuODc5LDEyLjUsNTAuNSwxMi41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzEyMV8iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNS41LDMzLjVDNC4xMjEsMzMuNSwzLDMyLjM3OSwzLDMxYzAtMS4zNzksMS4xMjEtMi41LDIuNS0yLjUgICAgQzYuODc5LDI4LjUsOCwyOS42MjEsOCwzMUM4LDMyLjM3OSw2Ljg3OSwzMy41LDUuNSwzMy41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzEyMF8iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNTAuNSwzMy41Yy0xLjM3OSwwLTIuNS0xLjEyMS0yLjUtMi41YzAtMS4zNzksMS4xMjEtMi41LDIuNS0yLjUgICAgYzEuMzc5LDAsMi41LDEuMTIxLDIuNSwyLjVDNTMsMzIuMzc5LDUxLjg3OSwzMy41LDUwLjUsMzMuNSIvPgoJCTxwYXRoIGlkPSJYTUxJRF8xMTlfIiBzdHlsZT0iZmlsbDojNkU4QzYxOyIgZD0iTTIyLDguOTc1Yy00LjE1NywyLjE2OS03LDYuNTEyLTcsMTEuNTI2YzAsNS4wMTMsMi44NDMsOS4zNTcsNywxMS41MjVWOC45NzV6Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzExOF8iIHN0eWxlPSJmaWxsOiM2RThDNjE7IiBkPSJNMzQsOC45NzV2MjMuMDUxYzQuMTU3LTIuMTY4LDctNi41MTIsNy0xMS41MjVDNDEsMTUuNDg2LDM4LjE1NywxMS4xNDQsMzQsOC45NzUiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTE3XyIgeT0iNDguNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzExNl8iIHg9IjM0IiB5PSI0OC41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTE1XyIgeT0iNDUuNSIgc3R5bGU9ImZpbGw6IzU0Njk0OTsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzExNF8iIHg9IjM0IiB5PSI0NS41IiBzdHlsZT0iZmlsbDojNTQ2OTQ5OyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTEzXyIgeT0iNDIuNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzExMl8iIHg9IjM0IiB5PSI0Mi41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTExXyIgeT0iMzkuNSIgc3R5bGU9ImZpbGw6IzU0Njk0OTsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzExMF8iIHg9IjM0IiB5PSIzOS41IiBzdHlsZT0iZmlsbDojNTQ2OTQ5OyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTA5XyIgeT0iMzYuNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEwOF8iIHg9IjM0IiB5PSIzNi41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTA3XyIgeD0iMjIiIHk9IjQuNSIgc3R5bGU9ImZpbGw6I0QxRDREMjsiIHdpZHRoPSIxMiIgaGVpZ2h0PSIzMiIvPgoJCTxyZWN0IGlkPSJYTUxJRF8xMDZfIiB4PSIyMiIgeT0iMzYuNSIgc3R5bGU9ImZpbGw6I0E1QTVBNDsiIHdpZHRoPSIxMiIgaGVpZ2h0PSIxNSIvPgoJPC9nPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" /><b> ข้อมูลสมาชิกรหัส <?= $customer->GetValue('precode') . $customer->GetValue('id') ?> </b></span> </div>
                <div class="da-panel-content da-form-container">
                    <form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL ?>transfer_money<?php echo ($transfer_money->GetPrimary() != '') ? '&action=edit&id=' . $transfer_money->GetPrimary() : ''; ?>" method="post" class="da-form">
                        <?php if ($transfer_money->GetPrimary() != ''): ?>
                            <input type="hidden" name="id" value="<?php echo $transfer_money->GetValue('id') ?>" />
                            <input type="hidden" name="transfer_date" value="<?php echo $transfer_money->GetValue('transfer_date') ?>" />
                            <input type="hidden" name="created_at" value="<?php echo $transfer_money->GetValue('created_at') ?>" />
                            <input type="hidden" name="customer_id" value="<?php echo $transfer_money->GetValue('customer_id') ?>" />

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
                            //   $sql = "SELECT * FROM " . $orders->getTbl() . " WHERE status ='ชำระเงินแล้ว' AND customer_id = " . $_GET['id'];
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


                                    // $res_income = array_search($_GET['id'], $arr); // $key = 2; 
//$key = array_search('red', $arr);   // $key = 1;

                                 //   print_r($arr);
                                  //  die();
                                    if (in_array($_GET['id'], $arr)) {

                                        if ($arr[0] == $_GET['id']) {
                                            $receive_money = 200;
                                        } else {
                                            $receive_money = 100;
                                        }
                                    }

                                    $receive_money = 0;


                                    if (in_array($_GET['id'], $arr)) {

                                        if ($arr[0] == $_GET['id']) {
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
<?php } else { ?>

    <div class="row-fluid">
        <div class="span12">
            <?php
            // Report errors to the user


            Alert2(GetAlert('error'));


            Alert2(GetAlert('success'), 'success');
            ?>
            <div class="da-panel collapsible">
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-grid"></i> ประวัติการถอนเงินของสมาชิก</span> </div>
                <div class="da-panel-toolbar">
                    <div class="btn-toolbar">
                        <div class="btn-group">

                        </div>
                    </div>
                </div>
                <div class="da-panel-content da-table-container">
                    <table id="da-ex-datatable-sort" class="da-table" sort="3" order="asc" width="1000">
                        <thead>
                            <tr style="font-size: 12px">
                                <th>ลำดับ</th>
                                <th>รหัสสมาชิก</th>
                                <th>ชื่อ</th>

                                <th>ตัวเลือก</th>
                            </tr>
                        </thead> 
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM " . $customer->getTbl();

                            $query = $db->Query($sql);

                            $i = 1;

                            while ($row = $db->FetchArray($query)) {
                                ?>
                                <tr>
                                    <td class="center" width="8%" style="font-size: 12px"><?= $i++ ?></td>
                                    <td class="center" style="font-size: 12px"><?php echo $row['precode'] . $row['id']; ?></td>
                                    <td style="font-size: 12px"><?php echo $row['customer_name'] . " " . $row['customer_lastname'] ?></td>


                                    <td class="center" style="font-size: 12px"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>transfer_money_history&action=edit&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-small">ดูประวัติ</a>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>



        function multi_delete() {

            var msg_id = "";
            var res = "";

            $('input:checkbox[id^="chkboxID"]:checked').each(function () {


                msg_id += ',' + $(this).val();
                res = msg_id.substring(1);


            });
            if (res != '') {
                if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                    document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>customer&action=del&id=' + res;
                }
            }

        }
        $('document').ready(function () {

            var money_balance = $('#money_balance').val();
            $('#main_money_balance').val(money_balance);

        });

    </script>
<?php } ?>
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

