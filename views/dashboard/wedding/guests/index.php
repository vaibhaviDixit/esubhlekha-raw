<?php
// errors(1);
locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');


DB::connect();
$languages = enumToArray(DB::select('information_schema.COLUMNS', 'COLUMN_TYPE', "TABLE_NAME = 'weddings' AND COLUMN_NAME = 'lang'", 'COLUMN_TYPE DESC')->fetch()[0]);
DB::close();


sort($languages);

controller("Wedding");
$wedding = new Wedding();
$weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);
$weddingID=$_REQUEST['id'];
$lang=$_REQUEST['lang'];

DB::connect();
$guests = DB::select('guests', '*', " weddingID='$weddingID' AND lang='$lang' ")->fetchAll();
DB::close();

controller("Guest");
$guest=new Guest();
$_REQUEST['weddingID']=$_REQUEST['id'];

?>

<head>
	<script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
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
		<h1 class="h2">Guests</h1>

		<div class="float-end">
			<button type="button" class="btn btn-primary mb-3" id="addGuestBtn" data-bs-toggle="modal" data-bs-target="#addGuestModal">
			<i class="bi bi-plus-circle"></i> Add Guest</button>
		</div>

<!-- Modal -->
<div class="modal fade" id="addGuestModal" tabindex="-1" role="dialog" aria-labelledby="addGuestModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Enter Guest Information</h5>
       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      <div class="modal-body">
        <form class="m-0" method="post">
         	    	
		 <div class="row">
		    <!-- Name -->
		    <div class="mb-1 col-sm-6">
		        <label for="name" class="form-label">Name</label>
		        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?= $_REQUEST['name'] ?? '' ?>" required>
		    </div>
		    <!-- Phone -->
		    <div class="mb-1 col-sm-6">
		        <label for="phone" class="form-label">Phone</label>
		        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone" value="<?= $_REQUEST['phone'] ?? '' ?>" required>
		        <strong id="phoneMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>
		   
		</div>
		<div class="row">
			     <!-- Email -->
		    <div class="mb-1 col-sm-4">
		        <label for="email" class="form-label">Email</label>
		        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?= $_REQUEST['email'] ?? '' ?>">
		        <strong id="emailMsg" class="text-danger errorMsg my-2 fw-bolder"></strong>
		    </div>
		    	<!-- Language -->
				<div class="mb-1 col-sm-4">
					<label for="lang" class="form-label">Language</label>
					<select class="form-select" id="lang" name="lang" required>
						<?php foreach ($languages as $lang) {
							?>
							<option value="<?= $lang ?>" <?php
							  if ($_REQUEST['lang'] == $lang)
								  echo 'selected';
							  elseif ($lang == 'en')
								  echo 'selected' ?>>
								<?= Locale::getDisplayLanguage($lang, "en") ?>
							</option>
							<?php
						} ?>
					</select>
				</div>

			<!-- Gender -->
		    <div class="mb-1 col-sm-4">
		        <label for="gender" class="form-label">Gender</label>
		        <select class="form-select" id="gender" required name="gender">
		            <option value="male" <?= ($_REQUEST['gender'] ?? '') == 'male' ? 'selected' : '' ?>>Male</option>
		            <option value="female" <?= ($_REQUEST['gender'] ?? '') == 'female' ? 'selected' : '' ?>>Female</option>
		            <option value="other" <?= ($_REQUEST['gender'] ?? '') == 'other' ? 'selected' : '' ?>>Other</option>
		        </select>
		    </div>
		</div>

<div class="mx-auto text-center">
			<!-- Submit Button -->
    <button type="submit" id="submit-btn" name="btn-submit" class="btn btn-primary mx-auto">Add Guest</button>

</div>

        </form>
      </div>
    </div>
  </div>
