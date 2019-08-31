function getUrlParam(names) {//获取URL中的参数
  var reg = new RegExp("(^|&)" + names + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
  var r = window.location.search.substr(1).match(reg); //匹配目标参数
  if (r != null) return unescape(r[2]); return null; //返回参数值
}
$(function(){//底部菜单点击事件
  $("#addressMenu").click(function(){ 
    if(!/addressBook/.test(window.location.pathname)){
      $("body").not("#menu").animate({"left":"100vw"},function(){
        location="../addressBook/addressBook.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
      });
    }
  })
  $("#spareMenu").click(function(){
    if(!/spare/.test(window.location.pathname)){
      $("body").not("#menu").animate({"left":"100vw"},function(){
        location="../spare/spare.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
      });
    }
  })
  $("#presonMessageMenu").click(function(){
    if(!/message/.test(window.location.pathname)){
      $("body").not("#menu").animate({"left":"100vw"},function(){
        location="../message/message.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
      });
    }
  })
  $("#administratorMenu").click(function(){
    if(getUrlParam("dataUsed")==1){
      if(!/administrator/.test(window.location.pathname)){
        $("body").not("#menu").animate({"left":"100vw"},function(){
          location="../administrator/administrator.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
        }); 
      }
    }
  })
})