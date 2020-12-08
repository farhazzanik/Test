<?php
	// require_once('dbConfig.php');

 //    require_once('Shortener.php');
 //    $Shortener = new Shortener($db);
    // $longURL = 'https://www.codexworld.com/tutorials/php/';
    // $shortUrl_prefix= 'https://abc.com/';

    // try {
    //     $shortcode = $Shortener->urlToShortCode($longURL);

    //     $shortURL = $shortUrl_prefix.$shortcode;

    //     echo 'shortUrl : '.$shortURL;
        
    // } catch (Exception $e) {
    //     echo $e->getMessage();
    // }


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
  		<div class="container-sm col-md-4" >
  				<form name="form1" action="#">
                    <div id="alert-danger" role="alert">
                    </div>
			    	<div class="mb-3">
					  <label for="exampleFormControlInput1" class="form-label">Orginal URL</label>
					  <input type="text" class="form-control" id="orgUrl" placeholder="https://www.facebook.com/FarhaZz.Anik3/">
					</div>
					<div class="mb-3">
					  <label for="exampleFormControlInput1" class="form-label">Short URL</label>
					  <div class="input-group">
						  <input type="text" class="form-control" id="shortcode" name="shortcode" placeholder="shortcode"  onkeyup="checkCharacter()">
						  <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="generateId()" >
						  	<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-clockwise" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							  <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
							  <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
							</svg>
						  </button>
					  </div>
                       <span id="errortext"></span>
					</div>
					<div class="mb-3">
					 <button type="button" class="btn btn-success" id="submit" disabled name="submit" onclick="submitData()" >Submit</button>
					</div>
				</form>
		</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript">
    	//checking text fields length more than 4 character
    	function checkCharacter(){
    		var shortcode = document.getElementById('shortcode');
    		var errortext = document.getElementById('errortext');
    		var submitbtn = document.getElementById('submit');
            var lognUrl = document.getElementById('orgUrl');
    		if(shortcode.value.length < 4){
    			errortext.innerHTML= "It shoud be  4 Characters or more...";
    			errortext.style.color = 'red';
    			shortcode.style.borderColor = 'red'
                submitbtn.disabled  = true;
    		}else {
    			errortext.innerHTML= "";
    			shortcode.style.borderColor = 'green';
    			submitbtn.disabled  = false;
    			
    		}
    	}

        //Auto Generate Short Link
        function generateId(){
            var lognUrl = document.getElementById('orgUrl');
            var errorMessage = document.getElementById('alert-danger');
            var shortcode = document.getElementById('shortcode');
            if(lognUrl.value.length > 0 ){
                $.ajax({
                    url: 'Shortener.php',
                    type: 'post',
                    data: { "lognUrl": lognUrl.value},
                    success: function(response) { 
                        var str = response.split("|");
                        errorMessage.innerHTML = str[0];
                        shortcode.value=str[1]; 
                        errorMessage.classList.add('alert');
                        errorMessage.classList.add('alert-danger');

                    }
                });

            }else {
                  errorMessage.innerHTML = "Use Orginal URL...";  
                  errorMessage.classList.add('alert');
                  errorMessage.classList.add('alert-danger'); 
            }      
        }

        //Insert Data in Database
        function submitData(){
            var lognUrl = document.getElementById('orgUrl');
            var errorMessage = document.getElementById('alert-danger');
            var shortcode = document.getElementById('shortcode');
            if(lognUrl.value.length > 0  && shortcode.value.length > 3){
                    $.ajax({
                        url: 'Shortener.php',
                        type: 'post',
                        data: { "lognUrl": lognUrl.value,"shortCode" : shortcode.value },
                        success: function(response) { 
                            var str = response.split("|");
                            errorMessage.innerHTML = str[0];
                            errorMessage.classList.add('alert');
                            errorMessage.classList.add('alert-danger');

                        }
                    });

                }else {
                  errorMessage.innerHTML = "Please Fill up data...";  
                  errorMessage.classList.add('alert');
                  errorMessage.classList.add('alert-danger'); 
            }      

        }
    </script>
  </body>
</html>