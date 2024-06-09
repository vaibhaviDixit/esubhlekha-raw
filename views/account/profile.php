<?php

// errors(1);
locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

$currentUser=App::getUser();

// controller("Auth");
$user = new Auth();

?>

<head>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">


		<h1 class="h2">Profile</h1>

	<form method="post" id="form" name="createWedding" class="form-wedding" enctype="multipart/form-data">

		<?php
	
		if (isset($_POST['btn-submit'])) {
          	$updateUser = $user->edit($currentUser['userID'], $_REQUEST);

			if ($updateUser['error']) {
				?>
				<div class="alert alert-danger">
					<?php
					foreach ($updateUser['errorMsgs'] as $msg) {
						if (count($msg))
							echo $msg[0] . "<br>";
					}
					?>
				</div>
				<?php
			}else{
				redirect("user/profile/");

			}	
			
	}

		?>

	<div class="row">

		<!-- Name -->
		<div class="mb-3 col-sm-6">
			<label for="name" class="form-label">Name</label>
			<input type="text" class="form-control" id="name" name="name"
				placeholder="Enter Name" value="<?= $currentUser['name'] ?>">
		</div>

		<!-- Phone -->
		<div class="mb-3 col-sm-6">
			<label for="phone" class="form-label">Phone</label>
			<input type="text" class="form-control" id="phone" name="phone"
			 value="<?= $currentUser['phone'] ?>" readonly>
		</div>

		<!-- Email -->
		<div class="mb-3 col-sm-6">
			<label for="email" class="form-label">Email</label>
			<input type="text" class="form-control" id="email" name="email"
				placeholder="Enter Email" value="<?= $currentUser['email'] ?>">
		</div>

		<!-- Gender -->
		<div class="mb-3 col-sm-4">
			<label  class="form-label">Gender</label>
			<div class="d-flex gap-3">
			 	<!-- Male Radio Button -->
				<div class="form-check">
				  <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?php if ($currentUser['gender'] === 'male') echo 'checked'; ?>>
				  <label class="form-check-label" for="male">
				    Male
				  </label>
				</div>

				<!-- Female Radio Button -->
				<div class="form-check">
				  <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?php if ($currentUser['gender'] === 'female') echo 'checked'; ?>>
				  <label class="form-check-label" for="female">
				    Female
				  </label>
				</div>

			</div>

		</div>

	</div>
	<!-- Submit Button -->
	<button type="submit" name="btn-submit" class="btn btn-primary">Update</button>



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