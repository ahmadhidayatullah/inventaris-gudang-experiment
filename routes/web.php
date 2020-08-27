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
Auth::routes();
// Route::post('/login', [
//     'uses'          => 'Auth\LoginController@login',
//     'middleware'    => 'checkStatus',
// ]);
Route::get('/registrasi',function(){
    return view('auth.register');
})->name('daftar');

Route::post('/registrasi', 'UserController@daftar')->name('daftar.submit');
Route::get('/konfirmasi',function(){
    return view('auth.konfirmasi');
})->name('konfirmasi');

Route::group(['middleware' => ['web','auth']],function(){
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'user'],function(){
        Route::get('/', 'UserController@index')->name('user');
        Route::post('/', 'UserController@store')->name('user.store');
        Route::get('/buat-user', 'UserController@create')->name('user.create');
        Route::get('/belum-aktif', 'UserController@listOfNonaktif')->name('user.listOfNonaktif');
        Route::get('/aktif', 'UserController@listOfAktif')->name('user.listOfAktif');
        Route::get('/{id}/edit', 'UserController@edit')->name('user.edit');
        Route::put('/{id}', 'UserController@update')->name('user.update');
        Route::put('/{id}/status', 'UserController@changeStatus')->name('user.change-status');
        Route::delete('/{id}', 'UserController@destroy')->name('user.destroy');
    });

    Route::group(['prefix' => 'jenis-barang'],function(){
        Route::get('/', 'JenisBarangController@index')->name('jenis-barang');
        Route::post('/', 'JenisBarangController@store')->name('jenis-barang.store');
        Route::get('/buat-program', 'JenisBarangController@create')->name('jenis-barang.create');
        Route::get('/{id}/edit', 'JenisBarangController@edit')->name('jenis-barang.edit');
        Route::put('/{id}', 'JenisBarangController@update')->name('jenis-barang.update');
        Route::delete('/{id}', 'JenisBarangController@destroy')->name('jenis-barang.destroy');
    });

    Route::group(['prefix' => 'barang'],function(){
        Route::get('/', 'BarangController@index')->name('barang');
        Route::post('/', 'BarangController@store')->name('barang.store');
        Route::get('/tambah-barang', 'BarangController@create')->name('barang.create');
        Route::get('/{id}/edit', 'BarangController@edit')->name('barang.edit');
        Route::put('/{id}', 'BarangController@update')->name('barang.update');
        Route::delete('/{id}', 'BarangController@destroy')->name('barang.destroy');
    });

    Route::group(['prefix'=>'transaksi'],function(){
        Route::get('/','TransaksiController@index')->name('transaksi');
        Route::get('/riwayat-tambah-stok','TransaksiController@riwayatTambahStok')->name('transaksi.riwayat-masuk');
        Route::get('/riwayat-keluar-stok','TransaksiController@riwayatStokKeluar')->name('transaksi.riwayat-keluar');
        Route::post('/{id}/tambah-stok','TransaksiController@tambahStok')->name('transaksi.masuk');
        Route::post('/{id}/keluar-stok','TransaksiController@stokKeluar')->name('transaksi.keluar');
        Route::delete('/{id}/tambah-stok','TransaksiController@destroyTambahStok')->name('transaksi.destroy-masuk');
        Route::delete('/{id}/stok-keluar','TransaksiController@destroyStokKeluar')->name('transaksi.destroy-keluar');
    });

    
});
