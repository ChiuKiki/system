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
    data:[{"name":"单周","value":-1},{"name":"双周","value":0}]
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

$(function(){//点击搜索按钮开始搜索
  $("#spareSearch").click(function(){
    var data;
    if($(".week input").val()=="单周"){
      data=-1;
    }
    else if($(".week input").val()=="双周"){
      data=0;
    }
    else{
      data=$(".week input").val();
    }
    console.log(data);
    console.log($(".weekDay input").attr("data-value"));
    console.log($(".class input").attr("data-value"));
    console.log($(".department input").attr("data-value"));
    $.ajax({
      url:"http://system.chiukiki.cn/api/free",
      data:{
        weekNum:data,
        day:$(".weekDay input").attr("data-value"),
        class:$(".class input").attr("data-value"),
        department:$(".department input").attr("data-value")
      },
      success:function(data){
        $("body").append("<div id='alert'>"+"请求成功"+"</div>");
        window.setTimeout(function(){$("#alert").remove();},2000);
        console.log(data.name[0]);
        $("#addressBookTable").empty();
        if(data.message!=""){ 
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
      },
      error:function(){
        $("body").append("<div id='alert'>"+"请求失败"+"</div>");
        window.setTimeout(function(){$("#alert").remove();},2000);
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

