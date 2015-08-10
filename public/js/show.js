/**
 * Created by yaqin on 15-7-20.
 *       骑士团企业秀
 */
var hasTouch = 'ontouchstart' in window; // 检测是否是触碰设备
var rooturl =  getRootPath();
var width = document.documentElement.clientWidth;
var height = document.documentElement.clientHeight;
var score="0";
var pg="0";

/*
 获取项目所在目录
 取到user
 add by dongwg
 */
function getRootPath(){
    var pathName = window.document.location.pathname;
    var pos = pathName.indexOf('/recruit/');
    var localhostPaht = pathName.substring(0, pos+9);
    //alert(localhostPaht);

    return localhostPaht;
}
$(function(){
  var DEFAULT_WIDTH = 640, // 页面的默认宽度
      ua = navigator.userAgent.toLowerCase(), // 根据 user agent 的信息获取浏览器信息
      deviceWidth = window.screen.width, // 设备的宽度
      devicePixelRatio = window.devicePixelRatio || 1, // 物理像素和设备独立像素的比例，默认为1
      targetDensitydpi;
  // Android4.0以下手机不支持viewport的width，需要设置target-densitydpi
  if (ua.indexOf("android") !== -1 && parseFloat(ua.slice(ua.indexOf("android")+8)) < 4) {
      targetDensitydpi = DEFAULT_WIDTH / deviceWidth * devicePixelRatio * 160;
      $('meta[name="viewport"]').attr('content', 'target-densitydpi=' + targetDensitydpi + ', width=device-width, user-scalable=no');
  }
    $(".main-page").on("click",function(){
        var numberPage=$(this).attr("id").split("page")[1];
            pg=parseInt(numberPage)+1;
        $("#page"+pg+"").show().siblings(".main-page").hide();

    });
    $(".editable-image images").on("click",function(){
        var score1=$(this).attr("score");
        var page=$(this).attr("page");
        if(score1 >0 && score1 <= 100){
            score = score*1 + score1*1; ;
        }
        if(pg == 6){
            $("title").html("我的创业潜力值为："+score+"，您也赶紧来试试！"); 
        }
        pg=parseInt(page)+1;
        $("#page"+pg+"").show().siblings(".main-page").hide();
    });
    $("#page1").on("touchstart",function(){
        var numberPage=$(this).attr("id").split("page")[1];
        pg=parseInt(numberPage)+1;
        $("#page"+pg+"").show().siblings(".main-page").hide();
    });
     $("#bg").on("click",function(){
        $("#pay_follow").hide();
        $(".potential").hide();
        $("#bg" ).animate({
            left: 0, 
            top: 0, 
            opacity: "hide"
        }, "slow");
     });
});
function edClick(){
    $(".potent-num").html(score);
    var bh = $(document).height();
    var bw = $(document).width();
    $("#bg").css({
            height:bh,
            width:bw,
            display:"block"
    });                
       var h="-"+354/2+"px";
       var w="-"+300/2+"px";
       $("#fx").css("margin-top","-100");
        $(".potent-bg").css("margin-top",h);
        $(".potent-bg").css("margin-left",w);
    $(".potential").show();
    
//    alert("您的创业潜力值为："+score+"，您也赶紧来试试！");
}
function follow(){
    var bh = $(document).height();
    var bw = $(document).width();
    $("#bg").css({
            height:bh,
            width:bw,
            display:"block"
    });    
    var h="-"+258/2+"px";
    var w="-"+258/2+"px";
    $("#pay_follow").css("margin-top",h);
    $("#pay_follow").css("margin-left",w);
    $("#pay_follow").show();
};
