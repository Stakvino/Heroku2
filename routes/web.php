<?php

use App\Fournisseur;

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
$adresses = Fournisseur::first()->adresses->toArray();
//dd($adresses[0]['id']);

Route::get('/', 'PagesController@index')->name('pages.index');

Route::get('/fournisseurs', 'FournisseurController@index')->name('fournisseur.index');

Route::post('/fournisseurs/{fourniseur}/update', 'FournisseurController@update')
->name('fournisseur.patch');

Route::get('/fournisseurs/get-data', 'FournisseurController@getFournisseurs')
->name('fournisseur.get.fournisseurs');

Route::delete('/fournisseurs/{fourniseur}/destroy', 'FournisseurController@destroy')
->name('fournisseur.destroy');

Route::post('/fournisseurs/{fournisseur}/contact/store', 'ContactController@store')
->name('contact.store');

Route::post('/fournisseurs/contact/{contact}/update',
 'ContactController@update')->name('contact.patch');

 Route::post('/contact/destroy/{contact}', 'ContactController@destroy')
 ->name('contact.destroy');
 

//Ajax Routes
Route::post('/fournisseurs/{fournisseur}/ajax/childrow', 'AjaxController@childrow')
->name('ajax.childrow');

Route::get('/fournisseurs/ajax/{contact}/contactrow', 'AjaxController@contactrow')
->name('ajax.contactrow');

Route::get('/fournisseurs/ajax/{contact}/contactform', 'AjaxController@contactform')
->name('ajax.contactform');





Route::post('/', 'FournisseurController@index')->name('fournisseur.index.post');

Route::get('/{fourniseur}', 'FournisseurController@show')->name('fournisseur.show');

Route::get('/fournisseurs/create', 'FournisseurController@create')
->name('fournisseur.create');

Route::post('/fournisseurs/store', 'FournisseurController@store')
->name('fournisseur.store');

Route::delete('/fournisseurs/destroy/{fournisseur}', 'FournisseurController@destroy')
->name('fournisseur.destroy');

Route::get('/{fourniseur}/ajouter-contact', 'ContactController@create')
->name('contact.create');

Route::get('/{fournisseur}/modifier-fournisseur', 'FournisseurController@edit')
->name('fournisseur.edit');

//Contacts Routes
Route::get('/{fournisseur}/contact/{contact}', 'ContactController@show')
->name('contact.show');

Route::get('/{fournisseur}/ajouter-contact', 'ContactController@create')
->name('contact.create');

Route::get('/{fournisseur}/contact/{contact}/modifier-contact', 'ContactController@edit')
->name('contact.edit');
