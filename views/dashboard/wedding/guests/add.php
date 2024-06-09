<?php
die();
errors(1);

locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

DB::connect();
$weddings = DB::select('weddings', '*', "lang = 'en'")->fetchAll();
DB::close();

controller("Wedding");
controller("Guest");

$wedding = new Wedding();
$guest=new Guest();
$weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);

$_REQUEST['weddingID']=$_REQUEST['id'];

?>

<head>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <h1 class="h2">Add Guest</h1>

     <div>
     	
     	<form  method="post">

     		<?php

			if (isset($_POST['btn-submit'])) {

				$createGuest = $guest->create($_REQUEST);

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
					redirect("wedding/" . $_REQUEST['id'] . "/" . $_REQUEST['lang']."/guests");
				}

			}

			?>
    	
 <div class="row">
    <!-- Name -->
    <div class="mb-3 col-sm-4">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?= $_REQUEST['name'] ?? '' ?>">
    </div>

    <!-- Email -->
    <div class="mb-3 col-sm-4">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?= $_REQUEST['email'] ?? '' ?>">
    </div>

    <!-- Phone -->
    <div class="mb-3 col-sm-4">
        <label for="phone" class="form-label">Phone</label>
        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter Phone" value="<?= $_REQUEST['phone'] ?? '' ?>">
    </div>
</div>

<div class="row">
    <!-- Gender -->
    <div class="mb-3 col-sm-4">
        <label for="gender" class="form-label">Gender</label>
        <select class="form-select" id="gender" name="gender">
            <option value="male" <?= ($_REQUEST['gender'] ?? '') == 'male' ? 'selected' : '' ?>>Male</option>
            <option value="female" <?= ($_REQUEST['gender'] ?? '') == 'female' ? 'selected' : '' ?>>Female</option>
            <option value="other" <?= ($_REQUEST['gender'] ?? '') == 'other' ? 'selected' : '' ?>>Other</option>
        </select>
    </div>

    <!-- Age -->
    <div class="mb-3 col-sm-4">
        <label for="age" class="form-label">Age</label>
        <input type="number" class="form-control" id="age" name="age" placeholder="Enter Age" value="<?= $_REQUEST['age'] ?? '' ?>">
    </div>

    <!-- City -->
    <div class="mb-3 col-sm-4">
        <label for="city" class="form-label">City</label>
        <input type="text" class="form-control" id="city" name="city" placeholder="Enter City" value="<?= $_REQUEST['city'] ?? '' ?>">
    </div>
</div>

<div class="row">
    <!-- Relation -->
    <div class="mb-3 col-sm-4">
        <label for="relation" class="form-label">Relation</label>
        <select class="form-select" id="relation" name="relation">
            <option value="friend" <?= ($_REQUEST['relation'] ?? '') == 'friend' ? 'selected' : '' ?>>Friend</option>
            <option value="closeFriend" <?= ($_REQUEST['relation'] ?? '') == 'closeFriend' ? 'selected' : '' ?>>Close Friend</option>
            <option value="relative" <?= ($_REQUEST['relation'] ?? '') == 'relative' ? 'selected' : '' ?>>Relative</option>
            <option value="closeRelative" <?= ($_REQUEST['relation'] ?? '') == 'closeRelative' ? 'selected' : '' ?>>Close Relative</option>
            <option value="brother" <?= ($_REQUEST['relation'] ?? '') == 'brother' ? 'selected' : '' ?>>Brother</option>
            <option value="sister" <?= ($_REQUEST['relation'] ?? '') == 'sister' ? 'selected' : '' ?>>Sister</option>
            <option value="mother" <?= ($_REQUEST['relation'] ?? '') == 'mother' ? 'selected' : '' ?>>Mother</option>
            <option value="father" <?= ($_REQUEST['relation'] ?? '') == 'father' ? 'selected' : '' ?>>Father</option>
            <option value="vip" <?= ($_REQUEST['relation'] ?? '') == 'vip' ? 'selected' : '' ?>>VIP</option>
            <option value="colleague" <?= ($_REQUEST['relation'] ?? '') == 'colleague' ? 'selected' : '' ?>>Colleague</option>
            <option value="boss" <?= ($_REQUEST['relation'] ?? '') == 'boss' ? 'selected' : '' ?>>Boss</option>
            <option value="student" <?= ($_REQUEST['relation'] ?? '') == 'student' ? 'selected' : '' ?>>Student</option>
            <option value="teacher" <?= ($_REQUEST['relation'] ?? '') == 'teacher' ? 'selected' : '' ?>>Teacher</option>
        </select>
    </div>

    <!-- RSVP -->
    <div class="mb-3 col-sm-4">
        <label for="RSVP" class="form-label">RSVP</label>
        <select class="form-select" id="RSVP" name="RSVP">
            <option value="yes" <?= ($_REQUEST['RSVP'] ?? '') == 'yes' ? 'selected' : '' ?>>Yes</option>
            <option value="no" <?= ($_REQUEST['RSVP'] ?? '') == 'no' ? 'selected' : '' ?>>No</option>
        </select>
    </div>

    <!-- Arrival Time -->
    <div class="mb-3 col-sm-4">
        <label for="arrivalTime" class="form-label">Arrival Time</label>
        <input type="datetime-local" class="form-control" id="arrivalTime" name="arrivalTime" placeholder="Enter Arrival Time" value="<?= $_REQUEST['arrivalTime'] ?? '' ?>">
    </div>
