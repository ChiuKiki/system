function getUrlParam(names) {//从URL中获取参数
  var reg = new RegExp("(^|&)" + names + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
  var r = window.location.search.substr(1).match(reg); //匹配目标参数
  if (r != null) return unescape(r[2]); return null; //返回参数值
}
$(function(){/*载入时获得人员的数据*/
  $("#addressBookSearchImg").click(function(){
    $.get("http://system.chiukiki.cn/api/queryInfo",{
	  query:$("#addressBook").val()
	},
	function(data,xhrFields){
  
      //console.log(data[0]["name"]);
	  for(var i=0;i<data.length;i++){
      var k=0;
		  for(var j in data[i]){

		    $("tr").eq(i+1).children().eq(k).text(data[i][j]);
		    k++;
		  }
    }
    xhrFields:{withCredentials:true};
	})	
});
});
$(function(){//为表格的每一行添加点击事件
  $("td").click(function(){

    if(!($(this).parent().children().eq(0).text()==""||$(this).parent().children().eq(0).text()==null)){

      alert($(this).parent().children().eq(0).text());
      location="../message/message.html?way=addressBook"+"&queryName="+encodeURI(encodeURI($(this).parent().children().eq(0).text()));
    }
  })
})

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