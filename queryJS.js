/* Consulta en API de Binance */

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

// Envío de parámetros para crear la consulta

let request = {
  env: {
    terminalType: "APP",
  },

  merchantTradeNo: null,
  prepayId: "216106764469239808",
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

// Endpoint para crear la orden de consulta

fetch("https://bpay.binanceapi.com/binancepay/openapi/v2/order/query", {
  method: "POST",
  headers: headers,
  body: json_request,
})
  .then((response) => response.json())
  .then((data) => {
    console.log(data);
  })
  .catch((error) => console.error(error));
