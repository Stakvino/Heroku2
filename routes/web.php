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

Route::get('/', 'FournisseurController@index')->name('fournisseur.index');

Route::post('/', 'FournisseurController@index')->name('fournisseur.index.post');

Route::patch('/{fourniseur}', 'FournisseurController@update')->name('fournisseur.patch');

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

Route::post('/{fournisseur}/contact/store', 'ContactController@store')
->name('contact.store');

Route::get('/{fournisseur}/contact/{contact}/modifier-contact', 'ContactController@edit')
->name('contact.edit');

Route::patch('/{fournisseur}/contact/{contact}/update', 'ContactController@update')
->name('contact.patch');

Route::delete('/contact/destroy/{contact}', 'ContactController@destroy')
->name('contact.destroy');