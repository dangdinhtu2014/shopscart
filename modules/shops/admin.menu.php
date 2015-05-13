<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 10 Jan 2014 04:47:14 GMT
 */

if( ! defined( 'NV_ADMIN' ) ) die( 'Stop!!!' );

$allow_func = array(
	'main',
	'alias',
	'items',
	'exptime',
	'addtime',
	'setting',
	'content',
	'custom_form',
	'keywords',
	'del_content',
	'detemplate',
	'cat',
	'change_cat',
	'list_cat',
	'del_cat',
	'block',
	'blockcat',
	'del_block_cat',
	'list_block_cat',
	'chang_block_cat',
	'change_block',
	'list_block',
	'prounit',
	'delunit',
	'order',
	'or_del',
	'or_view',
	'money',
	'delmoney',
	'active_pay',
	'payport',
	'changepay',
	'actpay',
	'docpay',
	'group',
	'del_group',
	'list_group',
	'change_group',
	'getcatalog',
	'getgroup',
	'discounts',
	'view',
	'tags',
	'tagsajax',
	'template' );
if( defined( 'NV_IS_SPADMIN' ) )
{
	$allow_func[] = 'setting';
	$allow_func[] = 'fields';
}

$submenu['order'] = $lang_module['order_title'];
$submenu['items'] = $lang_module['content_add_items'];
$submenu['content'] = $lang_module['content_add'];
$submenu['discounts'] = $lang_module['discounts'];
$submenu['cat'] = $lang_module['categories'];
$submenu['group'] = $lang_module['group'];
$submenu['blockcat'] = $lang_module['block'];
$submenu['prounit'] = $lang_module['prounit'];
$submenu['money'] = $lang_module['money'];
$submenu['tags'] = $lang_module['tags'];
$submenu['payport'] = $lang_module['setup_payment'];
$submenu['docpay'] = $lang_module['document_payment'];
$submenu['setting'] = $lang_module['setting'];
// $submenu['template'] = $lang_module['template'];
if( defined( 'NV_IS_SPADMIN' ) )
{
	//$submenu['setting'] = $lang_module['setting'];
	//$submenu['fields'] = 'Custom Fields';
}
