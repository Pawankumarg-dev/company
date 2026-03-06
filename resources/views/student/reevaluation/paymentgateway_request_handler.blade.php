<html>
<head>
    <title> Redirecting to payment gateway</title>
</head>
<body>
@include('paymentgateway.CryptoNew') Redirecting to payment gateway... Please do not close the window..
    <?php

    error_reporting(0);

    $merchant_data="";
  //  $working_key='8D29080EBDBF0C2E451319B1183A12EF';//Shared by CCAVENUES
   // $access_code='AVAY53IJ99BL03YALB';//Shared by CCAVENUES
    $nber_id = Session::get('nber_id');
    $working_key = \App\Configuration::where('attribute','ccavenue_working_key_nber_'.$nber_id)->first()->value;
    $access_code = \App\Configuration::where('attribute','ccavenue_access_code_nber_'.$nber_id)->first()->value;
   /* foreach ($data as $key => $value){
        if($merchant_data != "")
            $merchant_data .= "&";
        $merchant_data.=$key.'='.$value;
    } */
    $data = Session::get('data');

    foreach ($data as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}

    Session::forget('data');

    $encrypted_data=payment_encrypt($merchant_data,$working_key);
    ?>
    <form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction">

  {{--  <form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
      --}}
      <?php
        echo "<input type=hidden name=encRequest value=$encrypted_data>";
        echo "<input type=hidden name=access_code value=$access_code>";
        ?>
    </form>
    <script language='javascript'>document.redirect.submit();</script> 
</body>
</html>



