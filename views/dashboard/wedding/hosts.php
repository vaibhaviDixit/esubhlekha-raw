<?php
locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

// current user id
$userID=App::getUser()['email'];

controller("Wedding");
$wedding = new Wedding();
$weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);
$hosts = json_decode($weddingData['hosts'], true);
?>

<head>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <h1 class="h2">Hosts</h1>

     	
     	<form id="form" method="post" class="form-wedding"  name="updateWedding" >
    	
			<?php
if (isset($_REQUEST['btn-submit'])) {
	
	$updateWedding = $wedding->update($_REQUEST['id'], $_REQUEST['lang'], $_REQUEST);

	if ($updateWedding['error']) {
		?>
		<div class="alert alert-danger">
			<?php
			foreach ($updateWedding['errorMsgs'] as $msg) {
				if (count($msg))
					echo $msg[0] . "<br>";
			}
			?>
		</div>
		<?php
	}else
	redirect("wedding/" . $_REQUEST['id'] ."/". $_REQUEST['lang'] ."/timeline");

}
	?>
    	<div class="row">

			<input type="text" hidden name="hosts">

		    <div class="mb-3 col-sm-6">
		      <label for="brideFather" class="form-label">Bride's Father</label>
		      <input type="text" class="form-control" id="brideFather" name="brideFather" placeholder="Enter Bride's Father Name" value="<?= $_REQUEST['brideFather'] ?? $hosts['brideFather']['name'] ?>" required>
		      <strong id="brideFatherMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>

		    <div class="mb-3 col-sm-6">
		      <label for="groomFather" class="form-label">Groom Father</label>
		      <input type="text" class="form-control" id="groomFather" name="groomFather" placeholder="Enter Groom's Father Name" value="<?= $_REQUEST['groomFather'] ?? $hosts['groomFather']['name'] ?>" required>
		      <strong id="groomFatherMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>

		    <div class="mb-3 col-sm-6">
		      <label for="brideMother" class="form-label">Bride Mother</label>
		      <input type="text" class="form-control" id="brideMother" name="brideMother" placeholder="Enter Bride's Mother Name" value="<?= $_REQUEST['brideMother'] ?? $hosts['brideMother']['name'] ?>" required>
		      <strong id="brideMotherMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>

		    <div class="mb-3 col-sm-6">
		      <label for="groomMother" class="form-label">Groom Mother</label>
		      <input type="text" class="form-control" id="groomMother" name="groomMother" placeholder="Enter Name" value="<?= $_REQUEST['groomMother'] ?? $hosts['groomMother']['name'] ?>" required >
		      <strong id="groomMotherMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>

		    <div class="mb-3 col-sm-6">
		      <label for="brideTagline" class="form-label">Bride Tagline</label>
		      <input type="text" class="form-control" id="brideTagline" name="brideTagline" placeholder="Eldest Daughter of .." value="<?= $_REQUEST['brideTagline'] ?? $hosts['brideTagline'] ?>" required>
		      <strong id="brideTaglineMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>

		    <div class="mb-3 col-sm-6">
		      <label for="groomTagline" class="form-label">Groom Tagline</label>
		      <input type="text" class="form-control" id="groomTagline" name="groomTagline" value="<?= $_REQUEST['groomTagline'] ?? $hosts['groomTagline'] ?>" placeholder="S/o" required >
		      <strong id="groomTaglineMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>

    	</div>

    <!-- Submit Button -->
    <button type="submit" id="btn-submit" name="btn-submit" class="btn btn-primary">Save & Next</button>
  </form>
    

</main>
<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>












