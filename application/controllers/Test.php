<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2015/5/23
 * Time: 18:40
 */
class TestController extends Yaf_Controller_Abstract
{
    public function testAction($name = "AAAA")
    {
        //1. fetch query
        $get = $this->getRequest()->getQuery("get", "default value");

        //2. fetch model
        $model = new SampleModel();

        //3. assign
        $this->getView()->assign("content", $model->selectSample());
        $this->getView()->assign("name", $get);

        //4. render by Yaf, 如果这里返回FALSE, Yaf将不会调用自动视图引擎Render模板
        return TRUE;
    }
}