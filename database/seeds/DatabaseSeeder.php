<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prefix = '55';
        $contatos[] = ['nome'=>'Ezek','numero'=>'4191864888'];
        $contatos[] = ['nome'=>'Mauricio','numero'=>'4199414829'];
        $contatos[] = ['nome'=>'Eduardo','numero'=>'4284066679'];
        $contatos[] = ['nome'=>'Ricardo','numero'=>'4288263668'];
        $contatos[] = ['nome'=>'Marlon','numero'=>'4291015263'];
        $contatos[] = ['nome'=>'Rodrigo','numero'=>'4291058588'];
        $contatos[] = ['nome'=>'Rafael','numero'=>'4291086149'];
        $contatos[] = ['nome'=>'Gabriel','numero'=>'4291125577'];
        $contatos[] = ['nome'=>'Rulian','numero'=>'4291332793'];
        $contatos[] = ['nome'=>'Arth','numero'=>'4291567750'];
        $contatos[] = ['nome'=>'Tarsila','numero'=>'4298007900'];
        $contatos[] = ['nome'=>'Gabriel','numero'=>'4298079206'];
        $contatos[] = ['nome'=>'Anderson','numero'=>'4298086744'];
        $contatos[] = ['nome'=>'Su','numero'=>'4298182710'];
        $contatos[] = ['nome'=>'Mauro','numero'=>'4298207468'];
        $contatos[] = ['nome'=>'Aline','numero'=>'4298479595'];
        $contatos[] = ['nome'=>'Thaise','numero'=>'4298590193'];
        $contatos[] = ['nome'=>'Tonia','numero'=>'4299095519'];
        $contatos[] = ['nome'=>'Lays','numero'=>'4299120650'];
        $contatos[] = ['nome'=>'Fernanda','numero'=>'4299178682'];
        $contatos[] = ['nome'=>'Miguel','numero'=>'4299308968'];
        $contatos[] = ['nome'=>'Alex','numero'=>'4299416541'];
        $contatos[] = ['nome'=>'Lucas','numero'=>'4299422666'];
        $contatos[] = ['nome'=>'Veronica','numero'=>'4299456958'];
        $contatos[] = ['nome'=>'Edinho','numero'=>'4299482641'];
        $contatos[] = ['nome'=>'Renato','numero'=>'4299486552'];
        $contatos[] = ['nome'=>'Lucas','numero'=>'4299493924'];
        $contatos[] = ['nome'=>'Robson','numero'=>'4299613014'];
        $contatos[] = ['nome'=>'Allan','numero'=>'4299724812'];
        $contatos[] = ['nome'=>'Reinaldo','numero'=>'4299933718'];
        $contatos[] = ['nome'=>'Gustavo','numero'=>'4299936651'];
        $contatos[] = ['nome'=>'Marcelo','numero'=>'4299997033'];
        $contatos[] = ['nome'=>'Rodrigo','numero'=>'4388596556'];
        $contatos[] = ['nome'=>'Lucas','numero'=>'4391885005'];
        $contatos[] = ['nome'=>'Lucas','numero'=>'4399132444'];
        $contatos[] = ['nome'=>'Willian','numero'=>'4399683575'];

        // $this->call(UsersTableSeeder::class);
        foreach ($contatos as $contato) {
            \DB::table('contatos')->insert([
              'nome' => $contato['nome'],
              'numero' => $prefix . $contato['numero'],
              'whatsapp' => false,
              'telefone' => false,
              'id_usuario' => 1,
              'created_at' => \Carbon\Carbon::now(),
              'updated_at' => \Carbon\Carbon::now()
            ]);
        }
    }
}
