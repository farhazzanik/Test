
        //auto load data in table
        function loadData(){
            var tbody = document.getElementById('tbody');
            $.ajax({
                    url: 'loadData.php',
                    success: function(response) { 
                        tbody.innerHTML=response;
                        //submitbtn.disabled  = false; 

                    }
                });
        }
        loadData();

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
            var submitbtn = document.getElementById('submit');
            if(lognUrl.value.length > 0 ){
                $.ajax({
                    url: 'Shortener.php',
                    type: 'post',
                    data: { "autoLongUrl": lognUrl.value},
                    success: function(response) { 
                        shortcode.value=response;
                        submitbtn.disabled  = false; 

                    }
                });

            }else {
                  errorMessage.innerHTML = "Use Orginal URL...";  
                  errorMessage.classList.add('alert');
                  errorMessage.classList.add('alert-danger'); 
                  submitbtn.disabled  = true;
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
                            loadData();

                        }
                    });

                }else {
                  errorMessage.innerHTML = "Please Fill up data...";  
                  errorMessage.classList.add('alert');
                  errorMessage.classList.add('alert-danger'); 
            }      

        }

        //total click insert in database
        function totalHit(id){
            $.ajax({
                    url: 'Shortener.php',
                    type: 'post',
                    data: { "id": id},
                    success: function(response) { 
                        //console.log(response);
                        loadData();
                    }
            }); 
        }