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
$route['default_controller'] = 'index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['lupaPassword'] = 'index/lupaPassword';
$route['pertanyaan'] = 'index/pertanyaan';
$route['resetPassword'] = 'index/resetPassword';
$route["logout"] = "index/logout";
$route["profile"] = "c_profile/editProfile";
$route["editProfile"] = "c_profile/editProfile";
$route["gantiPassword"] = "c_profile/gantiPassword";
$route['dashboard'] = 'c_dashboard';
 
//Menu Management
$route['menu'] = 'c_menu';
$route["tambah_menu"] = "c_menu/tambah_menu";
$route['view_menu_edit/(.+)'] = 'c_menu/view_menu_edit/$1';
$route['process_menu_edit'] = 'c_menu/process_menu_edit';
$route['process_menu_delete/(.+)'] = 'c_menu/process_menu_delete/$1';

//Access Menu Management
$route['access_add'] = 'c_menu/process_access_add';
$route['process_access_delete/(.+)'] = 'c_menu/process_access_delete/$1';
$route['view_access_edit/(.+)'] = 'c_menu/view_access_edit/$1';
$route['validation_access_edit'] = 'c_menu/validation_access_edit';

//SubMenu Management
$route['subMenu'] = 'c_menu/view_sub_menu';
$route['validation_sub_add'] = 'c_menu/validation_sub_add';
$route['view_edit_sub/(.+)'] = 'c_menu/view_sub_edit/$1';
$route['validation_sub_edit'] = 'c_menu/validation_sub_edit';
$route['process_delete_sub/(.+)'] = 'c_menu/process_sub_delete/$1';

//User Management
$route["user"] = "c_user";
$route["process_user_check/(.+)"] = "c_user/process_user_check/$1";
$route["validation_user_add"] = "c_user/validation_user_add";
$route["view_user_edit/(.+)"] = "c_user/view_user_edit/$1";
$route["validation_user_edit"] = "c_user/validation_user_edit";
$route["process_user_delete/(.+)"] = "c_user/process_user_delete/$1";
$route["cetakUser/(.+)"] = "c_user/cetakUser/$1";
$route["cardUser/(.+)"] = "c_user/cardUser/$1";
$route["logUser"] = "c_user/view_log_user";
$route["export_user"] = "c_user/export_user";
$route["import_user"] = "c_user/import_user";

//Customer Management
$route['customer'] = 'c_customer';
$route["tambah_customer"] = "c_customer/tambah_customer";
$route['view_customer_edit/(.+)'] = 'c_customer/view_customer_edit/$1';
$route['process_customer_edit'] = 'c_customer/process_customer_edit';
$route['process_customer_delete/(.+)'] = 'c_customer/process_customer_delete/$1';
$route["export_customer"] = "c_customer/export_customer";
$route["import_customer"] = "c_customer/import_customer";

//Material Management
$route['material'] = 'c_material';
$route["tambah_material"] = "c_material/tambah_material";
$route['view_material_edit/(.+)'] = 'c_material/view_material_edit/$1';
$route['process_material_edit'] = 'c_material/process_material_edit';
$route['process_material_delete/(.+)'] = 'c_material/process_material_delete/$1';
$route["export_material"] = "c_material/export_material";
$route["import_material"] = "c_material/import_material";
$route["material_delete/(.+)"] = "c_material/process_material_delete/$1";

//Part Management
$route['part'] = 'c_part';
$route["tambah_part"] = "c_part/tambah_part";
$route['view_part_edit/(.+)'] = 'c_part/view_part_edit/$1';
$route['process_part_edit'] = 'c_part/process_part_edit';
$route['process_part_delete/(.+)'] = 'c_part/process_part_delete/$1';
$route["export_part"] = "c_part/export_part";
$route["import_part"] = "c_part/import_part";

//Model Management
$route['model'] = 'c_model';
$route["tambah_model"] = "c_model/tambah_model";
$route['view_model_edit/(.+)'] = 'c_model/view_model_edit/$1';
$route['process_model_edit'] = 'c_model/process_model_edit';
$route['process_model_delete/(.+)'] = 'c_model/process_model_delete/$1';
$route["export_model"] = "c_model/export_model";
$route["import_model"] = "c_model/import_model";

