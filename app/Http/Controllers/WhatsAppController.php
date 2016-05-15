<?php

namespace App\Http\Controllers;

use App\Contato;
use Illuminate\Http\Request;

use App\Http\Requests;
use Mockery\CountValidator\Exception;

class WhatsAppController extends Controller
{
  public $number;
  public $password;
  public $nickname;
  public $taget;
  public $status;


	public function __construct($number = null)
	{
		$this->password = env('WHATSAPP_PASSOWRD');
		if($number == null)
			$this->number = env('WHATSAPP_NUMBER');
		else
			$this->number = $number;
	}

	public function setNumber($number)
	{
		$this->number = $number;
	}

	public function setNick($nick)
	{
		$this->nickname = $nick;
	}

	public function getCode()
	{
		try{

			$type = 'sms'; # This can be either sms or voice

			$response = \WhatsapiTool::requestCode($this->number, $type);
			return TRUE;

		}catch (\Exception $e){
			return FALSE;
		}
	}

	public function getPassword($code)
	{
		try{
			$response = \WhatsapiTool::registerCode($this->number, $code);
			$this->password = $response->pw;
			return $response->pw;
		}catch (\Exception $e){
			throw new Exception('Erro ao gerar senha '.$e->getMessage());
		}
	}

	/**
	 * taget(envio) ex: 554299998888
	 * @param $message
	 * @param $target
	 * @return bool
	 */
	public function enviar(Request $request)
	{
		try{
			if(is_array($request->target)){
				if(count($request->target) < 10)
					foreach ($request->target as $number)
						$this->_send($number,$request->message);
				else
					throw new Exception('Excedeu limite de target');
			}else{
				if(is_string($request->target) && strlen($request->target) == 12)
					$this->_send($request->target,$request->message);
				else
					throw new Exception('Target incorreto');
			}
			return $this->_return('success','Mensagem enviada');
		}catch (\Exception $e){
			return $this->_return('error','Erro ao enviar menssage pelo whatsapp',$e->getMessage());
		}
	}

	public function multi()
	{

		require_once(base_path('whatsApi/src/whatsprot.class.php'));

		if(!empty($this->nickname))
			$this->nickname = 'App Tob';

		$w = new \WhatsProt($this->number, $this->nickname, true, true);
		$w->connect();
		$w->loginWithPassword($this->password);
		$pessoas = Contato::all()->toArray();
//		$pessoas[] = ['nome'=>'jonas','numero'=>'554299603082'];
//		$pessoas[] = ['nome'=>'diego','numero'=>'554288017598'];
//		$pessoas[] = ['nome'=>'fortes','numero'=>'554299920126'];
//		$pessoas[] = ['nome'=>'guilhermino','numero'=>'554298424923'];
		foreach ($pessoas as $pessoa) {
			$msg = 'Ola '.strtoupper($pessoa['nome']).', esta mensagem é uma demostracao do aplicativo KeepSell em funcionamento';
			$this->sendMessage($pessoa['numero'],$msg,$w);
//			$this->_send($pessoa['numero'],$msg);
			sleep(1);
		}
		$w->pollMessage();
		echo 'fim';
	}

	private function _send($target,$message)
	{
		require_once(base_path('whatsApi/src/whatsprot.class.php'));

		if(!empty($this->nickname))
			$this->nickname = 'App Tob';

		$w = new \WhatsProt($this->number, $this->nickname, true, true);
		$w->connect();
		$w->loginWithPassword($this->password);
		$this->sendMessage($target,$message,$w);
		$w->pollMessage();
	}

	private function sendMessage($target,$message,$w)
	{
		$w->sendMessage($target,$message);
	}

}
