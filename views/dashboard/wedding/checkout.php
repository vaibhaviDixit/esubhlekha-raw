<?php
locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');

controller("Wedding");
$wedding = new Wedding();
$weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);
$story = json_decode($weddingData['story'], true);

// Set the plan details
$planName = "Standard";
$planPrice = 16000;
$discountAmount = 500;
$totalAmount = $planPrice - $discountAmount;


?>

<head>
    <!-- Add Razorpay script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<!-- Main Start -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
    <h1>Checkout</h1>


    <div class="container mt-2">
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <!-- Plan Information -->
                        <div class="mb-3">
                            <h5>Selected Plan: <span class="text-primary"><?= $planName ?></span></h5>
                            <p>Price: ₹ <?= $planPrice ?></p>
                        </div>

                        <!-- Price Summary -->
                        <div class="mb-3">
                            <h5>Summary</h5>
                            <div>Subtotal: ₹ <?= $planPrice ?></div>
                            <div>Discount: - ₹ <?= $discountAmount ?></div>
                            <h4 class="mt-1">Total: <b class="text-primary">₹ <?= $totalAmount ?></b></h4>
                        </div>

                        <!-- Checkout Button -->
                        <button id="checkoutBtn" class="btn btn-primary btn-block">Proceed to Checkout</button>
                    </div>

                    <!-- PAYMENT FORM (hidden) that will be submitted automatically when payment success -->
                    <form method="post" id="paymentIDForm">
                    	<input type="text" name="paymentID" id="paymentID" hidden="">
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Razorpay checkout configuration
    var options = {
        key: '<?php echo $config['RAZORPAY_API']; ?>', // should be placed in config.php
        amount: <?= $totalAmount * 100 ?>, // amount in paise
        currency: 'INR',
        name: 'Your Wedding Invitation Plan',
        description: 'Selected Plan: <?= $planName ?>',
        handler: function (response) {
            // Insert data into the database on successful payment
            var paymentId = response.razorpay_payment_id;
            insertIntoDatabase(paymentId);	

        },
        prefill: {
            name: 'eSubhalekha',
            email: 'vaibhavidixit511@gmail.com',
            contact: '9122334455'
        },
        notes: {
            plan_id: 'YOUR_PLAN_ID'
        },
        theme: {
            color: '#3498db'
        }
    };

    var rzp = new Razorpay(options);

    // Event listener for checkout button
    document.getElementById('checkoutBtn').addEventListener('click', function () {
        rzp.open();
    });

    rzp1.on('payment.failed', function (response){
		        alert("Payment Failed! "+response.error.description);
		});


    // Function to insert data into the database
    function insertIntoDatabase(paymentId) {
        
        // using AJAX

        jQuery.ajax({
        	type:'post',
        	url: 'payment_process.php',
            data: 'paymentID=' + paymentId + "&weddingID=" + '<?php echo $_REQUEST['id'];?>' + "&userID=" + '<?php echo App::getUser()['userID'];?>',
        	success:function(result){
        		// redirect user to other page
        	}

        });
         

    }

</script>

<?php require('views/partials/dashboard/scripts.php') ?>


