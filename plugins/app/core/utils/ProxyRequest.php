<?php

namespace app\core\utils;

class ProxyRequest {

	public $proxy = null;

	public function getProxy(){
		
		$aHTTP['http']['header']          = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36\r\n";		
		$context = stream_context_create($aHTTP);
		$data = file_get_contents("https://antizapret.prostovpn.org/proxy.pac", false, $context);
		
		$re = '/HTTPS (.*); PROXY (.*); DIRECT/';		
		preg_match_all($re, $data, $matches, PREG_SET_ORDER, 0);		
		
		if (isset($matches[0]) && isset($matches[0][1])) {
			return $this->proxy = "ssl://" . $matches[0][1];			
		}
		
		// Fallback
		return $this->proxy = "ssl://proxy-ssl.antizapret.prostovpn.org:3143";
	}
	
	public function request($sURL) {
		
		if ($this->proxy == null) {
			$this->getProxy();
		}				

		$aHTTP['http']['proxy']           = $this->proxy;
		$aHTTP['http']['request_fulluri'] = true; 
		$aHTTP['http']['method']          = 'GET';
		$aHTTP['http']['header']          = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36\r\n";		

		$context = stream_context_create($aHTTP);
		return file_get_contents($sURL, false, $context);

	}
}