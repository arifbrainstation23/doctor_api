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
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['doctor-details/(:any)']='home/doctor_single/$1';
$route['book-appointment/(:any)']='user/book_appointment/$1';
$route['profile']='user/profile';
$route['appointments']='common/appointments';
$route['favourite']='user/favourite';
$route['plans']='home/plans';


/** api routes*/
$route['api/login']='authentication/login';
$route['api/registration']='authentication/signup';
$route['api/forget_password']='authentication/fwd_section';
$route['api/get_slot']='webservice/get_slot';
$route['api/book_appointment']='webservice/book_appointment';
$route['api/cancel_appointment']='webservice/canceled_appointment';
$route['api/add_favourite']='common/add_favourite';
$route['api/remove_favourite']='common/remove_favourite';
$route['api/add_review']='common/add_review';



$route['api/appointments']='common/appointments';
$route['api/update_clinics']='common/update_clinics';
$route['api/delete_clinic']='common/delete_clinic';
$route['api/clinic_status']='common/clinic_status';
$route['api/booking_status']='common/start_booking';
$route['api/become_doctor']='common/become_doctor';





