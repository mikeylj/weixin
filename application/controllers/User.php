<?php
/**
 * Created by IntelliJ IDEA.
 * User: yutajun
 * Date: 15/8/2
 * Time: 下午9:35
 * To change this template use File | Settings | File Templates.
 */
class UserController extends Yaf_Controller_Abstract
{
    public function init()
    {
        $this->_user = new UserModel();
        $this->_util = new utils();
    }
    public function loginAction()
    {
        if($this->getRequest()->isPost())
        {
            $username = $this->getRequest()->getPost('username');
            $pwd      = $this->getRequest()->getPost('password');

            $ret  = $this->_user->loginUser($username, sha1(trim($pwd)));

            if($ret)
            {
                //$_SESSION['username']=$username."ddd"; //这种方式已经不使用了
                Yaf_Session::getInstance()->set("username",$username);

                //$ret如果是正确的，那么返回的是user_uuid
                Yaf_Session::getInstance()->set("user_uuid",$ret);
                $had_order_serial = Yaf_Session::getInstance()->get("order_serial");
                if(!$had_order_serial){
                    $order_serial = date('U').'98'.rand(10000,99999);
                    Yaf_Session::getInstance()->set("order_serial",$order_serial);
                }

                // exit("登录成功！");
                exit($this->_util->ret_json(0,"登陆成功"));
            }
            else
            {
                //$this->getView()->assign("content",'登陆不成功！！');
                exit($this->_util->ret_json(1,"登陆失败"));
            }
        }

        return true;
    }
    public function LogoutAction()
    {
        unset($_SESSION['username']);
        unset($_SESSION['user_uuid']);
        unset($_SESSION['order_serial']);
        header('Location:/index/');
    }

}