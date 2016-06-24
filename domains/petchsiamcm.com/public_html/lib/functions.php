<?php

class Utility {

    function UpdateSql2($str_sql) {
        $res = false;
        $dbhost = DB_HOST;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;
        $conn = mysql_connect($dbhost, $dbuser, $dbpass);
        if (!$conn) {
            die('Could not connect: ' . mysql_error());
        }
        $sql = $str_sql;

        mysql_select_db(DB_DEFAULT);
        $retval = mysql_query($sql, $conn);
        if (!$retval) {
            die('Could not update data: ' . mysql_error());
        }
        echo "Updated data successfully\n";
        mysql_close($conn);
    }

    function Insert($table_name, $form_data) {
        // retrieve the keys of the array (column titles)
        $res = false;
        $dbhost = DB_HOST;
        $dbuser = DB_USER;
        $dbpass = DB_PASS;
        $conn = @mysql_connect($dbhost, $dbuser, $dbpass);
        if (!$conn) {
         //   die('Could not connect: ' . mysql_error());
        }
        $fields = array_keys($form_data);

        // build the query
        $sql = "INSERT INTO " . $table_name . "
    (`" . implode('`,`', $fields) . "`)
    VALUES('" . implode("','", $form_data) . "')";
        
        mysql_select_db(DB_DEFAULT);
        
        $retval = mysql_query($sql, $conn);
        if (!$retval) {
            die('Could not update data: ' . mysql_error());
        }else{
            $res = true;
        }
        return $res;
    }

    function ShowDateEn($myDate) {
        $myDateArray = explode("-", $myDate);
        $myDay = sprintf("%d", $myDateArray[2]);
        switch ($myDateArray[1]) {
            case "01" : $myMonth = "Jan";
                break;
            case "02" : $myMonth = "Feb";
                break;
            case "03" : $myMonth = "Mar";
                break;
            case "04" : $myMonth = "Apr";
                break;
            case "05" : $myMonth = "May";
                break;
            case "06" : $myMonth = "Jun";
                break;
            case "07" : $myMonth = "Jul";
                break;
            case "08" : $myMonth = "Aug";
                break;
            case "09" : $myMonth = "Sep";
                break;
            case "10" : $myMonth = "Oct";
                break;
            case "11" : $myMonth = "Nov";
                break;
            case "12" : $myMonth = "Dec";
                break;
        }
        $myYear = sprintf("%d", $myDateArray[0]);
        return($myDay . " " . $myMonth . " " . $myYear);
    }

    function ShowDateThTime($myDate) {
        if ($myDate != "0000-00-00 00:00:00") {
            $myTimeArray = explode(" ", $myDate);
            $myTime = explode(":", $myTimeArray[1]);
            $myDateArray = explode("-", $myDate);
            $myDay = sprintf("%d", $myDateArray[2]);
            switch ($myDateArray[1]) {
                case "01" : $myMonth = "ม.ค.";
                    break;
                case "02" : $myMonth = "ก.พ.";
                    break;
                case "03" : $myMonth = "มี.ค.";
                    break;
                case "04" : $myMonth = "เม.ย.";
                    break;
                case "05" : $myMonth = "พ.ค.";
                    break;
                case "06" : $myMonth = "มิ.ย.";
                    break;
                case "07" : $myMonth = "ก.ค.";
                    break;
                case "08" : $myMonth = "ส.ค.";
                    break;
                case "09" : $myMonth = "ก.ย.";
                    break;
                case "10" : $myMonth = "ต.ค.";
                    break;
                case "11" : $myMonth = "พ.ย.";
                    break;
                case "12" : $myMonth = "ธ.ค.";
                    break;
            }
            $myYear = sprintf("%d", $myDateArray[0]);
            return($myDay . "/" . $myMonth . "/" . $myYear . ", " . $myTime[0] . ":" . $myTime[1]);
        } else {
            return "&nbsp;";
        }
    }

