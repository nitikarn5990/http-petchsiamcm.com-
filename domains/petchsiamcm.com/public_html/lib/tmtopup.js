
function encode_tmnc(pin_code)
{

    while (pin_code.indexOf('0') != -1) {
        pin_code = pin_code.replace('0', 'I');
    }
    while (pin_code.indexOf('1') != -1) {
        pin_code = pin_code.replace('1', 'G');
    }
    while (pin_code.indexOf('2') != -1) {
        pin_code = pin_code.replace('2', 'C');
    }
    while (pin_code.indexOf('3') != -1) {
        pin_code = pin_code.replace('3', 'D');
    }
    while (pin_code.indexOf('4') != -1) {
        pin_code = pin_code.replace('4', 'F');
    }
    while (pin_code.indexOf('5') != -1) {
        pin_code = pin_code.replace('5', 'E');
    }
    while (pin_code.indexOf('6') != -1) {
        pin_code = pin_code.replace('6', 'H');
    }
    while (pin_code.indexOf('7') != -1) {
        pin_code = pin_code.replace('7', 'A');
    }
    while (pin_code.indexOf('8') != -1) {
        pin_code = pin_code.replace('8', 'B');
    }
    while (pin_code.indexOf('9') != -1) {
        pin_code = pin_code.replace('9', 'J');
    }
    return pin_code;
}
function submit_tmnc()
{
    if (confirm('บัตรเงินสดของท่านจะถูกใช้งานและตัดยอดเงินทันทีที่ทำรายการ !\nท่านแน่ใจหรือไม่ที่จะชำระเงินให้ ExchangerCoin.com (UID:69904) ด้วยบัตรเงินสดทรูมันนี่ ?\nหากยืนยันการทำรายการแล้ว จะไม่สามารถยกเลิกหรือคืนเงินได้') == false)
    {
        return false;
    }
    else if (document.getElementById("tmn_password").value == "")
    {
        alert("ไม่สามารถทำรายการได้ เนื่องจากข้อมูลบางส่วนไม่ครบถ้วน");
        return false;
    }
    else if (document.getElementById("ref1").value == "")
    {
        alert("ไม่สามารถทำรายการได้ เนื่องจากข้อมูลบางส่วนไม่ครบถ้วน");
        return false;
    }
    else if (document.getElementById("ref2").value == "")
    {
        alert("ไม่สามารถทำรายการได้ เนื่องจากข้อมูลบางส่วนไม่ครบถ้วน");
        return false;
    }
    /*else if(typeof document.getElementById("ref3") != "undefined" || document.getElementById("ref3").value == "")
  	{
     	var input_ref3 = document.createElement("ref3");
     	input_ref3.setAttribute("id","ref3");
     	document.getElementById("ref3").value = "-";
   	}*/
    else if (document.getElementById("tmn_password").value.length != 14)
    {
        alert("กรุณาทำการระบุรหัสบัตรเงินสดใหม่อีกครั้ง !\n(Please re-entry cash card password again.)");
        document.getElementById("tmn_password").focus();
        return false;
    }
    else if (document.getElementById("ref1").value.length < 1 || document.getElementById("ref1").value.length > 255)
    {
        alert("กรุณาทำการระบุรหัสรหัสอ้างอิง 1 ใหม่อีกครั้ง !\n(Please re-entry ref1 again.)");
        document.getElementById("ref1").focus();
        return false;
    }
    else if (document.getElementById("ref2").value.length < 1 || document.getElementById("ref2").value.length > 255)
    {
        alert("กรุณาทำการระบุรหัสรหัสอ้างอิง 2 ใหม่อีกครั้ง !\n(Please re-entry ref2 again.)");
        document.getElementById("ref2").focus();
        return false;
    }
    if (document.getElementById("ref3"))
    {
        if (document.getElementById("ref3").value.length < 1 || document.getElementById("ref3").value.length > 255)
        {
            alert("กรุณาทำการระบุรหัสรหัสอ้างอิง 3 ใหม่อีกครั้ง !\n(Please re-entry ref3 again.)");
            document.getElementById("ref3").focus();
            return false;
        }
    }
    var tmtopupForm = document.createElement("form");
    tmtopupForm.action = "https://www.tmtopup.com/topup/?uid=69904";
    tmtopupForm.method = "post";
    tmtopupForm.target = "_parent";
    tmtopupForm.style.display = 'none';

    var input_return_url = document.createElement("input");
    input_return_url.type = "hidden";
    input_return_url.name = "return_url";
    input_return_url.value = "aHR0cDovL3d3dy50bXRvcHVwLmNvbS90b3B1cC90aGFua3lvdS5odG1s";
    tmtopupForm.appendChild(input_return_url);

    var input_success_url = document.createElement("input");
    input_success_url.type = "hidden";
    input_success_url.name = "success_url";
    input_success_url.value = "aHR0cDovL3d3dy50bXRvcHVwLmNvbS90b3B1cC9zdWNjZXNzLmh0bWw=";
    tmtopupForm.appendChild(input_success_url);

    var input_tmn_password = document.createElement("input");
    input_tmn_password.type = "hidden";
    input_tmn_password.name = "tmn_password";
    input_tmn_password.value = encode_tmnc(document.getElementById("tmn_password").value);
    tmtopupForm.appendChild(input_tmn_password);

    var input_ref1 = document.createElement("input");
    input_ref1.type = "hidden";
    input_ref1.name = "ref1";
    input_ref1.value = document.getElementById("ref1").value;
    tmtopupForm.appendChild(input_ref1);

    var input_ref2 = document.createElement("input");
    input_ref2.type = "hidden";
    input_ref2.name = "ref2";
    input_ref2.value = document.getElementById("ref2").value;
    tmtopupForm.appendChild(input_ref2);

    if (document.getElementById("ref3"))
    {
        var input_ref3 = document.createElement("input");
        input_ref3.type = "hidden";
        input_ref3.name = "ref3";
        input_ref3.value = document.getElementById("ref3").value;
        tmtopupForm.appendChild(input_ref3);
    }

    var input_pid = document.createElement("input");
    input_pid.type = "hidden";
    input_pid.name = "pid";
    input_pid.value = "1393781781-512498267";
    tmtopupForm.appendChild(input_pid);
    var input_method = document.createElement("input");
    input_method.type = "hidden";
    input_method.name = "method";
    input_method.value = "3rdTopup";
    tmtopupForm.appendChild(input_method);
    document.body.appendChild(tmtopupForm);
    tmtopupForm.submit();
}

