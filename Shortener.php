<?php
	/**
	 * 
	 */


	require_once('dbConfig.php');
	$Shortener = new Shortener($db);
	$ajaxLongUrl = empty($_POST["lognUrl"]) ? "":$_POST["lognUrl"];
	$autoLongUrl = empty($_POST["autoLongUrl"]) ? "":$_POST["autoLongUrl"];
	$Usershortcode = empty($_POST["shortCode"]) ? "":$_POST["shortCode"];
	$shortUrl_prefix= 'https://abc.com/';
	$urlID = empty($_POST["id"]) ? "":$_POST["id"];

	if(!empty($ajaxLongUrl)){
		 try {
	        $shortcode = $Shortener->urlToShortCode($ajaxLongUrl,$Usershortcode);

	        $shortURL = $shortUrl_prefix.$shortcode;

	        echo $data = 'Short URL :'.$shortURL.'|'.$shortcode;
	        
	        
	    } catch (Exception $e) {
	        echo $e->getMessage();
	    }

	}

	if(!empty($autoLongUrl) && isset($_POST['autoLongUrl'])){
		 try {
		 	$shortcode  = $Shortener->urlExistsInDb($autoLongUrl);
		 	if($shortcode == false){
				 $shortcode = $Shortener->generateRandomString(6);
			}
	        echo $shortcode;
	        
	        
	    } catch (Exception $e) {
	        echo $e->getMessage();
	    }

	}

	if(!empty($urlID)){
		$upDatehit = $Shortener -> updateHit($urlID);
	}

	class Shortener 
	{
		
		protected static $chars = "abcdfghjkmnpqrstvwxyz|ABCDFGHJKLMNPQRSTVWXYZ|0123456789";
		protected static $table = "short_urls";
		protected static $checkUrlExists  = true;
		protected static $codeLength = 6;
		protected static $shortUrl_prefix= 'https://abc.com/';

		protected $pdo;
		protected $timestamp;

		public function __construct(PDO $pdo){
			$this->pdo = $pdo;
			$this->timestamp = date("Y-m-d H:i:s");
		}

		public function urlToShortCode($url , $Usershortcode){
			if(empty($url)){
				throw new Exception("URL not Found...");
			}

			if($this->validateUrlFormate($url) == false){
				throw new Exception("URL is not valid...");
				
			}
			if(self::$checkUrlExists){
				if(!$this->verifyUrlExists($url)){
					throw new Exception("URL doesn't apear to exist...");
				}
			}
			$shortcode = $this->urlExistsInDb($url);
			
			if($shortcode == false){
				$shortcode = $this->createShortcode($url , $Usershortcode);
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
			$ch =  curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_exec($ch);
			$response = curl_getinfo($ch,CURLINFO_HTTP_CODE);
			curl_close($ch);
			return (!empty($response) && $response != 404);
		}

		//checking url exists in DB
		public function urlExistsInDb($url){
			$query = "SELECT * FROM ".self::$table." WHERE long_url= :long_url limit 1";
			$stmt = $this->pdo->prepare($query);
			$param = array(
				"long_url" => $url
			);
			$stmt->execute($param);
			$result = $stmt->fetch();
			return (empty($result)) ? false : $result['short_code'];
		}


		//create shortcode
		protected function createShortcode($url , $Usershortcode){
				if(!empty($Usershortcode)){
					$shortcode = $Usershortcode;
				}else{

					$shortcode = $this->generateRandomString(self::$codeLength);
				}
				$id = $this->insertUrlInDB($url,$shortcode);
				return $shortcode;
		}

		public function generateRandomString($length = 6){
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
		public function insertUrlInDB($url , $code){
			$query = "INSERT INTO ".self::$table."(long_url,short_code,created,last_access_date) VALUES (:long_url, :shortcode, :timestamp ,:last_access_date)";
			$stmt = $this->pdo->prepare($query);
			$shortlink = self :: $shortUrl_prefix.$code;
			$param = array(
					"long_url" => $url,
					"shortcode" => $shortlink,
					"timestamp" => $this->timestamp,
					"last_access_date" => ""
			);
			$stmt->execute($param);
			return $this->pdo->lastInsertId();

		}

		//select data from databse
		public function showDatafromDB(){
			$data = $this->pdo->query("SELECT * FROM ".self::$table."  order by id desc ")->fetchAll(PDO::FETCH_ASSOC);
			return $data;
		}

		//update hit 
		public function updateHit($urlID){
			$query = "SELECT * FROM ".self::$table." WHERE id =:urlid limit 1";
			$stmt = $this->pdo->prepare($query);
			$param = array(
				"urlid" => $urlID
			);
			$stmt->execute($param);
			$result = $stmt->fetch();
			$newHit = $result["hits"] + 1;

			$Upquery = "UPDATE  ".self::$table." SET hits = :newhit , last_access_date = :last_access_date WHERE id = :urlid";
			$Upstmt = $this->pdo->prepare($Upquery);
			$Upparam = array(
					"newhit" => $newHit,
					"urlid" => $urlID,
					"last_access_date" => $this->timestamp
			);
			$Upstmt->execute($Upparam);
			return "success";
		}

	}



?>