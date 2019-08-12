var isfocus=false;
var originalHeight=document.documentElement.clientHeight || document.body.clientHeight;
window.onresize=function(){
    var  resizeHeight=document.documentElement.clientHeight || document.body.clientHeight;
    //软键盘弹起与隐藏  都会引起窗口的高度发生变化
    if(resizeHeight*1<originalHeight*1&&isfocus==true){ //resizeHeight<originalHeight证明窗口被挤压了
    $('#menu').css('display','none');
    }else{
        $('#menu').css('display','block'); 
    }
} 
$("input").focus(function(){
    isfocus=true;
     
});
$("input").blur(function(){
    isfocus=false;
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
		$("#spareBox").toggle();
		$("#menu").toggle();
		$("#container").css({"border-top":"3px solid rgb(48, 150, 7)","margin-top":"5vh"});
		$(".fromPart").css({"margin-top":"3vh"});
		$("#containerLeft").css({"height":"18vh"});
		$("#containerRight").css({"height":"43vh"});
		$("#callback").toggle();

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
                $("#callback").toggle();
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
});
$(function(){//点击修改,完成按钮根据值的不同来触发事件
	$("#spareButton").click(function(){
		if($("#alterText").text()=="修改"){/*返回之后再请求后端,获得个人信息*/
        
			$("#alterImg").attr("src","img/right.png");
			$("#alterText").text("完成");
			$("input").prop("readonly",false);
			$("input").css("border","1px solid rgb(48, 150, 7)");
			$("#hint").toggle();
			$("#spareEnter").toggle();
			$("#menu").toggle();/*修改细节*/

		}
		else{//点击完成时个人信息发生的事件

			$("#alterImg").attr("src","img/alter.png");
			$("#alterText").text("修改");
			$("input").prop("readonly",true);
			$("input").css("border","none");
			$("#hint").toggle();
			$("#spareEnter").toggle();
			$("#menu").toggle();/*修改细节*/

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
					if(data.message=="修改成功"){
					console.log("修改成功!");
					}
				});
				
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
								"/^([0-9]{12}$/",
								);
  information=new Array("姓名","学院","部门","职位","生日","电话","QQ","邮箱","学号");
  $(".data").blur(function(){
		if($("input").attr("readonly")!="readonly"){
	    var j=$(this).val();
	    var id=$(this).attr("id");
	   	var name=$("label[for='"+id+"']").text();
	  	name=name.replace(/:/,"");
	  	var i=0;
	  	for(;i<9;i++){
	  		if(information[i]==name){
	  			break;
	  		}
  		}
	  	var reg=eval(tests[i]);
	  	if(j==null||j==""){
	  		$("#hint").text(name+"不能为空!");
	  	}
	  	else if(reg.test(j)){
		  	$("#hint").text("");
	    }
	    else{
		  	$("#hint").text(name+"格式错误!");
			}
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
