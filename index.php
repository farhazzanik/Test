
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

                    <div>
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Short Link</th>
                              <th scope="col">Hit</th>
                              <th scope="col">Created Date</th>
                              <th scope="col">Last Access Date</th>
                            </tr>
                          </thead>
                          <tbody id="tbody">
                           
                          </tbody>
                        </table>
                    </div>
				</form>
		</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
  </body>
</html>