<?php
namespace app\index\model;
use think\Model;
use think\Db;
use think\Session;
class order extends Model
{
	//查询订单信息
	public function  ding($name)
	{
		$name = $name;
		return	Db::field('order.ord_hao,order.create_time,order.o_money,order.statu,order.id,order.ss_name')
			->table(['wbby_order'=>'order','wbby_user'=>'user'])
			->where("user.uid = order.o_id")
			->where("user.mobile = '$name'")
			->select();
	}
	//插入订单数据
	public function se($data)
	{
		return Db::name('order')->insert($data);
	}
	//成功提交订单
	public function xin($name)
	{
		return	Db::field('order.ord_hao,order.create_time,order.o_money,order.statu,order.kuaidi,order.ka')
			->table(['wbby_order'=>'order','wbby_user'=>'user'])
			->where("user.uid = order.o_id")
			->where("user.mobile = '$name'")->order('create_time','desc')
			->select();
	}
	//取消订单
	public function qu($qid)
	{
		return Db::name('order')->where("id = $qid")->delete();
	}
	//查询订单的数量
	public function ge($de)
	{
	   return  Db::name('order')->where("o_id = '$de'")->where("statu = 2")->count();
	}
	//查询未支付订单的数量
	public function ge1($de)
	{
	   return  Db::name('order')->where("o_id = '$de'")->where("statu = 1")->count();
	}
	//查询未评论订单的数量
	public function ge2($de)
	{
	   return  Db::name('order')->where("o_id = '$de'")->where("statu = 3")->count();
	}
}