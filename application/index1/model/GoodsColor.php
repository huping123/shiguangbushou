<?php
namespace app\index\model;
use think\Model;
use think\Db;
use think\Session;

class GoodsColor extends Model
{
	public function goods()
	{
		return $this->belongsTo('Goods', 'gid');
	}
}