<?php
include("IntHelper.php");
class ScTokenUtil
{
    const TOKEN_VERSION = 2; //Token版本

    const APP_ID = 1854229576;

    const APP_SECRET = 'OxhZuUd7m63PvnWd';

    /**
     * @param string $uid
     * @param array $parameter
     * @param array $privilege
     * @param int $valid_time
     * @return string
     */
    public static function createToken($uid, $parameter = [], $privilege = [], $valid_time = 0)
    {
        if (empty($uid)) {
            return null;
        }
        if ($valid_time == 0) {
            $valid_time = 86400 * 3; //Token 的有效时长，单位秒，默认3天
        }
        $parameter_bytes = IntHelper::uInt16(count($parameter));
        foreach ($parameter as $k => $v) {
            $parameter_bytes .= IntHelper::uInt16(strlen($k)) . $k . IntHelper::uInt16(strlen($v)) . $v;
        }
        $privilege_bytes = IntHelper::uInt16(count($privilege));
        foreach ($privilege as $k => $v) {
            $privilege_bytes .= IntHelper::uInt16(strlen($k)) . $k . IntHelper::uInt64($v);
        }
        $token_len = 50 + strlen($uid) + strlen($parameter_bytes) + strlen($privilege_bytes);
        $token_str = IntHelper::uInt32(self::TOKEN_VERSION) . IntHelper::uInt32($token_len) . IntHelper::uInt32(self::APP_ID)
            . IntHelper::uInt16(strlen($uid)) . $uid;
        $token_str .= $parameter_bytes;
        $token_str .= $privilege_bytes;
        $token_str .= IntHelper::uInt64((int) time() * 1000);
        $token_str .= IntHelper::uInt32($valid_time);
        $digital_signature = hash_hmac('sha1', $token_str, self::APP_SECRET, true);
        $token = self::urlsafeB64Encode($token_str . $digital_signature);
        if (substr($token, -1) == '=') { //去除末尾的 = 号
            $token = substr($token, 0, strlen($token) - 1);
        }
        return $token;
    }

    /**
     * @param $input
     * @return mixed|string|string[]
     */
    public static function urlsafeB64Encode($input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    /**
     * @param $input
     * @return bool|false|string
     */
    private static function urlsafeB64Decode($input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }
}
