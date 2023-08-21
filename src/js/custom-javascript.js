console.log('custom')
// Add your JS customizations here
addEventListener("hashchange", (event) => {
    //alert(window.location.hash.substring(1));
    const scrollId = window.location.hash.substring(1);
    dlinqScrollTo(scrollId);
});

function dlinqScrollTo(id){
    const destination = document.getElementById(id);
    destination.scrollIntoView({behavior: 'smooth', block: 'start'});
}


//Arrow stuff
// var getQuiver = document.querySelector('.major-container');
// console.log(getQuiver);


// for(var i = 0; i < 100; i++){
//   makeArrow(1);
// }

// function makeArrow (id){
//  var newDiv = document.createElement('div');
//   newDiv.classList.add("arrow");
//  var newContent = document.createTextNode(" "); 
//   // add the text node to the newly created div
//   newDiv.appendChild(newContent);  
//   var quiver = document.querySelector('#quiver');
//   const homeWrapper = document.querySelector('#full-width-home-wrapper');
//   homeWrapper.insertBefore(newDiv, quiver); 
// }

// var body =document.querySelector('body');
// console.log(body);

// body.onmousemove = function(event) {cursorFinder(event)};

// function cursorFinder(e) {
//     var x = e.clientX;
//     var y = e.clientY;
//     var coor = "Coordinates: (" + x + "," + y + ")";
  
  
//     //document.getElementById("data").innerHTML = coor;
//     var theArrows = document.getElementsByClassName("arrow");
//   for(var i = 0; i < theArrows.length; i++){
//      var xShapeCenter = getPos(theArrows[i],'x');
//      var yShapeCenter = getPos(theArrows[i],'y');
//     theArrows[i].style.transform = 'rotate('+ twisterMath(x, y, xShapeCenter, yShapeCenter)+'deg)';
//   }
// }


// //from https://stackoverflow.com/questions/288699/get-the-position-of-a-div-span-tag
// function getPos(el, pos) {
//     // yay readability
//     for (var lx=0, ly=0;
//          el != null;
//          lx += el.offsetLeft, ly += el.offsetTop, el = el.offsetParent);
//      if (pos === 'x'){
//        return lx
//      } else {
//        return ly
//      }
// }

// //from this crazy smart person https://codepen.io/pudinski/pen/xYoVaa/
// function twisterMath(x,y, xShapeCenter, yShapeCenter){
//   return  Math.atan2(x - xShapeCenter,-(y - yShapeCenter)) *(180 / Math.PI)
// }