
/*


const nombre= document.getElementById("name")

const email= document.getElementById("email")

const asunto= document.getElementById("asunto")

const mensaje= document.getElementById("mensaje")

const form= document.getElementById("form")

const parrafo= document.getElementById("warnings")




form.addEventListener("submit", e=>{

e.preventDefault()

let warnings = ""

let entrar= false

let regexEmail= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/

parrafo.innerHTML = ""

if(nombre.value.length<6){

  warnings += `El nombre no es válido <br>`

  entrar= true

}

if(!regexEmail.test(email.value)){

warnings += `El email no es válido <br>`

entrar= true

}

if(asunto.value.length<6){

  warnings += `El asunto no es válido <br>`

  entrar= true

}

if(mensaje.value.length<6){

  warnings += `El mensaje no es válido <br>`

  entrar= true

}


if(entrar){


  parrafo.innerHTML = warnings

}else{


  parrafo.innerHTML = "Enviado"
}



})




*/

















$(document).ready(function(){
  //Hide Loader
  $("#loader").hide();
  //Show Content
  $("#content").show();
  //type write function
  typeWrite(document.querySelector('.profession'));
  //Initiate aos animation
  AOS.init();
});

//Animation TYPE WRITE
function typeWrite(elemento){
    const textoArray = elemento.innerHTML.split('');
    elemento.innerHTML = ' ';
    textoArray.forEach(function(letra, i){
    setTimeout(function(){
      elemento.innerHTML += letra;
    }, 75 * i)
  });
}

//ANIMATION ON SCROLL
window.onscroll = function() {scrollFunction()};
function scrollFunction() {
  if (document.body.scrollTop > 40 || document.documentElement.scrollTop > 40) {
    $(".header").css("backgroundColor", "#000000");
  } else {
    $(".header").css("backgroundColor", "transparent");
  }
}

//MENU
//OPEN MENU BTN
$(".btn_menu").click(function(){
  $(".btn_menu").fadeOut("fast");
  $(".nav_menu").fadeIn("fast");
});
//CLOSE MENU BTN
$(".close_btn").click(function(){
  $(".nav_menu").fadeOut("fast");
  $(".btn_menu").fadeIn("fast");
});
//CLOSE MENU ON LINK CLICK
$(".a_menu").click(function(){
  $(".nav_menu").fadeOut("fast");
  $(".btn_menu").fadeIn("fast");
});

//MODAL IMAGE
var modalImage = document.getElementById('modal_image');
modalImage.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget;
  var image = button.getAttribute('data-image');

  document.getElementById("modal_img").src = image;
})

//MODAL VIDEO SHOW
var modalVideo = document.getElementById('modal_video');
modalVideo.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget;
  var video = button.getAttribute('data-video');

  document.getElementById("modal_video_iframe").src = video;
})
//MODAL VIDEO CLOSE
modalVideo.addEventListener('hidden.bs.modal', function (event) {
  document.getElementById("modal_video_iframe").src = "";
})

//TESTEMONIALS
$(document).ready(function(){
  $('.testimonial_container').owlCarousel({
      loop:true,
      center:true,
      items: 1,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true
  })
});