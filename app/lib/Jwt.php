<?php 

class Jwt {
  public static function create(Array $datas, String $key, $hash = 'SHA256') {
    $header = ['typ' => "JWT", 'alg' => 'HS256'];
    $payload = [
        'iss' => config('other', 'baseUrl'),      // 簽發者
        'iat' => $_SERVER['REQUEST_TIME'],        // 簽發時間
        'exp' => $_SERVER['REQUEST_TIME'] + 7200, // 過期時間
    ];
    if ($datas && is_array($datas)) {
      $payload = array_merge($payload, $datas);
    }
  
    $jwt = self::_base64urlEncode(json_encode($header)) . '.' . self::_base64urlEncode(json_encode($payload));
    return $jwt . '.' . self::_createSignature($jwt, $key, $hash);
  }

  public static function decodeIdToken(String $token, String $key, String $aud, String $iss, $hash = 'SHA256') {
    $tokens = explode('.', $token);
    if (count($tokens) !== 3)
      return false;

    list($header64, $payload64, $sign) = $tokens;

    $headerDecode = self::_base64urlDecode($header64);
    $payloadDecode = self::_base64urlDecode($payload64);
    $signatureDecode = self::_base64urlDecode($sign);

    $target = $header64 . '.' . $payload64;

    if (!$check = self::_checkSignature($hash, $target, $key, $signatureDecode))
      return false;

    $payloadDecode = json_decode($payloadDecode, true);

    $time = $_SERVER['REQUEST_TIME'];
    if (isset($payloadDecode['iat']) && $payloadDecode['iat'] > $time)
      return false;

    if (isset($payloadDecode['exp']) && $payloadDecode['exp'] < $time)
      return false;

    if (isset($payloadDecode['iss']) && $payloadDecode['iss'] != $iss)
      return false;

    if (isset($payloadDecode['aud']) && $payloadDecode['aud'] != $aud)
      return false;

    foreach(['iss', 'aud', 'exp', 'iat'] as $value) {
      if (isset($payloadDecode[$value])) {
        unset($payloadDecode[$value]);
      }
    }

    return $payloadDecode;
  }

  public static function _createSignature(string $input, string $key, string $hash) {
    return self::_base64urlEncode(hash_hmac($hash, utf8_encode($input), utf8_encode($key), true));
  }

  private static function _checkSignature($hash, $target, $key, $signatureDecode) {
    $calcSignature = hash_hmac($hash, utf8_encode($target), utf8_encode($key), true);
    if ($signatureDecode != $calcSignature)
      return false;
    return true;
  }

  private static function _base64urlEncode($data) {                                                                                                                                           
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');                                                                                                              
  }

  private static function _base64urlDecode($data) {                                                                                                                                           
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));                                                                          
  } 
}