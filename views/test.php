<?php

errors(1);

// controller('Theme');

// Instantiate the ThemeController class
// $themeController = new ThemeController();

// Call the getThemes method
// $themes = $themeController->render('fairytale_theme', $_REQUEST['type']);

controller('BrevoSMS');

// API: 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


// Usage
// $brevoSms = new BrevoSMS();
// $sender = 'Vaibhavi';
// $recipient = '+918767431102';
// $message = 'Hello OTP: 34563!';
// $webUrl = '';
// $brevoSms->sendTransactionalSms($sender, $recipient, $message);

// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md

    require_once './assets/vendor/twilio/src/Twilio/autoload.php';
    use Twilio\Rest\Client;

    $sid    = "ACa27fa54e8cf3ae1112b707df2b4e26fd";
    $token  = "3be89c6c664a9c9282ce9899a2307646";
    $twilio = new Client($sid, $token);

    $message = $twilio->messages
      ->create("+919121325466", // to
        array(
          "from" => "+12512377457",
          "body" => "Hello sir, text me on Whatsapp if you receive this sms, from: vaibhavi"
        )
      );

print_r($message);






