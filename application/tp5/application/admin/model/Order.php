<?php 
namespace app\admin\Model;
use think\Model;
use think\Db;

class Order extends Model
{   
	protected $updateTime = false;
	public function selectdata($status = '%')
	{   

		if($status == '%')
		{   
			
			$data = ['isdel' => 0];
		}else{
			//echo '22';
			$data = ['isdel' => 0,
			'status' => $status];
		}
		return Db::name('order')->where($data)->select();	
	}
	// public function del($id)
	// {
	// 	//return Db::name('order')->delete(['id']);
	//  }
	public function getStatusAttr($value)
	{
		$status = ['1'=>'待付款','2'=>'待发货','3'=>'待收货','4'=>'确认收货','5'=>'申请退货','6'=>'退货受理','7'=>'已退款','8'=>'交易成功','9'=>'物流异常'];
		return $status[$value];
	}
}