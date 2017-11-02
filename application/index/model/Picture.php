<?php
namespace app\index\model;
use think\Model;
use think\Db;
use think\Session;
class picture extends Model{
	public function res1($id)
	{
		// 接受商品id  图片
		return Db::name('picture')->where("pcid = $id")->select();
		// var_dump($id);
	}



}