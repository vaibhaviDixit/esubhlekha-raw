<?php
locked(['user', 'host', 'manager', 'admin']);
require('views/partials/dashboard/head.php');
require('views/partials/dashboard/sidebar.php');


controller("Wedding");
$wedding = new Wedding();
$weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);
$story = json_decode($weddingData['story'], true);

?>

<head>

</head>
<!--Main Start-->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

	<form method="post" name="updateWedding" class="form-wedding">

		<?php
		if (isset($_POST['btn-submit'])) {
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
			} else
				redirect("wedding/" . $_REQUEST['id'] . "/" . $_REQUEST['lang'] . "/whatsapp");

		}

		?>
		<h1 class="h2">Our Story</h1>
		<div class="row">

			<input type="text" hidden name="basic-details">
			<!-- How we met -->
			<div class="mb-3 col-8">
				<label for="howWeMet" class="form-label">How We Met</label>
				<textarea class="form-control" id="howWeMet" name="howWeMet"
					placeholder="Enter how Bride & Groom met for the first time"
					rows="3"><?= $_REQUEST['howWeMet'] ?? str_replace("<br>", "\r\n", $story['howWeMet']) ?></textarea>
			</div>

			<!-- When we met -->
			<div class="mb-3 col-4">
				<label for="whenWeMet" class="form-label">When We Met</label>
				<select id="whenWeMet" name="whenWeMet" class="form-control">
					<option hidden>Select Year</option>
					<?php
					for ($i = 1990; $i <= date('Y'); $i++):
						?>
						<option value="<?= $i ?>" <?php if ($story['whenWeMet'] == $i)
							echo "selected" ?>>
							<?= $i ?>
						</option>
						<?php
					endfor;
					?>
				</select>
			</div>

			<!-- Engagement -->
			<div class="mb-3 col-8">
				<label for="engagement" class="form-label">Engagement</label>
				<textarea class="form-control" id="engagement" name="engagement"
					placeholder="Enter how Bride & Groom got engaged"
					rows="3"><?= $_REQUEST['engagement'] ?? str_replace("<br>", "\r\n", $story['engagement']) ?></textarea>
			</div>

			<!-- Engagement Year -->
			<div class="mb-3 col-4">
				<label for="engagementYear" class="form-label">Engagement Year</label>
				<select id="engagementYear" name="engagementYear" class="form-control">
					<option hidden>Select Year</option>
					<?php
					for ($i = 1990; $i <= date('Y'); $i++):
						?>
						<option value="<?= $i ?>" <?php if ($story['engagementYear'] == $i)
							echo "selected" ?>>
							<?= $i ?>
						</option>
						<?php
					endfor;
					?>
				</select>
			</div>

			<!-- Memorable Moments -->
			<div class="mb-3 col-12">
				<label for="memorableMoments" class="form-label">Memorable Moments</label>
				<textarea class="form-control" id="memorableMoments" name="memorableMoments"
					placeholder="Add any sweet memorable moments you like to share"
					rows="3"><?= $_REQUEST['memorableMoments'] ?? str_replace("<br>", "\r\n", $story['memorableMoments']) ?></textarea>
			</div>



		</div>



		<!-- Submit Button -->
		<button type="submit" name="btn-submit" class="btn btn-primary">Save & Next</button>
	</form>

	</div>

	<script>
		let weddings = []
		<?php
		foreach ($weddings as $wedding) {
			echo "weddings.push('" . $wedding['weddingID'] . "')\n";
		}
		?>

		function generateWeddingID(groomName, brideName) {
			let weddingID = groomName + "Weds" + brideName;

			if (weddings.includes(weddingID)) {
				weddingID = groomName + "-Weds-" + brideName;
			}

			return weddingID;
		}

		function updateWeddingID() {
			const groomName = document.querySelector('#groomName').value.trim();
			const brideName = document.querySelector('#brideName').value.trim();
			const weddingIDField = document.querySelector('#weddingID');

			if (groomName.length && brideName.length) {
				const newWeddingID = generateWeddingID(groomName, brideName);
				weddingIDField.value = newWeddingID;
			} else weddingIDField.value = "";
		}

		document.querySelector('#groomName').addEventListener('focusout', updateWeddingID);
		document.querySelector('#brideName').addEventListener('focusout', updateWeddingID);
		document.querySelector('#groomName').addEventListener('keyup', updateWeddingID);
		document.querySelector('#brideName').addEventListener('keyup', updateWeddingID);
	</script>
</main>



<!--Main End-->

<?php require('views/partials/dashboard/scripts.php') ?>