//Category Management
$route['category'] = 'c_category';
$route["tambah_category"] = "c_category/tambah_category";
$route['view_category_edit/(.+)'] = 'c_category/view_category_edit/$1';
$route['process_category_edit'] = 'c_category/process_category_edit';
$route['process_category_delete/(.+)'] = 'c_category/process_category_delete/$1';
$route["export_category"] = "c_category/export_category";
$route["import_category"] = "c_category/import_category";

//Tool Management
$route['tool'] = 'c_tool';
$route["tambah_tool"] = "c_tool/tambah_tool";
$route['view_tool_edit/(.+)'] = 'c_tool/view_tool_edit/$1';
$route['process_tool_edit'] = 'c_tool/process_tool_edit';
$route['process_tool_delete/(.+)'] = 'c_tool/process_tool_delete/$1';
$route["export_tool"] = "c_tool/export_tool";
$route["import_tool"] = "c_tool/import_tool";

//Hole Management
$route['hole'] = 'c_hole';
$route["tambah_hole"] = "c_hole/tambah_hole";
$route['view_hole_edit/(.+)'] = 'c_hole/view_hole_edit/$1';
$route['process_hole_edit'] = 'c_hole/process_hole_edit';
$route['process_hole_delete/(.+)'] = 'c_hole/process_hole_delete/$1';
$route["export_hole"] = "c_hole/export_hole";
$route["import_hole"] = "c_hole/import_hole";

//Colour Management
$route['colour'] = 'c_colour';
$route["tambah_colour"] = "c_colour/tambah_colour";
$route['view_colour_edit/(.+)'] = 'c_colour/view_colour_edit/$1';
$route['process_colour_edit'] = 'c_colour/process_colour_edit';
$route['process_colour_delete/(.+)'] = 'c_colour/process_colour_delete/$1';
$route["export_colour"] = "c_colour/export_colour";
$route["import_colour"] = "c_colour/import_colour";

//Product Management
$route['product'] = 'c_product';
$route["tambah_product"] = "c_product/tambah_product";
$route["search_model"] = "c_product/search_model";
$route["search_part"] = "c_product/search_part";
$route["search_category"] = "c_product/search_category";
$route["search_tool"] = "c_product/search_tool";
$route["search_hole"] = "c_product/search_hole";
$route["search_colour"] = "c_product/search_colour";
$route['view_product_edit/(.+)'] = 'c_product/view_product_edit/$1';
$route['process_product_edit'] = 'c_product/process_product_edit';
$route["process_product_delete/(.+)"] = "c_product/process_product_delete/$1";

//Purchase Order
$route['purchaseorder'] = 'c_purchaseorder';
$route["tambah_purchaseorder"] = "c_purchaseorder/tambah_purchaseorder";
$route["search_customer"] = "c_purchaseorder/search_customer";
$route["search_product"] = "c_purchaseorder/search_product";
$route['view_purchaseorder_edit/(.+)'] = 'c_purchaseorder/view_purchaseorder_edit/$1';
$route['process_purchaseorder_edit'] = 'c_purchaseorder/process_purchaseorder_edit';
$route["process_purchaseorder_delete/(.+)"] = "c_purchaseorder/process_purchaseorder_delete/$1";

//PO Delivery
$route['podelivery'] = 'c_podelivery';
$route["tambah_podelivery"] = "c_podelivery/tambah_podelivery";
$route["search_purchaseorder"] = "c_podelivery/search_purchaseorder";
$route['view_podelivery_edit/(.+)'] = 'c_podelivery/view_podelivery_edit/$1';
$route['process_podelivery_edit'] = 'c_podelivery/process_podelivery_edit';
$route["process_podelivery_delete/(.+)"] = "c_podelivery/process_podelivery_delete/$1";

//Production Plan Injection
$route['planinjection'] = 'c_planinjection';
$route["tambah_planinjection"] = "c_planinjection/tambah_planinjection";
$route["search_purchaseorder"] = "c_planinjection/search_purchaseorder";
$route['view_planinjection_edit/(.+)'] = 'c_planinjection/view_planinjection_edit/$1';
$route['process_planinjection_edit'] = 'c_planinjection/process_planinjection_edit';
$route["process_planinjection_delete/(.+)"] = "c_planinjection/process_planinjection_delete/$1";

