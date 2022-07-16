<?php

use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/password.update', function () {
    return view('auth.passwords.reset');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('invoices', 'InvoicesController');
Route::resource('section', 'SectionController');
Route::resource('products', 'ProductController');
Route::resource('InvoiceAttachments', 'InvoiceAttachmentController');
Route::resource('invoiceArchife', 'invoiceArchifeController');

Route::get('/section/{id}/products', 'InvoicesController@getproducts');
 Route::get('/InvoiceDetails/{invoice}/', 'InvoiceDetailsController@edit')->name('InvoiceDetails');
 Route::get('/Invoiceshow/{invoice}/', 'InvoiceDetailsController@edit')->name('InvoiceDetails.show');

// Route::get('/InvoiceDetails/{id}/', 'InvoiceDetailsController@edit')->name('InvoiceDetails');

Route::get('view_file/{invoice_number}/{file_name}', 'InvoiceDetailsController@open_file');
Route::get('download/{invoice_number}/{file_name}', 'InvoiceDetailsController@get_file');
Route::post('destroy/{invoice_Details}','InvoiceDetailsController@destroy')->name('destroy');
Route::post('/status_update/{id}', 'InvoicesController@Status_Update')->name('status_update');
Route::get('Invoice_Paid','InvoicesController@Invoice_Paid');
Route::get('Invoice_UnPaid','InvoicesController@Invoice_UnPaid');
Route::get('Invoice_Partial','InvoicesController@Invoice_Partial');
Route::get('Print_invoice','InvoicesController@Print_invoice')->name('Print_invoice');
Route::get('Invoice_unPaid','InvoicesController@Invoice_unPaid')->name('Invoice_unPaid');
Route::get('export_invoices', 'InvoicesController@export')->name('export_invoices');
Route::get('invoices_report', 'InvoicesReport@index');
Route::post('Search_invoices', 'InvoicesReport@Search_invoices');
Route::get('customers_report', 'CustomerReport@index')->name("customers_report");
Route::post('Search_customers', 'CustomerReport@Search_customers');
Route::get('MarkAsRead_all','InvoicesController@MarkAsRead_all')->name('MarkAsRead_all');
Route::post('/import_excel/import', 'InvoicesController@import');


    Route::group(['middleware' => ['auth']], function () {
    Route::resource('users','UserController');
    Route::resource('roles','RoleController');
});
Route::get('/{page}', 'AdminController@index');
