<?php
namespace app\index\controller;

use think\Controller;

class Order extends Controller
{
	public function info()
	{
		return $this->fetch();
	}
}
