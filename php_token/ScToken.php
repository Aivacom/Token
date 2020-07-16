<?php
class ScToken {

    private $appid;
    private $secret;
    private $version = 2;
    private $uid;
    private $validatorTimes;
    

    public static function buildToken($appid,$app_secrect,$version,$uid,$validatorTimes,$currentTime){
            // int length = length();
// ByteBuffer buffer = ByteBuffer.allocate( length );
        $bytes = array();
        $bytes_version = integerToBytes($version);
        $bytes = array_merge($bytes_version);

// buffer.order( ByteOrder.BIG_ENDIAN );
// buffer.putInt( scToken.getVersion() );
// buffer.putInt( length );
// buffer.putInt( scToken.getAppId() );
// buffer.putShort( scToken.getUidLen() );
// buffer.put( scToken.getUid() );
// buffer.putShort( (short) parameterProps.size() );
// writeParameterProperties(buffer,parameterProps);
// buffer.putShort((short) privilegeProps.size());
// writePrivilegeProperties(buffer,privilegeProps);
// buffer.putLong( scToken.getBuildTimestampMills() );
// buffer.putInt( scToken.getValidTime() );
// byte[] array = buffer.array();
// byte[] summary = hmac( Arrays.copyOfRange( array, 0, array.length - TokenLenConstants.SUMMARY_BYTE_LEN ), this.secret );
// buffer.put( summary );
// return buffer.array();
       return $bytes;
    }

    /**
     * 安全的base解码
     */
    function urlsafe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    /**
     * base64编码
     */
    function urlsafe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
      }
    

    /**
    * 转换一个String字符串为byte数组
    * @param $str 需要转换的字符串
    * @param $bytes 目标byte数组
    * @author Zikie
    */
    public function getBytes($str) {
        $bytes = array();
        for($i = 0; $i < strlen($str); $i++){
            $bytes[$i] = ord($str[$i]);
        }
        return $bytes;
    }
    
    /**
    * 将字节数组转化为String类型的数据
    * @param $bytes 字节数组
    * @param $str 目标字符串
    * @return 一个String类型的数据
    */
    public function toStr($bytes){
        $str = '';
        foreach($bytes as $ch) {
            $str .= chr($ch);
        }
        return $str;
    }
    /**
    * 转换一个int为byte数组
    * @param $byt 目标byte数组
    * @param $val 需要转换的字符串
    *
    */
    public function integerToBytes($val) {
        $byt = array();
        $byt[0] = ($val & 0xff);
        $byt[1] = ($val >> 8 & 0xff);
        $byt[2] = ($val >> 16 & 0xff);
        $byt[3] = ($val >> 24 & 0xff);
        return $byt;
    }
    
    
    /**
    * 从字节数组中指定的位置读取一个Integer类型的数据
    * @param $bytes 字节数组
    * @param $position 指定的开始位置
    * @return 一个Integer类型的数据
    */
    public function bytesToInteger($bytes, $position) {
        $val = 0;
        $val = $bytes[$position + 3] & 0xff;
        $val <<= 8;
        $val |= $bytes[$position + 2] & 0xff;
        $val <<= 8;
        $val |= $bytes[$position + 1] & 0xff;
        $val <<= 8;
        $val |= $bytes[$position] & 0xff;
        return $val;
    }
        
 
}
$sc = new ScToken();
$data = 'AAAAAgAAADlpO+LVAAcxNDM0ODkwAAAAAAAAAXINN3XwAAP0gBTOV4TO78gbCHLkQChEbnIUGC0A';
//将base64编码的字符串进行url安全编码
$data = str_replace(array('+','/','='),array('-','_',''),$data);

echo $data;
?>