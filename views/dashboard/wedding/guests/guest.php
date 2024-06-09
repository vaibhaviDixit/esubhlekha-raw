<?php
// errors(1);

locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

DB::connect();
$weddings = DB::select('weddings', '*', "lang = 'en'")->fetchAll();
DB::close();

DB::connect();
$languages = enumToArray(DB::select('information_schema.COLUMNS', 'COLUMN_TYPE', "TABLE_NAME = 'weddings' AND COLUMN_NAME = 'lang'", 'COLUMN_TYPE DESC')->fetch()[0]);
DB::close();

controller("Wedding");
controller("Guest");

$wedding = new Wedding();
$guest=new Guest();
$weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);

$_REQUEST['weddingID']=$_REQUEST['id'];

$Guest=$guest->getGuest($_REQUEST['weddingID'],$_REQUEST['guestID']);

?>

<head>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    
    <a href="<?php echo route('wedding/' . $_REQUEST['id'] . '/' . $_REQUEST['lang'] . '/guests'); ?>" class="btn btn-primary">Back</a>

    <h1 class="h2">Update Guest</h1>
     <div>
     	
     	<form  method="post">

     		<?php

			if (isset($_POST['btn-submit'])) {
				// print_r($_REQUEST);
				$createGuest = $guest->updateGuest($_REQUEST);
				
                // print_r($createGuest);
				// die();

				if ($createGuest['error']) {
					?>
					<div class="alert alert-danger">
						<?php
						foreach ($createGuest['errorMsgs'] as $msg) {
							if (count($msg))
								echo $msg[0] . "<br>";
						}
						?>
					</div>
					<?php
				} else{
					redirect("wedding/" . $_REQUEST['weddingID'] . "/" . $_REQUEST['lang']."/guests");
				}

			}

			?>
    	
 <div class="row">
    <!-- Name -->
    <div class="mb-3 col-sm-4">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?= $Guest['name'] ?? '' ?>">
    </div>

    <!-- Email -->
    <div class="mb-3 col-sm-4">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?= $Guest['email'] ?? '' ?>">
    </div>

    <!-- Phone -->
    <div class="mb-3 col-sm-4">
        <label for="phone" class="form-label">Phone</label>
        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter Phone" value="<?= $Guest['phone'] ?? '' ?>">
    </div>
</div>

<div class="row">
    <!-- Gender -->
    <div class="mb-3 col-sm-3">
        <label for="gender" class="form-label">Gender</label>
        <select class="form-select" id="gender" name="gender">
            <option value="male" <?= ($Guest['gender'] ?? '') == 'male' ? 'selected' : '' ?>>Male</option>
            <option value="female" <?= ($Guest['gender'] ?? '') == 'female' ? 'selected' : '' ?>>Female</option>
            <option value="other" <?= ($Guest['gender'] ?? '') == 'other' ? 'selected' : '' ?>>Other</option>
        </select>
    </div>

    <!-- Age -->
    <div class="mb-3 col-sm-3">
        <label for="age" class="form-label">Age</label>
        <input type="number" class="form-control" id="age" name="age" placeholder="Enter Age" value="<?= $Guest['age'] ?? '' ?>">
    </div>

    <!-- Language -->
				<div class="mb-1 col-sm-3">
					<label for="lang" class="form-label">Language</label>
					<select class="form-select" id="lang" name="lang" required>
						<?php foreach ($languages as $lang) {
							?>
							<option value="<?= $lang ?>" <?php
							  if ($Guest['lang'] == $lang)
								  echo 'selected';
							  elseif ($lang == 'en')
								  echo 'selected' ?>>
								<?= Locale::getDisplayLanguage($lang, "en") ?>
							</option>
							<?php
						} ?>
					</select>
				</div>

    <!-- City -->
    <div class="mb-3 col-sm-3">
        <label for="city" class="form-label">City</label>
        <input type="text" class="form-control" id="city" name="city" placeholder="Enter City" value="<?= $Guest['city'] ?? '' ?>">
    </div>
</div>

