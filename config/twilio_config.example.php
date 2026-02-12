<?php
/**
 * Twilio credentials for SMS and WhatsApp.
 * Copy this file to twilio_config.php and fill in your values from https://console.twilio.com
 */
return [
    'account_sid'   => 'ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
    'auth_token'    => 'your_auth_token',
    'from_sms'      => '+1234567890',           // Your Twilio phone number (E.164)
    'from_whatsapp' => 'whatsapp:+14155238886', // WhatsApp sandbox or your Twilio WhatsApp number
];
