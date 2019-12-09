var starSelected1 = false;
var starSelected2 = false;
var starSelected3 = false;
var starSelected4 = false;
var starSelected5 = false;
var detect = false;

// --------------------- Star 1 --------------------- //
function hoverStar1() {
  document.getElementById("star1").src = "img/star-filled.png";
}

function unHoverStar1(){
  if(starSelected1 == false){
    if(detect == true) {
      document.getElementById("star1").src = "img/star-filled.png";
    }
    else {
      document.getElementById("star1").src = "img/star.png";
    }
  }
  else {
    document.getElementById("star1").src = "img/star-filled.png";
  }
}

function clickStar1(){
  document.getElementById("star1").src = "img/star-filled.png";
  document.getElementById("star2").src = "img/star.png";
  document.getElementById("star3").src = "img/star.png";
  document.getElementById("star4").src = "img/star.png";
  document.getElementById("star5").src = "img/star.png";
  starSelected1 = true;
  starSelected2 = false;
  starSelected3 = false;
  starSelected4 = false;
  starSelected5 = false;
  detect = true;
}

// --------------------- Star 2 --------------------- //
function hoverStar2() {
  document.getElementById("star1").src = "img/star-filled.png";
  document.getElementById("star2").src = "img/star-filled.png";
}

function unHoverStar2(){
  if(starSelected2 == false){
    if(detect == true) {
      document.getElementById("star1").src = "img/star-filled.png";
      document.getElementById("star2").src = "img/star.png";
    }
    else {
      document.getElementById("star1").src = "img/star.png";
      document.getElementById("star2").src = "img/star.png";
    }
  }
  else {
    document.getElementById("star1").src = "img/star-filled.png";
    document.getElementById("star2").src = "img/star-filled.png";
  }
}

function clickStar2(){
  document.getElementById("star1").src = "img/star-filled.png";
  document.getElementById("star2").src = "img/star-filled.png";
  document.getElementById("star3").src = "img/star.png";
  document.getElementById("star4").src = "img/star.png";
  document.getElementById("star5").src = "img/star.png";
  starSelected1 = true;
  starSelected2 = true;
  starSelected3 = false;
  starSelected4 = false;
  starSelected5 = false;
  detect = true;
}

// --------------------- Star 3 --------------------- //
function hoverStar3() {
  document.getElementById("star1").src = "img/star-filled.png";
  document.getElementById("star2").src = "img/star-filled.png";
  document.getElementById("star3").src = "img/star-filled.png";
}

function unHoverStar3(){
  if(starSelected3 == false){
    if(detect == true) {
      document.getElementById("star1").src = "img/star-filled.png";
      document.getElementById("star2").src = "img/star-filled.png";
      document.getElementById("star3").src = "img/star.png";
    }
    else {
      document.getElementById("star1").src = "img/star.png";
      document.getElementById("star2").src = "img/star.png";
      document.getElementById("star3").src = "img/star.png";
    }
  }
  else {
    document.getElementById("star1").src = "img/star-filled.png";
    document.getElementById("star2").src = "img/star-filled.png";
    document.getElementById("star3").src = "img/star-filled.png";
  }
}

function clickStar3(){
  document.getElementById("star1").src = "img/star-filled.png";
  document.getElementById("star2").src = "img/star-filled.png";
  document.getElementById("star3").src = "img/star-filled.png";
  document.getElementById("star4").src = "img/star.png";
  document.getElementById("star5").src = "img/star.png";
  starSelected1 = true;
  starSelected2 = true;
  starSelected3 = true;
  starSelected4 = false;
  starSelected5 = false;
  detect = true;
}

// --------------------- Star 4 --------------------- //
function hoverStar4() {
  document.getElementById("star1").src = "img/star-filled.png";
  document.getElementById("star2").src = "img/star-filled.png";
  document.getElementById("star3").src = "img/star-filled.png";
  document.getElementById("star4").src = "img/star-filled.png";
}

function unHoverStar4(){
  if(starSelected4 == false){
    if(detect == true) {
      document.getElementById("star1").src = "img/star-filled.png";
      document.getElementById("star2").src = "img/star-filled.png";
      document.getElementById("star3").src = "img/star-filled.png";
      document.getElementById("star4").src = "img/star.png";
    }
    else {
      document.getElementById("star1").src = "img/star.png";
      document.getElementById("star2").src = "img/star.png";
      document.getElementById("star3").src = "img/star.png";
      document.getElementById("star4").src = "img/star.png";
    }
  }
  else {
    document.getElementById("star1").src = "img/star-filled.png";
    document.getElementById("star2").src = "img/star-filled.png";
    document.getElementById("star3").src = "img/star-filled.png";
    document.getElementById("star4").src = "img/star-filled.png";
  }
}

function clickStar4(){
  document.getElementById("star1").src = "img/star-filled.png";
  document.getElementById("star2").src = "img/star-filled.png";
  document.getElementById("star3").src = "img/star-filled.png";
  document.getElementById("star4").src = "img/star-filled.png";
  document.getElementById("star5").src = "img/star.png";
  starSelected1 = true;
  starSelected2 = true;
  starSelected3 = true;
  starSelected4 = true;
  starSelected5 = false;
  detect = true;
}

// --------------------- Star 5 --------------------- //
function hoverStar5() {
  document.getElementById("star1").src = "img/star-filled.png";
  document.getElementById("star2").src = "img/star-filled.png";
  document.getElementById("star3").src = "img/star-filled.png";
  document.getElementById("star4").src = "img/star-filled.png";
  document.getElementById("star5").src = "img/star-filled.png";
}

function unHoverStar5(){
  if(starSelected5 == false){
    if(detect == true) {
      document.getElementById("star1").src = "img/star-filled.png";
      document.getElementById("star2").src = "img/star-filled.png";
      document.getElementById("star3").src = "img/star-filled.png";
      document.getElementById("star4").src = "img/star-filled.png";
      document.getElementById("star5").src = "img/star.png";
    }
    else {
      document.getElementById("star1").src = "img/star.png";
      document.getElementById("star2").src = "img/star.png";
      document.getElementById("star3").src = "img/star.png";
      document.getElementById("star4").src = "img/star.png";
      document.getElementById("star5").src = "img/star.png";
    }
  }
  else {
    document.getElementById("star1").src = "img/star-filled.png";
    document.getElementById("star2").src = "img/star-filled.png";
    document.getElementById("star3").src = "img/star-filled.png";
    document.getElementById("star4").src = "img/star-filled.png";
    document.getElementById("star5").src = "img/star-filled.png";
  }
}

function clickStar5(){
  document.getElementById("star1").src = "img/star-filled.png";
  document.getElementById("star2").src = "img/star-filled.png";
  document.getElementById("star3").src = "img/star-filled.png";
  document.getElementById("star4").src = "img/star-filled.png";
  document.getElementById("star5").src = "img/star-filled.png";
  starSelected1 = true;
  starSelected2 = true;
  starSelected3 = true;
  starSelected4 = true;
  starSelected5 = true;
  detect = true;
}

function show() {
  document.getElementById("reviewSubmitBtn").style.display = "block";
}

function showCreateRestaurant() {
  document.getElementById("createRestaurantForm").style.display = "block";
  document.getElementById("showCreateRestaurant").style.display = "none";
}

function showManageRestaurant() {
  document.getElementById("manageRestaurantForm").style.display = "block";
  document.getElementById("showManageRestaurant").style.display = "none";
}
