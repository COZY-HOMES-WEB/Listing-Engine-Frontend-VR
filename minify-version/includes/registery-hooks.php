<?php if(!defined('ABSPATH')){exit;}


function lef_register_admin_menus(){
add_menu_page('Listing Engine Frontend','LEF','manage_options','lef-main-menu','lef_render_main_page','dashicons-building',26);
add_submenu_page('lef-main-menu','Listing Engine Dashboard','Dashboard','manage_options','lef-dashboard','lef_render_dashboard_page');
add_submenu_page('lef-main-menu','Database Management','Database','manage_options','lef-database','lef_render_database_page');
add_submenu_page('lef-main-menu','Manage Reservations','Manage Reserv','manage_options','lef-manage-reservations','lef_render_manage_reservations_page');
remove_submenu_page('lef-main-menu','lef-main-menu');}add_action('admin_menu','lef_register_admin_menus');


function lef_inject_pending_reservation_bubble(){global $menu,$submenu,$wpdb;
$table=$wpdb->prefix.'ls_reservation';

if($wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s',$table))!==$table){return;}$pending_count=(int)$wpdb->get_var("SELECT COUNT(*) FROM `{$table}` WHERE `status` = 'pending'");
if($pending_count<=0){return;}


$bubble=sprintf(' <span class="awaiting-mod count-%1$d"><span class="pending-count">%1$d</span></span>',$pending_count);


if(isset($submenu['lef-main-menu'])){foreach($submenu['lef-main-menu']as&$item){if(isset($item[2])&&$item[2]==='lef-manage-reservations'){$item[0]='Manage Reserv'.$bubble;break;}}unset($item);
}


foreach($menu as&$main_item){if(isset($main_item[2])&&$main_item[2]==='lef-main-menu'){$main_item[0]='LEF'.$bubble;break;}}unset($main_item);
}add_action('admin_menu','lef_inject_pending_reservation_bubble',999);


function lef_render_main_page(){echo'<script>window.location.replace("admin.php?page=lef-dashboard");</script>';}function lef_render_dashboard_page(){$template_path=LEF_PLUGIN_DIR.'backend/template/dashboard.php';if(file_exists($template_path)){require_once $template_path;}else{echo'<div class="wrap"><div class="error"><p>Dashboard template not found.</p></div></div>';}}function lef_render_database_page(){$template_path=LEF_PLUGIN_DIR.'backend/template/database.php';if(file_exists($template_path)){require_once $template_path;}else{echo'<div class="wrap"><div class="error"><p>Database template not found.</p></div></div>';}}function lef_render_manage_reservations_page(){global $wpdb;$action=isset($_GET['action'])?sanitize_text_field($_GET['action']):'';$id=isset($_GET['id'])?intval($_GET['id']):0;if($action==='view'&&$id){
$reserv=$wpdb->get_row($wpdb->prepare("SELECT r.*, p.title as property_title, p.host_id
			 FROM {$wpdb->prefix}ls_reservation r
			 LEFT JOIN {$wpdb->prefix}ls_property p ON r.property_id = p.id
			 WHERE r.id = %d",$id),ARRAY_A);if($reserv){
$t_user=get_userdata($reserv['user_id']);$t_full_name=get_user_meta($reserv['user_id'],'full_name',true);$t_phone=get_user_meta($reserv['user_id'],'mobile_number',true);$reserv['traveller']=array('name'=>!empty($t_full_name)?$t_full_name:($t_user?$t_user->user_login:'Unknown'),'email'=>$t_user?$t_user->user_email:'N/A','phone'=>!empty($t_phone)?$t_phone:'N/A');
$h_user=get_userdata($reserv['host_id']);$h_full_name=get_user_meta($reserv['host_id'],'full_name',true);$h_phone=get_user_meta($reserv['host_id'],'mobile_number',true);$reserv['host']=array('name'=>!empty($h_full_name)?$h_full_name:($h_user?$h_user->user_login:'Unknown'),'email'=>$h_user?$h_user->user_email:'N/A','phone'=>!empty($h_phone)?$h_phone:'N/A');
$reserv['dates']=json_decode($reserv['reserve_date'],true);$reserv['guests']=json_decode($reserv['total_guests'],true);$template_path=LEF_PLUGIN_DIR.'backend/template/manage-reservation-models/view-edit.php';}else{$template_path=LEF_PLUGIN_DIR.'backend/template/manage-reservation-models/manage-reservation.php';}}else{$template_path=LEF_PLUGIN_DIR.'backend/template/manage-reservation-models/manage-reservation.php';}if(file_exists($template_path)){include $template_path;}else{echo'<div class="wrap"><div class="error"><p>Template not found.</p></div></div>';}}