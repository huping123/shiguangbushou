<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;
use app\index\model\Goods;
use think\Request;

class Good extends Controller
{
	protected $goods;
	public function _initialize()
    {
        $this ->user = new User(); 
        $this->goods = new Goods();
    }

}