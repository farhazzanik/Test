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
			$shortcode = $this->urlExistsInDb($url);
			if($shortcode == false){
				$shortcode = $this->createShortcode($url);
			}

			return $shortcode;
		}


		//validate url formate checking function
		protected function validateUrlFormate($url){
			//http://www.example.com)
			return filter_var($url,FILTER_VALIDATE_URL,FILTER_FLAG_HOST_REQUIRED);
		}

		//verfiry real url exists  function
		protected function verifyUrlExists($url){
			$ch =  crul_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_exec($ch);
			$response = curl_getinfo($ch,CURLINFO_HTTP_CODE);
			curl_close($ch)

			return (!empty($response) && $response != 404);
		}

		//checking url exists in DB
		protected function urlExistsInDb($url){
			$query = "SELECT * FROM ".self::$table." WHERE long_url= :long_url limit 1";
			$stmt = $this->pdo->prepare($query);
			$param = array(
				"long_url" => $url;
			)
			$stmt->execute($param);
			$result = $stmt->fetch();
			return (empty($result)) ? false : $result['short_code'];
		}


		//create shortcode
		protected function createShortcode($url){

				$shortcode = $this->generateRandomString(self:$codeLength);
				$id = $this->insertUrlInDB($url,$shortcode);
				return $shortcode;
		}

		protected function generateRandomString($length = 6){
			$sets = explode('|', self::$chars);
			$all = '';
			$randString = '';
			foreach ($sets as $set) {
				$randString.= $set[array_rand(str_split($set))];
				$all.=$set;
			}

			$all = str_split($all);
			for ($i=0; $i < $length - count($sets) ; $i++) { 
				$randString.= $all[array_rand($all)];
			}
			$randString = str_shuffle($randString);
			return $randString;
		}


		//insert URl in databse
		protected function insertUrlInDB($url , $code){
			$query = "INSERT INTO ".self::$table."(long_url,shortcode,created) VALUES(:long_url,:shortcode,:timestamp)";
			$stmt = $this->pdo->prepare($query);
			$param = array(
					"long_url" = $url;
					"shortcode" = $code;
					"timestamp" = $this->timestamp;
			);
			$stmt->execute($param);
			return $this->pdo->lastInsertId();

		}

		



	}

?>