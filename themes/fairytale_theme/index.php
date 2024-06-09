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
  <body data-spy="scroll" data-target="#navbar" data-offset="50">
    <!-- Hero start -->
    <section id="hero">
      <div class="hero-section img-hero">
        
        <div class="dark-overlay"></div>
        <p class="brand-text lead">The Wedding Of</p>
        <div class="hero-text">
          <p><?= $weddingData['groomName'] ?> <span class="and">&</span> <?= $weddingData['brideName'] ?></p>
          
        </div>
      </div>
    </section>
    <!-- Hero ends -->


    <!-- Navigation start -->
    <section class="mb-4  sticky-top"  id="nav" style="background-color: #d9d9d9;">
      <ul class="nav justify-content-center lead">
        <li class="nav-item">
          <a class="nav-link" href="#ourstory">Our story</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#eventsSection">Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#gallerySection">Gallery</a>
        </li>
      </ul>
    </section>
    <!-- Navigation ends -->

    <section id="ourstory" class="mt-5 pt-5">
      <br />
      <div class="container custom-container">
        <div class="row">
          <div class="col-md-5 col-12 justify-content-center">
            <div class="img-container mx-auto">
              <img
               src="<?php if(getImgURL('groom')){echo getImgURL('groom');}else{ echo assets('img/upload.png');} ?>"
                class="img-fluid img-about"
                alt="Image"
              />
            </div>
            <div class="row mt-5 align-items-center">
              <h1 class="text-center primary-color luxurious-script"><?= $weddingData['groomName'] ?></h1>
              <p class="text-center ledger">
                <?= $weddingData['groomQualifications'] ?>: <?= $weddingData['groomBio'] ?>
              </p>
            </div>
          </div>
          <div
            class="col-md-2 text-center d-flex justify-content-center align-items-center my-5"
          >
            <div
              style="
                width: 60px;
                height: 60px;
                background-color: #d4af37;
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
                margin-top: 10px;
              "
            >
              <span style="font-size: 2rem; color: white"> &#x2665;</span>
            </div>
          </div>


          <div class="col-md-5 col-12 justify-content-center">
            <div class="img-container mx-auto">
              <img
                src="<?php if(getImgURL('bride')){echo getImgURL('bride');}else{ echo assets('img/upload.png');} ?>"
                class="img-fluid img-about"
                alt="Image"
              />
            </div>
            <div class="row my-5">
              <h1 class="text-center primary-color luxurious-script"><?= $weddingData['brideName'] ?></h1>
              <p class="text-center ledger">
                <?= $weddingData['brideQualifications'] ?>: <?= $weddingData['brideBio'] ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!--Events start -->
    <div class="bg-gray pb-5 pt-3">
      <section class="container mt-2" id="eventsSection">
    
        <p class="text-center lead invited mb-0"><span class="text-dark line blockquote-footer"></span> You are invited <span class="text-dark ms-2 line blockquote-footer"></p>
        <h1 class="section-head text-center display-5 mt-0 mb-5">Saturday, 27 November 2024</h1>
        <h1 class="section-head text-center luxurious-script display-5 mt-5">Events</h1>
    
    
    
        <div id="eventsCarousel" class="owl-carousel owl-theme mt-4">
     <?php if ($timeline != null){
                            for ($i = 0; $i < count($timeline); $i++){
                              $datetimeObj1 = new DateTime($timeline[$i]['startTime']);
                              $datetimeObj2 = new DateTime($timeline[$i]['endTime']);
                              $from=$datetimeObj1->format("d-m-Y")." ".$datetimeObj1->format("H:i");
                              $to=$datetimeObj2->format("d-m-Y")." ".$datetimeObj2->format("H:i");
                                ?>
          <div class="item">
            <div class="card pink-border ">
              <img src="<?php echo getImgURL($timeline[$i]['event']); ?>"
                class="card-img-top eventImgDiv" alt="Reception">
              <div class="card-body text-center pb-1">
                <h4 class="text-dark mb-3"><?= $timeline[$i]['event'] ?></h4>
                <p class="card-text mb-0"><?php echo $from."<br> To <br> ".$to; ?>  
                </p>
                <p class="card-text mb-4"><?= $timeline[$i]['venue'] ?><br> 
              <?= str_replace("<br>", "\r\n", $timeline[$i]['address']) ?>
                </p>
                
               <a href="<?= $timeline[$i]['locationURL'] ?>" target="_blank"> <button class="btn btn-sm text-light">VIEW ON MAP</button></a>
              </div>
            </div>
          </div>
             <?php }} ?>

    
        </div>
    
      </section>
    </div>
    <!--Events Ends -->


    <!-- gallery start -->
  <section class="container custom-container my-2 pb-5" id="gallerySection">

    <h1 class="section-head text-center luxurious-script display-5 my-5">Gallery</h1>

    <div id="galleryCarousel" class="owl-carousel owl-theme mt-5">

        <?php 
    if (!$preweddingGallery['error']){
        for ($i = 0; $i < count($preweddingGallery); $i++){?>

        <div class="item ">
          <img src="<?= $preweddingGallery[$i]['imageURL'] ?>" class="galleyImg" style="border-radius: 15px;">
        </div>

    <?php 
            }
        }
    ?>


    </div>
  </section>
  <!-- gallery ends -->

     <!-- Travel Start -->
     <h1 class="luxurious-script text-center my-5">Travel</h1>
     <section id="travel" class="mb-5">
      
      <div class="travel-section">
        <img
          src="<?php themeAssets('fairytale_theme','img/bg-travel.png') ?>"
          alt="Hero Image" class="hero-image">
        <div class=""></div>
        
        <div class="travel-text">
          <p style="color:black"><?= $weddingData['travel'] ?></p>
          <p style="color:black" class="border-top"><?= $weddingData['accommodation'] ?></p>
        </div>
      </div>
  </section>
    <!-- Travel Ends -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
    integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>




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
          items: 3
        }
      }
    })
    </script>
  </body>
</html>
