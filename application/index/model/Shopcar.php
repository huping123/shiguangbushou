<?php
namespace app\index\model;
use think\Model;
use think\Db;
use think\Session;
class Shopcar extends Model{

	 //  //插入购物车数据库	
	  public function one($arr)
	  {
	  	return Db::name('shopcar')->insert($arr);
	  }
	 //  //查询个人购物详情
	public function two($gid)
	{
	  	// 查询购物详情
		return	Db::field('shopcar.ptitle,shopcar.money,goods.url,shopcar.nums')
			->table(['wbby_shopcar'=>'shopcar','wbby_goods'=>'goods'])
			->where("shopcar.wid = goods.pid")
			->where("shopcar.spid = $gid")
			->select();
	  }
	 //  //查看购物车订单
	public function che($name)
	{	
	   	return	Db::field('shopcar.ptitle,shopcar.money,goods.url,shopcar.nums,shopcar.pcolor,shopcar.id,shopcar.psize')
		 	->table(['wbby_shopcar'=>'shopcar','wbby_goods'=>'goods','wbby_user'=>'user'])
		 	->where("shopcar.wid = goods.pid")
		 	->where("shopcar.spid = user.uid")
		 	->where("user.mobile = '$name'")
		 	->select();
	   }
	//删除单个商品 
	 public function san($id)
	 {
	  	// var_dump($id);
	 return Db::name('shopcar')->where("id = $id")->delete();

	 }
	  //处理订单信息
	  public function chu($arr)
	  {
	  	$zhi = implode(',',$arr);
	  	return  Db::name('shopcar')->where("id in" . "(" . "$zhi" . ")")->select();
	 
	  }
	  
}