//Production Plan Printing
$route['planprinting'] = 'c_planprinting';
$route["tambah_planprinting"] = "c_planprinting/tambah_planprinting";
$route["search_purchaseorder"] = "c_planprinting/search_purchaseorder";
$route['view_planprinting_edit/(.+)'] = 'c_planprinting/view_planprinting_edit/$1';
$route['process_planprinting_edit'] = 'c_planprinting/process_planprinting_edit';
$route["process_planprinting_delete/(.+)"] = "c_planprinting/process_planprinting_delete/$1";

//Production Plan Spray
$route['planspray'] = 'c_planspray';
$route["tambah_planspray"] = "c_planspray/tambah_planspray";
$route["search_purchaseorder"] = "c_planspray/search_purchaseorder";
$route['view_planspray_edit/(.+)'] = 'c_planspray/view_planspray_edit/$1';
$route['process_planspray_edit'] = 'c_planspray/process_planspray_edit';
$route["process_planspray_delete/(.+)"] = "c_planspray/process_planspray_delete/$1";

//Production Plan Assy
$route['planassy'] = 'c_planassy';
$route["tambah_planassy"] = "c_planassy/tambah_planassy";
$route["search_purchaseorder"] = "c_planassy/search_purchaseorder";
$route['view_planassy_edit/(.+)'] = 'c_planassy/view_planassy_edit/$1';
$route['process_planassy_edit'] = 'c_planassy/process_planassy_edit';
$route["process_planassy_delete/(.+)"] = "c_planassy/process_planassy_delete/$1";

//Production Plan 2nd
$route['plan2nd'] = 'c_plan2nd';
$route["tambah_plan2nd"] = "c_plan2nd/tambah_plan2nd";
$route["search_purchaseorder"] = "c_plan2nd/search_purchaseorder";
$route['view_plan2nd_edit/(.+)'] = 'c_plan2nd/view_plan2nd_edit/$1';
$route['process_plan2nd_edit'] = 'c_plan2nd/process_plan2nd_edit';
$route["process_plan2nd_delete/(.+)"] = "c_plan2nd/process_plan2nd_delete/$1";

//Production Stok IPQC
$route['stockipqc'] = 'c_stockipqc';
$route["tambah_stockipqc"] = "c_stockipqc/tambah_stockipqc";
$route["search_purchaseorder"] = "c_stockipqc/search_purchaseorder";
$route['view_stockipqc_edit/(.+)'] = 'c_stockipqc/view_stockipqc_edit/$1';
$route['process_stockipqc_edit'] = 'c_stockipqc/process_stockipqc_edit';
$route["process_stockipqc_delete/(.+)"] = "c_stockipqc/process_stockipqc_delete/$1";

//Production Stok OQC
$route['stockoqc'] = 'c_stockoqc';
$route["tambah_stockoqc"] = "c_stockoqc/tambah_stockoqc";
$route["search_purchaseorder"] = "c_stockoqc/search_purchaseorder";
$route['view_stockoqc_edit/(.+)'] = 'c_stockoqc/view_stockoqc_edit/$1';
$route['process_stockoqc_edit'] = 'c_stockoqc/process_stockoqc_edit';
$route["process_stockoqc_delete/(.+)"] = "c_stockoqc/process_stockoqc_delete/$1";

//Production Stok Loading Area
$route['stockla'] = 'c_stockla';
$route["tambah_stockla"] = "c_stockla/tambah_stockla";
$route["search_purchaseorder"] = "c_stockla/search_purchaseorder";
$route['view_stockla_edit/(.+)'] = 'c_stockla/view_stockla_edit/$1';
$route['process_stockla_edit'] = 'c_stockla/process_stockla_edit';
$route["process_stockla_delete/(.+)"] = "c_stockla/process_stockla_delete/$1";

//Delivery Plan
$route['delivery'] = 'c_delivery';
$route["tambah_delivery"] = "c_delivery/tambah_delivery";
$route["search_purchaseorder"] = "c_delivery/search_purchaseorder";
$route['view_delivery_edit/(.+)'] = 'c_delivery/view_delivery_edit/$1';
$route['process_delivery_edit'] = 'c_delivery/process_delivery_edit';
$route["process_delivery_delete/(.+)"] = "c_delivery/process_delivery_delete/$1";
