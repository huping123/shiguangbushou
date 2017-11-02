<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Validate; //验证码

class Category extends controller
{
	public function product()
	{

		
		return $this->fetch();
	}
	

}