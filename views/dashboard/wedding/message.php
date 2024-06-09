<?php
// errors(1);
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

DB::connect();
$messageguests = DB::select('messages', '*', "weddingID='$weddingID' AND lang='$lang' AND messageID='$messageID' ")->fetchAll();
DB::close();

DB::connect();
$guests = DB::select('guests', '*', " weddingID='$weddingID' AND lang='$lang' ")->fetchAll();
DB::close();

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

<h1 class="h2"><?php echo strtoupper($messageguests[0]['type']); ?>  Message</h1>

	 <div class="container mt-4">

        <p class="bg-light p-3"><?= $messageguests[0]['text_']; ?></p>

        <div class="d-flex justify-content-end infobtns">
          <div class="">
            <a href="<?php echo $messageID.'/all'; ?>" class="btn btn-sm btn-outline-success">All</a>
          </div>
          <div class="">
            <a href="<?php echo $messageID.'/sent'; ?>" class="btn btn-sm btn-outline-warning">Sent</a>
          </div>
          <div class="">
            <a href="<?php echo $messageID.'/unsent'; ?>" class="btn btn-sm btn-outline-danger">Unsent</a>
          </div>
        </div>

        <h5>Guests</h5>

   <div class="my-3 d-flex justify-content-end"> <button class="btn btn-primary" onclick="sendBulkMsg();">Send Message</button> </div>

        <div class="table-responsive">
          <table class="table table-bordered table-sm small">
            <thead>
              <tr>
                <th class="text-center">Select All <input type="checkbox" name="selectRows" id="selectAllRows"></th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>City</th>
                <th>Relation</th>
              </tr>
            </thead>
            <tbody>

              <!-- Table rows will be populated dynamically -->
              <?php for ($i = 0; $i < count($guests); $i += 2) { ?>

                <input type="hidden" name="guestID" id="guestID_<?php echo $i; ?>" value="<?php echo $guests[$i]['guestID']; ?>">

             <tr class="csvRows">
                <td><input id="check_<?php echo $i; ?>" type="checkbox" name="selected_rows[]" value="<?php echo $i; ?>" id="check_<?php echo $i; ?>">
                </td>
                <td id="name_<?php echo $i; ?>"><?php echo $guests[$i]['name']; ?></td>
                <td id="phone_<?php echo $i; ?>"><?php echo $guests[$i]['phone']; ?></td>
                <td id="email_<?php echo $i; ?>"><?php echo $guests[$i]['email']; ?></td>
                <td id="city_<?php echo $i; ?>"><?php echo $guests[$i]['city']; ?></td>
                <td id="relation_<?php echo $i; ?>"><?php echo $guests[$i]['relation']; ?></td>
                
              </tr>


            <?php  } ?>
            </tbody>
          </table>

           
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