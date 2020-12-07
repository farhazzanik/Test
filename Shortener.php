<?php
	/**
	 * 
	 */
	class Shortener 
	{
		
		protected static $chars = "abcdfghjkmnpqrstvwxyz|ABCDFGHJKLMNPQRSTVWXYZ|0123456789";
		protected static $table = "short_urls";
		protected static $checkUrlExists  = false;
		protected static $codeLength = 6;
		protected $pdo;
		protected $timestamp;

		public function __construct(PDO $pdo){
			$this->pdo = $pdo;
			$this->timestamp = date("Y-m-d H:i:s");
		}

		public function urlToShortCode($url){
			if(empty($url)){
				throw new Exception("URL not Found...");
			}

			if($this->validateUrlFormate($url) == false){
				throw new Exception("URL is not valid...");
				
			}
			if(self::$checkUrlExists){
				if(!$this->verifyUrlExists($url)){
					throw new Exception("URL doesn't apear to exist...")
				}
			}
		
		}

		protected function validateUrlFormate($url){
			//http://www.example.com)
			return filter_var($url,FILTER_VALIDATE_URL,FILTER_FLAG_HOST_REQUIRED);
		}

		protected function verifyUrlExists($url){
			$ch =  crul_init($url);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_exec($ch);
			$response = curl_getinfo($ch,CURLINFO_HTTP_CODE);
			curl_close($ch);
		}
	}

?>