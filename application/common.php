<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function msubstr($str , $start=0 , $length , $charset="utf-8",$suffix=true){
    if(function_exists("mb_substr")){
        if($suffix){
            return mb_substr($str,$start,$length,$charset);
        }
        else {
            return mb_substr($str, $start, $length, $charset);
        }
    }
    elseif (function_exists('iconv_substr')) {
        if($suffix){
            return iconv_substr($str, $start, $length,$charset);
        }
        else{
            return iconv_substr($str,$start,$length,$charset);
        }
    }
}