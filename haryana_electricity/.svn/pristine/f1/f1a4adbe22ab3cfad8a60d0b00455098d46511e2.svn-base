<?php

require('SMS/sendsms.php');

class SMSController {

    function customerComplainMessage($complainNumber, $customer_phone) {

        $sendsms = new sendsms("http://trans.kapsystem.com/api/v3/", 'sms', "Ac69d1bbfb9f13e53d2db39756c155016", "AVTSOL");
        $message = "प्रिय ग्राहक, हमसे संपर्क करने के लिए धन्यवाद। आपके बिजली कनेक्शन शिकायत के लिए संदर्भ संख्या है: " . $complainNumber . "। हम आपकी शिकायत को हल करने के लिए काम कर रहे हैं।";
        $response = $sendsms->unicode_sms($customer_phone, $message, 'http://139.59.1.233/SMS/SMSdlr.php&custom=XX', 'json', '1');
        return $response;
    }

    function customerResolveMessage($complainNumber, $customer_phone) {
        $sendsms = new sendsms("http://trans.kapsystem.com/api/v3/", 'sms', "Ac69d1bbfb9f13e53d2db39756c155016", "AVTSOL");
        $message = "प्रिय ग्राहक, आपके बिजली कनेक्शन के लिए " . $complainNumber . " शिकायत नंबर हल किया गया है। किसी भी आगे की सहायता के लिए हमसे संपर्क करें।";
        $response = $sendsms->unicode_sms($customer_phone, $message, 'http://139.59.1.233/SMS/SMSdlr.php&custom=XX', 'json', '1');
        return $response;
    }

    function linemanComplainMessage($complainNumber, $linemanPhone, $customerName, $customerAddress, $customerPhone) {
        $sendsms = new sendsms("http://trans.kapsystem.com/api/v3/", 'sms', "Ac69d1bbfb9f13e53d2db39756c155016", "AVTSOL");
        //$message = "नई शिकायत निम्नलिखित विवरण के साथ पंजीकृत किया गया है: नाम: " . $customerName . " स्थान: " . $customerAddress . " संपर्क नंबर: " . $customerPhone . "";
         $message = "नई शिकायत निम्नलिखित विवरण के साथ पंजीकृत किया गया है। संदर्भ संख्या: " . $complainNumber . " नाम: " . $customerName . " स्थान: " . $customerAddress . " संपर्क नंबर: " . $customerPhone . "";
        $response = $sendsms->unicode_sms($linemanPhone, $message, 'http://139.59.1.233/SMS/SMSdlr.php&custom=XX', 'json', '1');
        return $response;
    }

}

?>