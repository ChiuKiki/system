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
var dataUsed;
function isUserCorrect(){//检测输入用户名的正确性
  var txt=document.getElementById("registerName").value;
  if(txt==null||txt==""){
    document.getElementById("registerHint").innerHTML="用户名不能为空";
  }
  else if(/^[a-z0-9_-]{3,16}$/.test(txt)){
    document.getElementById("registerHint").innerHTML="";    
  }
  else{
    document.getElementById("registerHint").innerHTML="用户名格式错误,用户名必须为非特殊字符不包括汉字";   
  }
}
function isPasswordCorrect(){/*检验密码的有效性*/
  var txt=document.getElementById("registerPassword").value;
  if(txt==null||txt==""){
    document.getElementById("registerHint").innerHTML="密码不能为空";
  }
  else if(/^[a-z0-9_-]{6,18}$/.test(txt)){
    document.getElementById("registerHint").innerHTML="";     
  }
  else{
    document.getElementById("registerHint").innerHTML="密码格式错误,密码为6到18位的非特殊字符不包括汉字"; 
  
  }
}
$(function(){//用于登录时跳转,前端向后端请求得到"登录成功"时,跳转页面
  $("#registerSubmit").on("click",function(){
      $.get("http://system.chiukiki.cn/api/operatorLogin",{
        number: $('#registerName')[0].value,
        password: $('#registerPassword')[0].value
      },function(data,xhrFields){
        xhrFields:{withCredentials:true};
        $("#registerHint").text("");
        alert(data[0].message);
          if(data[0].identity="administrator"){
            dataUsed=1;
          }
          else{
            dataUsed=0;
          }
          if(data[0].message=="登陆成功"){
              $("#registerHint").text("");
              location="addressBook/addressBook.html?queryNumber="+$('#registerName')[0].value+"&dataUsed="+dataUsed;
              name=$('#registerName')[0].value;
 
          }else{
             $("#registerHint").text("用户名和密码错误!");
             alert("登录失败!");
          }
      });
      
  });
});
$(function(){//点击注册跳转到注册页面
  $("#registerMessage").click(function(){
    location="register/register.html";
  })
})
$(function(){//点击开始找回密码框
  $("#findbackPassword").click(function(){
    $("#amendBox").toggle();
    $("#blackBox").toggle();
  })
})
$(function(){//点击保存时保存数据
  $("#reserve").click(function(){
    $.get("http://system.chiukiki.cn/api/forgetPassword",/*点击完成按钮提交信息*/
			{
        number:$("#userStudentNum").val(),
				tel:$("#userTelephone").val(),
				setPassword:$("#setPassword").val()
			},
			  function(data,xhrFields){
          xhrFields:{withCredentials:true};
					if(data.message=="找回密码成功"){
					console.log("找回密码成功!");
					}
				});
  })
});
$(function(){//点击关闭个人信息窗口
  $("#close,#closes").click(function(){
    $("#amendBox").toggle();
    $("#blackBox").toggle();
  })
})