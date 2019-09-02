
document.addEventListener('touchmove', function (event) {//禁止手机body滑动
  event.preventDefault();
});
$(function(){//当非管理员时隐藏管理员按钮
  if(getUrlParam("dataUsed")==0){
    $("#administratorMenu").hide();
  }
})
function getUrlParam(names) {//从URL中获取参数
  var reg = new RegExp("(^|&)" + names + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
  var r = window.location.search.substr(1).match(reg); //匹配目标参数
  if (r != null) return unescape(r[2]); return null; //返回参数值
}
$(function(){//载入时输出所有人员
  $.ajax({
    url:"http://system.chiukiki.cn/api/queryInitial",
    data:{

    },
    success:function(data){
      $("#addressBookTable").empty();
      $("#addressBookTable").append("<tr> <th>姓名</th> <th>部门</th> <th>职位</th> </tr>");
      for(var i=0;i<data.length;i++){
          $("#addressBookTable").append("<tr><td></td><td></td><td></td></tr>");
          var k=0;
          for(var j in data[i]){

              $("tr").eq(i+1).children().eq(k).text(data[i][j]);
              k++;
          }
      }
      $("td").on("click",function(){
          if(!($(this).parent().children().eq(0).text()==""||$(this).parent().children().eq(0).text()==null)){
            $("body").not("#menu").animate({"left":"100vw"},function(){
              location="../message/message.html?way=addressBook"+"&queryName="+encodeURI(encodeURI($(this).parent().children().eq(0).text()))+"&queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
            }); 
          }
      })
    },
    error:function(data){
       var datas=eval("("+data+")");
      $("body").append("<div id='alert'>"+datas.message+"</div>");
      window.setTimeout(function(){$("#alert").remove();},2000);
    }
  })
})
$(function(){/*点击时获得人员的数据*/
  $("#addressBookSearchImg").click(function(){
    if($("#addressBook").val()==null||$("#addressBook").val()==""){//如果输入为空,就返回所有人的数据
      $.ajax({
        url:"http://system.chiukiki.cn/api/queryInitial",
        data:{

        },
        success:function(data){
          $("body").append("<div id='alert'>"+"获取成功"+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
          $("#addressBookTable").empty();
          $("#addressBookTable").append("<tr> <th>姓名</th> <th>部门</th> <th>职位</th> </tr>");
          for(var i=0;i<data.length;i++){
            $("#addressBookTable").append("<tr><td></td><td></td><td></td></tr>");
            var k=0;
            for(var j in data[i]){
              $("tr").eq(i+1).children().eq(k).text(data[i][j]);
              k++;
            }
          }
          $("td").on("click",function(){
            if(!($(this).parent().children().eq(0).text()==""||$(this).parent().children().eq(0).text()==null)){
              location="../message/message.html?way=addressBook"+"&queryName="+encodeURI(encodeURI($(this).parent().children().eq(0).text()))+"&queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
            }
          })
        },
        error:function(data){
           var datas=eval("("+data+")");
          $("body").append("<div style='top:140vw;' id='alert'>"+datas.message+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
        }
      })
    }
    else{
      $.ajax({
        url:"http://system.chiukiki.cn/api/queryInfo",
        data:{
          query:$("#addressBook").val()
        },
        success:function(data){
          $("body").append("<div style='top:140vw;' id='alert'>"+"获取成功"+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
          $("#addressBookTable").empty();
          $("#addressBookTable").append("<tr> <th>姓名</th> <th>部门</th> <th>职位</th> </tr>");
          for(var i=0;i<data.length;i++){
            $("#addressBookTable").append("<tr><td></td><td></td><td></td></tr>");
            var k=0;
            for(var j in data[i]){
              $("tr").eq(i+1).children().eq(k).text(data[i][j]);
              k++;
            }
          }
          $("td").on("click",function(){
            if(!($(this).parent().children().eq(0).text()==""||$(this).parent().children().eq(0).text()==null)){
              location="../message/message.html?way=addressBook"+"&queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed")+"&queryName="+encodeURI(encodeURI($(this).parent().children().eq(0).text()));
            }
          })
        },
        error:function(data){
          var datas=eval("("+data+")");
          $("body").append("<div style='top:140vw;' id='alert'>"+datas.message+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
        }
      })
    }
  });
});