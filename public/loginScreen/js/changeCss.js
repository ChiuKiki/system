//用于切换电脑端和手机端的css
var browser={//判断是否为手机端;
    versions:function(){
        var u = navigator.userAgent, app = navigator.appVersion;
        
        return {
           
            trident: u.indexOf('Trident') > -1,
            
            presto: u.indexOf('Presto') > -1,
                    
            webKit: u.indexOf('AppleWebKit') > -1,
            
            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,
            
            mobile: !!u.match(/AppleWebKit.*Mobile.*/), 
            
            ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
            
            android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, 
            
            iPhone: u.indexOf('iPhone') > -1 , 
            
            iPad: u.indexOf('iPad') > -1,
            
            webApp: u.indexOf('Safari') == -1
        };
    }(), 
    language:(navigator.browserLanguage || navigator.language).toLowerCase()  
}   


if(browser.versions.mobile || browser.versions.ios || browser.versions.android || browser.versions.iPhone || browser.versions.iPad){    cssChange(); //如果是则改变css; 
}  
 
function cssChange(){
    var link = document.getElementsByTagName('link')[0];
   
    link.setAttribute('href','css/indexMobile.css');
    
}