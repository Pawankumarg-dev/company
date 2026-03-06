<html>
<head>
    <title> Non-Seamless-kit</title>
</head>
<body>
@include('paymentgateway.CryptoNew');
<center>
    <?php

    error_reporting(0);

    $merchant_data="";
    $working_key='8D29080EBDBF0C2E451319B1183A12EF';//Shared by CCAVENUES
    $access_code='AVAY53IJ99BL03YALB';//Shared by CCAVENUES

    foreach ($data as $key => $value){
        if($merchant_data != "")
            $merchant_data .= "&";
        $merchant_data.=$key.'='.$value;
    }

    $encrypted_data=payment_encrypt($merchant_data,$working_key);
    ?>

    <form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
        <?php
        echo "<input type=hidden name=encRequest value=$encrypted_data>";
        echo "<input type=hidden name=access_code value=$access_code>";
        ?>
    </form>
</center>
<script language='javascript'>document.redirect.submit();</script>

</body>
</html>

