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
function getUrlParam(names) {//从URL中获取参数
  var reg = new RegExp("(^|&)" + names + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
  var r = window.location.search.substr(1).match(reg); //匹配目标参数
  if (r != null) return unescape(r[2]); return null; //返回参数值
}
$(function(){//载入时输出所有人员
    $.get("http://system.chiukiki.cn/api/queryInitial",
        function(data,xhrFields){
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
            xhrFields:{withCredentials:true};
            $("td").on("click",function(){
                if(!($(this).parent().children().eq(0).text()==""||$(this).parent().children().eq(0).text()==null)){
                    location="../message/message.html?way=addressBook"+"&queryName="+encodeURI(encodeURI($(this).parent().children().eq(0).text()))+"&queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
                }
            })
        },error(function(){
          $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
        }));
})
$(function(){/*点击时获得人员的数据*/
  $("#addressBookSearchImg").click(function(){
    if($("#addressBook").val()==null||$("#addressBook").val()==""){
      $.get("http://system.chiukiki.cn/api/queryInitial",
        function(data,xhrFields){
          $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
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
          xhrFields:{withCredentials:true};
          $("td").on("click",function(){
            if(!($(this).parent().children().eq(0).text()==""||$(this).parent().children().eq(0).text()==null)){
              location="../message/message.html?way=addressBook"+"&queryName="+encodeURI(encodeURI($(this).parent().children().eq(0).text()))+"&queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
            }
          })
        },error(function(){
          $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
        }));
    }
    else{
       $.get("http://system.chiukiki.cn/api/queryInfo",{
	            query:$("#addressBook").val()
	          },
	          function(data,xhrFields){
              $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
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
              xhrFields:{withCredentials:true};
              $("td").on("click",function(){
                if(!($(this).parent().children().eq(0).text()==""||$(this).parent().children().eq(0).text()==null)){
                  location="../message/message.html?way=addressBook"+"&queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed")+"&queryName="+encodeURI(encodeURI($(this).parent().children().eq(0).text()));
                }
              })
	          },error(function(){
              $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
              window.setTimeout(function(){$("#alert").remove();},2000);
            }));	
    }
  });
});
$(function(){//底部菜单的逻辑
  $("#addressMenu").click(function(){//跳转到通讯录
    location="../addressBook/addressBook.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
  })
  $("#spareMenu").click(function(){//跳转到没课表
    location="../spare/spare.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
  })
  $("#presonMessageMenu").click(function(){//跳转到个人信息
    location="../message/message.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
  })
  if(getUrlParam("dataUsed")==1){//若为管理员则添加跳转并显示按钮,非管理员隐藏按钮
    $("#administratorMenu").click(function(){
      location="../administrator/administrator.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
    })
  }
})