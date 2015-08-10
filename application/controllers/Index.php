<?php
/**
 * @name IndexController
 * @author yulijun
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */

class IndexController extends Yaf_Controller_Abstract {
    /**
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/y/index/index/index/name/yantze 的时候, 你就会发现不同
     */
    private $host_url = "http://test.wx.behuo.com";
    public function index1Action() {//默认Action
        $site = new OptionModel();
        $product = new ProductModel();


        $page = $this->getRequest()->getQuery("page");
        $size = $this->getRequest()->getQuery("size");

        if(!($page&&$size)){
            $page=1;
            $size=12;
        }

        $itemlist = $product->selectPage($page, $size);
        $maxNum   = $product->selectAll_num();
        $siteInfo = $site->selectAll();

        $this->getView()->assign("name",$siteInfo[0]['value']);
        $this->getView()->assign("desc",$siteInfo[1]['value']);
        $this->getView()->assign("items",$itemlist);
        $this->getView()->assign("maxNum",intval($maxNum));
        $this->getView()->assign("curPage",intval($page));
        $this->getView()->assign("curSize",intval($size));

        return true;
    }
    public function beforeauthAction(){

        $callback   = $this->host_url . "/index/afterauth";
        $OAuthPage = wechat_sdk::getInstance()->get_oauth_redirect($callback);
        $this->redirect($OAuthPage);
        exit;

    }
    public function afterauthAction(){

        $code = $this->getRequest()->getQuery("code", 0);
        if(!wechat_sdk::getInstance()->reloadWxAC())
            exit("微信AC更新失败");

        $getAccessToken  = wechat_sdk::getInstance()->get_oauth_access_token($code);
        if(!empty($getAccessToken['errcode']))
        {
            $url   = $this->host_url . "/index/beforeauth";
            $this->redirect($url);
        }
        header("Content-Type: text/html; charset=utf-8");
        $access_token = $getAccessToken['access_token'];
        $openid = $getAccessToken['openid'];
        //验证数据库中该openid是否存在
        $wxuserModel = new WxuserModel;
        $wxuser        = $wxuserModel->selectWxSystemUser($openid);
        if(empty($wxuser)){

            //获取用户信息
            $getUserOAuthInfo = wechat_sdk::getInstance()->get_oauth_userinfo($access_token,$openid);
            $nickname = $getUserOAuthInfo['nickname'];
            $sex = $getUserOAuthInfo['sex'];
            $province  = !empty($getUserInfo['province']) ? $getUserInfo['province'] : '';
            $country   = !empty($getUserInfo['country']) ? $getUserInfo['country'] : '';

            $headimgurl = $getUserOAuthInfo['headimgurl'];
            //获取城市信息
            $getUserInfo = wechat_sdk::getInstance()->getUserInfo($openid);
            $city = !empty($getUserInfo['city']) ? $getUserInfo['city'] : '';

            $time = time();
            $arrData = array(
                'openid'    => $openid,
                'nickname'  => $nickname,
                'sex'   => $sex,
                'province'  => $province,
                'city'      => $city,
                'country'   => $country,
                'headimgurl'   => $headimgurl,
                'access_token'   => '',
                'create_time' =>date("Y-m-d H:i:s",time()),
                'update_time'   => '0000-00-00 00:00:00',
                'is_del'        => 'N'
            );
            $ret = $wxuserModel->insert($arrData);
            if(!empty($ret)){

                Yaf_Session::getInstance()->set("openid", $openid);
                Yaf_Session::getInstance()->set("nickname",$nickname);
            }
            else
                exit("增加用户失败" . $ret);

        }
        else
        {
            Yaf_Session::getInstance()->set("openid",$wxuser['openid']);
            Yaf_Session::getInstance()->set("nickname",$wxuser['nickname']);
        }
        $url   = $this->host_url . "/index/index";
        $this->redirect($url);


    }
    public function indexAction()
    {

        if(!Yaf_Session::getInstance()->get("openid") || Yaf_Session::getInstance()->get("openid") == ""){
            $url = $this->host_url . "/index/beforeauth";
            $this->redirect($url);
        }
        Yaf_Session::getInstance()->del("openid");
        $jsapi = wechat_sdk::getInstance()->getjsapi();

        $appid  = $jsapi['wx_appid'];
        $jsapi_ticket   = $jsapi['jsapi_ticket'];
        $timestamp      = time();
        $this_url            = $this->host_url . "/index/index";
        $nonceStr       = "Wm3WZYTPz0wzccnW";
        $jsapi_sigure  = wechat_sdk::getInstance()->getJsapi_signature($jsapi_ticket, $timestamp, $this_url, $nonceStr);


        $this->getView()->assign("appid", $appid);
        $this->getView()->assign("nonceStr", $nonceStr);
        $this->getView()->assign("timestamp",$timestamp);
        $this->getView()->assign("jsapi_sigure",$jsapi_sigure);

        return true;
    }

    public function photoAction()
    {

    }
    public function testAction()
    {
        echo "test";

        $wxSdk = new wechat_sdk;
        exit;

    }


}