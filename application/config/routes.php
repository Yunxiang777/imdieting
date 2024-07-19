<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/userguide3/general/routing.html
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
// $route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/** page */
//首頁
$route['default_controller'] = 'home/main';
//頁面
$route['home'] = 'home/main';
$route['diet'] = 'diet/main';
//使用者
$route['login'] = 'Members/login';
$route['logout'] = 'Members/logout';
$route['register'] = 'Members/register';
//會員
$route['profile'] = 'Profile/main';
//文章資訊頁
$route['article'] = 'article/main';

/** API */
//使用者登入驗證
$route['v1/members/auth'] = 'Members/auth';
$route['v1/members/signUp'] = 'Members/signUp';
//食物資料
$route['v1/diet/getFoodData'] = 'api/Diet/getFoodData';
$route['v1/diet/getMealData'] = 'api/Diet/getMealData';
//食物紀錄
$route['v1/diet/addMeal'] = 'Diet/addMeal';
$route['v1/diet/deleteMeal'] = 'Diet/deleteMeal';
$route['v1/diet/editMeal'] = 'Diet/editMeal';
//個人資料
$route['v1/profile/update'] = 'Profile/updateProfileData';
//文章資料
$route['v1/article/getArticle'] = 'Article/getWaterfallData';
