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


        $chk = 0;
        $cpt = $_POST['capt'];
        if ($cpt != $_SESSION['CAPTCHA']) {
            ?>
            <script> alert('Error code');</script>
            <?php
        } else {

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
                
            } else {
                echo "<script>  alert('Error');</script>";
            }
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
        <form action="<?php echo ADDRESS ?>contact/ติดต่อเรา" method="post" class="form-send-msg">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" name="txt_name" class="form-control" id="" placeholder="" data-validation="required">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="text" name="txt_email" class="form-control" id="" placeholder="" data-validation="required,email">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Tel</label>
                <input type="text" name="txt_tel" class="form-control" id="" placeholder="" data-validation="required,number">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Subject</label>
                <input type="text" name="txt_subject" class="form-control" id="" placeholder="" data-validation="required">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Message</label>
                <textarea name="txt_message" class="form-control" data-validation="required"
                          rows="7">

                </textarea> 
            </div>

            <div class="form-group"> 

                <div class="g-recaptcha" data-sitekey="6LeMxSITAAAAAHn6FCGQNv47qSaAS3HGl7_tK0eV"></div>

            </div>
            <div class="form-group"> 

                <input id="submit_bt" name="submit_bt" type="submit" value="Submit" class="btn btn-default" />

            </div>
        </form>
    </div>


</div>

<script src='https://www.google.com/recaptcha/api.js?hl=th'></script>
