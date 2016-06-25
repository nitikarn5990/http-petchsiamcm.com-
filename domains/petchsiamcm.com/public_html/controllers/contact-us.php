<?php
@session_start();
if ($_POST ["submit_bt"] == 'Send') {

    //form submitted
    //check if other form details are correct
    //verify captcha
    $recaptcha_secret = "6LeMxSITAAAAAEPNFj9C3VJifv8yAUH3HDLkgRuW";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $_POST['g-recaptcha-response']);
    $response = json_decode($response, true);
    if ($response["success"] === true) {


//        $chk = 0;
//        $cpt = $_POST['capt'];
//        if ($cpt != $_SESSION['CAPTCHA']) {
//       
//        } else {

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

        $contact_message->SetValue('status', 'no read');

        // $contact_message->Save();

        if ($contact_message->Save()) {
            
        } else {
            echo "<script>  alert('Error');</script>";
        }
    } else {
        echo "<script>  alert('Error Code');</script>";
    }
}
?>

<div id="content">
    <h1><?= $contact->getDataDesc('contact_title', 'id = 1') ?></h1>
    <p><?= $contact->getDataDesc('contact_detail', 'id = 1') ?></p>
    <p>&nbsp;</p>
    <h1>ข้อมูลติดต่อเรา</h1>
    <div class="formemail">
        <form action="<?php echo ADDRESS ?>contact" method="post" class="form-send-msg">

            <p> Name<br />
                <span>
                    <input type="text" name="txt_name" value=""  data-validation="required"

                           class="contactin"   />
                </span> </p>
            <p> Email.<br />
                <span>
                    <input type="text" name="txt_email" class="contactin" value=""  data-validation="required,email"  

                           />
                </span> </p>
            <p> Tel<br />
                <span>
                    <input type="text" name="txt_tel" value=""  data-validation="required,number"

                           class="contactin"  />
                </span> </p>
            <p> Subject<br />
                <span>
                    <input type="text" name="txt_subject" value=""  data-validation="required"

                           class="contactin"  />
                </span> </p>
            <p> Message<br />
                <span>
                    <textarea name="txt_message" class="area"  data-validation="required"
                              rows="7" cols="50"></textarea>
                </span> </p>

            <p>
            <div class="g-recaptcha" data-sitekey="6LeMxSITAAAAAHn6FCGQNv47qSaAS3HGl7_tK0eV"></div>
            </p>
            <p>
                <input id="submit_bt" name="submit_bt" type="submit" value="Send"

                       style="width: 80px; height: 30px;" />
                <input name="reset"

                       type="reset" value="Reset" style="width: 80px; height: 30px;" />
            </p>
        </form>
    </div>


</div>

<script src='https://www.google.com/recaptcha/api.js?hl=th'></script>

<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.23/theme-default.min.css"
      rel="stylesheet" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js"></script>
<script>

    $.validate();
</script>
