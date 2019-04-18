<?php

/***
 * @param string $msg  return notice message
 * @param int $code default 200 success
 * @param array $data  return data
 * @return array
 */
     function returnMessage($msg='',$code=200,$data=[])
    {
        return ['msg'=>$msg,'code'=>$code,'data'=>$data];
    }