    function ShowDateTh($myDate) {
        $myDateArray = explode("-", $myDate);
        $myDay = sprintf("%d", $myDateArray[2]);
        switch ($myDateArray[1]) {
            case "01" : $myMonth = "ม.ค.";
                break;
            case "02" : $myMonth = "ก.พ.";
                break;
            case "03" : $myMonth = "มี.ค.";
                break;
            case "04" : $myMonth = "เม.ย.";
                break;
            case "05" : $myMonth = "พ.ค.";
                break;
            case "06" : $myMonth = "มิ.ย.";
                break;
            case "07" : $myMonth = "ก.ค.";
                break;
            case "08" : $myMonth = "ส.ค.";
                break;
            case "09" : $myMonth = "ก.ย.";
                break;
            case "10" : $myMonth = "ต.ค.";
                break;
            case "11" : $myMonth = "พ.ย.";
                break;
            case "12" : $myMonth = "ธ.ค.";
                break;
        }
        $myYear = sprintf("%d", $myDateArray[0]) + 543;
        if ($myDay == 0) {
            return("");
        } else {
            return($myDay . " " . $myMonth . " " . $myYear);
        }
    }

    function scan_directory_recursively($directory, $filter = FALSE) {
        // if the path has a slash at the end we remove it here
        if (substr($directory, -1) == '/') {
            $directory = substr($directory, 0, -1);
        }
        // if the path is not valid or is not a directory ...
        if (!file_exists($directory) || !is_dir($directory)) {
            // ... we return false and exit the function
            return FALSE;
            // ... else if the path is readable
        } elseif (is_readable($directory)) {
            // we open the directory
            $directory_list = opendir($directory);
            // and scan through the items inside
            while (FALSE !== ($file = readdir($directory_list))) {
                // if the filepointer is not the current directory
                // or the parent directory
                if ($file != '.' && $file != '..') {
                    // we build the new path to scan
                    $path = $directory . '/' . $file;
                    // if the path is readable
                    if (is_readable($path)) {
                        // we split the new path by directories
                        $subdirectories = explode('/', $path);
                        // if the new path is a directory
                        if (is_dir($path)) {
                            // add the directory details to the file list
                            $directory_tree[] = array(
                                'path' => $path,
                                'name' => end($subdirectories),
                                'kind' => 'directory',
                                // we scan the new path by calling this function
                                'content' => scan_directory_recursively($path, $filter));
                            // if the new path is a file
                        } elseif (is_file($path)) {
                            // get the file extension by taking everything after the last dot
                            //$extension = end(explode('.',end($subdirectories)));
                            // if there is no filter set or the filter is set and matches
                            if ($filter === FALSE || $filter == $extension) {
                                // add the file details to the file list
                                $directory_tree[] = array(
                                    'path' => $path,
                                    'name' => end($subdirectories),
                                    //'extension' => $extension,
                                    'size' => filesize($path),
                                    'kind' => 'file');
                            }
                        }
                    }
                }
            }
            // close the directory
            closedir($directory_list);
            // return file list
            return $directory_tree;
            // if the path is not readable ...
        } else {
            // ... we return false
            return FALSE;
        }
    }

    function seoTitle($raw) {
        $raw = preg_replace('#[^-ก-๙a-zA-Z0-9]#u', '-', $raw);
        $raw = ereg_replace("-+", "-", $raw);
        if (substr($raw, 0, 1) == '-')
            $raw = substr($raw, 1);
        if (substr($game_url, -1) == '-')
            $raw = substr($raw, 0, -1);
        return strtolower($raw);
    }

    function replaceQuote($arrData = array()) {
        $arrNewData = array();
        $str = array("'");
        $code = array("&#39;");
        foreach ($arrData as $data => $value) {
            $arrNewData[$data] = str_replace("\\", "", $value);
        }
        return $arrNewData;
    }

    function getAllCheckValues($chk_name) {
        $found = array(); //create a new array 
        foreach ($chk_name as $key => $val) {
            //echo "KEY::".$key."VALue::".$val."<br>";
            if ($val == '1') { //replace '1' with the value you want to search
                $found[] = $key;
            }
        }
        foreach ($found as $kev_f => $val_f) {
            unset($chk_name[$val_f - 1]); //unset the index of un-necessary values in array
        }
        $final_arr = array(); //create the final array
        return $final_arr = array_values($chk_name); //sort the resulting array again
    }

