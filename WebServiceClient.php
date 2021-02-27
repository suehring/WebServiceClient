<?php

/* Woefully incomplete cURL class
 * that can be used as a web service client 
 * for CNMT 310
 */

class WebServiceClient {

	private $_ch;
	private $_method = "POST";
	private $_url = null;
	private $_reqHeaders = array();
	private $_returnxfer = 1;
	private $_postFields;
	private $_contentLength;
	private $_contentType;
	private $_curlOptions = array(
				CURLOPT_CUSTOMREQUEST => "POST", 
				CURLOPT_HTTPHEADER => array(),
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => null,
		);

	public function __construct($url = null) {
		$this->_url = $url;
		$this->_curlOptions[CURLOPT_URL] = $url;
		$this->_ch = curl_init($url);
	} //end function construct

	public function setReturnTransfer($xfer) {
		$this->_curlOptions[CURLOPT_RETURNTRANSFER] = $xfer;
		$this->returnxfer = $xfer;
	}

	public function getReturnTransfer() {
		return $this->returnxfer;
	}

	public function setMethod($method) {
		$this->_curlOptions[CURLOPT_CUSTOMREQUEST] = $method;
		$this->_method = $method;
	}  //end function setMethod

	public function getMethod() {
		return $this->_method;
	}

	public function setURL($url) {
		$this->_curlOptions[CURLOPT_URL] = $url;
		$this->_url = $url;
	}

	public function getURL() {
		return $this->_url;
	}

  public function ignoreSSL() {
    $this->_curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
  }

	public function setReqHeaders($header) {
		if (is_array($header)) {
			foreach ($header as $value) {
				array_push($this->_reqHeaders,$value);
			}
		} else {
			array_push($this->_reqHeaders,$header);
		}
	}
	
	public function getReqHeaders() {
		return $this->_reqHeaders;
	}

	public function send() {
		//this returns boolean, should check it
		$this->_curlOptions[CURLOPT_HTTPHEADER] = $this->_reqHeaders;
		foreach ($this->_curlOptions as $key => $value) {
			curl_setopt($this->_ch,$key,$value);
		}
		//curl_setopt_array($this->_ch,$this->_curlOptions);
		if (is_null($this->_url)) {
			return "Error: URL is not set";
		}
		$return = curl_exec($this->_ch);
		if ($return === false) {
      return "Error: " . curl_error($this->_ch);
    } else {
      return $return;
    }
	}

	public function setOption($option,$value) {
		$this->_curlOptions[$option] = $value;
		curl_setopt($this->_ch,$option,$value);
	}

	public function setPostFields($fields,$type="json") {
		if (!is_array($fields)) {
			return "Error: Send an array into setPostFields";
		}
		if ($type == "json") {
			$this->_postFields = json_encode($fields);
			$this->_contentType = "application/json";
		} else {
			$this->_postFields = $fields;
		}
		$this->_contentLength = strlen($this->_postFields);
		$header = "Content-Length: " . $this->_contentLength;
		$this->setReqHeaders($header);
		$this->setReqHeaders("Content-Type: " . $this->_contentType);
		$this->_curlOptions[CURLOPT_POSTFIELDS] = $this->_postFields;
	} //end setPostFields

} //end class WebServiceClient

/*
$client = new WebServiceClient("http://cnmt310.braingia.org/ziplookup.php");
//$client->setMethod("GET");
$apikey = "515051505150";
$username = "suehring";
$zip = "54481";
$data = array("apikey" => $apikey, "zip" => $zip, "username" => $username);
$client->setPostFields($data);
//var_dump($client);
print $client->send();
*/
