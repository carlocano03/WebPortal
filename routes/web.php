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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

// Auth::routes('/admin');
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('admin', [
  'as' => 'admin',
  'uses' => 'Auth\LoginController@showLoginForm'
]);
//scripts
Route::get('/fetchposition', 'HomeController@fetchposition');
// member
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/member/dashboard', 'MemberController@index');
Route::get('/member/equity', 'MemberController@equity');
Route::get('/member/loans', 'MemberController@loans');

Route::get('/member/election', 'ElectionController@index');
Route::post('/member/savevote', 'ElectionController@savevote');
Route::post('/member/abstainvote', 'ElectionController@savevote');

Route::get('/member/onboarding', 'MemberController@onboarding');
Route::get('/member/update-password', 'MemberController@updatepw');
Route::post('/member/update-password', 'MemberController@savepw');
Route::post('/member/onboarding', 'MemberController@saveonboarding');

Route::get('/generate/soa', 'MemberController@generatesoa');
Route::get('/generate/equity', 'MemberController@generateequity');
Route::get('/generate/loans', 'MemberController@generateloans');

//admin
Route::get('/admin/dashboard', 'AdminController@index');
Route::get('/admin/count', 'AdminController@getTotal');
Route::get('/admin/member_soa/{id}', 'AdminController@member_soa');
Route::get('/admin/members', 'AdminController@members');
Route::get('/admin/onboarding', 'AdminController@onboarding');
Route::post('/admin/onboarding', 'AdminController@saveonboarding');

Route::get('/admin/loans', 'AdminController@loansmasterlist');
Route::get('/admin/loan-details/{id}', 'AdminController@loandetails');

Route::get('/admin/member_equity/{id}', 'AdminController@equity');
Route::get('/admin/member_loans/{id}', 'AdminController@loans');

Route::get('/admin/update-password', 'AdminController@updatepw');
Route::post('/admin/update-password', 'AdminController@savepw');

Route::get('/admin/manage-admin', 'AdminController@manageadmin');
Route::get('/admin/add', 'AdminController@adminadd');
Route::post('/admin/save', 'AdminController@adminsave');

Route::get('/admin/generate/soa/{id}', 'AdminController@generatesoa');
Route::get('/admin/generate/equity/{id}', 'AdminController@generateequity');
Route::get('/admin/generate/loans/{id}', 'AdminController@generateloans');
Route::get('/admin/generate/loanspertype/{id}', 'AdminController@generateloanspertype');

Route::get('/admin/import_member', 'ImportController@import_member');
Route::post('/admin/import_member', 'ImportController@member_action');

Route::get('/admin/import_equity', 'ImportController@import_equity');
Route::post('/admin/import_equity', 'ImportController@equity_action');

Route::get('/admin/import_loan', 'ImportController@import_loan');
Route::post('/admin/import_loan', 'ImportController@loan_action');

Route::get('/admin/tempass', 'AdminController@tempass');
Route::get('/admin/election', 'ElectionController@admin_election');