    function genCodeRandom($num_require) {
        $alphanumeric = array(
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        if ($num_require > sizeof($alphanumeric)) {
            echo "Error alphanumeric_rand(\$num_require) : \$num_require must less than " . sizeof($alphanumeric) . ", $num_require given";
            return;
        }
        $rand_key = array_rand($alphanumeric, $num_require);
        for ($i = 0; $i < sizeof($rand_key); $i++)
            $randomstring .= $alphanumeric[$rand_key[$i]];
        return $randomstring;
    }

    ###############Gen Key Password#################

    var $hash_key = 'vcm,nd;sihafd5465456dsfaskjhjkhlakseauhetjkh';  //  รหัสพิเศษ ที่จะเอาไปใส่ร่วมกับ encode ให้เปลี่ยนไปในแต่ละเว็บ

    // encode

    function enCrypted($string, $h_key = "") {
        if ($h_key = "") {
            $key = $this->hash_key;
        } else {
            $key = $h_key;
        }
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
    }

    // decode
    function deCrypted($encrypted, $h_key = "") {
        if ($h_key = "") {
            $key = $this->hash_key;
        } else {
            $key = $h_key;
        }
        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
    }

    function btce_query($method, array $req = array()) {
        // API settings
        $key = 'ULURYUJL-XGSXCXSC-YK4I82AC-J1DFCUO9-82VECLAI'; // your API-key
        $secret = '050595ac8113382223876a1b1bf856a2c67fa9e67f36dd0dcd885c5bb91f40ce'; // your Secret-key

        $req['method'] = $method;
        $mt = explode(' ', microtime());
        $req['nonce'] = $mt[1];

        // generate the POST data string
        $post_data = http_build_query($req, '', '&');

        $sign = hash_hmac('sha512', $post_data, $secret);

        // generate the extra headers
        $headers = array(
            'Sign: ' . $sign,
            'Key: ' . $key,
        );

        // our curl handle (initialize if required)
        static $ch = null;
        if (is_null($ch)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; BTCE PHP client; ' . php_uname('s') . '; PHP/' . phpversion() . ')');
        }
        curl_setopt($ch, CURLOPT_URL, 'https://btc-e.com/tapi/');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        // run the query
        $res = curl_exec($ch);
        if ($res === false)
            throw new Exception('Could not get reply: ' . curl_error($ch));
        $dec = json_decode($res, true);
        if (!$dec)
            throw new Exception('Invalid data received, please make sure connection is working and requested API exists');
        return $dec;
    }

    function getRatePercent($value, $rate, $percent, $action, $type = "THB", $format = true) {
        if ($type == "THB") {
            $price = $value;
        } else {
            $price = $value * $rate;
        }
        if ($action == "เพิ่ม") {
            $newprice = $price + (($percent * $price) / 100);
        } elseif ($action == "ลด") {
            $newprice = $price - (($percent * $price) / 100);
        }

        if ($format == true) {
            return number_format($newprice, 2);
        } else {
            return $newprice;
        }
    }

    function ShortNmae($str, $limit, $strs = "...") {
        $charset = 'UTF-8';
        if (mb_strlen($str, $charset) > $limit) {
            return $string = mb_substr($str, 0, $limit, $charset) . $strs;
            //return mb_strlen($str, $charset).' > '.$limit;
        } else {
            return $str;
        }
    }

