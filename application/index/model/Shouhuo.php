<?php
namespace app\index\model;
use think\Model;
use think\Db;
use think\Session;
class Shouhuo extends Model{
	public function xin($name)
	{
		return	Db::field('shouhuo.sname,shouhuo.sphone,shouhuo.semail,shouhuo.youbian,shouhuo.infomation')
			->table(['wbby_shouhuo'=>'shouhuo','wbby_user'=>'user'])
			->where("user.uid = shouhuo.yyid")
			->where("user.mobile = '$name'")
			->where("sta = 0")
			->select();
	}
	//修改收货信息
	public function xiu($arr,$name)
	{
		$un =Db::name('user')->where("mobile = '$name'")->select();
		$uid = $un[0]['uid'];
		// var_dump($uid);die;
		$re = Db::name('shouhuo')->where("yyid = $uid")->where("sta = 0")->select();
		if (empty($re)) {
			$sname = $arr[0];
			$semail= $arr[1];
			$infomation = $arr[2];
			$youbian = $arr[3];
			$sphone = $arr[4];
		 return Db::name('shouhuo')->where("yyid = '$uid'")->where("sta = 0")->insert(['sname'=>$sname,'semail'=>$semail,'infomation'=>$infomation,'youbian'=>$youbian,'sphone'=>$sphone,'dingdanbianhao'=>'null','yyid'=>$uid,'sta'=>0]);
		} else {
			$sname = $arr[0];
			$semail= $arr[1];
			$infomation = $arr[2];
			$youbian = $arr[3];
			$sphone = $arr[4];
			 return Db::name('shouhuo')->where("yyid = '$uid'")->where("sta = 0")->update(['sname'=>$sname,'semail'=>$semail,'infomation'=>$infomation,'youbian'=>$youbian,'dingdanbianhao'=>'null','sphone'=>$sphone]);
		}
		
	}
	//生成收货单
    public function sh($data1)
    {

    	return Db::name('shouhuo')->insert($data1);

    }

}