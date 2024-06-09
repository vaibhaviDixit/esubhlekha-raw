<?php

locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

DB::connect();
$weddings = DB::select('weddings', '*', "lang = 'en'")->fetchAll();
DB::close();

controller("Wedding");

$wedding = new Wedding();
$weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);

?>

<head>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <h1 class="h2">Additional Details</h1>

     <div>
     	
     	<form  method="post" enctype="multipart/form-data">

     		<?php

			if (isset($_POST['btn-submit'])) {

				controller("AWSBucket");
				$awsObj=new AWSBucket();
                
				// upload music to aws bucket
				if(!empty($_FILES['musicTrack']['name'])){
					$uploadedMusicURL = $awsObj->uploadToAWS($_FILES,'musicTrack');
					
					if(!empty($weddingData['music'])){
						$awsObj=new AWSBucket();
        				$awsObj->deleteFromAWS($weddingData['music']);
					}

					if($uploadedMusicURL['error']){
						echo '<div class="alert alert-danger">'.$uploadedMusicURL['errorMsg'].'</div>';
					}
					else{					
						$_REQUEST['music'] = $uploadedMusicURL['url'];	
					}
				}
                

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
				} else
					redirect("wedding/" . $_REQUEST['id'] . "/" . $_REQUEST['lang']."/our-story");

			}

			?>
    	
    <div class="row">
    		<!-- Groom Qualifications -->
			<div class="mb-3 col-6">
				<label for="groomQualifications" class="form-label">Groom Qualifications (Optional)</label>
				<input type="text" class="form-control" id="groomQualifications" name="groomQualifications"
					placeholder="B.Tech"
					value="<?= $_REQUEST['groomQualifications'] ?? $weddingData['groomQualifications'] ?>">
			</div>

			<!-- Bride Qualifications -->
			<div class="mb-3 col-6">
				<label for="brideQualifications" class="form-label">Bride Qualifications (Optional)</label>
				<input type="text" class="form-control" id="brideQualifications" name="brideQualifications"
					placeholder="B.Tech"
					value="<?= $_REQUEST['brideQualifications'] ?? $weddingData['brideQualifications'] ?>">
			</div>

			<!-- Groom Bio -->
			<div class="mb-3 col-sm-6">
				<label for="groomBio" class="form-label">Groom Bio (Optional)</label>
				<textarea class="form-control" id="groomBio" name="groomBio" placeholder="Enter Groom Bio"
					rows="3"><?= $_REQUEST['groomBio'] ?? $weddingData['groomBio'] ?></textarea>
			</div>

			<!-- Bride Bio -->
			<div class="mb-3 col-sm-6">
				<label for="brideBio" class="form-label">Bride Bio (Optional)</label>
				<textarea class="form-control" id="brideBio" name="brideBio" placeholder="Enter bride Bio"
					rows="3"><?= $_REQUEST['brideBio'] ?? $weddingData['brideBio'] ?></textarea>
			</div>
			
    </div>

    	<div class="row">
		    <div class="mb-3 col-sm-6">
		      <label for="musicTrack" class="form-label">Music Track</label>
		      
		      <input type="file" class="form-control" id="musicTrack" accept="audio/*" name="musicTrack">

		      <strong id="musicTrackMsg" class="text-danger errorMsg my-2 fw-bolder"><?php
			 	if(!empty($weddingData['music'])):
					?>
					<a class="ms-3" href="<?=$weddingData['music']?>" target="_blank">View File <i class="bi bi-box-arrow-up-right"></i> </a>
					<?php endif;?>
				</strong>
		    </div>

		    <div class="mb-3 col-sm-6">
		      <label for="ytLive" class="form-label">Youtube Live Integration</label>
		      
		      <input type="text" class="form-control" id="ytLive" placeholder="Enter Youtube Live URL" yturl name="youtube" value="<?= $_REQUEST['youtube'] ?? $weddingData['youtube'] ?>">

		      <strong id="ytLiveMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>

    	</div>

		<div class="row mt-3">
		    <div class="mb-3 col-sm-6">
		      <label for="accommodation" class="form-label">Accommodation Details</label>
		        <textarea class="form-control" id="accommodation" rows="3" name="accommodation"><?=$_REQUEST['accommodation'] ?? $weddingData['accommodation']?></textarea>
		      <strong id="accommodationMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>

		    <div class="mb-3 col-sm-6">
		      <label for="travel" class="form-label">Travel Details</label>
		        <textarea class="form-control" id="travel" rows="3" name="travel"><?=$_REQUEST['travel'] ?? $weddingData['travel']?></textarea>
		      <strong id="travelMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>

    	</div>

    <!-- Submit Button -->
    <button type="submit" id="submit-btn" name="btn-submit" class="btn btn-primary">Save & Next</button>
  </form>

     </div>
    

</main>
<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>












