<?php
@session_start();
if ($_POST ["submit_bt"] == 'Submit') {

    //form submitted
    //check if other form details are correct
    //verify captcha
    $recaptcha_secret = "6LeMxSITAAAAAEPNFj9C3VJifv8yAUH3HDLkgRuW";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $_POST['g-recaptcha-response']);
    $response = json_decode($response, true);
    if ($response["success"] === true) {



        $chk = 1;
        $arrData = array();

        $arrData = $functions->replaceQuote($_POST);

        $contact_message->SetValues($arrData);

        if ($contact_message->GetPrimary() == '') {

            $contact_message->SetValue('created_at', DATE_TIME);

            $contact_message->SetValue('updated_at', DATE_TIME);
        } else {

            $contact_message->SetValue('updated_at', DATE_TIME);
        }

        $contact_message->SetValue('status', 'ยังไม่ได้อ่าน');

        // $contact_message->Save();

        if ($contact_message->Save()) {
//            echo "<script>  $(document).ready(function(){   noty({  text: 'ส่งข้อความสำเร็จ', type: 'success',
//                    theme: 'relax',
//                    timeout: 3000, }); });</script>";

            SetAlert('ส่งข้อความสำเร็จ', 'success');
            header('location:' . ADDRESS . 'contact');
            die();
        } else {
            echo "<script>  $(document).ready(function(){   noty({  text: 'Error Code', type: 'warning',
                    theme: 'relax',
                    timeout: 3000, }); });</script>";
        }
    } else {
        echo "<script>  $(document).ready(function(){   noty({  text: 'Error Code', type: 'warning',
                    theme: 'relax',
                    timeout: 3000, }); });</script>";
    }
}
?>


<div class="col-md-12 well">
     <div class="col-md-12">
      
            <?php
            // Report errors to the user


            Alert(GetAlert('error'));


            Alert(GetAlert('success'), 'success');
            ?>
      
        
    </div>
    <div class="col-md-12">
        <form class="form-horizontal form-paymentss  " enctype="multipart/form-data"  method="POST" action="<?php echo ADDRESS ?>contact">
            <section class="">
                <h1 style="margin-top: 0;"><?= $contact->getDataDesc('contact_title', 'id = 1') ?></h1>
                <?= $contact->getDataDesc('contact_detail', 'id = 1') ?>
            </section>
            <p>&nbsp;</p>
            <section class="my-panel">
                <h1 style="margin-top: 0;"> ข้อมูลติดต่อเรา</h1>
                <div class="row">
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">ชื่อ <em>*</em></label>
                        <span>
                            <input type="text" class="form-control" name="txt_name" value="<?= isset($_POST['txt_name']) ? $_POST['txt_name'] : '' ?>" data-validation="required">
                        </span> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">เบอร์โทร <em>*</em></label>
                        <span>
                            <input type="text" class="form-control" name="txt_tel" value="<?= isset($_POST['txt_tel']) ? $_POST['txt_tel'] : '' ?>"  data-validation="number,required">
                        </span> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">Email <em>*</em></label>
                        <span>
                            <input type="text" name="txt_email" class="form-control" id="email" value="<?= isset($_POST['txt_email']) ? $_POST['txt_email'] : '' ?>"  data-validation="required,email">
                        </span> 
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">หัวข้อ <em>*</em></label>
                        <span> 
                            <input type="text" class="form-control" name="txt_subject"  value="<?= isset($_POST['txt_subject']) ? $_POST['txt_subject'] : '' ?>" data-validation="required">
                        </span> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">ข้อความ <em>*</em></label>

                        <textarea class="form-control" name="txt_message" rows="3" data-validation="required"><?= isset($_POST['txt_message']) ? $_POST['txt_message'] : '' ?></textarea>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <div class="g-recaptcha" data-sitekey="6LeMxSITAAAAAHn6FCGQNv47qSaAS3HGl7_tK0eV"></div>
                    </div>
                </div>
            </section>

            <div class="row">
                <div class="col-md-12">
                    <button type="submit" id="submit_bt" class="btn btn-success" name="submit_bt" value="Submit"><i class="fa fa-save"></i>&nbsp;Submit</button>

                </div>
            </div>
        </form>
    </div>
</div>



<script src='https://www.google.com/recaptcha/api.js?hl=th'></script>

<script src="http://malsup.github.io/jquery.form.js"></script>
<script src="http://malsup.github.io/jquery.blockUI.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.23/theme-default.min.css"
      rel="stylesheet" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js"></script>

<script>

    $.validate();



</script>