</div>
<!-- modal end -->

		
		<div class="table-responsive" style="clear: both;">

		<?php
		  if(sizeof($guests)==0){
		        echo "<p class='mt-5'>No guests found!</p>";
		   }
		   else{
		?>
			<table id="myTable" class="table table-striped table-sm">
                <thead>
                  <tr class="fw-bold">
                  	<th class="text-center">Action</th>
                    <th>Name</th>
				    <th>Email</th>
				    <th>Phone</th>
				    <th>Gender</th>
				    <th>Lang</th>
				    <th>Age</th>
				    <th>City</th>
				    <th>Relation</th>
				    <th>RSVP</th>
				    <th>Arrival Time</th>
				    <th>Travel Mode</th>
				    <th>Transport Name</th>
				    <th>Pickup</th>
				    <th>Status</th>
				    <th>Created At</th>
				    <th>Created By</th>
				    <th>Additional Guests</th>
				    <th>Guest Message</th>
                    
                  </tr>
                </thead>
                <tbody>

                <?php 

                foreach($guests as $guest){
                ?>
                  <tr>

                  	<td> 
                  		<div class="d-flex">
                  			<a class="btn action-btn btn-sm btn-success text-white" target="_blank" href="https://api.whatsapp.com/send/?phone=+91<?php echo $guest['phone'];?>&text=Namaste *<?php echo $guest['name'];?>*";?> <i class="bi bi-whatsapp"></i></a>

                  		 <a href="<?php echo route('wedding/'.($_REQUEST['id']).'/'. $_REQUEST['lang'].'/guests/'.$guest['guestID']); ?>" class="btn action-btn btn-sm btn-warning text-white"> 
                  		 	<i class="bi bi-pen"></i>
                  		 </a>

                  		<a class="btn action-btn btn-sm btn-danger text-white" data-bs-toggle="modal" data-bs-target="#delete<?php echo md5($guest['guestID']);?>"> <i class="bi bi-trash"></i></a>

            <div class="modal fade" id="delete<?php echo md5($guest['guestID']); ?>" tabindex="-1" aria-labelledby="delete<?php echo md5($guest['guestID']); ?>Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Delete User - <?php echo $guest['name'];?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    
                 Are you sure you want to delete this guest?
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                  <form method="POST">
                  <a href="<?php echo route("wedding/" . $_REQUEST['id'] . "/" . $_REQUEST['lang']."/guests/".$guest['guestID']."/delete");?>" class="btn btn-primary">Yes</a>
                  </form>
                </div>
              </div>
            </div>
          </div>

                  		</div>
                  		  </td>
                   

                    <td><?php echo $guest['name'];?></td>
				    <td><?php echo $guest['email'];?></td>
				    <td><a href="tel:+91<?php echo $guest['phone'];?>"><?php echo $guest['phone'];?></a></td>
				    <td><?php echo $guest['gender'];?></td>
				    <td><?php echo $guest['lang'];?></td>
				    <td><?php echo $guest['age'];?></td>
				    <td><?php echo $guest['city'];?></td>
				    <td><?php echo $guest['relation'];?></td>
				    <td><?php echo $guest['RSVP'];?></td>
				    <td><?php echo $guest['arrivalTime'];?></td>
				    <td><?php echo $guest['travelMode'];?></td>
				    <td><?php echo $guest['transportName'];?></td>
				    <td><?php echo $guest['pickup'];?></td>
				    <td><?php echo $guest['status'];?></td>
				    <td><?php echo $guest['createdAt'];?></td>
				    <td><?php echo $guest['createdBy'];?></td>
				    <td><?php echo $guest['additionalGuests'];?></td>
				    <td><?php echo $guest['guestMessage'];?></td>
				    
               
                  </tr>
                <?php }?>
                                  
                </tbody>
              </table>
          <?php }  ?>
		  <!-- else ends -->
		</div>

	</div>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/core.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>
  
<script type="text/javascript">
	
	 let phoneError = true;
	 let emailError = true;
    let phone = document.querySelector("#phone");
    let email = document.querySelector("#email");

    let phones = []
    let emails = []

    <?php
    foreach ($guests as $data) {
      echo "phones.push('" . md5($data['phone']) . "')\n";
      echo "emails.push('" . md5($data['email']) . "')\n";
    }
    ?>

 checkErrors();

    function validateMobile(mobilenumber) {
      var regmm = "^([6-9][0-9]{9})$";
      var regmob = new RegExp(regmm);
      if (regmob.test(mobilenumber)) {
        return true;
      } else {
        return false;
      }
    }

    function validateEmail(email) {
	  var regEx = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  	  return regEx.test(email);
	}


    function validatephone() {
      let phoneValue = phone.value.trim();
      let phoneMsg = document.querySelector("#phoneMsg")
      if (phone.value.trim() == "") {
        phoneError = true;
        checkErrors();
        phoneMsg.innerText = "Mobile number can't be empty";
        phone.classList.add("is-invalid");
      }
      else if (!validateMobile(phoneValue)) {
        phoneError = true;
        checkErrors();
        phoneMsg.innerText =
          "Mobile number is invalid (10 digits only)";
        phone.classList.add("is-invalid");
      } else if (phones.includes(CryptoJS.MD5(phoneValue).toString())) {
        phoneError = true
        checkErrors()
        phoneMsg.innerText = "Phone already in use"
        phone.classList.add("is-invalid")
      } else {
        phoneError = false;
        checkErrors();
        phone.classList.remove("is-invalid");
        phone.classList.add("is-valid");
        phoneMsg.innerText = "";
      }
    }

    phone.addEventListener("focusout", function () {
      validatephone();
    });
    phone.addEventListener("keyup", function () {
      validatephone();
    });

    function validateemail() {
      let emailValue = email.value.trim();
      let emailMsg = document.querySelector("#emailMsg")
      if (email.value.trim() == "") {
        emailError = true;
        checkErrors();
        emailMsg.innerText = "Email number can't be empty";
        email.classList.add("is-invalid");
      }
      else if (!validateEmail(emailValue)) {
        emailError = true;
        checkErrors();
        emailMsg.innerText =
          "Invalid email";
        email.classList.add("is-invalid");
      } else if (emails.includes(CryptoJS.MD5(emailValue).toString())) {
        emailError = true
        checkErrors()
        emailMsg.innerText = "Email already in use"
        email.classList.add("is-invalid")
      } else {
        emailError = false;
        checkErrors();
        email.classList.remove("is-invalid");
        email.classList.add("is-valid");
        emailMsg.innerText = "";
      }
    }

    email.addEventListener("focusout", function () {
      validateemail();
    });
    email.addEventListener("keyup", function () {
      validateemail();
    });


   
    function checkErrors() {
      errors = phoneError+emailError
      if (errors) {
        document.querySelector("#submit-btn").disabled = true;
      } else {
        
        document.querySelector("#submit-btn").disabled = false;
        
      }
    }
     

</script>



	<script>
		  $(document).ready( function () {
		      if (document.getElementById('myTable')) {
			    // Execute the code if the element exists
			    $('#myTable').DataTable({
			        language: {
			            search: ""
			        }
			    });
			    
			    let search = document.querySelector("#myTable_filter input");
			    search.placeholder = "Search";
			    search.classList.remove("form-control-sm");
			    search.style.width = "350px";
			}
		  } );
	</script>
</main>



<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>