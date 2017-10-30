<?php
namespace app\admin\Controller;
use app\admin\model\User as UserModel;
use think\Controller;
use think\Db;
use think\Request;
use think\Paginate;
class User extends Controller
{
	public function user_list()
	{   
		$list =Db::name('user')->paginate(2);
		$user = new UserModel;
		//获取分页显示
		$page = $list->render();
		$this->assign('list',$list);
		$this->assign('page',$page);
		return $this->fetch();
	}
	public function jinzhi(Request $request)
	{
		$uid = $request->param('uid');
		$user = new UserModel;
		$re = $user->forbiten($uid);
		//dump($re);
		if ($re){

			echo "<script>alert('禁止成功');history.back();</script>";
		}else{
				echo "<script>alert('禁止失败');history.back();</script>";
		}
	}
	public function huifu(Request $request)
	{
		$uid = $request->param('uid');
		$user = new UserModel;
		$re = $user->kai($uid);
		//dump($re);
		if($re){

			echo "<script>alert('解禁成功');history.back()</script>";
		}else{
			echo "<script>alert('恢复失败');history.back()</script>";
		}
	}
}