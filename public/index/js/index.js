var winHeight = $(window).height();  //当手机软键盘弹出时将底部菜单,藏在软键盘后面,软键盘关闭不变
$(window).resize(function () {
  var thisHeight = $(this).height();
  if ( winHeight - thisHeight > 140 ) {
      //键盘弹出
      $('#menu').css('position','static');
      $("body").css("overflow-y","scroll");
  } else {
      //键盘收起
      $('#menu').css({'position':'fixed','bottom':'0'});
      $("body").css("overflow-y","hidden");
      
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
    $.ajax({
      url:"http://system.chiukiki.cn/api/operatorLogin",
      data:{
        number: $('#registerName')[0].value,
        password: $('#registerPassword')[0].value
      },
      success:function(data){
        $("#registerHint").text("");
        $("body").append("<div id='alert'>"+data[0].message+"</div>");
        window.setTimeout(function(){$("#alert").remove();},2000);
        if(data[0].identity="administrator"){
          dataUsed=1;
        }
        else{
          dataUsed=0;
        }
        location="addressBook/addressBook.html?queryNumber="+$('#registerName')[0].value+"&dataUsed="+dataUsed;
      },
      error:function(data){
        $("#registerHint").text("用户名和密码错误!");
        $("body").append("<div id='alert'>"+data[0].message+"</div>");
        window.setTimeout(function(){$("#alert").remove();},2000);
      }
    })
  });
});
$(function(){//点击注册跳转到注册页面
  $("#registerMessage").click(function(){
    $("body").not("#menu").animate({"left":"100vw"},function(){
      location="register/register.html";
    });
  })
})
$(function(){//点击开始找回密码框
  $("#findbackPassword").click(function(){
    $("#amendBox").toggle();
    $("#blackBox").toggle();
    $("#amendBox").animate({"top":"50%"},500); 
  })
})
$(function(){//点击保存时保存数据
  $("#reserve").click(function(){
    var detections=true;
    tests=new Array("/^[a-z0-9_-]{3,16}$/","/^1(3|4|5|7|8|9)[0-9]{9}$/","/^[a-z0-9_-]{6,18}$/");
    information=new Array("用户名","电话","密码");
    hint=new Array("用户名必须为学号","电话必须为12位电话号码","密码为6到8位非特殊字符");
    for(var i=0;i<tests.length;i++){//依次检测数据是否正确
      var j=$(".data").eq(i).attr("placeholder");console.log("j="+j);
      var text=j[j.length-2]+j[j.length-1];console.log(text);
      var reg=eval(tests[i]);console.log(i);
      if(($(".data").eq(i).val()==null||$(".data").eq(i).val()=="")){
        $("body").append("<div id='alert'>"+text+"不能为空"+"</div>");
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
    if(detections==true){
      $.ajax({
        url:"http://system.chiukiki.cn/api/forgetPassword",
        data:{
          number:$("#userStudentNum").val(),
				  tel:$("#userTelephone").val(),
				  setPassword:$("#setPassword").val()
        },
        success:function(data){
          $("body").append("<div id='alert'>"+"修改成功"+data.message+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
        },
        error:function(data){
          $("body").append("<div id='alert'>"+"修改失败"+data.message+"</div>");
          window.setTimeout(function(){$("#alert").remove();},2000);
			  }
      })
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