</div>

<div class="row">
    <!-- Travel Mode -->
    <div class="mb-3 col-sm-3">
        <label for="travelMode" class="form-label">Travel Mode</label>
        <select class="form-select" id="travelMode" name="travelMode">
            <option value="car" <?= ($_REQUEST['travelMode'] ?? '') == 'car' ? 'selected' : '' ?>>Car</option>
            <option value="train" <?= ($_REQUEST['travelMode'] ?? '') == 'train' ? 'selected' : '' ?>>Train</option>
            <option value="bus" <?= ($_REQUEST['travelMode'] ?? '') == 'bus' ? 'selected' : '' ?>>Bus</option>
            <option value="flight" <?= ($_REQUEST['travelMode'] ?? '') == 'flight' ? 'selected' : '' ?>>Flight</option>
        </select>
    </div>

    <!-- Transport Name -->
    <div class="mb-3 col-sm-3">
        <label for="transportName" class="form-label">Transport Name</label>
        <input type="text" class="form-control" id="transportName" name="transportName" placeholder="Enter Transport Name" value="<?= $_REQUEST['transportName'] ?? '' ?>">
    </div>

    <!-- Pickup -->
    <div class="mb-3 col-sm-3">
        <label for="pickup" class="form-label">Pickup</label>
        <select class="form-select" id="pickup" name="pickup">
            <option value="yes" <?= ($_REQUEST['pickup'] ?? '') == 'yes' ? 'selected' : '' ?>>Yes</option>
            <option value="no" <?= ($_REQUEST['pickup'] ?? '') == 'no' ? 'selected' : '' ?>>No</option>
        </select>
    </div>

    <!-- Additional Guests -->
    <div class="mb-3 col-sm-3">
        <label for="additionalGuests" class="form-label">Additional Guests</label>
        <input type="number" class="form-control" id="additionalGuests" name="additionalGuests" placeholder="Enter Additional Guests" value="<?= $_REQUEST['additionalGuests'] ?? '' ?>">
    </div>


</div>

<div class="row">
    <!-- Guest Message -->
    <div class="mb-3 col-sm-12">
        <label for="guestMessage" class="form-label">Guest Message</label>
        <textarea class="form-control" id="guestMessage" name="guestMessage" rows="3" placeholder="Enter Guest Message"><?= $_REQUEST['guestMessage'] ?? '' ?></textarea>
    </div>
</div>




    <!-- Submit Button -->
    <button type="submit" id="submit-btn" name="btn-submit" class="btn btn-primary">Save & Next</button>
  </form>

     </div>
    

</main>
<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>












