<?php
// errors(1);
controller('Guest');
$guestID = $_REQUEST['guestID'];

$guest = new Guest();

$guest = $guest->delete($_REQUEST['id'],$guestID);

if(!$guest['error']){
    ?>
    <script>
        window.location.href = "<?php echo route("wedding/" . $_REQUEST['id'] . "/" . $_REQUEST['lang']."/guests");?>"
    </script>
    <?php }
else echo json_encode($guest);


?>
