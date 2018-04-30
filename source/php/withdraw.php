<?php
header('Content-Type: text/html; charset=utf-8');
$ch = curl_init();
        $header = array(
            'Authorization: Basic ' . base64_encode('5a3a8af63c1eafcb268b4570:WJWkrJyaBr8QrDtkhsRwhcG74Bhkvud7'),
            'Ik-Api-Account-Id: 5a3a8af63c1eafcb268b4570'
        );
          $data = array(
            'amount' => 100, //Sum
            'paywayId' => '58bb79e53d1eaf89758b4567', //Payway ID
            'details' => array(			//Details from prm
                'tt' => '+79277870103', 
            ),
            'purseId' => '403633781593', // Withdrawal purse id
            'calcKey' => 'ikPayerPrice',// psPayeeAmount || ikPayerPrice
            'action' => 'process',         // calc || process
	    'paymentNo' => time() //pmNo
        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.interkassa.com/v1/withdraw');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);
        print_r($result);
?>