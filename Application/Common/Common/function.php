<?php 
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=false){//截取固定长度的字符串
 	if(function_exists("mb_substr")){
		if($suffix&&(mb_strlen($str)>$length))
			return mb_substr($str, $start, $length, $charset)."…";
		else
			return mb_substr($str, $start, $length, $charset);
	}elseif(function_exists('iconv_substr')) {
		if($suffix&&(mb_strlen($str)>$length))
			return iconv_substr($str,$start,$length,$charset)."…";
		else
			return iconv_substr($str,$start,$length,$charset);
	}
	$re['utf-8'] = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";
	$re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";
	$re['gbk'] = "/[x01-x7f]|[x81-xfe][x40-xfe]/";
	$re['big5'] = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";
	preg_match_all($re[$charset], $str, $match);
	$slice = join("",array_slice($match[0], $start, $length));
	if($suffix) return $slice."…";
	return $slice;
}

function verify(){//验证码调用方法
	$Verify = new \Think\Verify();
	$Verify->fontSize = 16;
	$Verify->length   = 4;
	$Verify->useNoise = ture;
	$Verify->useCurve = false;
	$Verify->imageH = 30;
	$Verify->entry();
}

function check_verify($code, $id = ""){//检查验证码输入是否正确
	$verify = new \Think\Verify();
	return $verify->check($code, $id);
}  
?>