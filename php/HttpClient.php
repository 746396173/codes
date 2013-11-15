<?php

/**
 * Author: dds_feng
 * Email: dds_feng@qq.com
 *
 * Example:
 * $http = new HttpClient(__DIR__.'/cookie.ck');
 * $http->setReferer('http://foo.com');//set request referer
 * echo $http->Get('http://foo.com/');//get
 * $http->setProxy('http://127.0.0.1:8888');//set http proxy
 * echo $http->Post('http://bar.com/xxx', array('a'=>'123', 'b'=>'456'));//post
 **/

class HttpClient{
	private $ch;

	function __construct($cookieJar){
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/4.0; QQDownload 685; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET4.0C; .NET4.0E)');//UA
		curl_setopt($this->ch, CURLOPT_TIMEOUT, 40);//timeout
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, TRUE);//follow redirection
		curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->ch, CURLOPT_ENCODING, 'UTF-8');
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);//ssl
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($this->ch, CURLOPT_COOKIEJAR, $cookieJar);//cookie jar
		curl_setopt($this->ch, CURLOPT_COOKIEFILE, $cookieJar);
	}

	function __destruct(){
		curl_close($this->ch);
	}

	final public function setProxy($proxy='http://192.168.0.103:3128'){
		//curl_setopt($this->ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
		curl_setopt($this->ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);//HTTP proxy
		//curl_setopt($this->ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);//Socks5 proxy
		curl_setopt($this->ch, CURLOPT_PROXY, $proxy);
	}

	final public function setReferer($ref=''){
		if($ref != ''){
			curl_setopt($this->ch, CURLOPT_REFERER, $ref);//Referrer
		}
	}

	final public function setCookie($ck=''){
		if($ck != ''){
			curl_setopt($this->ch, CURLOPT_COOKIE, $ck);//Cookie
		}
	}

	final public function Get($url, $header=false, $nobody=false){
		curl_setopt($this->ch, CURLOPT_POST, false);//GET
		curl_setopt($this->ch, CURLOPT_URL, $url);
		curl_setopt($this->ch, CURLOPT_HEADER, $header);//Response Header
		curl_setopt($this->ch, CURLOPT_NOBODY, $nobody);//Response Body
		return curl_exec($this->ch);
	}

	final public function Post($url, $data=array(), $header=false, $nobody=false){
		curl_setopt($this->ch, CURLOPT_URL, $url);
		curl_setopt($this->ch, CURLOPT_HEADER, $header);//Response Header
		curl_setopt($this->ch, CURLOPT_NOBODY, $nobody);//Response Body
		curl_setopt($this->ch, CURLOPT_POST, true);//POST
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));//data
		return curl_exec($this->ch);
	}

	final public function getError(){
		return curl_error($this->ch);
	}
}

// vim: noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
