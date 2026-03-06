<html>
<head>
    <title> Non-Seamless-kit</title>
</head>
<body>
@include('paymentgateway.Crypto');
<center>
    <?php

    error_reporting(0);

    $merchant_data='';
    $working_key='E74BC536117CA8DB31A6DB99B52104E1';//Shared by CCAVENUES
    $access_code='AVOJ04IK01AF99JOFA';//Shared by CCAVENUES

    foreach ($data as $key => $value){
        if($merchant_data != "")
            $merchant_data .= "&";
        $merchant_data.=$key.'='.$value;
    }

    $encrypted_data=payment_encrypt($merchant_data,$working_key);
    ?>

    <form method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
        <?php
        echo "<input type=hidden name=encRequest value=$encrypted_data>";
        echo "<input type=hidden name=access_code value=$access_code>";
        ?>
    </form>
</center>
<script language='javascript'>document.redirect.submit();</script>

</body>
</html>
