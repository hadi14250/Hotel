<?php

define('PAYTM_ENVIRONMENT', 'TEST'); // Change to 'PROD' for production
define('PAYTM_MERCHANT_KEY', 'a1l&MRLBLOrmuDGD'); // Sandbox merchant key
define('PAYTM_MERCHANT_MID', 'tKOskL16930420179530'); // Sandbox MID
define('PAYTM_MERCHANT_WEBSITE', 'WEBSTAGING'); // Sandbox website name
define('INDUSTRY_TYPE_ID', 'Retail'); //change this given by paytm
define('CHANNEL_ID', 'WEB'); //change this with website channel given by paytm
define('CALLBACK_URL', 'http://localhost/karma/pay_response.php'); //change this with callback url

$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
$PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';

if (PAYTM_ENVIRONMENT == 'PROD') {
	$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
	$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
}

define('PAYTM_REFUND_URL', '');
define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);

define('PAYTM_TXN_URL', $PAYTM_TXN_URL);
?>