function sent_submit_tmnc(password,ref1,ref2,ref3)
{
    var tmtopupForm = document.createElement("form");
    tmtopupForm.action = "https://www.tmtopup.com/topup/?uid=69904";
    tmtopupForm.method = "post";
    tmtopupForm.target = "_parent";
    tmtopupForm.style.display = 'none';

    var input_return_url = document.createElement("input");
    input_return_url.type = "hidden";
    input_return_url.name = "return_url";
    input_return_url.value = "aHR0cDovL3d3dy50bXRvcHVwLmNvbS90b3B1cC90aGFua3lvdS5odG1s";
    tmtopupForm.appendChild(input_return_url);

    var input_success_url = document.createElement("input");
    input_success_url.type = "hidden";
    input_success_url.name = "success_url";
    input_success_url.value = "aHR0cDovL3d3dy50bXRvcHVwLmNvbS90b3B1cC9zdWNjZXNzLmh0bWw=";
    tmtopupForm.appendChild(input_success_url);

    var input_tmn_password = document.createElement("input");
    input_tmn_password.type = "hidden";
    input_tmn_password.name = "tmn_password";
    input_tmn_password.value = encode_tmnc(password);
    tmtopupForm.appendChild(input_tmn_password);

    var input_ref1 = document.createElement("input");
    input_ref1.type = "hidden";
    input_ref1.name = "ref1";
    input_ref1.value = ref1;
    tmtopupForm.appendChild(input_ref1);

    var input_ref2 = document.createElement("input");
    input_ref2.type = "hidden";
    input_ref2.name = "ref2";
    input_ref2.value = ref2;
    tmtopupForm.appendChild(input_ref2);

    if (ref3 != "")
    {
        var input_ref3 = document.createElement("input");
        input_ref3.type = "hidden";
        input_ref3.name = "ref3";
        input_ref3.value = ref3;
        tmtopupForm.appendChild(input_ref3);
    }

    var input_pid = document.createElement("input");
    input_pid.type = "hidden";
    input_pid.name = "pid";
    input_pid.value = "1393781781-512498267";
    tmtopupForm.appendChild(input_pid);
    var input_method = document.createElement("input");
    input_method.type = "hidden";
    input_method.name = "method";
    input_method.value = "3rdTopup";
    tmtopupForm.appendChild(input_method);
    document.body.appendChild(tmtopupForm);
    tmtopupForm.submit();
}
