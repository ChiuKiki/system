
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
			$.ajax({
				url:"http://system.chiukiki.cn/api/query",
				data:{
          queryName:decodeURI(decodeURI(getUrlParam("queryName")))
				},
				success:function(data){
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
				},
				error:function(e){
					console.log(e);
				}
			})
		});			
	}
	else{//从底部菜单进入个人信息的情况

		$(function(){/*载入时获得人员的数据*/
			console.log(getUrlParam("queryNumber"))
			$.ajax({
				url:"http://system.chiukiki.cn/api/queryNumber",
				data:{
          queryNumber:getUrlParam("queryNumber")
				},
				success:function(data){
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
			  },
			  error:function(e){
				  $("body").append("<div id='alert'>"+"载入失败"+"</div>");
					window.setTimeout(function(){$("#alert").remove();},2000);
					console.log(e);
			  }
		  })
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
			$("#callback").show();
			$("#container").css("height","120vw");
			$("#hint").show();
			$("#spareEnter").hide();
			$("#menu").hide();/*修改细节*/
      
		}
		else{//点击完成时个人信息发生的事件
			$("#callback").hide();
			for(var i=0;i<10;i++){
				if(i!=9){
					$("input").eq(i).attr("placeholder","");
				}
				else{
					$("textarea").attr("placeholder","");
				}
			}
			tests=new Array("/^[\u2E80-\u9FFF]{2,5}$/",
								"/^[\u2E80-\u9FFF]+学院$/",
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
										 "学院必须为两位以上的汉字,且以学院结尾",
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
						$("body").append("<div id='alert'>"+"修改成功"+"</div>");
						window.setTimeout(function(){$("#alert").remove();},2000);
					},
					error:function(e){
            $("body").append("<div id='alert'>"+"修改失败"+"</div>");
						window.setTimeout(function(){$("#alert").remove();},2000);
						console.log(e);
					}
				})
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
$(function(){
	$("#callback").click(function(){//返回到上一页
		$("body").not("#menu").animate({"left":"100vw"},function(){
			if(getUrlParam("way")=="addressBook"){
				location="../addressBook/addressBook.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
			}
			else{
				location="../message/message.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
			}
		});
	})
})
$(function(){
	$("#spareEnter").click(function(){
		$("body").not("#menu").animate({"left":"100vw"},function(){
			location="../spareScanf/spareScanf.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
		}); 
	})
})