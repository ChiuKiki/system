 
function getUrlParam(names) {//获取URL中的参数
    var reg = new RegExp("(^|&)" + names + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg); //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}
$(function(){//为选择框输入数据
  $(".week").wxSelect({
    data:[{"name":"单周","value":-1},{"name":"双周","value":0},{"name":"所有周","value":"-2"},{"name":"","value":""}]
  });
});

$(function(){//点击改变颜色
  $("#menu").toggle();
  $("td").attr("spare","1");
  $("td").click(function(){
    if($(this).css("backgroundColor")=="rgb(48, 150, 7)"){
      $(this).css({backgroundColor:"red"});
      $(this).attr("spare","0");console.log($(this).attr("spare"));
    }
    else{
      $(this).css({backgroundColor:"rgb(48, 150, 7)"});
      $(this).attr("spare","1");console.log($(this).attr("spare"));
    }
  })
})
$(function(){//点击按钮保存
  $("#spareScanfSearch").click(function(){console.log($("#week").val()+" "+$("#week").attr("data-value"));
    var data;
    $("#spareScanfHint").text("");
    if( (!($("#week").val()==""||$("#week").val()==null)) ){
      if( /^[0-9]|(1[0-9])$/.test($("#week").val()) ){
         data=$("#week").val();
         $("#spareScanfHint").text("");
      } 
      else if( $("#week").attr("data-value")==0||$("#week").attr("data-value")==-1||$("#week").attr("data-value")==-2 ){
        data=$("#week").attr("data-value");
        $("#spareScanfHint").text("");
      }
      else{
        $("#spareScanfHint").text("请输入纯数字(1-19)");
      }
      var arrs=new Array([$("#1-2-1").attr("spare"),$("#1-2-2").attr("spare"),$("#1-2-3").attr("spare"),$("#1-2-4").attr("spare"),$("#1-2-5").attr("spare")],
                         [$("#3-4-1").attr("spare"),$("#3-4-2").attr("spare"),$("#3-4-3").attr("spare"),$("#3-4-4").attr("spare"),$("#3-4-5").attr("spare")],
                         [$("#5-6-1").attr("spare"),$("#5-6-2").attr("spare"),$("#5-6-3").attr("spare"),$("#5-6-4").attr("spare"),$("#5-6-5").attr("spare")],
                         [$("#7-8-1").attr("spare"),$("#7-8-2").attr("spare"),$("#7-8-3").attr("spare"),$("#7-8-4").attr("spare"),$("#7-8-5").attr("spare")],
                         [$("#9-11-1").attr("spare"),$("#9-11-2").attr("spare"),$("#9-11-3").attr("spare"),$("#9-11-4").attr("spare"),$("#9-11-5").attr("spare")]
      );
      console.log("arrs="+arrs);
      $.get("http://system.chiukiki.cn/api/insertFree",{
            arr:arrs,
            weekNum:data
      },function(data,xhrFields){
        xhrFields:{withCredentials:true};
        if(data.message=="录入成功"){
          if(!confirm("是否继续")){
            location="../addressBook/addressBook.html?queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
            $("#spareScanfHint").text("");
          }
        }
        else{
          $("#spareScanfHint").text("录入失败");
        }
      })
    }
    else{
      $("#spareScanfHint").text("周数不能为空!");
    }
  })
})
