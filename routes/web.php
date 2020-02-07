<?php

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

use App\Produto;
use App\Categoria;


Route::get('/categorias', function () {
    $cats = Categoria::all();
    if(count($cats) == 0)
        echo "<h4> Voce nã possui nenhuma categoria cadastrada </h4>";
    else
        foreach($cats as $c) {
            echo "<p>" . $c->id . "-" . $c->nome . "</p>";
        }
});

Route::get('/produtos', function () {
    $prods = Produto::all();
    if(count($prods) == 0)
        echo "<h4> Voce nã possui nenhum produto cadastrado </h4>";
    else
        echo "<table>";
        echo "<thead> <tr> <td> Nome </td>  <td> Estoque </td>  <td> Preco </td>  <td> Categoria </td> </tr> </thead>";
        foreach($prods as $p) {
            echo "<tr>";
            echo "<td>" . $p->nome . "</td>";
            echo "<td>" . $p->estoque . "</td>";
            echo "<td>" . $p->preco . "</td>";
            echo "<td>" . $p->categoria->nome . "</td>";
            echo "</tr>"; 
        }
});

Route::get('/categoriasprodutos', function () {
    $cats = Categoria::all();
    if(count($cats) == 0)
        echo "<h4> Voce nã possui nenhuma categoria cadastrada </h4>";
    else
        foreach($cats as $c) {
            echo "<p>" . $c->id . "-" . $c->nome . "</p>";

            $produtos = $c->produtos;

            if (count($produtos) > 0) {
                echo "<ul>";
                foreach ($produtos as $p) {
                    echo "<li>" . $p->nome . "</li>";
                }
                echo "</ul>";
            }
        }
});

Route::get('/categoriasprodutos/json' , function() {
    $cats = Categoria::with('produtos')->get();
    return $cats->toJson();
});

Route::get('/adicionarproduto' , function() {

    $cat = Categoria::find(1);

    $p = new Produto();
    $p->nome = "Meu novo Produto";
    $p->estoque = 10;
    $p->preco = 100;
    $p->categoria()->associate($cat);
    $p->save(); 
    return $p->toJson();
});

Route::get('/removerprodutocategoria' , function() {

    $p = Produto::find(10);
    if(isset($p)) {
        $p->categoria()->dissociate();
        $p->save();
        return $p->toJson();
    };
    
    return '';
});
