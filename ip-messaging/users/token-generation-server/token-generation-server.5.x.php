<?php
// Get the PHP helper library from twilio.com/docs/php/install
require_once '/path/to/vendor/autoload.php'; // Loads the library
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;

// Required for all Twilio access tokens
$twilioAccountSid = 'ACxxxxxxxxxxxx';
$twilioApiKey = 'SKxxxxxxxxxxxx';
$twilioApiSecret = 'xxxxxxxxxxxxxx';

// Required for Chat grant
$chatServiceSid = 'ISxxxxxxxxxxxx';
// An identifier for your app - can be anything you'd like
$appName = 'TwilioChatDemo';
// choose a random username for the connecting user
$identity = "john_doe";
// A device ID should be passed as a query string parameter to this script
$deviceId = 'somedevice';
$endpointId = $appName . ':' . $identity . ':' . $deviceId;

// Create access token, which we will serialize and send to the client
$token = new AccessToken(
    $twilioAccountSid,
    $twilioApiKey,
    $twilioApiSecret,
    3600,
    $identity
);

// Create Chat grant
$chatGrant = new ChatGrant();
$chatGrant->setServiceSid($chatServiceSid);
$chatGrant->setEndpointId($endpointId);

// Add grant to token
$token->addGrant($chatGrant);

// return serialized token and the user's randomly generated ID
echo json_encode(
    array(
        'identity' => $identity,
        'token' => $token->toJWT(),
    )
);
