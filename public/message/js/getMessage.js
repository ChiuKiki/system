var detections=true;
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
$(function(){//加载信息
	if(getUrlParam("way")=="addressBook"){//当从通讯录进入个人信息时的情况

		for(var i=1;i<10;i++){//将label标签的内容换成图片
			
		  $("label").eq(i-1).empty();
			$("label").eq(i-1).append("<img src='img/project"+i+".png' style='width:10vw;height:10vw;float:left;'/>");
			
		}
		$("#spareBox").hide();
		$("#menu").hide();
		$("#container").css({"border-top":"3px solid rgb(48, 150, 7)","margin-top":"5vw","height":"120vw"});
		$(".fromPart").css({"margin-top":"3vw","height":"10vw"});
		$("#containerLeft").css({"height":"35vw"});
		$("#containerRight").css({"height":"86vw"});
		$(".data").css({"margin-top":"3vw"})
		$("#callback").show();

		$(function(){/*载入时获得人员的数据*/
			console.log(decodeURI(decodeURI(getUrlParam("queryName"))));
      $.get("http://system.chiukiki.cn/api/query",{
        queryName:decodeURI(decodeURI(getUrlParam("queryName")))
      },
      function(data,xhrFields){
        xhrFields:{withCredentials:true};
        var j=0;
        for(var i in data[0]){

          if(i!="message"){

						$("input").eq(j).attr({ value: data[0][i] });
						console.log(data[0][i]);
						
          }
          else{

						$("#userTextarea").text(data[0][i]);
						
          }
					j++;
					
				}
				
      });
		});
				
	}
	else{//从底部菜单进入个人信息的情况

    $(function(){/*载入时获得人员的数据*/console.log(getUrlParam("queryNumber"))
      $.get("http://system.chiukiki.cn/api/queryNumber",{
            queryNumber:getUrlParam("queryNumber")
            },
            function(data,xhrFields){
							xhrFields:{withCredentials:true};
                $("#callback").hide();
                var j=0;
                for(var i in data[0]){
                  if(i!="message"){
                    $("input").eq(j).attr({ value: data[0][i] });console.log(data[0][i]);
                  }
                  else{
                    $("#userTextarea").text(data[0][i]);
                  }
                  j++;
                }
            });
    });
	}
	
})
$(function(){//禁用修改
	$("input").prop("readonly",true);
	$("textarea").prop("readonly",true);
});
$(function(){//点击修改,完成按钮根据值的不同来触发事件
	$("#spareButton").click(function(){
		if($("#alterText").text()=="修改"){/*返回之后再请求后端,获得个人信息*/
        
			$("#alterImg").attr("src","img/right.png");
			$("#alterText").text("保存");
			$("input").prop("readonly",false);
			$("textarea").prop("readonly",false);
			$("textarea").css("border","1px solid rgb(48, 150, 7)");
			$("#userStudentNum").prop("readonly",true);
			$("#containerLeft").css("height","22vw");
			$("#containerRight").css("height","60vw");
			$(".fromPart").css({"margin-top":"6vw","margin-bottom":"0"});
			$("input").css({"border":"1px solid rgb(48, 150, 7)"});
			var placeholders=new Array("姓名","学院","部门","职位","生日格式为12.18","电话为12位手机号码","QQ","邮箱","学号","说点什么吧");
			for(var i=0;i<10;i++){
				if(i!=9){
					$("input").eq(i).attr("placeholder",placeholders[i]);
				}
				else{
					$("textarea").attr("placeholder",placeholders[9]);
				}
			}

			$("#container").css("height","120vw");
			$("#hint").show();
			$("#spareEnter").hide();
			$("#menu").hide();/*修改细节*/
      
		}
		else{//点击完成时个人信息发生的事件
			for(var i=0;i<10;i++){
				if(i!=9){
					$("input").eq(i).attr("placeholder","");
				}
				else{
					$("textarea").attr("placeholder","");
				}
			}
			tests=new Array("/^[\u2E80-\u9FFF]{2,5}$/",
								"/^[\u2E80-\u9FFF]+$/",
								"/^[\u2E80-\u9FFF]+$/",
								"/^[\u2E80-\u9FFF]+$/",
								"/^(?:1[0-2]|[1-9]).(?:[1-9]|([1-2][0-9])?|3[0-1])$/",
								"/^1(3|4|5|7|8|9)[0-9]{9}$/",
								"/^[1-9][0-9]{4,9}$/",
								"/^([a-z0-9_\.-]+)@([0-9a-z\.-]+)\.([a-z]{2,6})$/",
								"/^[0-9]{12}$/"
								);
	    information=new Array("姓名","学院","部门","职位","生日","电话","QQ","邮箱","学号");
      hint=new Array("姓名必须为2位到5位的汉字",
										 "学院必须为两位以上的汉字",
			               "部门必须为两位以上的汉字",
			               "职位必须为两位以上的汉字",
										 "生日必须是12.18这种格式",
										 "电话必须为12位电话号码",
										 "QQ必须正确",
										 "邮箱必须符合要求",
			               "学号必须为12位的数字"
                )
			for(var i=0;i<tests.length;i++){//依次检测数据是否正确

				var j=$(".data").eq(i).attr("placeholder");console.log("j="+j);
				var text=j[j.length-2]+j[j.length-1];console.log(text);
				var reg=eval(tests[i]);console.log(i);
				if(($(".data").eq(i).val()==null||$(".data").eq(i).val()=="")){
					$("#hint").text(text+"不能为空!");
					detections=false;
					break;
				}
				else{
					  console.log(reg);
					  console.log(reg.test($(".data").eq(i).val()));
					  if( reg.test($(".data").eq(i).val()) ){
							$("#hint").text("");
							detections = true;
					  }
					  else{
							$("#hint").text(text+"格式错误!"+hint[i]);
							detections=false;
							break;
						}
				}
	    }
			if(detections==true){//如果数据没问题则发送请求

				$("#alterImg").attr("src","img/alter.png");
			  $("#alterText").text("修改");
				$("input").prop("readonly",true);
	      $("textarea").prop("readonly",true);	
			  $("input").css("border","none");
			  $("#hint").hide();                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
			  $("#spareEnter").show();
				$("#menu").show();/*修改细节*/
				
        $.get("http://system.chiukiki.cn/api/updatePeople",/*点击完成按钮提交信息*/
			      {
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
			      function(data,xhrFields){
							xhrFields:{withCredentials:true};
							$("body").append("<div style='position:absolute; top:90vh; left:40vw; font-size:3vw; color:gray; z-index:999;' id='alert'>"+data.message+"</div>");
              window.setTimeout(function(){$("#alert").remove();},1000);
				    });
			}			
		}
	})
})

$(function(){//检测数据是否符合格式
	
  tests=new Array("/^[\u2E80-\u9FFF]{2,5}$/",
								"/^[\u2E80-\u9FFF]+$/",
								"/^[\u2E80-\u9FFF]+$/",
								"/^[\u2E80-\u9FFF]+$/",
								"/^(?:1[0-2]|[1-9]).(?:[1-9]|([1-2][0-9])?|3[0-1])$/",
								"/^1(3|4|5|7|8|9)[0-9]{9}$/",
								"/^[1-9][0-9]{4,9}$/gim",
								"/^([a-z0-9_\.-]+)@([0-9a-z\.-]+)\.([a-z]{2,6})$/",
								"/^[0-9]{12}$/"
								);
	information=new Array("姓名","学院","部门","职位","生日","电话","QQ","邮箱","学号");
  hint=new Array("姓名必须为2位到5位的汉字",
										 "学院必须为两位以上的汉字",
			               "部门必须为两位以上的汉字",
			               "职位必须为两位以上的汉字",
										 "生日必须是12.18这种格式",
										 "电话必须为12位电话号码",
										 "QQ必须正确",
										 "邮箱必须符合要求",
			               "学号必须为12位的数字"
                )
  $(".data").blur(function(){
		var j=$(this).attr("placeholder");console.log("j="+j);
		var text=j[j.length-2]+j[j.length-1];console.log(text);
	  
	  for(var i=0;i<information.length;i++){
	  	if(information[i]==text){
	  		break;
	  	}
		}console.log(i);
	    var reg=eval(tests[i]);console.log(reg);
	    if($(this).val()==null||$(this).val()==""){
	    	$("#hint").text(text+"不能为空!");
	    }
	    else if(reg.test($(this).val())){
		    $("#hint").text("");
	    }
	    else{
		    $("#hint").text(text+"格式错误"+hint[i]);
		  }
	});
});
$(function(){//底部菜单的逻辑即返回键的逻辑
  $("#addressMenu").click(function(){
    location="../addressBook/addressBook.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
  })
  $("#spareMenu").click(function(){
    location="../spare/spare.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
  })
  $("#presonMessageMenu").click(function(){
    location="../message/message.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
  })
	if(getUrlParam("dataUsed")==1){//是管理员进入管理员页
		$("#administratorMenu").click(function(){
			location="../administrator/administrator.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
		})
	}
	$("#callback").click(function(){//返回到上一页

	history.go(-1);

	})
	$("#spareEnter").click(function(){
		location="../spareScanf/spareScanf.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
	})
})
