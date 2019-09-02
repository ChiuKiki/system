
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
        $("body").append("<div id='alert'>"+"查询成功"+"</div>");
        window.setTimeout(function(){$("#alert").remove();},2000);
        $("#administratorTable").empty();
        console.log(data[0][0]);
        $("#administratorTable").append('<tr> <th><input type="checkbox" id="allSelect" class="selectPart" value=true/><p>全选</p></th>' 
                                            +"<th>操作</th>"
                                            +"<th>姓名</th>"
                                            +"<th>部门</th>"
                                            +"<th>职位</th>"
                                            +"<th>电话</th>"
                                            +"<th>QQ</th>"
                                            +"<th>邮箱</th>"
                                            +"<th>学院</th>"
                                            +"<th>学号</th>"
                                            +"<th>生日</th>"
                                            +'</tr>');
        for(var i in data){
          $("#administratorTable").append('<tr> <td><input type="checkbox" class="selectPart" value=true/><p>选中</p></td>'
                                          +'<td class="operate"><a class="operateChange">修改</a> <a class="operateDelete">删除</a></td> <td>'
                                          +data[i].name+'</td> <td>'
                                          +data[i].department+'</td> <td>'
                                          +data[i].position+'</td> <td>'
                                          +data[i].tel+'</td> <td>'
                                          +data[i].QQ+'</td> <td>'
                                          +data[i].email+'</td> <td>'
                                          +data[i].school+'</td> <td>'
                                          +data[i].number+'</td> <td>'
                                          +data[i].birthday+'</td>'+'</tr>');
        }
        $(".operateChange").on('click',function(){//如果点击修改则跳转到个人页面
  
          console.log($(this).parent().parent().children().eq(9).text());
          $("#amendBox").toggle();
          $("#blackBox").toggle();
          $("#amendBox").animate({"top":"65%"},500); 
          $.ajax({//发送请求获取个人信息
            url:"http://system.chiukiki.cn/api/queryAdmin",
            data:{
              queryNumber:$(this).parent().parent().children().eq(9).text()
            },
            success:function(data){
               var datas=eval("("+data+")");
              $("body").append("<div id='alert'>"+datas.message+"</div>");
              window.setTimeout(function(){$("#alert").remove();},2000);
              var j=0;
              for(var i in data[0]){
                $(".fromPart input").eq(j).attr({ value: data[0][i] });console.log(data[0][i]);
                j++;
              }
            },
            error:function(data){
              var datas=eval("("+data+")");
              $("body").append("<div style=' color:white;' id='alert'>"+datas.message+"</div>");
              window.setTimeout(function(){$("#alert").remove();},2000);
            }
          })
        })
        $(".operateDelete").on('click',function() {//操作中的删除按钮
          if(confirm("你确定要删除这些用户的信息?")){
            var people=new Array();
            people.push($(this).parent().parent().children().eq(9).text());
            $(this).parent().parent().remove();
            $.ajax({
              url:"http://system.chiukiki.cn/api/delete",
              data:{
                number: people
              },
              success:function(data) {
                var datas=eval("("+data+")");
                $("body").append("<div id='alert'>"+datas.message+"</div>");
                window.setTimeout(function(){$("#alert").remove();},2000);
                if (datas.message == "删除成功") {
                  console.log(datas.message);
                }
              },
              error:function(data){
                var datas=eval("("+data+")");
                $("body").append("<div id='alert'>"+datas.message+"</div>");
                window.setTimeout(function(){$("#alert").remove();},2000);
              }
            })
              $(this).parent().parent().remove();
          }
        })
        $("#allSelect").on("click",function(){//设置全选的逻辑
          console.log($("#allSelect").attr("checked")); 
          if($("#allSelect").prop("checked")){
            $(".selectPart").prop("checked",true);
          }  
          else{
            $(".selectPart").prop("checked",false);
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
});
$(function(){//点击保存时保存数据
  $("#reserve").click(function(){
    var detections=true;
    tests=new Array("/^[\u2E80-\u9FFF]{2,5}$/",
								"/^[\u2E80-\u9FFF]+$/",
                "/^[\u2E80-\u9FFF]+$/",
                "/^1(3|4|5|7|8|9)[0-9]{9}$/",
                "/^[1-9][0-9]{4,9}$/",
                "/^([a-z0-9_\.-]+)@([0-9a-z\.-]+)\.([a-z]{2,6})$/",
                "/^[\u2E80-\u9FFF]+学院$/",
                "/^[0-9]{12}$/",
                "/^(?:1[0-2]|[1-9]).(?:[1-9]|([1-2][0-9])?|3[0-1])$/"
		);
	    information=new Array("姓名","部门","职位","电话","QQ","邮箱","学院","学号","生日");
      hint=new Array("姓名必须为2位到5位的汉字",
                     "部门必须为两位以上的汉字",
                     "职位必须为两位以上的汉字",
                     "电话必须为12位电话号码",
                     "QQ必须正确",
                     "邮箱必须符合要求",
                     "学院必须为两位以上的汉字且以学院结尾",
                     "学号必须为12位的数字",
										 "生日必须是12.18这种格式",
      )
			for(var i=0;i<tests.length;i++){//依次检测数据是否正确
				var j=$(".data").eq(i).attr("placeholder");   console.log("j="+j);
				var text=j[j.length-2]+j[j.length-1];         console.log(text);
				var reg=eval(tests[i]);                       console.log(i);
				if(($(".data").eq(i).val()==null||$(".data").eq(i).val()=="")){
          $("body").append("<div id='alert'>"+text+"不为空"+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
          detections=false;
          console.log("为空");
					break;
				}
				else{
					console.log(reg);
					  console.log(reg.test($(".data").eq(i).val()));
					  if( reg.test($(".data").eq(i).val()) ){
              detections = true;
              console.log("正确");
					  }
					  else{
              $("body").append("<div id='alert'>"+text+"格式错误!"+"<br/>"+hint[i]+"</div>"
              );
              window.setTimeout(function(){$("#alert").remove();},2000);
              detections=false;
              console.log("错误");
							break;
						}
				}
      }
      if(detections == true){
        $.ajax({  
          url:"http://system.chiukiki.cn/api/updatePeople",
          data:{
          name:$("#userName").val(),
          birthday:$("#userBirthday").val(),
          QQ:$("#userQQ").val(),
          number:$("#userStudentNum").val(),
          tel:$("#userTelephone").val(),
          email:$("#userEmail").val(),
				  school:$("#userAcademy").val(),
				  department:$("#userDepartment").val(),
				  position:$("#userWork").val()
        },
        success:function(data){
          $("body").append("<div id='alert'>"+"修改成功"+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
           
        },
        error:function(data){
          $("body").append("<div id='alert'>"+"修改失败"+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
        }
        })
        $("#amendBox").animate({"bottom":"100vw"},function(){
          $("#amendBox").toggle();
          $("#blackBox").toggle();
        }); 
      }
  })
});
$(function(){//点击关闭个人信息窗口
  $("#close,#closes").click(function(){
    $("#amendBox").animate({"top":"-100vw"},500,function(){
      $("#amendBox").toggle();
      $("#blackBox").toggle();
    }); 
  })
})
$(function(){//删除用户信息
  $("#deleteBox").click(function(){
    if(confirm("你确定要删除这些用户的信息?")){
      var people=new Array();
      $(".selectPart:checked").each(function(){
          if(!($(this).parent().parent().children().eq(9).text()==""||$(this).parent().parent().children().eq(8).text()==null)){
            people.push($(this).parent().parent().children().eq(9).text());  
          }
          $(this).parent().parent().remove();
      });
      $.ajax({
        url:"http://system.chiukiki.cn/api/delete",
        data:{
        number:people
        },
        success:function(data){
          $("body").append("<div id='alert'>"+"删除成功"+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
        },
        error:function(data){
          $("body").append("<div id='alert'>"+"删除失败"+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
        }
      })
    }
  })
});