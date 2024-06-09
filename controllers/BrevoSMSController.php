<?php

require 'brevosms/vendor/autoload.php';


class BrevoSMS {
    protected $config;
    protected $apiInstance;

    public function __construct() {

        $this->config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', 'xsmtpsib-1ce3c75ada664bf463ba02a19d64c7ca14314cbe7c4be28d5192384d9810bd24-NkcjYP4DKaUpFdW8');

		$this->apiInstance = new SendinBlue\Client\Api\TransactionalSMSApi(
		    new GuzzleHttp\Client(),
		    $this->config
		);
    }

    public function sendTransactionalSms($sender, $recipient, $content, $webUrl = null) {
        $sendTransacSms = new \SendinBlue\Client\Model\SendTransacSms();
        $sendTransacSms['sender'] = $sender;
        $sendTransacSms['recipient'] = $recipient;
        $sendTransacSms['content'] = $content;
        $sendTransacSms['type'] = 'transactional';
        if ($webUrl) {
            $sendTransacSms['webUrl'] = $webUrl;
        }

        try {
            $result = $this->apiInstance->sendTransacSms($sendTransacSms);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling TransactionalSMSApi->sendTransacSms: ', $e->getMessage(), PHP_EOL;
        }
    }
}


?>


