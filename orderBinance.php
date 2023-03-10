<?php

 /* Orden de compra en API de Binance */

// Declaración de las variables a utilizar

    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $nonce = '';
    for($i=1; $i <= 32; $i++)
    {
        $pos = mt_rand(0, strlen($chars) - 1);
        $char = $chars[$pos];
        $nonce .= $char;
    }
    $ch = curl_init();
    $timestamp = round(microtime(true) * 1000);

// Envío de parámetros para crear la consulta

     $request = array(
       "env" => array(
             "terminalType" => "APP" 
          ), 
       "merchantTradeNo" => mt_rand(982538,9825382937292), 
       "orderAmount" => 00.15, 
       "currency" => "BUSD", 
       "goods" => array(
                "goodsType" => "01", 
                "goodsCategory" => "D000", 
                "referenceGoodsId" => "7876763A3B", 
                "goodsName" => "Ice Cream", 
                "goodsDetail" => "Greentea ice cream cone" 
             ) 
    ); 
 
    $json_request = json_encode($request);

// Fórmula para crear el payload

    $payload = $timestamp."\n".$nonce."\n".$json_request."\n";

// API Key y Secret de Binance

    $binance_pay_key = "";
    $binance_pay_secret = "";

// Fórmula para crear el signature

    $signature = strtoupper(hash_hmac('SHA512',$payload,$binance_pay_secret));
    $headers = array();
    $headers[] = "Content-Type: application/json";
    $headers[] = "BinancePay-Timestamp: $timestamp";
    $headers[] = "BinancePay-Nonce: $nonce";
    $headers[] = "BinancePay-Certificate-SN: $binance_pay_key";
    $headers[] = "BinancePay-Signature: $signature";

// Endpoint para crear la orden de compra

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, "https://bpay.binanceapi.com/binancepay/openapi/v2/order");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_request);
    $result = curl_exec($ch);
    if (curl_errno($ch)) { echo 'Error:' . curl_error($ch); }
    curl_close ($ch);
    var_dump($result);

?>