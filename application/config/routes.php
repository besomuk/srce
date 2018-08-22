<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// sa leve strane je ono sto se dolazi kao URL, sa desne strane kontroler koji se poziva
$route['view_message/(:any)'] = 'messages/view_message/$1';
$route['admin'] = 'admin/index';
$route['view_message'] = 'messages/view_message';
$route['write_message'] = 'messages/write_message';
$route['messages/(:any)'] = 'messages/view/$1';
$route['messages'] = 'messages';

$route['default_controller'] = 'messages';
$route['(:any)'] = 'pages/view/$1';
