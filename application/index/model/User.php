<?php
namespace app\index\model;
use think\Model;
use think\Db;
use traits\model\SoftDelete;
class User extends Model
{
	use SoftDelete;//自动触发
	static public function checkMobile($data)
	{
		//检查手机号是否已存在
		if(db('user')->where('mobile',"$data")->find()){
			return true;
		} else {
			return false;
		}

	}

	static function insertData($data)
	{
		$mobile = $data['phone'];
		$result = db('user')->where('mobile',"$mobile")->find();
		if($result)
		{
			return false;
		}else{
			$regip = $_SERVER['REMOTE_ADDR'];
			 if($regip == '::1'){
		 		$regip = '127.0.0.1';
			 }
		 $regip= ip2long($regip);
		 $userInfo = new User;
		 $userInfo->data(
		 	[
			 	'mobile' => "$mobile",
			 	'regip' => "$regip",
			 	
		 	]);
		 	$result =  $userInfo->save();

			return $result;
		}	
			
	}
  //生成订单查询用户id
   public function us($mobile)
   {
      return Db::name('user')->where('mobile',$mobile)->select();
   }
    //个人购物查询用户表的id
   public function gouwu($una)
   {
     $result3 = Db::name('user')->where('mobile',$una)->select();
     return $result3[0]['uid'];
   }
   //查询用户表的id
   public function uid($uname1)
   {
     $result3 = Db::name('user')->where('mobile',$uname1)->select();
     return $result3[0]['uid'];
   }
      //修改个人手机号
   public function ol($name)
   {
      return Db::name('user')->where("mobile = '$name'")->select();
   }
//查询用户的个人信息
   public function info($name)
   {
    return  Db::name('user')->where("mobile = '$name'")->select();
   }
 //查询用户的id
   public function di($name)
   {
     return Db::name('user')->where("mobile = '$name'")->select();
   }
      //收货详情
   public function shou($name)
   {
     // 查询收货详情
      return  Db::field('shouhuo.sname,shouhuo.sphone,shouhuo.semail,shouhuo.infomation,shouhuo.youbian')
        ->table(['wbby_user'=>'user','wbby_shouhuo'=>'shouhuo'])
        ->where("user.uid = shouhuo.yyid")
        ->where("sta = 0")
        ->where("user.mobile = '$name'")
        ->select();
   }

}