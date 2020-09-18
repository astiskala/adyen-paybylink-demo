<?php
  $url = "https://checkout-test.adyen.com/v52/paymentLinks";
  $apikey = "INSERT_API_KEY_HERE";
  $merchantAccount = "INSERT_MERCHANT_ACCOUNT_KEY_HERE";
  $currency = "AUD";
  $countryCode = "AU";
  $locale = "en-US";
?>
<!doctype html>
<html lang="">
<head>
    <meta charset="utf-8">
    <title>Pay by Link</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <style>.details{padding-bottom:18px;width:100%}h1{color:#00112c;font-size:1.25em;font-weight:600;line-height:24px;margin:16px 0 6px}.modal-wrapper{display:-webkit-box;height:100%;left:0;overflow-y:auto;padding:24px;position:fixed;top:0;visibility:hidden;width:100%;z-index:1}.modal-wrapper:before{background:rgba(0,17,44,.5);content:"";height:100%;left:0;opacity:0;position:fixed;top:0;transition:opacity .3s linear;width:100%;z-index:10}.modal-wrapper--open{visibility:visible}.modal-wrapper--open:before{opacity:1}.modal-wrapper--open .modal{opacity:1;transform:scale(1)}.modal{border-radius:12px;background-color:#fff;margin:auto;transition:opacity .2s ease,visibility .2s ease;opacity:0;transform:scale(.7);position:relative;z-index:11}@media (min-width:600px){.modal{min-height:200px;transition:opacity .2s ease,visibility .2s ease,-webkit-transform .2s ease;width:464px}}.modal__header{border-bottom:1px solid #e6e9eb;display:-webkit-box;font-size:1.25em;font-weight:700;min-height:63px;padding:14px 14px 10px 16px}.modal__header__icon{background:transparent;border:none;border-radius:50%;cursor:pointer;height:38px;margin:0;padding:0;transition:background .1s linear;width:38px}.modal__header__icon:hover{background:#f7f8f9}.modal__header__icon:focus{background:#e6e9eb;outline:0}.modal-wrapper.modal-wrapper--termsAndConditions .modal__content{padding:16px}@media (min-width:600px){.modal-wrapper.modal-wrapper--termsAndConditions .modal__content{padding:24px}}.modal-wrapper.modal-wrapper--termsAndConditions .modal__content .termsAndConditionsText{font-size:13px;margin-bottom:16px}@media (min-width:600px){.modal-wrapper.modal-wrapper--termsAndConditions .modal__content .termsAndConditionsText{margin-bottom:24px}}.modal-wrapper.modal-wrapper--termsAndConditions .modal__content .button{width:100%}*,:after,:before{box-sizing:border-box}body,html{height:100%;width:100%}body{background:#fff;color:#00112c;margin:0;min-height:100vh;padding:0;position:relative;font:16px -apple-system,BlinkMacSystemFont,sans-serif}button{font-family:inherit}.wrapper{background:#fff;height:auto;min-height:100vh;padding:0 0 56px;position:relative;display:-webkit-box}@media (min-width:600px){.wrapper{padding:88px 0}}@media (min-width:1200px){.wrapper{height:auto;padding:0;position:relative}}.main{background:#fff;margin:0 auto;min-height:100px;height:100%;display:-webkit-box;padding:0 16px 16px;width:100%;z-index:1}@media (min-width:600px){.main{border-radius:12px;box-shadow:0 0 12px rgba(0,17,44,.2);max-width:490px;padding:24px;position:relative;width:100%}}@media (min-width:1200px){.main{margin:120px 0 24px 120px}}.checkout--hidden{display:none}.checkout--loading{position:relative}.link{color:#06f;text-decoration:none;transition:box-shadow .3s ease-out}.link:hover{text-decoration:underline}.link:focus{border-radius:3px;box-shadow:0 0 0 2px #99c2ff;outline:0}.button{background-color:#00112c;border:0;border-radius:6px;color:#fff;cursor:pointer;font-size:1em;font-weight:500;height:48px;padding:15px 25px;text-align:center;text-decoration:none;transition:background .3s ease-out,box-shadow .3s ease-out}.button:active{background:#3a4a5c}.button:focus{box-shadow:0 0 0 2px #99c2ff;outline:0}.label{display:block}.label__text{transition:color .1s ease-out;display:block;overflow:hidden;white-space:nowrap;color:#00112c;font-size:.81em;font-weight:400;line-height:13px;padding-bottom:5px}.input{color:#00112c;display:block;height:40px;background:#fff;border:1px solid #b9c4c9;border-radius:6px;padding:5px 8px;position:relative;outline:none;width:100%;transition:border .2s ease-out,box-shadow .2s ease-out;font:1em inherit}.inputfield{height:100%;width:100%;display:block;border:none}.button{background:#00112c;border:0;border-radius:6px;color:#fff;cursor:pointer;font-size:1em;font-weight:500;height:48px;margin:0;padding:15px;text-decoration:none;transition:background .3s ease-out,box-shadow .3s ease-out;width:100%}</style>
  </head>
  <body>
    <div>
       <div>
          <div style="background: linear-gradient(rgb(255, 255, 255) 50%, rgba(0, 0, 0, 0) 50%);"></div>
       </div>
       <div class="main">
          <div class="details">

<?php

$postData = file_get_contents("php://input");
if ($postData != "") {
    parse_str($postData, $params);
    $requestString = '{
      "reference": "' . addslashes($params["reference"]) . '",
      "amount": {
        "value": ' . $params["amount"] * 100 . ',
        "currency": "' . $currency . '"
      },
      "countryCode": "' . $countryCode . '",
      "merchantAccount": "' . $merchantAccount . '",
      "shopperLocale": "' . $locale . '"
    }';
    error_log($requestString);

    $curlAPICall = curl_init();
    curl_setopt($curlAPICall, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curlAPICall, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curlAPICall, CURLOPT_POSTFIELDS, $requestString);
    curl_setopt($curlAPICall, CURLOPT_URL, $url);

    $headers = array(
        "X-Api-Key: " . $apikey,
        "Content-Type: application/json",
        "Content-Length: " . strlen($requestString)
    );

    curl_setopt($curlAPICall, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curlAPICall);
    error_log($response);
    curl_close($curlAPICall);
    $json_result = json_decode($response);
    $url = $json_result->{"url"};
?>
            Please wait...
            <script>
              window.location.replace('<?php echo $url; ?>');
            </script>
<?php
} else {
?>
            <h1>Make a Payment</h1>
            <br>
            <form action="index.php" method="post">
              <label class="label"><span class="label__text">Payment amount</span><span class="input adyen-checkout__input--large"><input class="inputfield" type="number" required name="amount" min="0" step=".01" pattern="^\d*(\.\d{0,2})?$"></span></label>
              <br>
              <label class="label"><span class="label__text">Invoice number</span><span class="input adyen-checkout__input--large"><input class="inputfield" type="text" required name="reference"></span></label>
              <br>
              <input class="button" type="submit" value="Next">
            </form>
<?php
}
?>
          </div>
       </div>
    </div>
  </body>
</html>
