<?php 

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
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> <?= $weddingData['groomName'] ?> & <?= $weddingData['brideName'] ?> </title>
    <link rel="stylesheet" href="./index.css" />
    <link rel="stylesheet"
    href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lenis@1.0.45/dist/lenis.min.js"></script> 
   
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Julius+Sans+One&family=La+Belle+Aurore&family=Orbitron:wght@400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Staatliches&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap");
      @import url("https://fonts.googleapis.com/css2?family=Julius+Sans+One&family=La+Belle+Aurore&family=Orbitron:wght@400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Public+Sans:ital,wght@0,100..900;1,100..900&family=Staatliches&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap");
    </style>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"
    />
    <style>
      #container {
        position: relative;
        width: 351px;
        height: 618px;
      }
  
      .path-div {
        position: absolute;
        transform: translate(-50%, -50%);
      }
  
      .circle {
        width: 90px;
        height: 90px;
        background-color: #fff;
      
        border-radius: 50%;
      }
    </style>
  </head>
  <body class="w-screen h-auto relative normalfont flex flex-col overflow-x-hidden">
    <nav
      class="h-[40px] bg-[#E3A5B5] text-lg text-[#933E63] w-full flex justify-center items-center normalfont fixed z-40 top-0 left-0"
    >
      <p>October 18</p>
    </nav>
    <div
      class="h-screen gap-[30px] flex flex-col justify-center items-center bg-[#C8E6B5] relative"
    >
      <img
        class="absolute top-0 left-0 h-[250px] lg:h-[500px]"
        src="<?php themeAssets('design2','images/decormaterial.svg') ?>"
        alt=""
      />
      <img
        class="absolute top-[500px] lg:top-[300px] right-0 z-30 h-[700px] lg:h-[1150px]"
        src="<?php themeAssets('design2','images/Group 31.svg') ?>"
        alt=""
      />
      <div class="w-[200px]">
        <p class="text-center text-[#587767] text-xs lg:text-sm">
          s simply dummy text of the printing and typesetting industry. Lorem
          Ipsum
        </p>
      </div>
      <div
        class="w-[400px] sm:w-full px-auto flex flex-col sm:flex-row justify-center items-center relative cursivefont gap-[90px] sm:gap-[130px] lg:gap-[250px] lg:my-[200px] text-[#D96599]"
      >
        <p class="text-left sm:text-center text-[40pt] sm:text-[50pt] pl-[50px] w-full sm:w-auto sm:pl-0"> <?= $weddingData['brideName'] ?></p>

        <img
          class="absolute h-[160px] lg:h-[350px] top-[50%] right-[50%] translate-x-[50%] -translate-y-[55%]"
          src="<?php themeAssets('design2','images/rosedecor.svg') ?>"
          alt=""
        />

        <p class="text-right sm:text-center text-[40pt] sm:text-[50pt] pr-[50px] w-full sm:w-auto sm:pr-0"> <?= $weddingData['groomName'] ?> </p>
      </div>
      <div class="w-full flex flex-col justify-center items-center">
        <p class="text-center text-[#587767] text-xs lg:text-sm w-[300px]">
          s simply dummy text of the printing and typesetting industry. Lorem
          Ipsum has been the industry's standard dummy text ever since the
          1500s, when an unknown printer took a galley of type and scrambled it
          to make a type specimen book.
        </p>
        <button
          class="px-8 py-2 rounded-r-full rounded-l-full bg-[#92B47D] text-sm mt-[100px] font-light text-[#D6E5CC] hover:bg-[#8CBF6C] hover:cursor-pointer ease-in-out duration-300"
        >
          save date
        </button>
      </div>
    </div>
    <div
      class="relative w-full h-[700px] lg:h-[800px] flex flex-col items-center bg-[#933E63] z-0"
    >
      <img
        src="<?php themeAssets('design2','images/flower.svg') ?>"
        class="absolute w-[200px] lg:w-[280px] top-[350px] lg:top-[300px] normalfont left-0"
        alt=""
      />
       <div
        class="w-full h-[300px] relative flex items-center justify-center text-[#933E63]" id="countdown"
      >
        <div class="w-full h-[120px] bg-[#C8E6B5] absolute top-0"></div>
        <div class="w-full h-[180px] absolute top-[100px]"></div>

        <div
          class="w-[100px] h-[100px] lg:w-[140px] lg:h-[140px] flex flex-col items-center justify-center normalfont rounded-full z-20 bg-[#F7FABD] translate-x-[50px] z-20 border-[2px] lg:border-[5px] border-[#933E63]"
        >
          <p class="text-lg lg:text-[30pt] leading-tight"><span class="days">03</span></p>
          <p class="text-sm">Days</p>
        </div>
        <div
          class="w-[120px] h-[120px] lg:w-[140px] lg:h-[140px] flex flex-col items-center justify-center normalfont rounded-full z-30 bg-[#D9D9D9] z-30 border-[2px] lg:border-[5px] border-[#933E63] shadow-lg"
        >
          <p class=" text-2xl lg:text-[30pt] leading-tight"><span class="hours">05</span></p>
          <p class="text-sm">Hours</p>
        </div>
        <div
          class="w-[100px] h-[100px] lg:w-[140px] lg:h-[140px] flex flex-col items-center justify-center normalfont rounded-full z-20 bg-[#F7FABD] -translate-x-[50px] z-20 border-[2px] lg:border-[5px] border-[#933E63]" 
        >
          <p class="text-lg lg:text-[30pt] leading-tight"><span class="min">15</span></p>
          <p class="text-sm">Mins</p>
        </div>
      </div>
      <div
        class="h-full flex flex-col justify-start items-center text-[30pt] lg:text-[50pt] mt-[30px]"
      >
        <p class="text-[#F9ECE6]">October 18</p>
        <div
          class="text-[#F9ECE6] flex flex-col justify-center gap-[30px] items-center text-xl mt-[20px]"
        >
          <p>WE ARE <span class="text-[#C8E6B5]">GETTING MARRIED.</span></p>
          <p class="text-sm px-4 max-w-[800px] text-center text-light text-sm">
            s simply dummy text of the printing and typesetting industry. Lorem
            Ipsum has been the industry's standard dummy text ever since the
            1500s, when an unknown printer took a galley of type and scrambled it
            to make a type specimen book.  s simply dummy text of the printing and typesetting industry. Lorem
            Ipsum has been the industry's standard dummy text ever since the
            1500s, when an unknown printer took a galley of type and scrambled it
            to make a type specimen book.
          </p>
        </div>
      </div>
    </div>
    <div
      class="relative lg:px-auto lg:h-[700px] bg-[#D9D9D9] grid grid-cols-2 w-full normalfont"
    >
      <div
        class="col-span-2 lg:col-span-1  flex flex-col justify-center items-center lg:items-start pt-[100px] pb-[50px] lg:h-[700px] px-4 lg:px-[80px] "
      >
        <p class="text-xl lg:text-[40pt] text-[#C75184] leading-tight">
          MEET THE BRIDE <br />& GROOM
        </p>
        <p class="text-[35pt] cursivefont text-[#D96599]"><?= $weddingData['brideName'] ?>&<?= $weddingData['groomName'] ?></p>

        <p class="text-sm text-center text-[#C37D9B]">
          <?= $weddingData['brideQualifications'] ?>
                          <?= $weddingData['brideBio'] ?>
        </p>
        <p class="text-sm text-center text-[#C37D9B] max-w-[400px] mt-[30px]">
          <?= $weddingData['groomQualifications'] ?>
                          <?= $weddingData['groomBio'] ?>
        </p>
      </div>
      <div class=" col-span-2 lg:col-span-1 flex justify-end items-center h-[700px]">
        <img
          src="<?php if(getImgURL('couple')){echo getImgURL('couple');}else{ echo assets('img/upload.png');} ?>"
          class="w-full h-full object-cover"
          alt=""
        />
      </div>
    </div>
    <div class="relative h-auto lg:h-[700px] w-full bg-[#AD4F78] grid grid-cols-2">
      <div class="absolute bottom-0 w-[180px] sm:w-[210px] lg:w-[330px] translate-y-[50%]">
        <img src="<?php themeAssets('design2','images/flowerdecormaterial.svg') ?>" alt="" />
      </div>
      <div
        class="w-full h-full col-span-2 lg:col-span-1 flex flex-col justify-center items-center py-[50px]"
      >
        <p
          class="text-[40pt] bg-gradient-to-bl from-pink-50 via-[#FFD7E8] to-[#D66998] bg-clip-text text-transparent leading-[43pt]"
        >
          Gallery<br />&Moments
        </p>
        <p class="text-lg font-thin text-[#FDFDFD]">your beautiful momments.</p>
      </div>
      <div class="col-span-2 lg:col-span-1 bg-[rgb(240,240,240,0.3)] relative ">
        <div
          class="w-[40px] h-[40px] absolute top-0 right-[50%] rotate-90 lg:rotate-0 translate-x-[50%] lg:-translate-x-[50%]  lg:top-[50%] lg:left-0 -translate-y-[50%] -translate-x-[20px] rounded-full shadow-lg bg-[#FFF0F7] flex justify-center items-center border-[1px] border-[rgb(240,240,240)]"
        >
        <i class='bx bx-right-arrow-alt  text-[#AD4F78] text-xl'></i>
        </div>
        <div class="w-full flex  h-[500px] lg:h-[700px] overflow-hidden">

            <?php 
    if (!$preweddingGallery['error']){
        for ($i = 0; $i < count($preweddingGallery); $i++){ ?>

      <img src="<?= $preweddingGallery[$i]['imageURL'] ?>"
        class="object-cover" />

    <?php 
            }
        }
    ?>
          
        </div>
      </div>
    </div>
    <div class="w-full h-[300px] relative normalfont">
      <div class="absolute bottom-0 w-[180px] sm:w-[210px] lg:w-[330px]  translate-y-[50%] right-0 z-20">
        <img src="<?php themeAssets('design2','images/mirrrordecor.svg') ?>" alt="" />
      </div>
      <div class="w-full h-full flex flex-col gap-5 justify-center items-center"> 
        <p class="text-2xl lg:text-[35pt] text-[#AD4F78]">Are you attending?</p>
        <button class="px-5 py-2 bg-[#C8E6B5] rounded-r-full rounded-l-full text-[#587446] font-light text-sm hover:bg-[#A8DD87] ease-in-out duration-300">I'm attending</button>
      </div>
    </div>
    <!-- Our story section -->
    <div class="w-full bg-[#933E63] py-[30px] lg:py-[60px] relative z-0">
     
        <div class="w-[400px] sm:pb-[50px] lg:pb-[100px] flex flex-col justify-center items-center mx-auto">
          <div class="w-full flex justify-center items-center text-[#FCF5FA] text-[30pt] pb-[40px] lg:pb-[80px]">
            Our story
          </div >
          <div id="container" class="scale-[50%] sm:scale-[90%] lg:scale-100">
            <svg width="351" height="618" viewBox="0 0 351 618" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path id="svg-path" d="M1.25766 1C-2.57567 77.1667 34.8577 234.8 215.258 256C396 256 413.3 397.7 148.5 616.5" stroke="#FCF5FA" stroke-width="2"/>
            </svg>
            <div class="path-div" data-index="0" data-percentage="1">
              <div class="circle relative overflow-hidden px-1 py-1 bg-[#FCF5FA]">
                <div class="w-full h-full bg-[#FCF5FA] rounded-full overflow-hidden">
                  <img src="<?php if(getImgURL('couple')){echo getImgURL('couple');}else{ echo assets('img/upload.png');} ?>" class="object-cover w-full " alt="">
                </div>
              </div>
              <div class="absolute flex flex-col gap-1 left-[100px] top-[50%] -translate-y-[50%] w-[340px] px-3 py-2  rounded-lg bg-[rgb(243,243,243,0.27)] border-[rgb(243,243,243,0.27)] border-[1px] text-[#FCF5FA] backdrop-blur-[6px]">
                <div class="w-full text-2xl text-center">How we met...</div>
                <p class="w-full px-1 text-sm text-center font-light"> <?= $story['whenWeMet'] ?>- <?= $story['howWeMet'] ?> </p>
              </div>
            </div>
            <div class="path-div" data-index="1" data-percentage="40">
              <div class="circle relative overflow-hidden px-1 py-1 bg-[#FCF5FA]">
                <div class="w-full h-full bg-[#FCF5FA] rounded-full overflow-hidden">
                  <img src="<?php if(getImgURL('couple')){echo getImgURL('couple');}else{ echo assets('img/upload.png');} ?>" class="object-cover w-full " alt="">
                </div>
              </div>
              <div class="absolute flex flex-col gap-1 right-[100px] top-[50%] -translate-y-[50%] w-[340px] px-3 py-2  rounded-lg bg-[rgb(243,243,243,0.27)] border-[rgb(243,243,243,0.27)] border-[1px] text-[#FCF5FA] backdrop-blur-[6px]">
                <div class="w-full text-2xl text-center">little love....</div>
                <p class="w-full px-1 text-sm text-center font-light"> <?= $story['memorableMoments'] ?></p>
              </div>
            </div>
            <div class="path-div" data-index="2" data-percentage="100">
              <div class="circle relative overflow-hidden px-1 py-1 bg-[#FCF5FA]">
                <div class="w-full h-full bg-[#FCF5FA] rounded-full overflow-hidden">
                  <img src="<?php if(getImgURL('couple')){echo getImgURL('couple');}else{ echo assets('img/upload.png');} ?>" class="object-cover w-full " alt="">
                </div>
              </div>
              <div class="absolute flex flex-col gap-1 left-[100px] top-[50%] -translate-y-[50%] w-[340px] px-3 py-2  rounded-lg bg-[rgb(243,243,243,0.27)] border-[rgb(243,243,243,0.27)] border-[1px] text-[#FCF5FA] backdrop-blur-[6px]">
                <div class="w-full text-2xl text-center">We are engaged...</div>
                <p class="w-full px-1 text-sm text-center font-light"> <?= $story['engagementYear'] ?> - <?= $story['engagement'] ?> </p>
              </div>
            </div>
        </div>
     </div>
     </div></div>
     <!-- Our story ends here -->
    <div class="w-full flex flex-col">
      <div class=" h-[300px] bg-[#C8E6B5] grid grid-cols-2 justify-start items-center lg:px-[100px] py-[50px] lg:py-[100px] ">
        <div class="normalfont col-span-2 lg:col-span-1 flex flex-col items-center lg:justify-end lg:items-end pl-3 lg:pr-auto ">
          <p class="text-[45pt] normalfont text-[#D96599]">Events.</p>
          <div class=" flex flex flex-wrap font-thin gap-1 lg:gap-1">
            <?php if ($timeline != null){ for ($i = 0; $i < count($timeline); $i++){ ?>

            <button class="px-3 py-1 bg-[#D96599] text-[#FFFFFF] rounded-l-full rounded-r-full text-sm"><?= $timeline[$i]['event'] ?></button>

            <?php }} ?>
          </div>
        </div>
      </div>
      <div class="w-full lg:px-8 xl:px-[100px] mx-auto overflow-hidden py-2 normalfont">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <?php if ($timeline != null){ for ($i = 0; $i < count($timeline); $i++){ ?>
            <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i ?>" class="<?php if($i==0){ echo 'active';} ?>"></li>
            <?php }} ?>
          </ol>

          <div class="carousel-inner">

             <?php if ($timeline != null){
                            for ($i = 0; $i < count($timeline); $i++){
                              $datetimeObj1 = new DateTime($timeline[$i]['startTime']);
                              $datetimeObj2 = new DateTime($timeline[$i]['endTime']);
                              $from=$datetimeObj1->format("d-m-Y")." ".$datetimeObj1->format("H:i");
                              $to=$datetimeObj2->format("d-m-Y")." ".$datetimeObj2->format("H:i");
              ?>
                            
            <div class="carousel-item <?php if($i==0){ echo 'active';} ?>">
              <div class="w-full h-full flex flex-col">
                <div class="w-full h-[300px] overflow-hidden">
                  <img class="h-full w-full object-cover" src="<?php echo getImgURL($timeline[$i]['event']); ?>" alt="">
                </div>
                <div class="w-full flex justify-start items-start">
                  <p class="text-[45pt] pl-3 text-[#D96599]"><?= $timeline[$i]['event'] ?></p>
                </div>
                <p> <?php echo $from."To".$to; ?><br>
                  <?= $timeline[$i]['venue'] ?><br> 
                  <?= str_replace("<br>", "\r\n", $timeline[$i]['address']) ?> </p>
              </div>
            </div>

     <?php }} ?>



          </div>
          <a class="carousel-control-prev " href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon " aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
       </div>
      </div>
    </div>
    <div class="w-full bg-[#8FB378] py-[80px]  normalfont">
        <div class="max-w-6xl mx-auto h-full grid grid-cols-2 flex justify-center ">
          <div class="col-span-2 lg:col-span-1 h-full flex justify-center items-center">

            <div class="w-[450px] h-[350px] bg-white ">
              <img src="<?php themeAssets('design2','images/venue.png') ?>" class="object-cover h-full" alt="">
            </div>
          </div> 
          <div class="col-span-2  lg:col-span-1 h-full flex justify-start sm:justify-center lg:justify-start items-center px-4">
            <div class="flex flex-col justify-start">
              <p class="text-[45pt] text-[#EEF7E9]">Accomodation</p>
              <p  class="text-xs w-full sm:w-[500px] lg:w-[300px] text-[#CFFFB1] text-left lg:text-right"> <?= $weddingData['accommodation'] ?></p>
            </div>
          </div>
        </div>

         <div class="max-w-6xl mx-auto h-full grid grid-cols-2 flex justify-center ">
        
          <div class="col-span-2  lg:col-span-1 h-full flex justify-start sm:justify-center lg:justify-start items-center px-4">
            <div class="flex flex-col justify-start">
              <p class="text-[45pt] text-[#EEF7E9]">Travel</p>
              <p  class="text-xs w-full sm:w-[500px] lg:w-[300px] text-[#CFFFB1] text-left lg:text-right"> <?= $weddingData['travel'] ?> </p>
            </div>
          </div>

          <div class="col-span-2 lg:col-span-1 h-full flex justify-center items-center">

            <div class="w-[450px] h-[350px] bg-white ">
              <img src="<?php themeAssets('design2','images/venue.png') ?>" class="object-cover h-full" alt="">
            </div>
          </div> 

        </div>

    </div>
    <div class="w-full bg-[#C8E6B5] h-[400px] ">

      <div class="max-w-6xl mx-auto h-[400px] relative flex flex-col justify-center items-center normalfont overflow-hidden">
        <p class="text-[30pt] lg:text-[50pt] text-[#608F41]">We are excited!</p>
