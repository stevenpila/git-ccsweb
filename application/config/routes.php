<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = 'account';

$route['forum/create_forum'] = 'forum/create_forum';
$route['forum/create_comment'] = 'forum/create_comment';
$route['forum/edit_forum'] = 'forum/edit_forum';
$route['forum/pin_forum'] = 'forum/pin_forum';
$route['forum/unpin_forum'] = 'forum/unpin_forum';
$route['forum/edit_comment'] = 'forum/edit_comment';
$route['forum/delete_forum'] = 'forum/delete_forum';
$route['forum/delete_forum/(:num)'] = 'forum/delete_forum/$1';
$route['forum/delete_comment'] = 'forum/delete_comment';
$route['forum/view_comment'] = 'forum/view_comment';
$route['forum/suggest_comment'] = 'forum/suggest_comment';
$route['forum/unsuggest_comment'] = 'forum/unsuggest_comment';
$route['forum/verify_captcha_and_topic'] = 'forum/verify_captcha_and_topic';
$route['forum/(:any)'] = 'forum/view_forum/$1';

$route['profile/(upload|update_information|update_account|update_email|update_company|get_all_users|update_current_profile_picture|check_if_password_is_correct|remove_current_profile_picture)'] = 'profile/$1';
$route['profile/(:any)'] = 'profile/index/$1';

$route['gallery/(index|create_album|check_if_album_exist|delete_album|delete_albums|rename_album|delete_picture|set_album_cover|add_to_slides|add_many_to_slides|delete_many_photos)'] = 'gallery/$1';
$route['gallery/(:any)'] = 'album/index/$1';

$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */