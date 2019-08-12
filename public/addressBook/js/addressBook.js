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
$(function(){
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

                    alert($(this).parent().children().eq(0).text());
                    location="../message/message.html?way=addressBook"+"&queryName="+encodeURI(encodeURI($(this).parent().children().eq(0).text()))+"&queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed");
                }
            })
        })
})
$(function(){/*点击时获得人员的数据*/
  $("#addressBookSearchImg").click(function(){
    $.get("http://system.chiukiki.cn/api/queryInfo",{
	  query:$("#addressBook").val()
	},
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

                alert($(this).parent().children().eq(0).text());
                location="../message/message.html?way=addressBook"+"&queryNumber="+getUrlParam("queryNumber")+"&dataUsed="+getUrlParam("dataUsed")+"&queryName="+encodeURI(encodeURI($(this).parent().children().eq(0).text()));
            }
        })
	})	
});
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
})