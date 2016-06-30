
<?php
if ($_POST['submit_bt'] == 'บันทึกข้อมูลถอนเงิน') {





    if ($_POST['submit_bt'] == 'บันทึกข้อมูล') {


        $redirect = true;
    } else {


        $redirect = true;
    }


    $arrData = array();


    if ($_POST['status'] == 'โอนแล้ว') {


        $arrData = array(
            'updated_at' => DATE_TIME,
            'transfer_date' => DATE_TIME,
            'status' => $_POST['status']
        );
        
    }else{
        
        $arrData = array(
            'updated_at' => DATE_TIME,
            'transfer_date' => '0000-00-00 00:00:00',
            'status' => $_POST['status']
        );
    }



        if ($transfer_money->updateSQL($arrData, array('id' => $_POST['id']))) {


            SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success');

            if ($redirect) {

                header('location:' . ADDRESS_ADMIN_CONTROL . 'transfer_money');

                die();
            } else {

                header('location:' . ADDRESS_ADMIN_CONTROL . 'transfer_money&action=edit&id=' . $transfer_money->GetPrimary());

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


    if ($transfer_money->DeleteMultiID($_GET['id'])) {


        // Set alert and redirect


        SetAlert('Delete Data Success', 'success');


        header('location:' . ADDRESS_ADMIN_CONTROL . 'transfer_money');


        die();
    } else {


        SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}


if ($_GET['id'] != '' && $_GET['action'] == 'edit') {

    // For Update


    $transfer_money->SetPrimary((int) $_GET['id']);
    if (!$transfer_money->GetInfo()) {


        SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


        $transfer_money->ResetValues();
    }


    $customer->SetPrimary((int) $transfer_money->GetValue('customer_id'));
    if (!$customer->GetInfo()) {


        SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


        $customer->ResetValues();
    }
}
?> 
<?php if ($_GET['action'] == "add" || $_GET['action'] == "edit") { ?>
    <div class="row-fluid">
        <div class="span6">
            <?php
// Report errors to the user
            Alert2(GetAlert('error'));

            Alert2(GetAlert('success'), 'success');
            ?>
            <div class="da-panel collapsible">
                <div class="da-panel-header"> <span class="da-panel-title"> <img width="20" height="20" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDU2IDU2IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1NiA1NjsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxnIGlkPSJYTUxJRF8xNF8iPgoJPGcgaWQ9IlhNTElEXzEyN18iPgoJCTxwYXRoIGlkPSJYTUxJRF8xNDdfIiBzdHlsZT0iZmlsbDojRTlFOEQzOyIgZD0iTTIxLjA5NCwzMS41QzE3LjQzOCwyOS4xOTksMTUsMjUuMTM5LDE1LDIwLjVjMC00LjYzOSwyLjQzOC04LjY5OSw2LjA5NC0xMSAgICBIMTAuOTc1QzEwLjk5LDkuNjY1LDExLDkuODMxLDExLDEwYzAsMy4wMzgtMi40NjMsNS41LTUuNSw1LjVjLTAuMTY5LDAtMC4zMzUtMC4wMS0wLjUtMC4wMjV2MTAuMDUgICAgQzUuMTY1LDI1LjUxLDUuMzMxLDI1LjUsNS41LDI1LjVjMy4wMzcsMCw1LjUsMi40NjIsNS41LDUuNWMwLDAuMTY5LTAuMDEsMC4zMzUtMC4wMjUsMC41SDIxLjA5NHoiLz4KCQk8cGF0aCBpZD0iWE1MSURfMTQ2XyIgc3R5bGU9ImZpbGw6I0U5RThEMzsiIGQ9Ik01MC41LDE1LjVjLTMuMDM4LDAtNS41LTIuNDYyLTUuNS01LjVjMC0wLjE2OSwwLjAxLTAuMzM1LDAuMDI1LTAuNUgzNC45MDYgICAgQzM4LjU2MSwxMS44MDEsNDEsMTUuODYxLDQxLDIwLjVjMCw0LjYzOS0yLjQzOSw4LjY5OS02LjA5NCwxMWgxMC4xMTlDNDUuMDEsMzEuMzM1LDQ1LDMxLjE2OSw0NSwzMWMwLTMuMDM4LDIuNDYyLTUuNSw1LjUtNS41ICAgIGMwLjE2OSwwLDAuMzM1LDAuMDEsMC41LDAuMDI1di0xMC4wNUM1MC44MzUsMTUuNDksNTAuNjY5LDE1LjUsNTAuNSwxNS41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzE0NV8iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNS41LDEyLjVDNC4xMjEsMTIuNSwzLDExLjM3OSwzLDEwczEuMTIxLTIuNSwyLjUtMi41QzYuODc5LDcuNSw4LDguNjIxLDgsMTAgICAgUzYuODc5LDEyLjUsNS41LDEyLjUiLz4KCQk8cGF0aCBpZD0iWE1MSURfMTQ0XyIgc3R5bGU9ImZpbGw6I0U5RThEMzsiIGQ9Ik01MC41LDEyLjVjLTEuMzc5LDAtMi41LTEuMTIxLTIuNS0yLjVzMS4xMjEtMi41LDIuNS0yLjUgICAgYzEuMzc5LDAsMi41LDEuMTIxLDIuNSwyLjVTNTEuODc5LDEyLjUsNTAuNSwxMi41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzE0M18iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNS41LDMzLjVDNC4xMjEsMzMuNSwzLDMyLjM3OSwzLDMxYzAtMS4zNzksMS4xMjEtMi41LDIuNS0yLjUgICAgQzYuODc5LDI4LjUsOCwyOS42MjEsOCwzMUM4LDMyLjM3OSw2Ljg3OSwzMy41LDUuNSwzMy41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzE0Ml8iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNTAuNSwzMy41Yy0xLjM3OSwwLTIuNS0xLjEyMS0yLjUtMi41YzAtMS4zNzksMS4xMjEtMi41LDIuNS0yLjUgICAgYzEuMzc5LDAsMi41LDEuMTIxLDIuNSwyLjVDNTMsMzIuMzc5LDUxLjg3OSwzMy41LDUwLjUsMzMuNSIvPgoJCTxwYXRoIGlkPSJYTUxJRF8xNDFfIiBzdHlsZT0iZmlsbDojNkU4QzYxOyIgZD0iTTIyLDguOTc1Yy00LjE1NywyLjE2OS03LDYuNTEyLTcsMTEuNTI2YzAsNS4wMTMsMi44NDMsOS4zNTcsNywxMS41MjVWOC45NzV6Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzE0MF8iIHN0eWxlPSJmaWxsOiM2RThDNjE7IiBkPSJNMzQsOC45NzV2MjMuMDUxYzQuMTU3LTIuMTY4LDctNi41MTIsNy0xMS41MjVDNDEsMTUuNDg2LDM4LjE1NywxMS4xNDQsMzQsOC45NzUiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTM5XyIgeT0iNDguNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzOF8iIHg9IjM0IiB5PSI0OC41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTM3XyIgeT0iNDUuNSIgc3R5bGU9ImZpbGw6IzU0Njk0OTsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzNl8iIHg9IjM0IiB5PSI0NS41IiBzdHlsZT0iZmlsbDojNTQ2OTQ5OyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTM1XyIgeT0iNDIuNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzNF8iIHg9IjM0IiB5PSI0Mi41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTMzXyIgeT0iMzkuNSIgc3R5bGU9ImZpbGw6IzU0Njk0OTsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzMl8iIHg9IjM0IiB5PSIzOS41IiBzdHlsZT0iZmlsbDojNTQ2OTQ5OyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTMxXyIgeT0iMzYuNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEzMF8iIHg9IjM0IiB5PSIzNi41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTI5XyIgeD0iMjIiIHk9IjQuNSIgc3R5bGU9ImZpbGw6I0QxRDREMjsiIHdpZHRoPSIxMiIgaGVpZ2h0PSIzMiIvPgoJCTxyZWN0IGlkPSJYTUxJRF8xMjhfIiB4PSIyMiIgeT0iMzYuNSIgc3R5bGU9ImZpbGw6I0E1QTVBNDsiIHdpZHRoPSIxMiIgaGVpZ2h0PSIxNSIvPgoJPC9nPgoJPHJlY3QgaWQ9IlhNTElEXzEyNl8iIHk9IjQuNSIgc3R5bGU9ImZpbGw6IzZFOEM2MTsiIHdpZHRoPSI1NiIgaGVpZ2h0PSIzMiIvPgoJPGcgaWQ9IlhNTElEXzEwNV8iPgoJCTxwYXRoIGlkPSJYTUxJRF8xMjVfIiBzdHlsZT0iZmlsbDojRTlFOEQzOyIgZD0iTTIxLjA5NCwzMS41QzE3LjQzOCwyOS4xOTksMTUsMjUuMTM5LDE1LDIwLjVjMC00LjYzOSwyLjQzOC04LjY5OSw2LjA5NC0xMSAgICBIMTAuOTc1QzEwLjk5LDkuNjY1LDExLDkuODMxLDExLDEwYzAsMy4wMzgtMi40NjMsNS41LTUuNSw1LjVjLTAuMTY5LDAtMC4zMzUtMC4wMS0wLjUtMC4wMjV2MTAuMDUgICAgQzUuMTY1LDI1LjUxLDUuMzMxLDI1LjUsNS41LDI1LjVjMy4wMzcsMCw1LjUsMi40NjIsNS41LDUuNWMwLDAuMTY5LTAuMDEsMC4zMzUtMC4wMjUsMC41SDIxLjA5NHoiLz4KCQk8cGF0aCBpZD0iWE1MSURfMTI0XyIgc3R5bGU9ImZpbGw6I0U5RThEMzsiIGQ9Ik01MC41LDE1LjVjLTMuMDM4LDAtNS41LTIuNDYyLTUuNS01LjVjMC0wLjE2OSwwLjAxLTAuMzM1LDAuMDI1LTAuNUgzNC45MDYgICAgQzM4LjU2MSwxMS44MDEsNDEsMTUuODYxLDQxLDIwLjVjMCw0LjYzOS0yLjQzOSw4LjY5OS02LjA5NCwxMWgxMC4xMTlDNDUuMDEsMzEuMzM1LDQ1LDMxLjE2OSw0NSwzMWMwLTMuMDM4LDIuNDYyLTUuNSw1LjUtNS41ICAgIGMwLjE2OSwwLDAuMzM1LDAuMDEsMC41LDAuMDI1di0xMC4wNUM1MC44MzUsMTUuNDksNTAuNjY5LDE1LjUsNTAuNSwxNS41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzEyM18iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNS41LDEyLjVDNC4xMjEsMTIuNSwzLDExLjM3OSwzLDEwczEuMTIxLTIuNSwyLjUtMi41QzYuODc5LDcuNSw4LDguNjIxLDgsMTAgICAgUzYuODc5LDEyLjUsNS41LDEyLjUiLz4KCQk8cGF0aCBpZD0iWE1MSURfMTIyXyIgc3R5bGU9ImZpbGw6I0U5RThEMzsiIGQ9Ik01MC41LDEyLjVjLTEuMzc5LDAtMi41LTEuMTIxLTIuNS0yLjVzMS4xMjEtMi41LDIuNS0yLjUgICAgYzEuMzc5LDAsMi41LDEuMTIxLDIuNSwyLjVTNTEuODc5LDEyLjUsNTAuNSwxMi41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzEyMV8iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNS41LDMzLjVDNC4xMjEsMzMuNSwzLDMyLjM3OSwzLDMxYzAtMS4zNzksMS4xMjEtMi41LDIuNS0yLjUgICAgQzYuODc5LDI4LjUsOCwyOS42MjEsOCwzMUM4LDMyLjM3OSw2Ljg3OSwzMy41LDUuNSwzMy41Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzEyMF8iIHN0eWxlPSJmaWxsOiNFOUU4RDM7IiBkPSJNNTAuNSwzMy41Yy0xLjM3OSwwLTIuNS0xLjEyMS0yLjUtMi41YzAtMS4zNzksMS4xMjEtMi41LDIuNS0yLjUgICAgYzEuMzc5LDAsMi41LDEuMTIxLDIuNSwyLjVDNTMsMzIuMzc5LDUxLjg3OSwzMy41LDUwLjUsMzMuNSIvPgoJCTxwYXRoIGlkPSJYTUxJRF8xMTlfIiBzdHlsZT0iZmlsbDojNkU4QzYxOyIgZD0iTTIyLDguOTc1Yy00LjE1NywyLjE2OS03LDYuNTEyLTcsMTEuNTI2YzAsNS4wMTMsMi44NDMsOS4zNTcsNywxMS41MjVWOC45NzV6Ii8+CgkJPHBhdGggaWQ9IlhNTElEXzExOF8iIHN0eWxlPSJmaWxsOiM2RThDNjE7IiBkPSJNMzQsOC45NzV2MjMuMDUxYzQuMTU3LTIuMTY4LDctNi41MTIsNy0xMS41MjVDNDEsMTUuNDg2LDM4LjE1NywxMS4xNDQsMzQsOC45NzUiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTE3XyIgeT0iNDguNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzExNl8iIHg9IjM0IiB5PSI0OC41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTE1XyIgeT0iNDUuNSIgc3R5bGU9ImZpbGw6IzU0Njk0OTsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzExNF8iIHg9IjM0IiB5PSI0NS41IiBzdHlsZT0iZmlsbDojNTQ2OTQ5OyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTEzXyIgeT0iNDIuNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzExMl8iIHg9IjM0IiB5PSI0Mi41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTExXyIgeT0iMzkuNSIgc3R5bGU9ImZpbGw6IzU0Njk0OTsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzExMF8iIHg9IjM0IiB5PSIzOS41IiBzdHlsZT0iZmlsbDojNTQ2OTQ5OyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTA5XyIgeT0iMzYuNSIgc3R5bGU9ImZpbGw6IzYwN0I1MzsiIHdpZHRoPSIyMiIgaGVpZ2h0PSIzIi8+CgkJPHJlY3QgaWQ9IlhNTElEXzEwOF8iIHg9IjM0IiB5PSIzNi41IiBzdHlsZT0iZmlsbDojNjA3QjUzOyIgd2lkdGg9IjIyIiBoZWlnaHQ9IjMiLz4KCQk8cmVjdCBpZD0iWE1MSURfMTA3XyIgeD0iMjIiIHk9IjQuNSIgc3R5bGU9ImZpbGw6I0QxRDREMjsiIHdpZHRoPSIxMiIgaGVpZ2h0PSIzMiIvPgoJCTxyZWN0IGlkPSJYTUxJRF8xMDZfIiB4PSIyMiIgeT0iMzYuNSIgc3R5bGU9ImZpbGw6I0E1QTVBNDsiIHdpZHRoPSIxMiIgaGVpZ2h0PSIxNSIvPgoJPC9nPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" />  ถอนเงิน </span> </div>
                <div class="da-panel-content da-form-container">
                    <form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL ?>transfer_money<?php echo ($transfer_money->GetPrimary() != '') ? '&action=edit&id=' . $transfer_money->GetPrimary() : ''; ?>" method="post" class="da-form">
                        <?php if ($transfer_money->GetPrimary() != ''): ?>
                       
                     
                            <input type="hidden" name="id" value="<?php echo $transfer_money->GetValue('id') ?>" />

                        <?php endif; ?>
                        <div class="da-form-inline">

                            <fieldset>
                                <legend><b>ถอนเงิน</b></legend>
                                <div class="span12">
                                    <div class="da-form-row">
                                        <label class="da-form-label">ถอนเงินจำนวน (บาท) <span class="required">*</span></label>
                                        <div class="da-form-item large">
                                            <input type="text" name="total" disabled="" value="<?php echo ($transfer_money->GetPrimary() != '') ? $transfer_money->GetValue('total') : ''; ?>" class="span12 required number"/>
                                            <label class=" help-block"> ยอดถอนเงินขั้นต่ำ 500.00 บาทขึ้นไป </label>
                                        </div>
                                    </div>
                                </div> 

                            </fieldset>
                            <fieldset>
                                <legend><b>สถานะการโอน</b></legend>
                                <div class="da-form-row">
                                    <label class="da-form-label">สถานะ <span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <ul class="da-form-list">
                                            <?php
                                            $getStatus = $transfer_money->get_enum_values('status');

                                            $i = 1;

                                            foreach ($getStatus as $status) {
                                                if ($status != 'รับปันผล') {
                                                    ?>
                                                    <li>
                                                        <input type="radio" name="status" id="status" value="<?php echo $status ?>" <?php echo ($transfer_money->GetPrimary() != "") ? ($transfer_money->GetValue('status') == $status) ? "checked=\"checked\"" : "" : ($i == 1) ? "checked=\"checked\"" : "" ?> class="required"/>
                                                        <label><?php echo $status ?></label>
                                                    </li>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </fieldset>

                        </div>
                        <div class="btn-row">


                            <button type="submit" name="submit_bt" class="btn btn-success" value="บันทึกข้อมูลถอนเงิน">บันทึกข้อมูล</button>

                    </form>
                </div>
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
            <div class="da-panel-header"><b> <span class="da-panel-title"> <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCIgdmlld0JveD0iMCAwIDM5NCAzOTQiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDM5NCAzOTQ7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNMzQ0LDg1Ljc1SDIzOS43NzlWNzEuMDI5YzAtMjMuNTg4LTE5LjE5MS00Mi43NzktNDIuNzc5LTQyLjc3OXMtNDIuNzc5LDE5LjE5MS00Mi43NzksNDIuNzc5Vjg1Ljc1SDUwICAgIGMtMjcuNjE0LDAtNTAsMjIuMzg2LTUwLDUwdjE4MGMwLDI3LjYxNCwyMi4zODYsNTAsNTAsNTBoMjk0YzI3LjYxNCwwLDUwLTIyLjM4Niw1MC01MHYtMTgwQzM5NCwxMDguMTM2LDM3MS42MTQsODUuNzUsMzQ0LDg1Ljc1ICAgIHogTTE4My4wNDMsMjg2Ljk3NWMwLDQuMzUzLTEuNDA0LDguMzY1LTMuNzY0LDExLjY0N3YtMy40ODVjMC0xMC4wOTQtOC4xODMtMTguMjc2LTE4LjI3Ni0xOC4yNzZIMTMzLjI0ICAgIGMxNy44MDItNS4zNDUsMzAuNzczLTIxLjg0OSwzMC43NzMtNDEuMzljMC0yMy44NjktMTkuMzUtNDMuMjE5LTQzLjIxOC00My4yMTljLTIzLjg2OSwwLTQzLjIxOSwxOS4zNS00My4yMTksNDMuMjE5ICAgIGMwLDE5LjU0MSwxMi45NzMsMzYuMDQzLDMwLjc3NCw0MS4zOUg4MC41ODdjLTEwLjA5MywwLTE4LjI3Niw4LjE4NC0xOC4yNzYsMTguMjc2djMuNDg1Yy0yLjM1OS0zLjI4Mi0zLjc2NC03LjI5Ny0zLjc2NC0xMS42NDcgICAgVjIwMi40OGMwLTExLjA0Niw4Ljk1NS0yMCwyMC0yMGg4NC40OTRjMTEuMDQ2LDAsMjAsOC45NTQsMjAsMjB2ODQuNDkzTDE4My4wNDMsMjg2Ljk3NUwxODMuMDQzLDI4Ni45NzV6IE0yMTIuNzc5LDEwMi40NzEgICAgYzAsOC43MDEtNy4wNzksMTUuNzc5LTE1Ljc3OSwxNS43NzljLTguNzAxLDAtMTUuNzc5LTcuMDc5LTE1Ljc3OS0xNS43NzlWNzEuMDNjMC04LjcwMSw3LjA3OS0xNS43NzksMTUuNzc5LTE1Ljc3OSAgICBzMTUuNzc5LDcuMDc5LDE1Ljc3OSwxNS43NzlWMTAyLjQ3MXogTTMxNS4zMzMsMjcxLjc1YzAsMTEuMDQ2LTguOTU0LDIwLTIwLDIwaC01MGMtMTEuMDQ1LDAtMjAtOC45NTQtMjAtMjB2LTIuMzMzICAgIGMwLTExLjA0Niw4Ljk1NS0yMCwyMC0yMGg1MGMxMS4wNDYsMCwyMCw4Ljk1NCwyMCwyMFYyNzEuNzV6IE0zMzcuMzMzLDIwNS43NWMwLDExLjA0Ni04Ljk1NCwyMC0yMCwyMGgtNzIgICAgYy0xMS4wNDUsMC0yMC04Ljk1NC0yMC0yMHYtMi4zMzNjMC0xMS4wNDYsOC45NTUtMjAsMjAtMjBoNzJjMTEuMDQ2LDAsMjAsOC45NTQsMjAsMjBWMjA1Ljc1eiIgZmlsbD0iIzAwMDAwMCIvPgoJPC9nPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" width="20" height="20" /> <?php echo ($customer->GetPrimary() != '') ? '' : '' ?> ข้อมูลสมาชิกรหัส <?php echo $customer->GetValue('precode') . $customer->GetValue('id') ?> </span> </b></div>
            <div class="da-panel-content da-form-container">
                <form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL ?>customer<?php echo ($customer->GetPrimary() != '') ? '&action=edit&id=' . $customer->GetPrimary() : ''; ?>" method="post" class="da-form">
                    <?php if ($customer->GetPrimary() != ''): ?>
                        <input type="hidden" name="id" value="<?php echo $customer->GetValue('id') ?>" />
                        <input type="hidden" name="image_idcard" value="<?php echo $customer->GetValue('image_idcard') ?>" />
                        <input type="hidden" name="image_bank" value="<?php echo $customer->GetValue('image_bank') ?>" />
                        <input type="hidden" name="created_at" value="<?php echo $customer->GetValue('created_at') ?>" />
                    <?php endif; ?>
                    <div class="da-form-inline">
                        <fieldset>
                            <legend><b>ข้อมูลสมาชิก</b></legend>
                            <div class="da-form-row">
                                <label class="da-form-label">รหัส <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="codeid" disabled="" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('precode') . $customer->GetValue('id') : ''; ?>" class="span12 required" readonly="readonly"/>
                                </div>
                            </div>
                        </fieldset>
                        <div class="da-form-row">
                            <label class="da-form-label">ชื่อสมาชิก <span class="required">*</span></label>
                            <div class="da-form-item large ">
                                <input type="text" name="customer_name" disabled="" id="customer_name" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('customer_name') : ''; ?>" class="span12 required" />
                            </div>

                        </div>
                        <div class="da-form-row">
                            <label class="da-form-label">นามสกุล <span class="required">*</span></label>
                            <div class="da-form-item large ">
                                <input type="text" name="customer_lastname" disabled="" id="customer_lastname" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('customer_lastname') : ''; ?>" class="span12 required" />
                            </div>

                        </div>

                        <div class="da-form-row">
                            <label class="da-form-label">เบอร์โทร<span class="required">*</span></label>
                            <div class="da-form-item large">
                                <input type="text" name="customer_tel" disabled="" id="customer_tel" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('customer_tel') : ''; ?>" class="span12 required" />
                            </div>
                        </div>
                        <div class="da-form-row">
                            <label class="da-form-label">ที่อยู่ <span class="required">*</span></label>
                            <div class="da-form-item large">

                                <textarea class="span12 required" disabled="" name="customer_address"><?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('customer_address') : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="da-form-row">
                            <label class="da-form-label">จังหวัด <span class="required">*</span></label>
                            <div class="da-form-item large">
                                <input type="text" name="customer_province" disabled="" id="" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('customer_province') : ''; ?>" class="span12 required" />
                            </div>
                        </div>

                        <div class="da-form-row">
                            <label class="da-form-label">รหัสไปรษณีย์ <span class="required">*</span></label>
                            <div class="da-form-item large">
                                <input type="text" name="customer_zipcode" disabled="" id="" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('customer_zipcode') : ''; ?>" class="span12 required"/>
                            </div>
                        </div>
                        <fieldset>
                            <legend><b>ไฟล์สำเนาบัตรประชาชน</b></legend>
                            <div class="da-form-row">
                                <label class="da-form-label">ไฟล์ที่อัพโหลด <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <?php if ($customer->GetValue('image_idcard') != '') { ?>
                                        <img src="<?= ADDRESS ?>img/<?= $customer->GetValue('image_idcard') ?>" class="span12">
                                    <?php } ?>
                                </div>
                            </div>

                        </fieldset>
                        <fieldset>
                            <legend><b>ไฟล์สำเนาหน้าสมุดบัญชี</b></legend>
                            <div class="da-form-row">
                                <label class="da-form-label">ไฟล์ที่อัพโหลด <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <?php if ($customer->GetValue('image_bank') != '') { ?>
                                        <img src="<?= ADDRESS ?>img/<?= $customer->GetValue('image_bank') ?>" class="span12">
                                    <?php } ?>
                                </div>
                            </div>

                        </fieldset>
                        <fieldset>
                            <legend><b>หน้าสมุดบัญชี</b></legend>
                            <div class="da-form-row">
                                <label class="da-form-label">ชื่อธนาคาร <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <select name="bank_company" class="span12 required" disabled="">
                                        <option value="">---- เลือก ----</option>
                                        <?php
                                        $sql = "SELECT * FROM " . $bank_company->getTbl() . " ORDER BY bank_name ";

                                        $query = $db->Query($sql);

                                        if ($db->NumRows($query) > 0) {
                                            ?>
                                            <?php while ($row = $db->FetchArray($query)) { ?>
                                                <option value="<?= $row['bank_name'] ?>" <?= $customer->GetValue('bank_company') == $row['bank_name'] ? 'selected' : '' ?>><?= $row['bank_name'] ?></option>

                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ประเภทบัญชี <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <select name="bank_type_account" class="span12 required" disabled="">
                                        <option value="">---- เลือก ----</option>
                                        <option value="เงินฝากออมทรัพย์"  <?= $customer->GetValue('bank_type_account') == 'เงินฝากออมทรัพย์' ? 'selected' : '' ?>>เงินฝากออมทรัพย์</option>
                                        <option value="เงินฝากประจำ" <?= $customer->GetValue('bank_type_account') == 'เงินฝากประจำ' ? 'selected' : '' ?>>เงินฝากประจำ</option>
                                        <option value="เงินฝากกระแสรายวัน" <?= $customer->GetValue('bank_type_account') == 'เงินฝากกระแสรายวัน' ? 'selected' : '' ?>>เงินฝากกระแสรายวัน</option>
                                    </select>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ชื่อบัญชี <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="bank_name" id="" disabled="" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('bank_name') : ''; ?>" class="span12 required" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">เลขบัญชี <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="bank_number" id="" disabled="" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('bank_number') : ''; ?>" class="span12 required" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">สาขา <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="bank_branch" id="" disabled="" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('bank_branch') : ''; ?>" class="span12 required" />
                                </div>
                            </div>

                        </fieldset>
                        <fieldset>
                            <legend><b>การเข้าสู่ระบบ</b></legend>
                            <div class="da-form-row">
                                <label class="da-form-label">เข้าสู่ระบบล่าสุด<span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="last_login" disabled="" id="last_login" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('last_login') : ''; ?>" class="span12 required" readonly="readonly"/>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend><b>Refer (ผู้แนะนำ)</b></legend>
                            <div class="da-form-row">
                                <label class="da-form-label">รหัสผู้แนะนำ <span class="required"></span></label>
                                <div class="da-form-item large">
                                    <?php
                                    if ($customer->GetValue('customer_refer_id') != 0) {
                                        $customer_refer_id = $customer->getDataDesc("precode", "id=" . $customer->GetValue('customer_refer_id')) . $customer->getDataDesc("id", "id=" . $customer->GetValue('customer_refer_id'));
                                        $customer_refer_name = $customer->getDataDesc("customer_name", "id=" . $customer->GetValue('customer_refer_id')) . " " . $customer->getDataDesc("customer_lastname", "id=" . $customer->GetValue('customer_refer_id'));
                                    } else {
                                        $customer_refer_id = "";
                                        $customer_refer_name = "";
                                    }
                                    ?>
                                    <input type="text" disabled="" name="customer_refer_id" id="customer_refer_id" value="<?php echo $customer_refer_id ?>" class="span12" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ชื่อผู้แนะนำ <span class="required"></span></label>
                                <div class="da-form-item large">
                                    <input type="text" disabled="" name="customer_refer_name" id="customer_refer_name" value="<?php echo $customer_refer_name; ?>" class="span12" />
                                </div>
                            </div>

                        </fieldset>
                        <fieldset>
                            <legend><b>ข้อมูลเข้าสู่ระบบ</b></legend>
                            <div class="da-form-row">
                                <label class="da-form-label">User name <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="login_email" disabled="" id="login_email" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('login_email') : ''; ?>" class="span12 required" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">Password<span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="login_password" disabled="" id="login_password" value="<?php echo ($customer->GetPrimary() != '') ? $functions->decode_login($customer->GetValue('login_password')) : ''; ?>" class="span12 required" />
                                </div>
                            </div>
                        </fieldset>
                        <input type="hidden" name="register_date" id="register_date" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('register_date') : ''; ?>">
                    </div>

                </form>
            </div>
        </div>
    </div> 
    </div>
<?php } else { ?>

    <div class="row-fluid">
        <div class="span12">
            <?php
            // Report errors to the user


            Alert2(GetAlert('error'));


            Alert2(GetAlert('success'), 'success');
            ?>
            <div class="da-panel collapsible">
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-grid"></i> คำขอถอนเงิน ทั้งหมด </span> </div>
                <div class="da-panel-toolbar">
                    <div class="btn-toolbar">
                        <div class="btn-group hidden">
                            <a class="btn" onClick="multi_delete()"><img src="http://icons.iconarchive.com/icons/awicons/vista-artistic/24/delete-icon.png" height="16" width="16"> Delete</a> 
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
                                <th>สถานะ</th>
                                <th>ยอดถอนเงิน</th>
                                <th>วันที่คำขอ</th>
                                <th>ตัวเลือก</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // $sql = "SELECT * FROM " . $transfer_money->getTbl() .' WHERE status != "รับปันผล" AND created_at BETWEEN "'.DATE.' 00:00:00" AND "'.DATE.' 23:59:59" ORDER BY created_at';
                            $sql = "SELECT * FROM " . $transfer_money->getTbl() . ' WHERE status != "รับปันผล"  ORDER BY id';


                            $query = $db->Query($sql);
                            $i = 1;
                            while ($row = $db->FetchArray($query)) {
                                $customer_id = $row['customer_id'];
                                $bg = $row['status'] == 'โอนแล้ว' ? 'bg-success' : 'bg-warning';
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td class="center" width="8%" style="font-size: 12px"><?= $i++ ?></td>
                                    <td class="center" style="font-size: 12px"><?php echo $customer->getDataDesc("precode", "id=" . $customer_id) . $customer->getDataDesc("id", "id=" . $customer_id); ?></td>
                                    <td style="font-size: 12px"><?php echo $customer->getDataDesc("customer_name", "id=" . $customer_id) . " " . $customer->getDataDesc("customer_lastname", "id=" . $customer_id) ?></td>
                                    <td class="center" style="font-size: 12px"><?php echo $row['status'] ?></td>
                                    <td class="center" style="font-size: 12px"><?php echo $row['total']; ?></td>
                                    <td class="center" style="font-size: 12px"><?php echo $row['created_at']; ?></td>
                                    <td class="center" style="font-size: 12px"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>transfer_money&action=edit&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-small">แก้ไข / ดู</a> <a href="#" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>transfer_money&action=del&id=<?php echo $row['id'] ?>'
                                                        }" class="btn btn-danger btn-small">ลบ</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php } ?>
