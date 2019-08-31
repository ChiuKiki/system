var winHeight = $(window).height();  //当手机软键盘弹出时将底部菜单,藏在软键盘后面,软键盘关闭不变
$(window).resize(function () {
  var thisHeight = $(this).height();
  if ( winHeight - thisHeight > 140 ) {
      //键盘弹出
      $('#menu').css('position','static');
      $('body').css("overflow-y","scroll");
  } else {
      //键盘收起
      $('#menu').css({'position':'fixed','bottom':'0'});
      $('body').css("overflow-y","hidden");
      
  }
})
function getUrlParam(names) {//获取URL中的参数
    var reg = new RegExp("(^|&)" + names + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg); //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}
$(function(){//为选择框输入数据
  $(".week").wxSelect({
    data:[{"name":"单周","value":-1},{"name":"双周","value":0},{"name":"所有周","value":"-2"},{"name":"","value":""}]
  });
});
$(function(){//点击改变颜色
  $("#menu").toggle();
  $("td").attr("spare","0");
  $("td").click(function(){
    if($(this).css("backgroundColor")=="rgb(154, 255, 154)"){
      $(this).css({backgroundColor:"rgb(242,242,242)"});
      $(this).attr("spare","0");console.log($(this).attr("spare"));
    }
    else{
      $(this).css({backgroundColor:"rgb(154 ,255 ,154)"});
      $(this).attr("spare","1");console.log($(this).attr("spare"));
    }
  })
})
$(function(){//创建下拉菜单
  $("#SelfWeekSelectButton").click(function(){
    $("#SelfWeekSelect").toggle(500);
  })
})
$(function(){//通过input的值来操作自由选择周数
  $(".dataList li").click(function(){
    for(var i=1;i<=18;i++){
      $("#"+i+"").prop("checked","");
    }
    if($(this).text()=="单周"){
      for(var i=1;i<18;i=i+2){
        $("#"+i+"").prop("checked","true");
      } 
    }
    else if($(this).text()=="双周"){
      for(var i=2;i<=18;i=i+2){
        $("#"+i+"").prop("checked","true");
      } 
    }
    else if($(this).text()=="所有周"){
      for(var i=1;i<=18;i++){
        $("#"+i+"").prop("checked","true");
      }
    }
    else{
      ;
    }
  })
  
})
$(function(){//点击向左向右按钮实现滑动
  $("#left").click(function(){
    $("#selfWeekSelectBox").finish().animate({"scrollLeft":"0"},900);
    console.log("1");
  })
  $("#right").click(function(){
    console.log("1");
    $("#selfWeekSelectBox").finish().animate({"scrollLeft":1000},900);
    
  })
})
$(function(){//点击按钮保存
  $("#spareScanfSearch").click(function(){
    var data=new Array;
    $("#spareScanfHint").text("");
    $("input[type='checkbox']:checked").each(function(){
      data.push($(this).attr("id"));
    })
    function sortNum(a,b){
      return a - b;
    }
    data=data.sort(sortNum);
    if(data!=null&&data!=""){
      var arrs=new Array([$("#1-2-1").attr("spare"),$("#1-2-2").attr("spare"),$("#1-2-3").attr("spare"),$("#1-2-4").attr("spare"),$("#1-2-5").attr("spare")],
                         [$("#3-4-1").attr("spare"),$("#3-4-2").attr("spare"),$("#3-4-3").attr("spare"),$("#3-4-4").attr("spare"),$("#3-4-5").attr("spare")],
                         [$("#5-6-1").attr("spare"),$("#5-6-2").attr("spare"),$("#5-6-3").attr("spare"),$("#5-6-4").attr("spare"),$("#5-6-5").attr("spare")],
                         [$("#7-8-1").attr("spare"),$("#7-8-2").attr("spare"),$("#7-8-3").attr("spare"),$("#7-8-4").attr("spare"),$("#7-8-5").attr("spare")],
                         [$("#9-11-1").attr("spare"),$("#9-11-2").attr("spare"),$("#9-11-3").attr("spare"),$("#9-11-4").attr("spare"),$("#9-11-5").attr("spare")]
      );
      console.log("arrs="+arrs);
      console.log("data="+data);
      $.ajax({
        url:"http://system.chiukiki.cn/api/insertFree",
        data:{
          arr:arrs,
          weekNum:data
        },
        success:function(data){
          $("body").append("<div id='alert'>"+"录入成功"+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
          if(data.message=="录入成功"){
            if(!confirm("是否继续")){
              location="../addressBook/addressBook.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
              $("#spareScanfHint").text("");
            }
          }
          else{
            $("#spareScanfHint").text("录入失败");
          }
        },
        error:function(){
          $("body").append("<div id='alert'>"+"录入失败"+"</div>");
				  window.setTimeout(function(){$("#alert").remove();},2000);
        }
      })
    }
    else{
      $("#spareScanfHint").text("周数不能为空!");
    }
  })
})
$(function(){
  $("#callback").click(function(){//返回到上一页
	  $("body").not("#menu").animate({"left":"100vw"},function(){
			location="../message/message.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
		});
	})
})
