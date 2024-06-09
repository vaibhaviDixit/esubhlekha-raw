<?php

locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');


controller("Wedding");
controller("Message");
$wedding = new Wedding();
$weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);

$message = new Message();
$weddingID=$_REQUEST['id'];
$lang=$_REQUEST['lang'];

DB::connect();
$messageData = DB::select('messages', '*', "weddingID='$weddingID' AND lang='$lang' ")->fetchAll();
DB::close();

$web=array();
$ar=array();
$rsvp=array();
$update=array();
$custom=array();

foreach ($messageData as $msg) {
	if($msg['type']=='web'){
		$web['text']=$msg['text_'];
        $web['status']=$msg['status'];
        $web['messageID']=$msg['messageID'];
	}
	else if($msg['type']=='ar'){
		$ar['text']=$msg['text_'];
        $ar['status']=$msg['status'];
        $ar['messageID']=$msg['messageID'];
	}
	else if($msg['type']=='rsvp'){
		$rsvp['text']=$msg['text_'];
        $rsvp['status']=$msg['status'];
        $rsvp['messageID']=$msg['messageID'];
	}
	else if($msg['type']=='update'){
		$update['text']=$msg['text_'];
        $update['status']=$msg['status'];
        $update['messageID']=$msg['messageID'];
	}
	else if($msg['type']=='custom'){
		$custom['text']=$msg['text_'];
        $custom['status']=$msg['status'];
        $custom['messageID']=$msg['messageID'];
	}

}

?>

<head>

<style type="text/css">
	 /* Custom styles */
        .tab-content {
            margin-top: 10px;
        }

        .tab-pane {
            padding: 20px;
        }

        .btn-save,.btn-send{
            margin-top: 10px;
        }

        .nav-link{
        	color: var(--color-primary-1);
        }
        nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
		    color: var(--color-secondary-1);
		    background-color: var(--color-primary-1);
		}

</style>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">

<h1 class="h2">Messages Setup</h1>