    function sentSMS($massage, $phone = "0830561165") {
        $url = "http://www.sbuysms.com/api.php";
        $user = "phiopan";
        $pass = "026924385";
        $phone = $phone;
        $message = $massage;

        $param = "command=send&username=$user&password=$pass&msisdn=$phone&message=$message";
        $agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    function sentMail($frommail, $tomail, $title, $html, $cc = "", $bcc = "", $atk = "") {
        require_once 'class.phpmailer.php';
        $mail = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch	
        $mail->CharSet = 'UTF-8';
        try {
            $mail->SetFrom($frommail, "exchangercoin.com");
            $mail->AddAddress($tomail);
            if ($cc != "") {
                $mail->AddCC($cc);
            }
            if ($bcc != "") {
                $mail->AddBCC($bcc);
            }
            $mail->Subject = $title;
            $mail->MsgHTML($html);
            if ($atk != "") {
                $mail->AddAttachment($atk);
            }    // attachment
            $mail->Send();
            echo "Message Sent OK<p></p>\n";
        } catch (phpmailerException $e) {
            echo $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
            echo $e->getMessage(); //Boring error messages from anything else!
        }
    }

    //Paypal
    // functions.php
    function check_txnid($tnxid) {
        /* global $link;
          return true;
          $valid_txnid = true;
          //get result set
          $sql = mysql_query("SELECT * FROM `payments` WHERE txnid = '$tnxid'", $link);
          if($row = mysql_fetch_array($sql)) {
          $valid_txnid = false;
          }
          return $valid_txnid; */
        $valid_txnid = false;
    }

    function check_price($price, $id) {
        $valid_price = false;
        //you could use the below to check whether the correct price has been paid for the product

        /*
          $sql = mysql_query("SELECT amount FROM `products` WHERE id = '$id'");
          if (mysql_numrows($sql) != 0) {
          while ($row = mysql_fetch_array($sql)) {
          $num = (float)$row['amount'];
          if($num == $price){
          $valid_price = true;
          }
          }
          }
          return $valid_price;
         */
        return true;
    }

    /* function updatePayments($data){	
      global $link;
      if(is_array($data)){
      $sql = mysql_query("INSERT INTO `payments` (txnid, payment_amount, payment_status, itemid, createdtime) VALUES (
      '".$data['txn_id']."' ,
      '".$data['payment_amount']."' ,
      '".$data['payment_status']."' ,
      '".$data['item_number']."' ,
      '".date("Y-m-d H:i:s")."'
      )", $link);
      return mysql_insert_id($link);
      }
      } */

    function tmn_refill($truemoney_password) {
        if (function_exists('curl_init')) {
            $curl = curl_init('https://www.tmpay.net/TPG/backend.php?merchant_id=test&password=' . $truemoney_password . '&resp_url= http://www.exchangercoin.com/tmtopup.php');
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_HEADER, FALSE);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            $curl_content = curl_exec($curl);
            curl_close($curl);
            return $curl_content;
        } else {
            $curl_content = file_get_contents('http://www.tmpay.net/TPG/backend.php?merchant_id=test&password=' . $truemoney_password . '&resp_url= http://www.exchangercoin.com/tmtopup.php');
            if (strpos($curl_content, 'SUCCEED') !== FALSE) {
                return true;
            } else {
                return false;
            }
        }
    }

    function encode_tmnc($pin_code) {
        $search = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $replace = array('I', 'G', 'C', 'D', 'F', 'E', 'H', 'A', 'B', 'J');
        $pid = str_replace($search, $replace, $pin_code);
        return $pid;
    }

    function fulldelete($location) {
        if (is_dir($location)) {
            $currdir = opendir($location);
            while ($file = readdir($currdir)) {
                if ($file <> ".." && $file <> ".") {
                    $fullfile = $location . "/" . $file;
                    if (is_dir($fullfile)) {
                        if (!fulldelete($fullfile)) {
                            return false;
                        }
                    } else {
                        if (!unlink($fullfile)) {
                            return false;
                        }
                    }
                }
            }
            closedir($currdir);
            if (!rmdir($location)) {
                return false;
            }
        } else {
            if (!unlink($location)) {
                return false;
            }
        }
        return true;
    }

    function padLeft($data, $limit, $value) {
        return str_pad($data, $limit, $value, STR_PAD_LEFT);
    }

    function encode_login($q) {
        $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
        $qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $q, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
        return( $qEncoded );
    }

    function decode_login($q) {
        $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
        $qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($q), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
        return( $qDecoded );
    }

}

?>