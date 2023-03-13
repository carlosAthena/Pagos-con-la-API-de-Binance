# Pagos-con-la-API-de-Binance

![image](https://user-images.githubusercontent.com/119626823/224407596-f8f6828e-a1b9-4107-923e-9483b6236916.png)

# Pagos y consutlas a la API de Binance con PHP y Javascript

Este es un repositorio simple y rápido sobre cómo iniciar pagos criptográficos utilizando la API oficial de Binance. Puede usar esto para iniciar pagos de comercio electrónico o cualquier otro pago de su elección desde su sitio web.

## Binance utiliza endpoints, headers y bodys para dar acceso a la consulta y pago con criptomonedas

La API de Binance Pay utiliza claves de API para autenticar las solicitudes. Puede ver y administrar sus claves de API en el Portal de administración de comerciantes de Binance.

Para Node se utiliza

```bash
npm install crypto-js
```

## Node

```python
/* Orden de compra-venta en API de Binance */

// Declaración de las variables a utilizar

let AES = require("crypto-js/aes");
let SHA256 = require("crypto-js/sha256");

// Solicitud de librería CryptoJS

let CryptoJS = require("crypto-js");

let chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
let nonce = "";
for (let i = 1; i <= 32; i++) {
  let pos = Math.floor(Math.random() * chars.length);
  let char = chars.charAt(pos);
  nonce += char;
}
let timestamp = Math.round(new Date().getTime());

// Envío de parámetros para crear la orden

let request = {
  env: {
    terminalType: "APP",
  },
  merchantTradeNo: Math.floor(Math.random() * 9825382937292) + 982538,
  orderAmount: 0.01,
  currency: "BUSD",
  goods: {
    goodsType: "01",
    goodsCategory: "D000",
    referenceGoodsId: "7876763A3B",
    goodsName: "Ice Cream",
    goodsDetail: "Greentea ice cream cone",
  },
};

let json_request = JSON.stringify(request);

// Fórmula para crear el payload

let payload = timestamp + "\n" + nonce + "\n" + json_request + "\n";

// API Key y Secret de Binance

let binance_pay_key = "";
let binance_pay_secret = "";

// Fórmula para crear el signature

let signature = CryptoJS.HmacSHA512(payload, binance_pay_secret)
  .toString(CryptoJS.enc.Hex)
  .toUpperCase();

let headers = new Headers();
headers.append("Content-Type", "application/json");
headers.append("BinancePay-Timestamp", timestamp.toString());
headers.append("BinancePay-Nonce", nonce);
headers.append("BinancePay-Certificate-SN", binance_pay_key);
headers.append("BinancePay-Signature", signature);

// Endpoint para crear la orden de compra

fetch("https://bpay.binanceapi.com/binancepay/openapi/v2/order", {
  method: "POST",
  headers: headers,
  body: json_request,
})
  .then((response) => response.json())
  .then((data) => {
    console.log(data);
  })
  .catch((error) => console.error(error));
```

## PHP

```python
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
```



## License

[MIT](https://choosealicense.com/licenses/mit/)
