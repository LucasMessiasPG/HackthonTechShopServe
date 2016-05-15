<?php

namespace App\Http\Controllers;

use App\Contato;
use App\Message;
use App\Perfil;
use Facebook\Facebook;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class ContatosController extends Controller
{
	//jonas = 554299603082;
	//deigo = 554288017598;
	//afonsinho = 554298424923;
	public function index()
	{
//		try {

//			$w = new WhatsAppController();
//			$w->getCode();
//			var_dump($w->getPassword(146540));

//			$fb = new Facebook([
//				'app_id' => env('FACEBOOK_APP_ID'), // Replace {app-id} with your app id
//				'app_secret' => env('FACEBOOK_APP_SECRET'),
//				'default_graph_version' => 'v2.6',
//			]);
//
//			$helper = $fb->getRedirectLoginHelper();
////			$response = $fb->get('/search?q='.$peaple.'&type=user&fields=id,name,picture', env('FACEBOOK_TOKEN_MESSAGE'));
//			$response = $fb->post('/me/messages',['recipient'=>['id'=>'1106531089368917'],'message'=>['text'=>'ola']],env('FACEBOOK_TOKEN_MESSAGE'));
//			dd($response);
//		} catch(\Facebook\Exceptions\FacebookSDKException $e) {
//			dd($e->getMessage());
//		}
//
//		$users = json_decode($response->getBody());
//		return view('home',compact('users'));
//		$userNode = $response->getGraphUser();
//		printf('Hello, %s!', $userNode->getName());


			return view('home');

//		require (base_path('whatsApi/src/whatsprot.class.php'));
//		$username = '554299322813';    // Your number with country code, ie: 34123456789
//		$nickname = 'Messias';    // Your nickname, it will appear in push notifications
//		$debug    = true;  // Shows debug log, this is set to false if not specified
//		$log      = true;  // Enables log file, this is set to false if not specified
//
//// Create a instance of WhatsProt class.
//		$w = new \WhatsProt($username, $nickname, $debug, $log);
//		$w->connect();
//		$w->loginWithPassword('RoNNQhISaulaunaUxG5IGneVzOA=');
//		$reponse = $w->sendMessage("554299603082","testando com app automatico");
//		$w->pollMessage();
//	}
//
//	public function massMessage()
//	{
//		require (base_path('whatsApi/src/whatsprot.class.php'));
//		$username = '554299322813';    // Your number with country code, ie: 34123456789
//		$nickname = 'Messias';    // Your nickname, it will appear in push notifications
//		$debug    = true;  // Shows debug log, this is set to false if not specified
//		$log      = true;  // Enables log file, this is set to false if not specified
//
//// Create a instance of WhatsProt class.
//		$w = new \WhatsProt($username, $nickname, $debug, $log);
//		$w->connect();
//		$w->loginWithPassword('RoNNQhISaulaunaUxG5IGneVzOA=');
//		$message = "This is broadcast message";
//		$targets = ["554298424923","554288017598", "554299603082"];
//		foreach ($targets as $target) {
//			echo 1;
//			$w->sendMessage($target,"broadcast teste denovo");
//		}
////		$w->pollMessage();
//	}
//
//	public function receiveMsg()
//	{
//		require (base_path('whatsApi/src/whatsprot.class.php'));
//		$username = '554299322813';    // Your number with country code, ie: 34123456789
//		$nickname = 'Messias';    // Your nickname, it will appear in push notifications
//		$debug    = true;  // Shows debug log, this is set to false if not specified
//		$log      = true;  // Enables log file, this is set to false if not specified
//
//// Create a instance of WhatsProt class.
//		$w = new \WhatsProt($username, $nickname, $debug, $log);
//		$w->connect();
//		$w->loginWithPassword('RoNNQhISaulaunaUxG5IGneVzOA=');
////		$reponse = $w->sendMessage("554298424923","testando com app automatico1");
//		$w->pollMessage();
//		$data = $w->GetMessages();
//		echo '<pre>';
//		if(!empty($data)) print_r($data);
//		sleep(1);
//		exit(0);
//	}
//
//	public function getCodeSms()
//	{
//		$number = '554299322813'; # Number with country code
//		$type = 'sms'; # This can be either sms or voice
//
//		$response = \WhatsapiTool::requestCode($number, $type);
//		dd($response);
//	}
//
//	public function getPw()
//	{
//		$number = '554299322813'; # Number with country code
//		$code = '615617'; # Replace with received code
//
//		$response = \WhatsapiTool::registerCode($number, $code);
//		dd($response);
//	}
//
//	public function sendWhats($number,$message)
//	{
//		if(strlen($message) > 200)
//			throw new Exception('Message excedeu limite de caracteres');
//
//		$whats = new WhatsAppController();
//		$whats->send($message,$number);
	}

	public function get($id)
	{
		return Contato::find($id);
	}

	public function filter(Request $request)
	{
		try {

			$campos = [
				'pesquisa'
			];

			$contatos_nome = Contato::where('nome','ilike','%'.$request->pesquisar.'%')->get();
			$contatos_numero = Contato::where('numero','ilike','%'.$request->pesquisar.'%')->get();
			$perfil_descricao = Perfil::where('descricao','ilike','%'.$request->pesquisar.'%')->get();

			$ids = [];
			foreach ($contatos_nome as $nome) {
				if($nome != null && in_array($nome->id,$ids) == false)
					$ids[] = $nome->id;
			}

			foreach ($contatos_numero as $numero) {
				if($numero != null && in_array($numero->id,$ids) == false)
					$ids[] = $numero->id;
			}

			foreach ($perfil_descricao as $descricao) {
				if($descricao != null && in_array($descricao->id_contato,$ids) == false)
					$ids[] = $descricao->id_contato;
			}

			$retorno = new \stdClass();
			foreach ($ids as $campo => $id) {
				$retorno->contato[] = Contato::find($id);

			}

			foreach ($retorno->contato as $campo => $contato) {
				$retorno->contato[$campo]->perfil = Perfil::where('id_contato','=',$contato->id)->get();
			}

			$retorno->messages = Message::where('id_usuario','=',1)->get();

			return $this->_return('success', 'Contato filtrado', $retorno);
		} catch (\Exception $e) {
			return $this->_return('error', 'Erro ao filtrar contato',[$e->getMessage(),$e->getLine()]);
		}
	}

  public function store(Request $request)
  {
    try{

	    $rules = [
		    'nome' => 'required|max:50',
		    'numero' => 'required|max:15',
		    'telefone' => 'required',
		    'whatsapp' => 'required',
		    'id_usuario' => 'required',
	    ];

	    $validation = \Validator::make($request->all(),$rules);

	    if($validation->fails())
		    return $this->_return('error','Erro ao cadastrar contato',$validation->errors());

	    DB::beginTransaction();
	    $contato = $request->all();
	    $contato['numero'] = preg_replace('/[^0-9]+/','',$contato['numero']);
	    $contato = Contato::create($contato);

	    if($request->perfil != null) {
		    $explode = explode(' ',$request->perfil);

		    if(is_string($explode))
			    $explode[] = [$explode];

		    foreach ($explode as $perfil) {
			    $new_perfil['descricao'] = $perfil;
			    $new_perfil['id_contato'] = $contato->id;
			    Perfil::create($new_perfil);
		    }
	    }

	    DB::commit();
	    return $this->_return('success','Contato cadastrado');
    }catch (\Exception $e){
	    DB::rollback();
	    return $this->_return('error','Erro ao cadastrar contato',[$e->getMessage(),$e->getLine()]);
    }
  }

	public function update($id,Request $request)
	{
		try{

			$contato = Contato::find($id);
			$contato['numero'] = preg_replace('/[^0-9]+/','',$contato['numero']);
			$contato->update($request->all());

			return $this->_return('success','Contato alterado');
		}catch (\Exception $e){
			return $this->_return('error','Erro ao alterar contato');
		}
	}

	public function destroy($id)
	{
		try{

			$contato = Contato::find($id);
			if($contato->delete())
				return $this->_return('success','Contato removido');

			return $this->_return('warning','Nao foi possivel remover contato');
		}catch (\Exception $e){
			return $this->_return('error','Erro ao remove contato');
		}
	}
}
