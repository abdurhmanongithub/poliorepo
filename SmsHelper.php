<?php

namespace App;

use Andegna\DateTimeFactory;
use Exception;
use GsmEncoder;
use SMPP;
use SmppAddress;
use SmppClient;
use TSocket;


$GLOBALS['SMPP_ROOT'] = dirname(__FILE__);
require_once $GLOBALS['SMPP_ROOT'] . '/protocol/smppclient.class.php';
require_once $GLOBALS['SMPP_ROOT'] . '/protocol/gsmencoder.class.php';
require_once $GLOBALS['SMPP_ROOT'] . '/transport/tsocket.class.php';

class SmsHelper
{
    
    static function sendSms($phone, $message)
    {

        // dd('d');

        try {
            // Construct transport and client, customize settings
            $transport = new TSocket(env('SMPP_HOST'), env('SMPP_PORT'), false);
            $transport->setRecvTimeout(10000);
            $transport->setSendTimeout(10000);
            $smpp = new SmppClient($transport);

            // Activate debug of server interaction
            $smpp->debug = true; // binary hex-output
            $transport->setDebug(true); // also get TSocket debug


            // Open the connection
            $transport->open();
            $smpp->bindTransmitter(env('SMPP_USER_NAME'), env('SMPP_PASSWORD'));




            // Prepare message
            $encodedMessage = GsmEncoder::utf8_to_gsm0338($message);
            if (strlen($phone) == 10 || strlen($phone) == 9 || strlen($phone) == 13) {
                if (str_starts_with($phone, '+251')) {
                    $phone = $phone;
                } elseif (str_starts_with($phone, '09')) {
                    $phone = '+251' . ltrim($phone, $phone[0]);
                } elseif (str_starts_with($phone, '9')) {
                    $phone = '+251' . $phone;
                } else {
                    throw new Exception("Ivalid  Phone NUmber", 1);
                }
            }

            $from = new SmppAddress(GsmEncoder::utf8_to_gsm0338(env('SMPP_SOURCE_ADDRESS')), SMPP::TON_ALPHANUMERIC);
            $to = new SmppAddress($phone, SMPP::TON_INTERNATIONAL, SMPP::NPI_E164);

            // Send
            $sms =   $smpp->sendSMS($from, $to, $encodedMessage);
            return $sms;


            // Close connection
            $smpp->close();
        } catch (Exception $e) {
            throw $e;
            // Try to unbind
            try {
                $smpp->close();
            } catch (Exception $ue) {
                // if that fails just close the transport


                if ($transport->isOpen())
                    $transport->close();
            }

            // Rethrow exception, now we are unbound or transport is closed
            return $e;
        }
    }
}
