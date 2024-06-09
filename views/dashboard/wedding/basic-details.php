<?php

locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

DB::connect();
$languages = enumToArray(DB::select('information_schema.COLUMNS', 'COLUMN_TYPE', "TABLE_NAME = 'weddings' AND COLUMN_NAME = 'lang'", 'COLUMN_TYPE DESC')->fetch()[0]);
DB::close();


sort($languages);

controller("Wedding");
controller("Gallery");

$wedding = new Wedding();
$weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);
$story = json_decode($weddingData['story'], true);


function getImgURL($name){
	$gallery = new Gallery();
	$row=$gallery->getGalleryImg($_REQUEST['id'],$name);
	
	if($row['imageURL']){
		return $row['imageURL'];
	}
	else{
		return false;
	}
	
}


?>

<head>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">


		<h1 class="h2">Basic Details</h1>

	<form method="post" id="form" name="createWedding" class="form-wedding" enctype="multipart/form-data">

		<?php
	
		if (isset($_POST['btn-submit'])) {

				controller("AWSBucket");
				$awsObj=new AWSBucket();

				$_REQUEST['host'] = App::getUser()['userID'];
				$groomArray=array();
				$brideArray=array();
				$addToGalleryBride=array();
				$addToGalleryGroom=array();

				$groomArray['weddingID']=$_REQUEST['id'];
				$brideArray['weddingID']=$_REQUEST['id'];

				// upload bride img to aws bucket
				if(isset($_FILES['bride']['name']) && strlen($_FILES['bride']['name'])>0){
					$gallery = new Gallery();

					$uploadedURL = $awsObj->uploadToAWS($_FILES,'bride');
					if($uploadedURL['error']){
						echo '<div class="alert alert-danger">'.$uploadedURL['errorMsg'].'</div>';
					}
					else{					
						$brideArray['imageURL'] = $uploadedURL['url'];	
						$brideArray['imageName']='bride';
						$brideArray['type']='bride';
					}
					$addToGalleryBride = $gallery->update($brideArray);
					
				}

				 // upload groom img to aws bucket
				if(isset($_FILES['groom']['name']) && strlen($_FILES['groom']['name'])>0 ){
					$gallery = new Gallery();

					$uploadedURL = $awsObj->uploadToAWS($_FILES,'groom');
					if($uploadedURL['error']){
						echo '<div class="alert alert-danger">'.$uploadedURL['errorMsg'].'</div>';
					}
					else{					
						$groomArray['imageURL'] = $uploadedURL['url'];	
						$groomArray['imageName']='groom';
						$groomArray['type']='groom';
					}
					$addToGalleryGroom = $gallery->update($groomArray);
				}

				$_REQUEST['weddingID']=$_REQUEST['id'];
		
				$createWedding = $wedding->update($_REQUEST['id'],$_REQUEST['lang'],$_REQUEST);
				
				if ($createWedding['error']) {
					?>
					<div class="alert alert-danger">
						<?php
						foreach ($createWedding['errorMsgs'] as $msg) {
							if (count($msg))
								echo $msg[0] . "<br>";
						}
						?>
					</div>
					<?php
				}else if ($addToGalleryBride['error']) {
					?>
					<div class="alert alert-danger">
						<?php
						foreach ($addToGalleryBride['errorMsgs'] as $msg) {
							if (count($msg))
								echo $msg[0] . "<br>";
						}
						?>
					</div>
					<?php
				}else if ($addToGalleryGroom['error']) {
					?>
					<div class="alert alert-danger">
						<?php
						foreach ($addToGalleryGroom['errorMsgs'] as $msg) {
							if (count($msg))
								echo $msg[0] . "<br>";
						}
						?>
					</div>
					<?php
				} else{
					redirect("wedding/" . $_REQUEST['weddingID'] . "/" . $_REQUEST['lang'] . "/our-story");
				}

			}

		?>

			<div class="row">


				<!-- groom pic -->
			    <div class="col-sm-6 mx-auto">
			      <label for="groom" class="form-label" style="position: relative;">

			      	Groom Photo<br>
			      	    <img id="groomImage" src="<?php if(getImgURL('groom')){echo getImgURL('groom');}else{ echo assets('img/upload.png');} ?>" 
			      	    alt="Groom Image" class="rounded-circle" style="width: 150px; height: 150px;">

			      	    <span class="btn btn-sm btn-secondary capture"><i class="fas fa-camera"></i></span>

			      </label>

			    	<input type="file" class="form-control" id="groom" accept="image/*" name="groom"  onchange="displayGroomImage(this)">
			    </div>

     	<!--  bride pic -->
			    <div class="col-sm-6 mx-auto">
			      <label for="bride" class="form-label" style="position: relative;">

			      	Bride Photo<br>
			      	    <img id="brideImage" src="<?php if(getImgURL('bride')){echo getImgURL('bride');}else{ echo assets('img/upload.png');} ?>" alt="Bride Image" class="rounded-circle" style="width: 150px; height: 150px;">

			      	    <span class="btn btn-sm btn-secondary capture"><i class="fas fa-camera"></i></span>

			      </label>

			      <input type="file" class="form-control" id="bride" accept="image/*" name="bride"  onchange="displayBrideImage(this)" >

			    </div>
  		

				<!-- Groom Name -->
				<div class="mb-3 col-sm-6">
					<label for="groomName" class="form-label">Groom Name</label>
					<input type="text" class="form-control" id="groomName" name="groomName"
						placeholder="Enter Groom Name" value="<?= $_REQUEST['groomName'] ?? $weddingData['groomName'] ?>">
				</div>

				<!-- Bride Name -->
				<div class="mb-3 col-sm-6">
					<label for="brideName" class="form-label">Bride Name</label>
					<input type="text" class="form-control" id="brideName" name="brideName"
						placeholder="Enter Bride Name" value="<?= $_REQUEST['brideName'] ?? $weddingData['brideName'] ?>">
				</div>

				<!-- From (Bride/Groom) -->
				<div class="mb-3 col-sm-6">
					<label class="form-label" for="fromRole">From</label>

					<select class="form-select" id="fromRole" name="fromRole">
						<option value="bride" <?= ($weddingData['fromRole'] == 'bride') ? 'selected' : '' ?>>Bride</option>
						<option value="groom" <?= ($weddingData['fromRole'] == 'groom') ? 'selected' : '' ?>>Groom</option>

					</select>
				</div>

				<!-- Language -->
				<div class="mb-3 col-sm-6">
					<label for="lang" class="form-label">Language</label>
					<select class="form-select" id="lang" name="lang">
						<?php foreach ($languages as $lang) {
							?>
							<option value="<?= $lang ?>" <?php
							  if ($weddingData['lang'] == $lang)
								  echo 'selected';
							  elseif ($lang == 'en')
								  echo 'selected' ?>>
								<?= Locale::getDisplayLanguage($lang, "en") ?>
							</option>
							<?php
						} ?>
					</select>
				</div>
				<!-- Wedding Name -->
				<div class="mb-3 col-sm-6">
					<label for="weddingName" class="form-label">Wedding Name</label>
					<input type="text" class="form-control" id="weddingName" name="weddingName"
						placeholder="Thota vaari pelli sandhadi" value="<?= $_REQUEST['weddingName'] ?? $weddingData['weddingName'] ?>">
				</div>

				<!-- Wedding ID -->
				<div class="mb-3 col-sm-6">
					<label for="weddingID" class="form-label">Wedding ID</label>
					<input type="text" class="form-control" id="weddingID" name="weddingID"
						placeholder="KishoreWedsSwathi" value="<?= $_REQUEST['id'] ?>" readonly disabled>
				</div>
			</div>



		<!-- Submit Button -->
		<button type="submit" name="btn-submit" class="btn btn-primary">Save & Next</button>
	</form>

	</div>

</main>

<script type="text/javascript">
	
	//display bride img
			function displayBrideImage(input) {
			  const file = input.files[0];

			  if (file) {
			    const reader = new FileReader();
			    
			    reader.onload = function (e) {
			      document.getElementById('brideImage').src = e.target.result;

			    };

			    reader.readAsDataURL(file);
			  }
			  
			}

			// display groom img
			function displayGroomImage(input) {

			  const file = input.files[0];

			  if (file) {
			    const reader = new FileReader();

			    reader.onload = function (e) {
			      document.getElementById('groomImage').src =e.target.result;

			    };

			    reader.readAsDataURL(file);
			  }

			}


</script>

<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>