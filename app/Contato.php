<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
	public $fillable = ['nome','numero','telefone','whatsapp','id_usuario'];

}
