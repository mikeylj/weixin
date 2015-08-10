<?php
/**
 * Created by IntelliJ IDEA.
 * User: yutajun
 * Date: 15/8/3
 * Time: 下午10:01
 * To change this template use File | Settings | File Templates.
 */

class WxsystemuserModel {
    protected $_table = "wx_system_user";
    protected $_index = "id";

    public function __construct()
    {
        $this->_db = Yaf_Registry::get('_db');
    }


    public function selectWxSystemUser($id)
    {
        $params = array(
            "wx_appid",
            "wx_appsecret",
            "wx_access_token",
            "expires_time",
            "is_del"
        );
        $whereis = array(
            "AND"=>array( $this->_index=>$id, "is_del"=>"N")
        );
        $result = $this->_db->select($this->_table, $params ,$whereis );

        return $result==null?false:$result[0];
    }
    public function selectAll()
    {
        $params = array(
            "*"
        );
        $result = $this->_db->select($this->_table, $params );

        return $result==null?false:$result;
    }

    public function insert($info)
    {
        $result = $this->_db->insert($this->_table, $info);
        //$sql = "REPLACE INTO ".$this->_table."(username, email, password, is_del) VALUES('".$info['username']."', '".$info['email']."', '".$info['password']."', b'0');";
        //$result = $this->_db->exec($sql);

        return $result<1?false:true;
    }
    public function update($username, $info)
    {
        $result = $this->_db->update($this->_table, $info, array( $this->_index=>$username ));

        return $result<1?false:true;
    }
    public function del($username)
    {
        $params = array( 'is_del'=>'1' );
        $whereis = array( $this->_index=>$username );
        $result = $this->_db->update($this->_table, $params, $whereis );
        return $result==null?false:true;
    }
}