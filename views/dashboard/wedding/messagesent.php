<?php
errors(1);
locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');


controller("Wedding");
controller("Message");
$wedding = new Wedding();
$weddingguests = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);

$message = new Message();
$weddingID=$_REQUEST['id'];
$lang=$_REQUEST['lang'];
$messageID=$_REQUEST['messageID'];
$messageType=$_REQUEST['messageType'];

DB::connect();
$messageguests = DB::select('messages', '*', "weddingID='$weddingID' AND lang='$lang' AND messageID='$messageID' ")->fetchAll();
DB::close();

if($messageType=="all"){
    DB::connect();
    // all guests
    $guests = DB::select('guests', '*', " weddingID='$weddingID' AND lang='$lang' ")->fetchAll();
    DB::close();
}
else if($messageType=="sent"){
    DB::connect();
    // msg sent guests
    $guests = DB::select('guests,message_logs', '*', " weddingID='$weddingID' AND lang='$lang' AND  message_logs.messageID='$messageID' AND  guests.guestID=message_logs.guestID ")->fetchAll();
    DB::close();
}
else if($messageType=="unsent"){
    DB::connect();
    // msg unsent guests
    $guests = DB::select('guests,message_logs', '*', " weddingID='$weddingID' AND lang='$lang' AND  message_logs.messageID<>'$messageID' AND  guests.guestID<>message_logs.guestID")->fetchAll();
    DB::close();
}
else{
    redirect("wedding/" . $_REQUEST['id'] . "/" . $_REQUEST['lang']."/messages/".$messageID);
}


controller("Guest");
$guest=new Guest();

?>

<head>

<style type="text/css">
    .infobtns .btn{
        border-radius: 0;
        border-color: darkgray;
    }
</style>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">

<h1 class="h2 d-inline"><?php echo strtoupper($messageguests[0]['type']); ?>  Message </h1>
<span class="text-small">( <?php echo strtoupper($messageType); ?> ) </span>

	 <div class="container mt-4">

        <p class="bg-light p-3"><?= $messageguests[0]['text_']; ?></p>

        <div class="d-flex justify-content-end infobtns">
          <div class="">
            <a href="all" class="btn btn-sm btn-outline-success">All</a>
          </div>
          <div class="">
            <a href="sent" class="btn btn-sm btn-outline-warning">Sent</a>
          </div>
          <div class="">
            <a href="unsent" class="btn btn-sm btn-outline-danger">Unsent</a>
          </div>
        </div>

        <h5>Guests</h5>

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

      

    <script>
            if(document.getElementById("selectAllRows")!=null){
                // JavaScript code to select all rows based on the checkbox in the header
                document.getElementById("selectAllRows").addEventListener("change", function() {
                    var checkboxes = document.getElementsByName("selected_rows[]");
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (!checkboxes[i].disabled) {
                            checkboxes[i].checked = this.checked;
                        }
                    }
                });
            }




    function sendBulkMsg(){
        
        var dataToInsert=[];
        var checkboxes = document.getElementsByName("selected_rows[]");

        for (var i = 0; i < checkboxes.length; i++) {

            if (checkboxes[i].checked && !checkboxes[i].disabled) {
                let j=parseInt(checkboxes[i].id[checkboxes[i].id.length-1]);
                dataToInsert.push(document.querySelector("#guestID_"+j).innerText);

            }
        }

        if (dataToInsert.length == 0) {
            alert("0 Records selected!");
        } else {

           var sendData = JSON.stringify(dataToInsert); // Convert dataToInsert to a JSON string
            var xhr = new XMLHttpRequest();
            var url = "sendMsges";
            var requestData = { jsArrayData: sendData }; // Wrap sendData in another object

            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-Type", "application/json");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = xhr.responseText;
                        var msg = JSON.parse(response);
                        if (!msg.error) {
                            alert(msg.msg);
                            window.location.href = "<?php echo route('admin/all'); ?>";
                        } else {
                            alert("Failed to insert data!");
                        }
                    } else {
                        console.error('Request failed:', xhr.statusText);
                    }
                }
            };

            xhr.send(JSON.stringify(requestData)); // Send the wrapped data
        }

    }

    </script>
    
    </div>
</main>


<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>