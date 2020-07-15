<?php 
	
	define("start", 3);
	define("length", 8);

	class TokenUtil
	{
		// const start = 3;
		// const length = 8;

		private $payloadMap;
		private $headerMap;

		// constructor
		public function __construct()
		{
			$argumentNum = func_num_args();
			$argument = func_get_args();
			$method = "__construct".$argumentNum;
			call_user_func_array(array($this,$method), $argument);	
		}


		public function __construct0()
		{
			$this->headerMap = null;
			$this->payloadMap = null;
		}


		public function __construct1($token)
		{
			$tokenArr = explode(".", $token);	// split token by . make it in head,s payload and signiture
			
			$header = $tokenArr[0];
			$payload = $tokenArr[1];
			$signiture = $tokenArr[2];

			// decode the header and payload
			$decodeHeader = $this->decode(base64_decode($header), a, b);
			$decodePayload = $this->decode(base64_decode($payload), a, b);

			// cover string header, payload to map data struture
			$this->headerMap = $this->converToMap($decodeHeader, "&");	
			$this->payloadMap = $this->converToMap($decodePayload, "&");

			$this->vertifyToken($this->headerMap, $this->payloadMap, $decodeHeader, $decodePayload, $signiture);
		}

		// from here to you see the next "///////////////" is encryption for sending token
		
		public function getToken($user, $password, $secreKey, $a, $b)
		{
			$header = array("typ" => "jwt", "alg" => "sha256");	// jwt header
			$payload = array("iss" => "Lber", "aud" => "Lber");		// jwt payload
			$payload["user"] = $user;
			$payload["password"] = $password;

			$encryptHeader = $this->getEncryptStr($header, $secreKey, $a, $b);	// using base 64 to encrpt

			$encryptPayload = $this->getEncryptStr($payload, $secreKey, $a, $b);

			$signature = $this->getSingiture($encryptHeader, $encryptPayload);

			return $encryptHeader.".".$encryptPayload.".".$signature;
		}


		//--------------------------------------------------------------------


		private function getEncryptStr($header)
		{
			$data = "";
			foreach($header as $key => $value)
			{
				$data = $data . $key . "=". $value . "&";
			}
			$data = substr($data, 0, strlen($data) - 1);
			return $this->encryption(base64_encode($data), 0, 0);
		}


		//--------------------------------------------------------------------

		private function encryption($data,$a, $b)
		{
			// left it for now
			return $data;
		}


		//--------------------------------------------------------------------


		private function getSingiture($encryptHeader, $encryptPayload)
		{
			$encodingString = $encryptHeader . "." . $encryptPayload;
			$signature = hash_hmac("sha256", $encodingString, secreKey);	// get signiture
			$signature = substr($signature, start, length);	// for more save other do not know which one i use

			return $signature;
		}


		////////////////////////////////////////////////////

		// here to end is for reciving token decryption

		public function vertifyHeader($headerMap)
		{
			if(!isset($headerMap["typ"]) || $headerMap["typ"] !== "jwt")
			{
				return false;
			}
			if(!isset($headerMap["alg"]) || $headerMap["alg"] !== "sha256")
			{
				return false;
			}

			return true;
		}


		//--------------------------------------------------------------------

		public function vertifyToken($headerMap, $payloadMap, $decodeHeader, $decodePayload, $signiture)
		{
			// vertify token
			if(!$this->vertifyHeader($headerMap) || !$this->vertifyPayload($payloadMap) || !$this->vertifySigniture($decodeHeader, $decodePayload, $signiture))
			{
				echo "verifing Error";
				exit("token verrifiing error");
			}
		}


		//--------------------------------------------------------------------

		public function vertifyPayload($payloadMap)
		{
			if(!isset($payloadMap["iss"]) || $payloadMap["iss"] !== "Lber")
			{
				return false;
			}
			if(!isset($payloadMap["aud"]) || $payloadMap["aud"] !== "Lber")
			{
				return false;
			}

			return true;
		}


		//--------------------------------------------------------------------


		private function converToMap($data, $c)
		{
			$contentArr = explode($c, $data);
			$contentMap = array();
			foreach($contentArr as $key => $value)
			{
				$splitEqual = explode("=", $value);
				$left = $splitEqual[0];
				$right = $splitEqual[1];
				$contentMap[$left] = $right;
			}

			return $contentMap;
		}


		//--------------------------------------------------------------------


		public function vertifySigniture($decodeHeader, $decodePayload, $signiture)
		{
			$encryptHeader = base64_encode($decodeHeader);	
			$encryptPayload = base64_encode($decodePayload);

			$vertifySigniture = $this->getSingiture($encryptHeader, $encryptPayload);

			if($vertifySigniture !== $signiture)
			{
				return false;
			}
			return true;
		}


		//--------------------------------------------------------------------

		private function decode($data, $a, $b)
		{
			return $data;
		}


		//--------------------------------------------------------------------

		// user have to run constructor with $token parameter first
		// if not run it first will reutrn null

		public function getPayloadMap()
		{
			return $this->payloadMap;
		}
	}

 ?>