<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2015/8/10
 * Time: 16:33
 */

class WxsystemuserjsapiModel {
    protected $_table = "wx_system_user_jsapi";
    protected $_index = "id";

    public function __construct()
    {
        $this->_db = Yaf_Registry::get('_db');
    }

    public function selectWxSystemUser($wx_system_user_id)
    {
        $params = array(
            "wx_system_user_id",
            "wx_appid",
            "jsapi_ticket",
            "expires_in",
            "is_del",
            'create_at'
        );
        $whereis = array(
            "AND"=>array( 'wx_system_user_id'=>$wx_system_user_id, "is_del"=>"N")
        );
        $result = $this->_db->select($this->_table, $params ,$whereis );

        return $result==null?false:$result[0];
    }
    public function insert($info)
    {
        $result = $this->_db->insert($this->_table, $info);
        //$sql = "REPLACE INTO ".$this->_table."(username, email, password, is_del) VALUES('".$info['username']."', '".$info['email']."', '".$info['password']."', b'0');";
        //$result = $this->_db->exec($sql);

        return $result<1?false:true;
    }
    public function update($id, $info)
    {
        $result = $this->_db->update($this->_table, $info, array( $this->_index=>$id ));

        return $result<1?false:true;
    }
    public function del($id)
    {
        $params = array( 'is_del'=>'1' );
        $whereis = array( $this->_index=>$id );
        $result = $this->_db->update($this->_table, $params, $whereis );
        return $result==null?false:true;
    }


}