<?php

			if (isset($_POST['btn-submit'])) {

				$_REQUEST['weddingID']=$_REQUEST['id'];

				$createMessage = $message->create($_REQUEST);

				if ($createMessage['error']) {
					?>
					<div class="alert alert-danger">
						<?php
						foreach ($createMessage['errorMsgs'] as $msg) {
							if (count($msg))
								echo $msg[0] . "<br>";
						}
						?>
					</div>
					<?php
				} else{
					redirect("wedding/" . $_REQUEST['id'] . "/" . $_REQUEST['lang']."/messages");
				}

			}

			?>

	 <div class="container mt-4">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="web-invitation-tab" data-bs-toggle="tab"
                    data-bs-target="#web-invitation" type="button" role="tab" aria-controls="web-invitation"
                    aria-selected="true">Web Invitation</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="ar-invitation-tab" data-bs-toggle="tab" data-bs-target="#ar-invitation"
                    type="button" role="tab" aria-controls="ar-invitation" aria-selected="false">AR Invitation</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="rsvp-tab" data-bs-toggle="tab" data-bs-target="#rsvp" type="button"
                    role="tab" aria-controls="rsvp" aria-selected="false">RSVP</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="updates-tab" data-bs-toggle="tab" data-bs-target="#updates" type="button"
                    role="tab" aria-controls="updates" aria-selected="false">Updates</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="custom-tab" data-bs-toggle="tab" data-bs-target="#custom" type="button"
                    role="tab" aria-controls="custom" aria-selected="false">Custom</button>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade show active" id="web-invitation" role="tabpanel"
                aria-labelledby="web-invitation-tab">

                <div class="d-flex flex-row-reverse">
                	<span class="badge rounded-pill bg-primary"><?= $web['status']?trim($web['status']):'NA'; ?></span>
                </div>
                
                <form method="post">
                	<textarea class="form-control" name="text_" placeholder="Write your message here..."><?= $web['text']?trim($web['text']):''; ?>
                	</textarea>
                	<input type="hidden" name="type" value="web">
	                <button class="btn btn-primary btn-save" type="submit" name="btn-submit">Save</button>

	                <a  href="messages/<?php echo $web['messageID']; ?>" class="btn btn-success btn-send <?php $web['text']?'':'disabled'; ?>">Send</a>

                </form>

            </div>
            <div class="tab-pane fade" id="ar-invitation" role="tabpanel" aria-labelledby="ar-invitation-tab">
                <div class="d-flex flex-row-reverse">
                    <span class="badge rounded-pill bg-primary"><?= $ar['status']?trim($ar['status']):'NA'; ?></span>
                </div>
                
                <form method="post">
                    <textarea class="form-control" name="text_" placeholder="Write your message here..."><?= $ar['text']?trim($ar['text']):''; ?>
                    </textarea>
                    <input type="hidden" name="type" value="ar">
                    <button class="btn btn-primary btn-save" type="submit" name="btn-submit">Save</button>

                    <a  href="messages/<?php echo $ar['messageID']; ?>" class="btn btn-success btn-send <?php $ar['text']?'':'disabled'; ?>">Send</a>

                </form>
            </div>

            <div class="tab-pane fade" id="rsvp" role="tabpanel" aria-labelledby="rsvp-tab">
                 <div class="d-flex flex-row-reverse">
                    <span class="badge rounded-pill bg-primary"><?= $rsvp['status']?trim($rsvp['status']):'NA'; ?></span>
                </div>
                
                <form method="post">
                    <textarea class="form-control" name="text_" placeholder="Write your message here..."><?= $rsvp['text']?trim($rsvp['text']):''; ?>
                    </textarea>
                    <input type="hidden" name="type" value="rsvp">
                    <button class="btn btn-primary btn-save" type="submit" name="btn-submit">Save</button>

                    <a  href="messages/<?php echo $rsvp['messageID']; ?>" class="btn btn-success btn-send <?php $rsvp['text']?'':'disabled'; ?>">Send</a>

                </form>
            </div>
            
            <div class="tab-pane fade" id="updates" role="tabpanel" aria-labelledby="updates-tab">
                <div class="d-flex flex-row-reverse">
                    <span class="badge rounded-pill bg-primary"><?= $update['status']?trim($update['status']):'NA'; ?></span>
                </div>
                
                <form method="post">
                    <textarea class="form-control" name="text_" placeholder="Write your message here..."><?= $update['text']?trim($update['text']):''; ?>
                    </textarea>
                    <input type="hidden" name="type" value="update">
                    <button class="btn btn-primary btn-save" type="submit" name="btn-submit">Save</button>

                    <a href="messages/<?php echo $update['messageID']; ?>" class="btn btn-success btn-send <?php $update['text']?'':'disabled'; ?>">Send</a>

                </form>
            </div>

             <div class="tab-pane fade" id="custom" role="tabpanel" aria-labelledby="custom-tab">
                <div class="d-flex flex-row-reverse">
                    <span class="badge rounded-pill bg-primary"><?= $custom['status']?trim($custom['status']):'NA'; ?></span>
                </div>
                
                <form method="post">
                    <textarea class="form-control" name="text_" placeholder="Write your message here..."><?= $custom['text']?trim($custom['text']):''; ?>
                    </textarea>
                    <input type="hidden" name="type" value="custom">
                    <button class="btn btn-primary btn-save" type="submit" name="btn-submit">Save</button>

                    <a href="messages/<?php echo $custom['messageID']; ?>" class="btn btn-success btn-send <?php $custom['text']?'':'disabled'; ?>">Send</a>

                </form>
            </div>

        </div>
    </div>

    

</main>

<script type="text/javascript">
	// Add event listeners to textareas
        document.querySelectorAll('textarea').forEach(textarea => {
            textarea.addEventListener('input', function () {
                // Enable or disable the corresponding send button based on whether the textarea has text
                let sendButton = this.parentNode.querySelector('.btn-send');
                sendButton.classList.toggle('disabled', !this.value.trim());
            });
        });

</script>
<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>