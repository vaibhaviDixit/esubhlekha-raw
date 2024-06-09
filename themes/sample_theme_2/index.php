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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            R<br>S<br>V<br>P
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
            <div class="item" style="background-image: url('https://images.pexels.com/photos/933118/pexels-photo-933118.jpeg');">
              <div class="carousel-caption">
                <p class="text-secondary">We are inviting you for the Wedding of</span></p>
                <h1 class="text-hero"><div class="bride"><?= $weddingData['groomName'] ?></div> <div class="and">&</div> <div class="groom"><?= $weddingData['brideName'] ?></div> </h1>
            
              </div>
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
        </section>
        <!-- Hero end -->

 <?php require('nav.php'); ?>

        <!-- about start -->
        <section class="container-fluid text-primary" id="aboutSection">
                <div class="text-center" style="padding-bottom: 65px;">
                  <h1 class="text-primary-3">Save the Date</h1>
                  <h3>FEB | 19 | 2024</h3>
                </div>

        </section>
        <!-- about ends -->

        <!-- bride groom start -->
        <section class="container mt-4" id="coupleSection">

            <h1 class="section-head text-primary">Bride & Groom</h1>

            <div class="container mt-6 brideGroomCont">
                <div class="row align-items-center">
                    <!-- Column 1 -->
                    <div class="col-sm-5 bg-primary" style="border-radius: 0 0 25% 0;">
                        <div class="text-center b_img_div">
                            <img src="<?php if(getImgURL('bride')){echo getImgURL('bride');}else{ echo assets('img/upload.png');} ?>"
                            alt="Person 1" class="img-fluid brideImg">
                        </div>
                        <div class="text-center">
                          <h3 class="text-secondary"><?= $weddingData['brideName'] ?> <small class="text-center fs-6">( <?= $weddingData['brideQualifications'] ?> )</small></sub>
                        </h3>
                        <p class="text-left">
                          
                          <?= $weddingData['brideBio'] ?>
                        </p>
                        
                    </div>
                    </div>

                  <div class="text-center col-sm-2"><img src="<?php themeAssets('sample_theme_2','img/heart.png') ?>" class="img-fluid" width="200"></div>

                    <!-- Column 2 -->
                    <div class="col-sm-5 mb-4 bg-primary" style="border-radius: 0 0 0 25%;margin-top: 20%;">

                      <div class="text-center g_img_div">
                            <img src="<?php if(getImgURL('groom')){echo getImgURL('groom');}else{ echo assets('img/upload.png');} ?>" alt="Person 2" class="img-fluid groomImg">
                        </div>

                        <div class="text-center">
                          <h3 class=" text-secondary"><?= $weddingData['groomName'] ?> <small class="text-center fs-6">( <?= $weddingData['groomQualifications'] ?> )</small></sub>
                            </h3>
                            <p class="text-right">
                              
                              <?= $weddingData['groomBio'] ?>
                          </p>
                        </div>

                    </div>

                </div>
            </div>


        </section>
        <!--  bride groom ends -->



 <!-- Our story start -->
        <section class="container" id="ourStorySection">

            <h1 class="section-head">Our Story</h1>

  <div class="container py-5">
    <div class="main-timeline-2">
      
      <div class="timeline-2 left-2">
        <div class="card">
          <img src="https://images.pexels.com/photos/2959192/pexels-photo-2959192.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="card-img-top"
            alt="Responsive image">
          <div class="card-body p-4">
            <h4 class="fw-bold mb-4">How We Meet</h4>
            <p class="text-muted mb-4"><i class="far fa-clock" aria-hidden="true"></i> <?= $story['whenWeMet'] ?></p>
            <p class="mb-0"><?= $story['howWeMet'] ?></p>
          </div>
        </div>
      </div>

      <div class="timeline-2 right-2">
        <div class="card">
          <img src="https://images.pexels.com/photos/3156648/pexels-photo-3156648.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="card-img-top"
            alt="Responsive image">
          <div class="card-body p-4">
            <h4 class="fw-bold mb-4">Engagement</h4>
            <p class="text-muted mb-4"><i class="far fa-clock" aria-hidden="true"></i> <?= $story['engagementYear'] ?></p>
            <p class="mb-0"><?= $story['engagement'] ?></p>
          </div>
        </div>
      </div>

      <div class="timeline-2 left-2">
        <div class="card">
          <img src="https://images.pexels.com/photos/5086401/pexels-photo-5086401.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="card-img-top"
            alt="Responsive image">
          <div class="card-body p-4">
            <h4 class="fw-bold mb-4">Memorable Moments</h4>
            <p class="mb-0"><?= $story['memorableMoments'] ?></p>
          </div>
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
          <div class="card bg-primary">
         <img src="<?php echo getImgURL($timeline[$i]['event']); ?>" class="eventImgDiv card-img-top" alt="Reception">
            <div class="card-body text-center">
              <h3 class="text-secondary"><?= $timeline[$i]['event'] ?></h3>
          
              <p class="card-text "><?php echo $from."<br> To <br> ".$to; ?>   </p>
              <div class="card-text d-flex align-items-center justify-content-center gap-2">

              <div> <?= $timeline[$i]['venue'] ?><br> 
              <?= str_replace("<br>", "\r\n", $timeline[$i]['address']) ?>
              </div>

              <div> <a href="<?= $timeline[$i]['locationURL'] ?>" target="_blank">
                <button class="btn-sm btn-secondary"><i class="bi bi-pin-map-fill"></i></button>
              </a> </div>

            </div>

              
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
        
        <div class="col-sm-12 text-start row align-items-center wavy-bottom">
            <h4 class="text-primary">Accomodation</h4>
            <p class=""><?= $weddingData['accommodation'] ?></p>

        </div>
    
    <div class="text-center"><img src="<?php themeAssets('sample_theme_2','img/car.gif') ?>" class="img-fluid" width="200"></div>

        <div class="col-sm-12 text-end row align-items-center">
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

        <div class="item">
          <img src="<?= $preweddingGallery[$i]['imageURL'] ?>">
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
                  var endTime = new Date("2024-12-10T12:00:00Z").getTime();
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


