var winHeight = $(window).height();  //当手机软键盘弹出时将底部菜单,藏在软键盘后面,软键盘关闭不变
var reserveStatics;
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
function getUrlParam(names) {//获取URL中的参数
    var reg = new RegExp("(^|&)" + names + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg); //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}
$(function(){/*载入时获得人员的数据并添加修改,删除的逻辑*/
	$("#addressBookSearchImg").click(function(){
    reserveStatics=$("#addressBook").val();
    $.ajax({
      url:"http://system.chiukiki.cn/api/queryInfoAdmin",
      data:{
        query:$("#addressBook").val()
      },
      success:function(data){
        $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data[0].message+"</div>");
        window.setTimeout(function(){$("#alert").remove();},2000);
        $("#administratorTable").empty();
        console.log(data[0][0]);
        $("#administratorTable").append('<tr> <th><input type="checkbox" id="allSelect" class="selectPart" value=true/><p>全选</p></th>' 
                                            +"<th>姓名</th>"
                                            +"<th>部门</th>"
                                            +"<th>职位</th>"
                                            +"<th>电话</th>"
                                            +"<th>QQ</th>"
                                            +"<th>邮箱</th>"
                                            +"<th>学院</th>"
                                            +"<th>学号</th>"
                                            +"<th>生日</th>"
                                            +'<th>操作</th></tr>');
        for(var i in data){
          $("#administratorTable").append('<tr> <td><input type="checkbox" class="selectPart" value=true/><p>选中</p></td> <td>'
                                          +data[i].name+'</td> <td>'
                                          +data[i].department+'</td> <td>'
                                          +data[i].position+'</td> <td>'
                                          +data[i].tel+'</td> <td>'
                                          +data[i].QQ+'</td> <td>'
                                          +data[i].email+'</td> <td>'
                                          +data[i].school+'</td> <td>'
                                          +data[i].number+'</td> <td>'
                                          +data[i].birthday+'</td> <td class="operate"><a class="operateChange">修改</a> <a class="operateDelete">删除</a></td></tr>');
        }
        $(".operateChange").on('click',function(){//如果点击姓名则跳转到个人页面
  
          console.log($(this).parent().parent().children().eq(8).text());
          $("#amendBox").toggle();
          $("#blackBox").toggle();
          $.ajax({
            url:"http://system.chiukiki.cn/api/queryAdmin",
            data:{
              queryNumber:$(this).parent().parent().children().eq(8).text()
            },
            success:function(data){
              $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999; color:white;' id='alert'>"+data.message+"</div>");
              window.setTimeout(function(){$("#alert").remove();},2000);
              inputValue=new Array();
              var j=0;
              for(var i in data[0]){

                $(".fromPart input").eq(j).attr({ value: data[0][i] });console.log(data[0][i]);
                j++;
              }
            },
            error:function(data){
              $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999; color:white;' id='alert'>"+data.message+"</div>");
              window.setTimeout(function(){$("#alert").remove();},2000);
            }
          })
        })
        $(".operateDelete").on('click',function() {//操作中的删除按钮
          if(confirm("你确定要删除这些用户的信息?")){
            var people=new Array();
            people.push($(this).parent().parent().children().eq(8).text());
            $(this).parent().parent().remove();
            $.ajax({
              url:"http://system.chiukiki.cn/api/delete",
              data:{
                number: people
              },
              success:function(data) {
                $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
                window.setTimeout(function(){$("#alert").remove();},2000);
                if (data.message == "删除成功") {
                  console.log(data.message);
                }
              },
              error:function(data){
                $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
                window.setTimeout(function(){$("#alert").remove();},2000);
              }
            })
              $(this).parent().parent().remove();
          }
        })
      },
      error:function(data){
        $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
        window.setTimeout(function(){$("#alert").remove();},2000);
      }
    })
  })	
});
$(function(){//点击保存时保存数据
  $("#reserve").click(function(){
    $.ajax({
      url:"http://system.chiukiki.cn/api/updatePeople",
      data:{
        name:$("#userName").val(),
				school:$("#userAcademy").val(),
				department:$("#userDepartment").val(),
				position:$("#userWork").val(),
				birthday:$("#userBirthday").val(),
				tel:$("#userTelephone").val(),
				QQ:$("#userQQ").val(),
				email:$("#userEmail").val(),
				number:$("#userStudentNum").val(),
				message:$("#userTextarea").val()
      },
      success:function(data){
        $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data[0].message+"</div>");
        window.setTimeout(function(){$("#alert").remove();},2000);
        if(data.message=="修改成功"){
          $.ajax({
            url:"http://system.chiukiki.cn/api/queryInfoAdmin",
            data:{
              query:reserveStatics
            },
            success:function(data){
              $("#administratorTable").empty();
              console.log(data[0][0]);
              $("#administratorTable").append('<tr> <th><input type="checkbox" id="allSelect" class="selectPart" value=true/><p>全选</p></th>' 
                                            +"<th>姓名</th>"
                                            +"<th>部门</th>"
                                            +"<th>职位</th>"
                                            +"<th>电话</th>"
                                            +"<th>QQ</th>"
                                            +"<th>邮箱</th>"
                                            +"<th>学院</th>"
                                            +"<th>学号</th>"
                                            +"<th>生日</th>"
                                            +'<th>操作</th></tr>');
              for(var i in data){
                $("#administratorTable").append('<tr> <td><input type="checkbox" class="selectPart" value=true/><p>选中</p></td> <td>'
                                          +data[i].name+'</td> <td>'
                                          +data[i].department+'</td> <td>'
                                          +data[i].position+'</td> <td>'
                                          +data[i].tel+'</td> <td>'
                                          +data[i].QQ+'</td> <td>'
                                          +data[i].email+'</td> <td>'
                                          +data[i].school+'</td> <td>'
                                          +data[i].number+'</td> <td>'
                                          +data[i].birthday+'</td> <td class="operate"><a class="operateChange">修改</a> <a class="operateDelete">删除</a></td></tr>');
              }
              $(".operateChange").on('click',function(){//如果点击姓名则跳转到个人页面
    
                console.log($(this).parent().parent().children().eq(8).text());
                $("#amendBox").toggle();
                $("#blackBox").toggle();
                $.ajax({
                  url:"http://system.chiukiki.cn/api/queryAdmin",
                  data:{
                    ueryNumber:$(this).parent().parent().children().eq(8).text()
                  },
                  success:function(data){
                    $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
                    window.setTimeout(function(){$("#alert").remove();},2000);
                    inputValue=new Array();
                    var j=0;
                    for(var i in data[0]){
      
                      $(".fromPart input").eq(j).attr({ value: data[0][i] });console.log(data[0][i]);
                      j++;
                    }
                  },
                  error:function(data){
                    $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
                    window.setTimeout(function(){$("#alert").remove();},2000);
                  }
                })
              })
              $(".operateDelete").on('click',function() {//操作中的删除按钮
                if(confirm("你确定要删除这些用户的信息?")){
                  var people=new Array();
                  people.push($(this).parent().parent().children().eq(8).text());
                  $(this).parent().parent().remove();
                  $.ajax({
                    url:"http://system.chiukiki.cn/api/delete",
                    data:{
                    number: people
                    },
                    success:function (data) {
                      $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
                      window.setTimeout(function(){$("#alert").remove();},2000);
                      if (data.message == "删除成功") {
                        console.log(data.message);
                      }
                    },
                    error:function(data){
                      $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
                      window.setTimeout(function(){$("#alert").remove();},2000);
                    }
                  })
                  $(this).parent().parent().remove();
                }
              })
              },
              error:function(){
                $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
                window.setTimeout(function(){$("#alert").remove();},2000);
              }
          })
        }
      },
      error:function(data){
        $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
        window.setTimeout(function(){$("#alert").remove();},2000);
      }
    })
    $("#amendBox").toggle();
    $("#blackBox").toggle();  
  })
});
$(function(){//点击关闭个人信息窗口
  $("#close,#closes").click(function(){
    $("#amendBox").toggle();
    $("#blackBox").toggle();
  })
})
$(function(){//设置全选的逻辑
    
    $("#allSelect").click(function(){
      console.log($("#allSelect").attr("checked")); 
      if($("#allSelect").prop("checked")){
        $(".selectPart").prop("checked",true);
      }  
    })
    
});
$(function(){//删除用户信息
  $("#deleteBox").click(function(){
    if(confirm("你确定要删除这些用户的信息?")){
      var people=new Array();
      $(".selectPart:checked").each(function(){
          if(!($(this).parent().parent().children().eq(8).text()==""||$(this).parent().parent().children().eq(8).text()==null)){
            people.push($(this).parent().parent().children().eq(8).text());  
          }
          $(this).parent().parent().remove();
      });
      $.ajax({
        url:"http://system.chiukiki.cn/api/delete",
        data:{
        number:people
        },
        success:function(data){
          $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
        },
        error:function(data){
          $("body").append("<div style='position:absolute; top:85vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
        }
      })
    }
  })
});
$(function(){//底部菜单的逻辑
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
});