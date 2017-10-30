<?php
namespace app\admin\Model;
use think\Model;
use think\Db;
use think\Paginator;
class User extends Model
{
	public function forbiten($id)
	{
		return Db::name('user')->update(['isdel' =>1,'uid'=>$id]);
	}
	public function kai($id)
	{
		return Db::name('user')->update(['isdel' =>0,'uid'=>$id]);
	}
}
