<?php

/* Woefull incomplete cURL class
 * that can be used as a web service client
 */

class WebServiceClient {

	private $_ch;
	private $_method = "POST";
	private $_url = null;
	private $_reqHeaders = array();
	private $_returnxfer = 1;
	private $_defaultCurlOptions = array(
				"CURLOPT_CUSTOMREQUEST" => "POST", 
				"CURLOPT_HTTPHEADER" => array(),
				"CURLOPT_RETURNTRANSFER" => 1,
				"CURLOPT_URL" => null,
		);

	public function __construct($url = null) {
		$this->_url = $url;
		$this->_ch = curl_init($url);
	} //end function construct

	public function setReturnTransfer($xfer) {
		$this->returnxfer = $xfer;
	}

	public function getReturnTransfer() {
		return $this->returnxfer;
	}

	public function setMethod($method) {
		$this->_method = $method;
	}  //end function setMethod

	public function getMethod() {
		return $this->_method;
	}

	public function setURL($url) {
		$this->_url = $url;
	}

	public function getURL() {
		return $this->_url;
	}

	public function setReqHeaders($header) {
		if (is_array($header)) {
			foreach ($header as $value) {
				array_push($this->_reqHeaders,$value);
			}
		} else {
			array_push($this->_reqHeaders,$value);
		}
	}
	
	public function getReqHeaders() {
		return $this->_reqHeaders();
	}

	public function sendReq() {
		//this returns boolean, should check it
		curl_setopt_array($this->_ch,$this->_curlOptions);
		if (is_null($this->_url)) {
			return "Error: URL is not set";
		}
		curl_exec($this->_ch);

	}

	public function setOption($option,$value) {
		$this->_curlOptions[$option] = $value;
		curl_setopt($this->_ch,$option,$value);
	}

} //end class WebServiceClient
