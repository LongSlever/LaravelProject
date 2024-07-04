<?php

use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Rota any, onde qualquer requisição pode ser feita
Route::any('/any', function () {
    return 'Permite todo tipo de acesso HTTP, como GET, PUSH DELETE, PUT.';
});

// Rota MATCH, onde posso definir quais requisições são permitidas serem feitas
Route::match(['put', 'delete'],'/match', function () {
    return 'Permite apenas acessos definidos';
});
// Rotas com parâmetros, não são obrigatórios.
Route::get('/produto/{id?}', function ($id = "Não informado") { 
    return 'O id do produto é '. $id;
});
// Redirecionando rotas
Route::get('/sobre', function () {
    return redirect('/empresa');
});

// Outra forma de usar o redirect
Route::redirect('/sobre', '/empresa');

// Uma forma mais simplificada de chamar uma view, sem usar uma requisição GET.
Route::view('/empresa', 'site/empresa');

// Redirecionando uma view com o NAME dela. Nesse caso, mesmo que mudassemos a rota, ainda conseguiriamos
//redirecionar com o NAME dela
Route::view('/news','/news')->name('noticias');

Route::get('/novidades', function() {
    return redirect()->route('noticias');
});

// Criando um grupo de ROTAS. Deixei um prefixo de ADMIN pra não precisar redigitar tudo.
Route::prefix('admin')->group(function () {
    Route::get('dashboard', function() {
        return 'dashbaord';
    });
    Route::get('cliente', function() {
        return 'cliente';
    });
    Route::get('users', function() {
        return 'users';
    });

});

// Criando um grupo de ROTAS. Aqui foi agrupado pelo NAME, onde também fizemos um agrupamento, mas pelo NAME de cada rota.
Route::name('admin.')->group(function () {
    Route::get('admin/dashboard', function() {
        return 'dashbaord';
    })->name('dashboard');
    Route::get('admin/cliente', function() {
        return 'cliente';
    })->name('cliente');
    Route::get('admin/users', function() {
        return 'users';
    })->name('users');

});

// Criando um grupo de ROTAS utilizando o próprio group. Com ele eu consigo criar um array e passar tanto o prefixo quanto o NOME
Route::group([
    'prefix' => 'admin',
    // chave para o name é AS no group
    'as' => 'admin.'
], function () {
    Route::get('dashboard', function() {
        return 'dashbaord';
    })->name('dashboard');
    Route::get('cliente', function() {
        return 'cliente';
    })->name('cliente');
    Route::get('users', function() {
        return 'users';
    })->name('users');

});


/************************TRABALHANDO COM CONTROLLERS ************************************** */

// Criando uma foto e passando a controller a ser chamada. o INDEX é o MÉTODO que vai ser chamado dentro dessa controller
// Route::get('/', [ProdutoController::class, 'index'])->name('produto.index');
// Gerando mais uma rota, mas agora passando um parâmetro e manipulando ele no método SHOW.
// Route::get('/produto/{id?}', [ProdutoController::class, 'show'])->name('produto.show');

// Estamos utilizando o recurso RESOURCE do laravel, onde magicamene todas as rotas e métodos já são carregados
// Devemos usar sempre no plural o primeiro parâmetro.
Route::resource('produtos', ProdutoController::class);