<img src="<?php themeAssets('design2','images/mirrorlotusdeco.svg') ?>" class="absolute bottom-0 left-0 h-[210px] lg:h-[350px]" alt="">
<img src="<?php themeAssets('design2','images/lotusdecor.svg') ?>" class="absolute bottom-0 right-0 h-[210px] lg:h-[350px]" alt="">
<p class="w-full px-4 lg:w-[400px] text-[#86BF62] text-xs lg:text-sm text-center font-thin ">s simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
<button class="px-4 py-1 bg-[#9CE46F] text-[#587446] text-sm rounded-r-full rounded-l-full text-sm mt-[30px] hover:bg-[#E0F0D7 ] ease-in-out duration-300">Back to top</button>     
</div>
      

    </div>
  </body>
  <script>
    function getPathPosition(path, percentage) {
      const length = path.getTotalLength();
      return path.getPointAtLength(length * percentage);
    }

    function placeDivs() {
      const path = document.getElementById('svg-path');
      const divs = document.querySelectorAll('.path-div');

      divs.forEach(div => {
        const percentage = div.dataset.percentage / 100;
        const { x, y } = getPathPosition(path, percentage);

        div.style.left = `${x}px`;
        div.style.top = `${y}px`;
      });
    }

    window.onload = placeDivs;
  </script>
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const lenis = new Lenis()

    lenis.on('scroll', (e) => {
      console.log(e)
    })
    
    function raf(time) {
      lenis.raf(time)
      requestAnimationFrame(raf)
    }
    
    requestAnimationFrame(raf)
});</script>

<script>
                
                  // Set the end time for the countdown (year, month (0-indexed), day, hour, minute, second)
                  var endTime = new Date("2024-12-11T12:00:00Z").getTime();
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

                    // let secselected= document.querySelectorAll(".sec");
                    // for (var i = 0; i < secselected.length; i++) {
                    //       secselected[i].innerHTML = seconds;
                    //   }
                   
                  }, 1000);

                </script>
                
</html>
