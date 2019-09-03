
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
  $(".weekDay").wxSelect({
    data:[{"name":"星期一","value":1},{"name":"星期二","value":2},{"name":"星期三","value":3},{"name":"星期四","value":4},{"name":"星期五","value":5},{"name":"星期六","value":6},{"name":"星期天","value":7},{"name":"工作日","value":8},{"name":"周末","value":"9"}]
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
   
    console.log($("#day").val());
    console.log($(".weekDay input").attr("data-value"));
    console.log($(".class input").attr("data-value"));
    console.log($(".department input").attr("data-value"));
    console.log(/^[\u2E80-\u9FFF]+$/.test($(".department input").attr("data-value")));
    if(/^(?:1[0-8]|[0-9])$/.test($("#day").val())&&( /^[\u2E80-\u9FFF]+$/.test($(".department input").attr("data-value")) || $(".department input").attr("data-value")=="" || $(".department input").attr("data-value")==null)){
      $.ajax({
        url:"http://system.chiukiki.cn/api/free",
        data:{
          weekNum:$("#day").val(),
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
                $("#addressBookTable").append("<tr> <td></td> <td>"+data.name[j]+"</td> <td>"+" "+"</td> </tr>");
  
              }
              else{
                $("#addressBookTable").append("<tr> <td></td> <td>"+data.name[j]+"</td> <td>"+data.name[j+1]+"</td> </tr>");
  
              }
            }
          }
        },
        error:function(e){
          $("body").append("<div id='alert'>"+e.responseText.message+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
        }
      })
    }
    else{
      $("body").append("<div id='alert'>"+"周数必须为纯数字"+"</div>");
      window.setTimeout(function(){$("#alert").remove();},2000);
    }
  })  
})
