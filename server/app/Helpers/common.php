<?php
/***
 * @param string $msg
 * @param array $data
 * @param int $statusCode=200
 * @return \Illuminate\Http\JsonResponse
 */
if (! function_exists('message')) {
    function message($msg = '', $data = [], $statusCode = 200)
    {
        return response()->json(['msg' => $msg, 'data' => $data], $statusCode);
    }
}

/***
 * @return string  return six random numbers
 */
if(!function_exists('sixRandom')) {
    function sixRandom()
    {
        $length = 6;
        $chars = '0123456789';
        $code = '';
        while (mb_strlen($code) < $length) {
            $code .= mb_substr($chars, (mt_rand() % mb_strlen($chars)), 1);
        }
        return $code;
    }
}

/***
 * @param $phone
 * @return bool
 */
if(!function_exists('isPhone')) {

    function isPhone($phone)
    {
        if (preg_match('/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\\d{8}$/', $phone)) {
            return true;
        }

        return false;
    }
}

/***
 * @param $email
 * @return bool
 */
if(! function_exists('isEmail')) {

    function isEmail($email)
    {
        if (preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/', $email)) {
            return true;
        }

        return false;
    }
}

if(!function_exists('')){

    function array_value_to_int(array $array){
       return array_map('toInt',$array);
    }

    function toInt($v){
        return intval($v);
    }
}