<div class="row">
    <!-- Relation -->
    <div class="mb-3 col-sm-4">
        <label for="relation" class="form-label">Relation</label>
        <select class="form-select" id="relation" name="relation">
            <option value="friend" <?= ($Guest['relation'] ?? '') == 'friend' ? 'selected' : '' ?>>Friend</option>
            <option value="closeFriend" <?= ($Guest['relation'] ?? '') == 'closeFriend' ? 'selected' : '' ?>>Close Friend</option>
            <option value="relative" <?= ($Guest['relation'] ?? '') == 'relative' ? 'selected' : '' ?>>Relative</option>
            <option value="closeRelative" <?= ($Guest['relation'] ?? '') == 'closeRelative' ? 'selected' : '' ?>>Close Relative</option>
            <option value="brother" <?= ($Guest['relation'] ?? '') == 'brother' ? 'selected' : '' ?>>Brother</option>
            <option value="sister" <?= ($Guest['relation'] ?? '') == 'sister' ? 'selected' : '' ?>>Sister</option>
            <option value="mother" <?= ($Guest['relation'] ?? '') == 'mother' ? 'selected' : '' ?>>Mother</option>
            <option value="father" <?= ($Guest['relation'] ?? '') == 'father' ? 'selected' : '' ?>>Father</option>
            <option value="vip" <?= ($Guest['relation'] ?? '') == 'vip' ? 'selected' : '' ?>>VIP</option>
            <option value="colleague" <?= ($Guest['relation'] ?? '') == 'colleague' ? 'selected' : '' ?>>Colleague</option>
            <option value="boss" <?= ($Guest['relation'] ?? '') == 'boss' ? 'selected' : '' ?>>Boss</option>
            <option value="student" <?= ($Guest['relation'] ?? '') == 'student' ? 'selected' : '' ?>>Student</option>
            <option value="teacher" <?= ($Guest['relation'] ?? '') == 'teacher' ? 'selected' : '' ?>>Teacher</option>
        </select>
    </div>

    <!-- RSVP -->
    <div class="mb-3 col-sm-4">
        <label for="RSVP" class="form-label">RSVP</label>
        <select class="form-select" id="RSVP" name="RSVP">
            <option value="yes" <?= ($Guest['RSVP'] ?? '') == 'yes' ? 'selected' : '' ?>>Yes</option>
            <option value="no" <?= ($Guest['RSVP'] ?? '') == 'no' ? 'selected' : '' ?>>No</option>
        </select>
    </div>

    <!-- Arrival Time -->
    <div class="mb-3 col-sm-4">
        <label for="arrivalTime" class="form-label">Arrival Time</label>
        <input type="datetime-local" class="form-control" id="arrivalTime" name="arrivalTime" placeholder="Enter Arrival Time" value="<?= $Guest['arrivalTime'] ?? '' ?>">
    </div>
</div>

<div class="row">
    <!-- Travel Mode -->
    <div class="mb-3 col-sm-3">
        <label for="travelMode" class="form-label">Travel Mode</label>
        <select class="form-select" id="travelMode" name="travelMode">
            <option value="car" <?= ($Guest['travelMode'] ?? '') == 'car' ? 'selected' : '' ?>>Car</option>
            <option value="train" <?= ($Guest['travelMode'] ?? '') == 'train' ? 'selected' : '' ?>>Train</option>
            <option value="bus" <?= ($Guest['travelMode'] ?? '') == 'bus' ? 'selected' : '' ?>>Bus</option>
            <option value="flight" <?= ($Guest['travelMode'] ?? '') == 'flight' ? 'selected' : '' ?>>Flight</option>
        </select>
    </div>

    <!-- Transport Name -->
    <div class="mb-3 col-sm-3">
        <label for="transportName" class="form-label">Transport Name</label>
        <input type="text" class="form-control" id="transportName" name="transportName" placeholder="Enter Transport Name" value="<?= $Guest['transportName'] ?? '' ?>">
    </div>

    <!-- Pickup -->
    <div class="mb-3 col-sm-3">
        <label for="pickup" class="form-label">Pickup</label>
        <select class="form-select" id="pickup" name="pickup">
            <option value="yes" <?= ($Guest['pickup'] ?? '') == 'yes' ? 'selected' : '' ?>>Yes</option>
            <option value="no" <?= ($Guest['pickup'] ?? '') == 'no' ? 'selected' : '' ?>>No</option>
        </select>
    </div>

    <!-- Additional Guests -->
    <div class="mb-3 col-sm-3">
        <label for="additionalGuests" class="form-label">Additional Guests</label>
        <input type="number" class="form-control" id="additionalGuests" name="additionalGuests" placeholder="Enter Additional Guests" value="<?= $Guest['additionalGuests'] ?? '' ?>">
    </div>


</div>

<div class="row">
    <!-- Guest Message -->
    <div class="mb-3 col-sm-12">
        <label for="guestMessage" class="form-label">Guest Message</label>
        <textarea class="form-control" id="guestMessage" name="guestMessage" rows="3" placeholder="Enter Guest Message"><?= $Guest['guestMessage'] ?? '' ?></textarea>
    </div>
</div>




    <!-- Submit Button -->
    <button type="submit" id="submit-btn" name="btn-submit" class="btn btn-primary">Save & Next</button>
  </form>

     </div>
    

</main>
<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>












