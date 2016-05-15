<?php

namespace App\Http\Controllers;

use App\Message;
use App\Perfil;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
	public function get($id)
	{
		return Message::find($id);
	}

	public function filter(Request $request)
	{
		try{

			$campos = [
				'title',
				'message'
			];

			$message = new Message();
			$query = $message->orderBy('tilte');
			$query->where('id_usuario','=',1);
			foreach ($request->only($campos) as $campo => $value) {
				if($value != null){
						$query->where($campo,'ilike','%'.$value.'%');
				}
			}

			return $this->_return('success','Mensagem filtrado',$query->get()->all());
		}catch (\Exception $e){
	    return $this->_return('error','Erro ao filtrar mensagem',$e->getMessage());
		}
	}

  public function store(Request $request)
  {
    try{

	    $rules = [
		    'title' => 'required',
		    'message' => 'required',
		    'id_usuario' => 'required'
	    ];

	    $validation = \Validator::make($request->all(),$rules);

	    if($validation->fails())
		    return $this->_return('error','Erro ao cadastrar mensagem',$validation->errors());

	    DB::beginTransaction();
	    $message = $request->all();
	    Message::create($message);

	    DB::commit();
	    return $this->_return('success','mensagem cadastrada');
    }catch (\Exception $e){
	    DB::rollback();
	    return $this->_return('error','Erro ao cadastrar mensagem',[$e->getMessage(),$e->getLine()]);
    }
  }


	public function update($id,Request $request)
	{
		try{

			$mensagem = Message::find($id);
			$mensagem->update($request->all());

			return $this->_return('success','mensagem alterada');
		}catch (\Exception $e){
			return $this->_return('error','Erro ao alterar mensagem');
		}
	}

	public function destroy($id)
	{
		try{

			$message = Message::find($id);
			if($message->delete())
				return $this->_return('success','Mensagem removido');

			return $this->_return('warning','Nao foi possivel remover mensagem');
		}catch (\Exception $e){
			return $this->_return('error','Erro ao remove mensagem');
		}
	}
}
