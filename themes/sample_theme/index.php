<?php 
// errors(1);


$wedding = new Wedding();
$weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);

$story = json_decode($weddingData['story'], true);
$timeline = json_decode($weddingData['timeline'], true);

$gallery = new Gallery();
$eventsGallery=$gallery->getEventGallery($_REQUEST['id']);
$preweddingGallery=$gallery->getPreWedGallery($_REQUEST['id']);

function getImgURL($name){
	$gallery = new Gallery();
	$row=$gallery->getGalleryImg($_REQUEST['id'],$name);

	if($row['imageURL']){
		return $row['imageURL'];
	}
	else{
		return false;
	}
	
}


?>
<!DOCTYPE html>
<html lang="en">
<?php include("head.php") ?>
<style>
    #app {
    
        max-height: 100vh !important;
    }

</style>

<body>
    <div id="app" class="">
        <!-- main content here -->


    <!-- Floating Button using Bootstrap -->
    <div class="fixed-button">
        <button type="button" class="btn btn-primary text-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            RSVP
                        </button>
    </div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Are you attending ?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form>
          <div class="">
            <label for="recipient-name" class="col-form-label">Name:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="">
            <label for="recipient-contact" class="col-form-label">Contact:</label>
            <input type="text" class="form-control" id="recipient-contact">
          </div>
          <div class="">
            <label for="recipient-number" class="col-form-label">Number of guests:</label>
            <input type="number" class="form-control" id="recipient-number">
          </div>
          <div class="">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-sm btn-secondary text-light" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn-sm btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
    <!-- Modal ends -->

          <!-- Hero start -->
        <section class="container-fluid" id="heroSection">
               
          <div id="heroCarousel" class="owl-carousel owl-theme">
            <!-- Slide 1 -->
            <div class="item" style="background-image: url('https://images.pexels.com/photos/1444442/pexels-photo-1444442.jpeg');">
              <div class="carousel-caption">
                <p class="text-secondary"><span class="lines">The Wedding Of</span></p>
                <h1 class="text-primary"><?= $weddingData['groomName'] ?> & <?= $weddingData['brideName'] ?></h1>
                <div class="d-flex justify-content-center align-items-center text-secondary gap-3" id="countdown">
                    <div>
                        <span class="days">03</span><br>
                        <span class="timerText">Days</span>
                    </div>
                     <div>
                        <span class="hours">05</span><br>
                        <span class="timerText">Hrs</span>
                    </div>
                     <div>
                        <span class="min">15</span><br>
                        <span class="timerText">Mins</span>
                    </div>
                     <div>
                        <span class="sec">57</span><br>
                        <span class="timerText">Sec</span>
                    </div>
                    
                </div>

              </div>
            </div>

           
          </div>
        </section>
        <!-- Hero end -->

 <?php require('nav.php'); ?>

        <!-- about start -->
        <section class="container" id="aboutSection">

            <div class="container">
                <div class="row align-items-center justify-content-center text-center gap-2">
                    <!-- First Column - Image -->
                    <div class="col-lg-4 image-column" style="width: auto;">
                        <img src="<?php if(getImgURL('couple')){echo getImgURL('couple');}else{ echo assets('img/upload.png');} ?>" class="img-fluid coupleImg" alt="couple">
                        <div class="img-bg"></div>
                    </div>

                    <!-- Second Column - Text -->
                    <div class="col-lg-6 text-center">
                        <p class="small text-secondary text-center">Join us to celebrate <br>The wedding of</p>
                        <h3 class="text-primary text-center"><?= $weddingData['groomName'] ?> & <?= $weddingData['brideName'] ?></h3>

                        <!-- Row with three texts separated by vertical line -->
                        <div class="d-flex justify-content-center align-items-center gap-3 mt-2 text-secondary">
                            <div class="">FEB</div>
                            <div class=""><span class="vertical-lines">19</span></div>
                            <div class="">2024</div>
                        </div>

                        <!-- Small Paragraph -->
                        <p class="mt-2 w-50 mx-auto">Fulai Garden, Sadashiv Peth, Pune</p>
                    </div>
                </div>
            </div>


        </section>
        <!-- about ends -->

        <!-- bride groom start -->
        <section class="container" id="coupleSection">

            <h1 class="section-head">Bride & Groom</h1>

            <div class="container mt-5">
                <div class="row">
                    <!-- Column 1 -->
                    <div class="col-lg-6 mb-4">
                        <div class="text-center">
                            <img src="<?php if(getImgURL('bride')){echo getImgURL('bride');}else{ echo assets('img/upload.png');} ?>"
                            alt="Person 1" class="img-fluid brideImg">
                        </div>
                        <h3 class="mt-3 text-center"><?= $weddingData['brideName'] ?></h3>
                        <p class="text-center">
                        	<b class="text-center d-block"><?= $weddingData['brideQualifications'] ?></b>
                        	<?= $weddingData['brideBio'] ?>
                    	</p>
                    </div>

                    <!-- Column 2 -->
                    <div class="col-lg-6 mb-4">
                        <div class="text-center">
                            <img src="<?php if(getImgURL('groom')){echo getImgURL('groom');}else{ echo assets('img/upload.png');} ?>" alt="Person 2" class="img-fluid groomImg">
                        </div>
                        <h3 class="mt-3 text-center"><?= $weddingData['groomName'] ?></h3>
                        <p class="text-center">
                        	<b class="text-center d-block"><?= $weddingData['groomQualifications'] ?></b>

                        	<?= $weddingData['groomBio'] ?></p>
                    </div>
                </div>
            </div>


        </section>
        <!--  bride groom ends -->


 <!-- Our story start -->
        <section class="container" id="ourStorySection">

            <h1 class="section-head">Our Story</h1>

            <div class="container mt-2">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="text-secondary"><?= $story['whenWeMet'] ?></div>
                                    <h6 class="text-capitalize text-primary">how we meet</h6>
                                    <p><?= $story['howWeMet'] ?></p>
                                    <div class="timeline-layout"></div>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="text-secondary"><?= $story['engagementYear'] ?></div>
                                    <h6 class="text-capitalize text-primary">Engagement</h6>
                                    <p><?= $story['engagement'] ?></p>
                                    <div class="timeline-layout"></div>
                                </div>
                            </div>

                              <div class="timeline-item">
                                <div class="timeline-content">
                                    <h6 class="text-capitalize text-primary">Memorable Moments</h6>
                                    <p><?= $story['memorableMoments'] ?></p>
                                    <div class="timeline-layout"></div>
                                </div>
                            </div>

                            <!-- Add more timeline items as needed -->

                        </div>
                    </div>
                </div>
            </div>


        </section>
        <!--  our story ends -->


    <!-- Events start -->
    <section class="container mt-2" id="eventsSection">

      <h1 class="section-head">Events</h1>


      <div id="eventsCarousel" class="owl-carousel owl-theme mt-5">
 <?php if ($timeline != null){
                            for ($i = 0; $i < count($timeline); $i++){
                            	$datetimeObj1 = new DateTime($timeline[$i]['startTime']);
                            	$datetimeObj2 = new DateTime($timeline[$i]['endTime']);
                            	$from=$datetimeObj1->format("d-m-Y")." ".$datetimeObj1->format("H:i");
                            	$to=$datetimeObj2->format("d-m-Y")." ".$datetimeObj2->format("H:i");
                                ?>
                            
        <div class="item ">
          <div class="card pink-border ">
         <img src="<?php echo getImgURL($timeline[$i]['event']); ?>" class="eventImgDiv card-img-top" alt="Reception">
            <div class="card-body text-center">
              <h3 class="text-primary"><?= $timeline[$i]['event'] ?></h3>
          
              <p class="card-text "><?php echo $from."<br> To <br> ".$to; ?>   </p>
              <p class="card-text"><?= $timeline[$i]['venue'] ?><br> 
              <?= str_replace("<br>", "\r\n", $timeline[$i]['address']) ?></p>
              <a href="<?= $timeline[$i]['locationURL'] ?>" target="_blank"><button class="btn-sm btn-primary">Location</button></a>
              
            </div>
          </div>
        </div>
     <?php }} ?>


      </div>


    </section>
    <!-- Events ends -->

     <!-- Getting there start -->
    <section class="container mt-2" id="eventsSection">

      <h1 class="section-head">Getting There</h1>

      <div class="row align-items-center">
        
        <div class="col-sm-4 text-start">
            <h4 class="text-primary">Accomodation</h4>
            <p><?= $weddingData['accommodation'] ?></p>

        </div>

        <div class="col-sm-4 text-center">
          <img src="<?php themeAssets('sample_theme','img/accomodation.png') ?>" class="img-fluid" width="100" height="100">
        </div>

        <div class="col-sm-4 text-end">
            <h4 class="text-primary">Travel</h4>
            <p><?= $weddingData['travel'] ?></p>

        </div>



      </div>

    </section>
    <!-- Getting there  ends -->

    <!-- gallery start -->
    <section class="container mt-2" id="gallerySection">

      <h1 class="section-head">Gallery</h1>

      <div id="galleryCarousel" class="owl-carousel owl-theme mt-5">

	<?php 
		if (!$preweddingGallery['error']){
    		for ($i = 0; $i < count($preweddingGallery); $i++){?>

        <div class="item ">
          <img src="<?= $preweddingGallery[$i]['imageURL'] ?>" class="gallery-images" style="border-radius: 40px;">
        </div>

    <?php 
            }
        }
    ?>


      </div>
    </section>
    <!-- gallery ends -->


 
        <?php include('footer.php'); ?> 
    </div>

    <script src="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js"></script>

    <script>
      document.addEventListener('DOMContentLoaded', function(){
        // Activate Owl Carousel
        $('#heroCarousel').owlCarousel({
          loop: true,
          margin: 10,
          nav: false,
          dots: false,
          items: 1,
          autoplay: true,
          autoplayTimeout: 3000, // Set your preferred autoplay timeout
          autoplayHoverPause: true
        });
      });

       $('#eventsCarousel').owlCarousel({
      loop: false,
      margin: 25,
      nav: false,
      autoplay: false,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 3
        }
      }
    })
    $('#galleryCarousel').owlCarousel({
      loop: false,
      margin: 15,
      nav: false,
      autoplay: false,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 4
        }
      }
    })

    </script>

                <script>
                
                  // Set the end time for the countdown (year, month (0-indexed), day, hour, minute, second)
                  var endTime = new Date("2024-02-10T12:00:00Z").getTime();
                    var now = new Date().getTime();
                   // Calculate the time difference
                    var timeDifference = endTime - now;

                     // If the countdown is over, display a message
                    if (timeDifference < 0) {
                      clearInterval(x);
                      document.getElementById("countdown").innerHTML = "Wedding Done!";
                    }

                  // Update the countdown every second
                  var x = setInterval(function() {
                    // Get the current time
                    var now = new Date().getTime();

                    // Calculate the time difference
                    var timeDifference = endTime - now;

                     // If the countdown is over, display a message
                    if (timeDifference < 0) {
                      clearInterval(x);
                      document.getElementById("countdown").innerHTML = "Wedding Done!";
                    }

                    // Calculate days, hours, minutes, and seconds
                    var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

                    if(days<10){
                        days="0"+days;
                    }
                     if(hours<10){
                        hours="0"+hours;
                    }
                     if(minutes<10){
                        minutes="0"+minutes;
                    }
                     if(seconds<10){
                        seconds="0"+seconds;
                    }

                    // Display the countdown
                   let daysselcted= document.querySelectorAll(".days");
                      for (var i = 0; i < daysselcted.length; i++) {
                          daysselcted[i].innerHTML = days;
                      }

                    let hoursselected=document.querySelectorAll(".hours");
                    for (var i = 0; i < hoursselected.length; i++) {
                          hoursselected[i].innerHTML = hours;
                      }

                    let minselected=document.querySelectorAll(".min");
                    for (var i = 0; i < minselected.length; i++) {
                          minselected[i].innerHTML = minutes;
                      }

                    let secselected= document.querySelectorAll(".sec");
                    for (var i = 0; i < secselected.length; i++) {
                          secselected[i].innerHTML = seconds;
                      }
                   
                  }, 1000);


                $(document).ready(function() {
                    var lastScrollTop = 0;
                    var heroSectionHeight = $('#heroSection').height(); // Replace with the actual ID of your hero section

                    $(window).scroll(function(event) {
                        var st = $(this).scrollTop();

                        // Check if the user is not in the hero section
                        if (st > heroSectionHeight) {
                            // Show the navbar
                            $('.navbar').addClass('visible');
                        } else {
                            // Hide the navbar
                            $('.navbar').removeClass('visible');
                        }

                        lastScrollTop = st;
                    });
                });


                </script>



</body>

</html>


