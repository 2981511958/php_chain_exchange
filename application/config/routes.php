<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
|--------------------------------------------------------------------------
| PC页面
|--------------------------------------------------------------------------
*/
//币币交易
$route['exchange'] = 'front/exchange';
$route['exchange/trade'] = 'front/exchange/trade';
$route['exchange/cancel'] = 'front/exchange/cancel';
$route['exchange/select_trade_type'] = 'front/exchange/select_trade_type';
$route['exchange/(:any)'] = 'front/exchange/index/$1';
$route['exchange/(:any)/(:any)'] = 'front/exchange/index/$1/$2';

$route['futures'] = 'front/dm';
$route['futures/trade'] = 'front/dm/trade';
$route['futures/info'] = 'front/dm/info';
$route['futures/cancel'] = 'front/dm/cancel';
$route['futures/close'] = 'front/dm/close';
$route['futures/select_dm_type'] = 'front/dm/select_dm_type';
$route['futures/(:any)'] = 'front/dm/index/$1';
$route['futures/(:any)/(:any)'] = 'front/dm/index/$1/$2';

//用户中心
$route['account'] = 'front/account';
$route['account/asset_futures'] = 'front/account/asset_dm';
$route['account/record_futures'] = 'front/account/record_dm';
$route['account/record_futures/(:any)'] = 'front/account/record_dm/$1';
$route['account/record_futures/(:any)/(:any)'] = 'front/account/record_dm/$1/$2';
$route['account/(:any)'] = 'front/account/$1';
$route['account/(:any)/(:any)'] = 'front/account/$1/$2';
$route['account/(:any)/(:any)/(:any)'] = 'front/account/$1/$2/$3';

$route['otc'] = 'front/otc';
$route['otc/pay'] = 'front/otc/pay';
$route['otc/trade'] = 'front/otc/trade';
$route['otc/cancel'] = 'front/otc/cancel';
$route['otc/select_trade_type'] = 'front/otc/select_trade_type';
$route['otc/(:any)'] = 'front/otc/index/$1';
$route['otc/(:any)/(:any)'] = 'front/otc/index/$1/$2';

//文章
$route['article'] = 'front/article';
$route['article/(:any)'] = 'front/article/$1';
$route['article/(:any)/(:any)'] = 'front/article/$1/$2';

//公共
$route['common/(:any)'] = 'front/common/$1';
//验证码
$route['common/validate/(:num)'] = 'front/common/validate/$1';
$route['common/validate/(:num)/(:num)'] = 'front/common/validate/$1/$2';
//上传
$route['common/upload/(:any)'] = 'front/common/upload/$1';
$route['common/upload/(:any)/(:any)'] = 'front/common/upload/$1/$2';

