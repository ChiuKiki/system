var winHeight = $(window).height();  //当手机软键盘弹出时将底部菜单,藏在软键盘后面,软键盘关闭不变
$(window).resize(function () {
    var thisHeight = $(this).height();
    if ( winHeight - thisHeight > 140 ) {
        //键盘弹出
        $('#menu').css('position','static');
    } else {
        //键盘收起
        $('#menu').css({'position':'fixed','bottom':'0'});
        
    }
})
$(function(){//当非管理员时隐藏管理员按钮
  if(getUrlParam("dataUsed")==0){
    $("#administratorMenu").hide();
  }
})
function getUrlParam(names) {//获取URL中的参数
    var reg = new RegExp("(^|&)" + names + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg); //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}
$(function(){//为选择框输入数据
  $(".week").wxSelect({
    data:[{"name":"单周","value":-1},{"name":"双周","value":0},{"name":"所有周","value":"-2"}]
  });
 
  $(".weekDay").wxSelect({
    data:[{"name":"周一","value":1},{"name":"周二","value":2},{"name":"周三","value":3},{"name":"周四","value":4},{"name":"周五","value":5},{"name":"周六","value":6},{"name":"周天","value":7},{"name":"工作日","value":8},{"name":"周末","value":"9"}]
  });
  $(".class").wxSelect({
    data:[{"name":"1-2节","value":"1-2"},{"name":"3-4节","value":"3-4"},{"name":"5-6节","value":"5-6"},{"name":"7-8节","value":"7-8"},{"name":"9-11节","value":"9-11"}]
  });
  $(".department").wxSelect({
    data:[{"name":"技术部","value":"技术部"}]
  })
});
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
$(function(){//点击搜索按钮开始搜索
  $("#spareSearch").click(function(){

    console.log($(".week input").attr("data-value"));
    console.log($(".weekDay input").attr("data-value"));
    console.log($(".class input").attr("data-value"));
    console.log($(".department input").attr("data-value"));
    var data=new Array;
    $("#spareScanfHint").text("");
    $("input[type='checkbox']:checked").each(function(){
      data.push($(this).attr("id"));
    })
    function sortNum(a,b){
      return a - b;
    }
    data=data.sort(sortNum);
    $.get("http://system.chiukiki.cn/api/free",{
      weekNum:data,
      day:$(".weekDay input").attr("data-value"),
      class:$(".class input").attr("data-value"),
      department:$(".department input").attr("data-value")
    },function(data,xhrFields){
      xhrFields:{withCredentials:true};
      console.log(data.name[0]);
      $("#addressBookTable").empty();
      if(data.message!="查询失败"){

        var departmentTitle=$(".department input").attr("data-value");
        $("#addressBookTable").append("<tr> <td>"+departmentTitle+"</td> <td>"+data.name[0]+"</td> <td>"+data.name[1]+"</td> </tr>");
        for(var j=2;j<data.name.length;j=j+2){
          if(j==data.name.length-1){
            $("#addressBookTable").append("<tr> <td></td> <td>"+data.name[j]+"</td> <td></td> </tr>");

          }
          else{
            $("#addressBookTable").append("<tr> <td></td> <td>"+data.name[j]+"</td> <td>"+data.name[j+1]+"</td> </tr>");

          }
        }
      }
    })
  })
})
$(function(){//底部菜单点击事件
    $("#addressMenu").click(function(){
        location="../addressBook/addressBook.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
    })
    $("#spareMenu").click(function(){
        location="../spare/spare.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
    })
    $("#presonMessageMenu").click(function(){
        location="../message/message.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
    })
    if(getUrlParam("dataUsed")==1){
      $("#administratorMenu").click(function(){
        location="../administrator/administrator.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
      })
    }
    $("#callback").click(function(){
        location="../addressBook/addressBook.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
    })
})

