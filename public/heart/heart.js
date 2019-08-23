function test(e){

  //这里可得到鼠标X坐标
  
  var pointX = e.pageX;
  //这里可以得到鼠标Y坐标
  var i=parseInt(Math.random()*8);
  var color;
  switch(i){
    case 0: color="blue"; break;
    case 1: color="DarkOrange1"; break;
    case 2: color="SpringGreen1"; break;
    case 3: color="DarkSlateBlue";break;
    case 4: color="LightSlateBlue";break;
    case 5: color="Khaki2";break;
    case 6: color="IndianRed";break;
    case 7: color="PeachPuff";break;
  }
  var pointY = e.pageY;
  $("body").append("<div class='heart' style='position:absolute;left:"+pointX+"px;top:"+pointY+"px;'>"
                  +"<div class='round1' style='background-color:"+color+"'></div>"
                  +"<div class='round2' style='background-color:"+color+"'></div>"
                  +"<div class='rec' style='background-color:"+color+"'></div>"
                  +"</div>");
    $(".heart").animate({top:"-10px",opacity:'0'},1000);              
    $(".heart").each(function(){
    if($(this).css("opacity")=="0"){
      $(this).remove();
    }
  })
    
}
$("html").click(function(){
  test(event);
});

