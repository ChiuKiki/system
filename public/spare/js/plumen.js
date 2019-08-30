(function($){
	$.fn.extend({
		//插件名称；
		_wx_ison: false,
		wxSelect:function(options){
			var defaults = {
				data: [],
				height:240
			};
			var options = $.extend(defaults,options);

			return this.each(function(){
				//创建元素
				var _this = this,
					w = $(_this).width() || $(_this).find("input").width();
					if(!$(_this).attr("data-bind")){
						init();
						renders(options.data);
					}

				function init(){
					$(_this).attr("data-bind",true);

					$(_this).append("<span class='wxSelect_bottom'></span>")
					$(_this).find(".wxSelect_bottom").css({
						"-webkit-appearance": "none",
            "-moz-appearance": "none",
            appearance: "none",
						width:"8vw",
						height:"5vw",
						background:"rgb(155, 223, 128)",
						display:"inline-block",
						position:"absolute",
						right:"-0.5vw",
						top:"0vw",
						borderRadius:" 0 45% 45% 0 ",
						zIndex:2
					})
					$(_this).css({position:"relative",width:w + "px"}),
					$(_this).append("<span class='wxSelect_label'></span>")
					$(_this).find(".wxSelect_label").css({
						"-webkit-appearance": "none",
            "-moz-appearance": "none",
            appearance: "none",
						display: "inline-block",
						width:"0",
					    height:"0",
					    borderWidth:"1.4vw 2.4vw 0",
					    borderStyle:"solid",
					    borderColor:"white transparent transparent",
						cursor: "pointer",
						position: "absolute",
						right: "2vw",
						top: "40%",
						borderRadius: '0',
						display:"block",
						zIndex:3
					})
					$(_this).append('<div class="dataBox"><ul class="dataList"></ul></div>');
					$(_this).find(".dataBox").css({
						"-webkit-appearance": "none",
            "-moz-appearance": "none",
            appearance: "none",
						width: "100%",
						maxHeight: "options.height" + "px",
						overflowY: "scroll",
						overflowX: "hidden",
						background:" #fff",
						boxShadow: "1px 2px 4px #ccc",
						display: "none",
						position:'absolute',
						zIndex:'999'
					});
					$(function(){ 
						console.log($(_this).find(".wx-input").prop("readonly"));
						if($(_this).find(".wx-input").prop("readonly")=="readonly"||$(_this).find(".wx-input").prop("readonly")==true){
						 
						  $(_this).find(".wxSelect_label,.wxSelect_bottom,.wx-input").on("click",function(event) {
							  $(_this).find(".dataBox").slideToggle(100);
						  });
					  }
				    else{
						  $(_this).find(".wxSelect_label,.wxSelect_bottom").on("click",function(event) {
					      $(_this).find(".dataBox").slideToggle(100);
					    });
						}
					  $(_this).find(".wx-input").on("blur",function(){
						  $(_this).find(".dataBox").slideToggle(100);
					  });
					})
					
					
					function input(e){
						var val = $(_this).find("input").val().trim()
						,dataSelect = []
						,data = options.data;
						console.log(val);
						if(val != ""){
							for(var i in data){
								if(data[i]['name'].indexOf(val) != -1){
									dataSelect.push(data[i]);
								}
							}
							renders(dataSelect);
						}else{
							renders(data);
						}
						$(_this).find(".dataBox").slideDown(50);
					}
					$(_this).find("input").eq(0).on("input",input);
					$(_this).find(".dataList").on("click","li",function(){
						var val = $(this).text();
						var data = $(this).attr("value");
						if(val != ""){
							$(_this).find(".wx-input").val(val).attr("data-value",data);
							$(_this).find(".dataBox").slideUp(50);
						}
					});
					if(!$.fn._wx_ison){
						$(document).on("click",function(event){
							var e = event || window.event;
							e.stopPropagation();	
							var flag = true
							,tag = $(".input-Selector")
							,target = $(e.target);
					        if(target.closest(tag).length == 0 && flag == true){
								$(".input-Selector").find(".dataBox").slideUp(50);
								flag = false;
				       		}
						});
						$.fn._wx_ison = true;
					}
				}
				//渲染列表
				function renders(data){
						$(_this).find(".dataList").html("");
						var html = "";
						for(var i = 0; i<data.length;i++){
							 html += "<li value="+data[i].value+">"+data[i].name+"</li>"
						}
						$(_this).find(".dataList").append(html);
						$(_this).find(".dataList li").css({
							"-webkit-appearance": "none",
							"-moz-appearance": "none",
							appearance: "none",
							padding:"2vw 0 0 2vw",
							border:"0",
							listStyleType:"none",
							fontSize:"3vw"
						});
						$(_this).find(".dataList li").hover(function(){
							$(this).css({
								background:"#d5dee6"
							})
						},function(){
							$(this).css({background:"none"})
						})
				}
			})
		}
	})
})(jQuery);