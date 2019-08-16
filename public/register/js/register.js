
var detection=new Boolean;
detection=true;
var detections=true;//判断是否数据都符合要求
var passwordSame=true;//判断密码是否一致
$(function(){//检测数据格式是否正确
  tests=new Array("/^[0-9]{12}$/",
                  "/^[\u2E80-\u9FFF]{2,5}$/",
								  "/^1(3|4|5|7|8|9)[0-9]{9}$/",
								  "/^[a-z0-9_-]{6,18}$/",
								  "/^[\u2E80-\u9FFF]{2,}$/");
 information=new Array("学号","姓名","电话","密码","部门");
 hint=new Array("学号必须为12位的数字",
                "姓名必须为2位到5位的汉字",
                "电话必须为12位电话号码",
                "密码必须为6位到18位的非特殊字符",
                "部门必须为两位以上的汉字"
                )
  $("input").blur(function(){
    $("#registerHint").text("");
		if($("input").attr("readonly")!="readonly"){
	    var j=$(this).attr("placeholder");
      var text=j[j.length-2]+j[j.length-1];
      if(($(this).val()==null||$(this).val()=="")){
          $("#registerHint").text(text+"不能为空!");
          detection=false;
      }
      else{
        for(var i=0;i<tests.length;i++){
          if(text==information[i]){  
             var reg=eval(tests[i]);console.log(i);
             if( reg.test($(this).val()) ){
               $("#registerHint").text("");
               detection=true;
               break;
             }
             else{
               $("#registerHint").text(text+"格式错误!"+hint[i]);
               detection=false;
               break;
             }
          }
        }
      }
      if(j=="请再次输入密码"){
        if($("#password").val()!=$("#passwordSure").val()){
          passwordSame=false;
          $("#registerHint").text("两次输入密码不一致");
        }
      }
    }
	});
});
$(function(){//先检验数据是否符合格式,符合再发送请求
  $("#registerSubmit").click(function(){//点击提交先检测数据是否正确
    tests=new Array("/^[0-9]{12}$/",
                  "/^[\u2E80-\u9FFF]{2,5}$/",
								  "/^1(3|4|5|7|8|9)[0-9]{9}$/",
                  "/^[a-z0-9_-]{6,18}$/",
                  "/^[a-z0-9_-]{6,18}$/",
								  "/^[\u2E80-\u9FFF]{2,}$/");
    information=new Array("学号","姓名","电话","密码","密码","部门");
    hint=new Array("学号必须为12位的数字",
                "姓名必须为2位到5位的汉字",
                "电话必须为12位电话号码",
                "密码必须为6位到18位的非特殊字符",
                "密码必须为6位到18位的非特殊字符",
                "部门必须为两位以上的汉字"
                )
    for(var i=0;i<tests.length;i++){//依次检测数据是否正确
      var j=$("input").eq(i).attr("placeholder");console.log("j="+j);
      var text=j[j.length-2]+j[j.length-1];console.log(text);
      if(($("input").eq(i).val()==null||$("input").eq(i).val()=="")){console.log($("input").eq(i).val());
          $("#registerHint").text(text+"不能为空!");
          detections=false;
          break;
      }
      else{
          if(text==information[i]){  
             var reg=eval(tests[i]);
             console.log(i);
             if( reg.test($("input").eq(i).val()) ){
               $("#registerHint").text("");
               detections=true;
             }
             else{
               $("#registerHint").text(text+"格式错误!"+hint[i]);
               detections=false;
               break;
             }
          }
      }
    }
    if($("#password").val()!=$("#passwordSure").val()){
      passwordSame=false;
      $("#registerHint").text("两次输入密码不一致");
    }
    if(detections==true&&passwordSame==true&&(!($("#password").val()==null||$("#password").val()==""))){

      $.get("http://system.chiukiki.cn/api/insert",{
        name:$("#name").val(),
		    number:$("#studentNum").val(),
				tel:$("#phone").val(),
				department:$("#department").val(),
				password:$("#password").val(),
                confirmPassword:$("#passwordSure").val()
      },function(data,xhrFields){
        xhrFields:{withCredentials:true};
        location="../index.html";

      })
    }
  });
});
