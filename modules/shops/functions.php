<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @copyright 2009
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 0:51
 */

if( ! defined( 'NV_SYSTEM' ) ) die( 'Stop!!!' );

define( 'NV_IS_MOD_SHOPS', true );

define( 'ACTION_METHOD', $nv_Request->get_string( 'action', 'get,post', '' ) );

define( 'TABLE_SHOPS_NAME', $db_config['prefix'] . '_' . $module_data );

define( 'SHOPS_LINK', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' );

require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';
require_once NV_ROOTDIR . '/modules/' . $module_file . '/site.functions.php';

$array_wishlist_id = array();
$arr_cat_title = array();
$catid = 0;
$parentid = 0;
$set_viewcat = '';
$alias_cat_url = isset( $array_op[0] ) ? $array_op[0] : '';
$alias_group_url = isset( $array_op[1] ) ? $array_op[1] : '';
$groupid = 0;

$array_displays = array(
	'0' => $lang_module['displays_new'],
	'1' => $lang_module['displays_price_asc'],
	'2' => $lang_module['displays_price_desc'] );

// Categories
foreach( $global_array_cat as $row )
{
	$global_array_cat[$row['catid']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $row['alias'];

	if( $alias_cat_url == $row['alias'] )
	{
		$catid = $row['catid'];
		$parentid = $row['parentid'];
	}
}

// Groups
foreach( $global_array_group as $row )
{
	$global_array_group[$row['groupid']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=group/' . $row['alias'];
	if( $alias_group_url == $row['alias'] )
	{
		$groupid = $row['groupid'];
	}
}
unset( $alias_cat_url, $row, $alias_group_url );

$page = 1;
$per_page = $pro_config['per_page'];

if( $op == 'main' )
{
	if( empty( $catid ) )
	{
		if( preg_match( '/^page\-([0-9]+)$/', ( isset( $array_op[0] ) ? $array_op[0] : '' ), $m ) )
		{
			$page = ( int )$m[1];
		}
	}
	else
	{
		if( sizeof( $array_op ) == 2 and ! preg_match( '/^page\-([0-9]+)$/', $array_op[1], $m ) )
		{
			$alias_url = $array_op[1];

			$op = 'detail';
		}
		else
		{
			if( preg_match( '/^page\-([0-9]+)$/', ( isset( $array_op[1] ) ? $array_op[1] : '' ), $m ) )
			{
				$page = ( int )$m[1];
			}

			$op = 'viewcat';
		}
		$parentid = $catid;
		while( $parentid > 0 )
		{
			$array_cat_i = $global_array_cat[$parentid];
			$array_mod_title[] = array(
				'catid' => $parentid,
				'title' => $array_cat_i['title'],
				'link' => $array_cat_i['link'] );
			$parentid = $array_cat_i['parentid'];
		}
		sort( $array_mod_title, SORT_NUMERIC );
	}
}

// Wishlist
if( defined( 'NV_IS_USER' ) and $pro_config['active_wishlist'] )
{
	$listid = $db->query( 'SELECT listid FROM ' . TABLE_SHOPS_NAME . '_wishlist WHERE user_id = ' . $user_info['userid'] . '' )->fetchColumn();
	if( $listid )
	{
		$array_wishlist_id = explode( ',', $listid );
	}
}

/**
 * GetDataIn()
 *
 * @param mixed $result
 * @param mixed $catid
 * @return
 */
function GetDataIn( $result, $catid )
{
	global $global_array_cat, $module_name, $db, $link, $module_info, $global_config;
	$data_content = array();
	$data = array();
	while( list( $id, $addtime, $title, $alias, $hometext, $homeimgfile, $homeimgthumb, $model, $quantity, $product_price, $money_unit, $discount_id, $showprice, $promotional, $newday ) = $result->fetch( 3 ) )
	{
		if( $homeimgthumb == 1 ) //image thumb
		{
			$thumb = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/' . $homeimgfile;
		}
		elseif( $homeimgthumb == 2 ) //image file
		{
			$thumb = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $homeimgfile;
		}
		elseif( $homeimgthumb == 3 ) //image url
		{
			$thumb = $homeimgfile;
		}
		else //no image
		{
			$thumb = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/' . $module_name . '/no-image.jpg';
		}

		$data[] = array(
			'id' => $id,
			'addtime' => $addtime,
			'title' => $title,
			'alias' => $alias,
			'hometext' => $hometext,
			'homeimgfile' => $homeimgfile,
			'homeimgthumb' => $thumb,
			'model' => $model,
			'quantity' => $quantity,
			'product_price' => $product_price,
			'discount_id' => $discount_id,
			'money_unit' => $money_unit,
			'showprice' => $showprice,
			'newday' => $newday,
			'promotional' => $promotional,
			'link_pro' => $link . $global_array_cat[$catid]['alias'] . '/' . $alias . $global_config['rewrite_exturl'],
			'link_order' => $link . 'setcart&amp;id=' . $id );
	} 

	$data_content['id'] = $catid;
	$data_content['title'] = $global_array_cat[$catid]['title'];
	$data_content['image'] = $global_array_cat[$catid]['image'];
	$data_content['data'] = $data;
	$data_content['alias'] = $global_array_cat[$catid]['alias'];

	return $data_content;
}

/**
 * GetDataInGroup()
 *
 * @param mixed $result
 * @param mixed $groupid
 * @return
 */
function GetDataInGroups( $result, $array_g )
{
	global $global_array_group, $module_name, $module_file, $db, $link, $module_info, $global_array_cat, $global_config;

	$data_content = array();
	$data = array();

	while( list( $id, $catid, $addtime, $title, $alias, $hometext, $homeimgfile, $homeimgthumb, $model, $quantity, $quantity, $money_unit, $discount_id, $showprice, $promotional, $newday ) = $result->fetch( 3 ) )
	{
		if( $homeimgthumb == 1 ) //image thumb
		{
			$thumb = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_name . '/' . $homeimgfile;
		}
		elseif( $homeimgthumb == 2 ) //image file
		{
			$thumb = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $homeimgfile;
		}
		elseif( $homeimgthumb == 3 ) //image url
		{
			$thumb = $homeimgfile;
		}
		else //no image
		{
			$thumb = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/' . $module_file . '/no-image.jpg';
		}

		$data[] = array(
			'id' => $id,
			'addtime' => $addtime,
			'title' => $title,
			'alias' => $alias,
			'hometext' => $hometext,
			'homeimgfile' => $homeimgfile,
			'homeimgthumb' => $thumb,
			'model' => $model,
			'quantity' => $quantity,
			'quantity' => $quantity,
			'discount_id' => $discount_id,
			'money_unit' => $money_unit,
			'showprice' => $showprice,
			'newday' => $newday,
			'promotional' => $promotional,
			'link_pro' => $link . $global_array_cat[$catid]['alias'] . '/' . $alias . $global_config['rewrite_exturl'],
			'link_order' => $link . 'setcart&amp;id=' . $id );
	}

	$data_content['id'] = $array_g[0];
	$data_content['title'] = $global_array_group[$array_g[0]]['title'];
	$data_content['data'] = $data;
	$data_content['alias'] = $global_array_group[$array_g[0]]['alias'];

	return $data_content;
}

/**
 * SetSessionProView()
 *
 * @param mixed $id
 * @param mixed $title
 * @param mixed $alias
 * @param mixed $addtime
 * @param mixed $link
 * @param mixed $homeimgthumb
 * @return
 */
function SetSessionProView( $id, $title, $alias, $addtime, $link, $homeimgthumb )
{
	global $module_data;
	if( ! isset( $_SESSION[$module_data . '_proview'] ) ) $_SESSION[$module_data . '_proview'] = array();
	if( ! isset( $_SESSION[$module_data . '_proview'][$id] ) )
	{
		$_SESSION[$module_data . '_proview'][$id] = array(
			'title' => $title,
			'alias' => $alias,
			'addtime' => $addtime,
			'link' => $link,
			'homeimgthumb' => $homeimgthumb );
	}
}

/**
 * getgroup_selecthtml()
 *
 * @param mixed $data_group
 * @param mixed $pid
 * @param mixed $listgroupid
 * @return
 */
function getgroup_selecthtml( $data_group, $pid, $listgroupid )
{
	$contents_temp = '';
	if( ! empty( $data_group ) )
	{
		foreach( $data_group as $groupid_i => $groupinfo_i )
		{
			$in_array = in_array( $groupid_i, $listgroupid );
			if( $groupinfo_i['parentid'] == $pid and $groupinfo_i['in_order'] and $in_array )
			{
				$xtitle_i = '';
				if( $groupinfo_i['lev'] > 0 )
				{
					for( $i = 2; $i <= $groupinfo_i['lev']; $i++ )
					{
						$xtitle_i .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					}
				}
				$contents_temp .= '<option value="' . $groupid_i . '">' . $xtitle_i . $groupinfo_i['title'] . '</option>';
				if( $groupinfo_i['numsubgroup'] > 0 )
				{
					$contents_temp .= getgroup_selecthtml( $data_group, $groupid_i, $listgroupid );
				}
			}
		}
	}
	return $contents_temp;
}

 
function creat_thumbs( $id, $homeimgfile, $module_name, $width = 200, $height = 150, $quality = 90 )
{
	if( $width >= $height ) $rate = $width / $height;
	else  $rate = $height / $width;

	$image = NV_UPLOADS_REAL_DIR . '/' . $module_name . '/' . $homeimgfile;

	if( $homeimgfile != '' and file_exists( $image ) )
	{
		$imgsource = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $homeimgfile;
		$imginfo = nv_is_image( $image );

		$basename = $module_name . $width . 'x' . $height . '-' . $id . '-' . md5_file( $image ) . '.' . $imginfo['ext'];

		if( file_exists( NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $basename ) )
		{
			$imgsource = NV_BASE_SITEURL . NV_TEMP_DIR . '/' . $basename;
		}
		else
		{
			require_once NV_ROOTDIR . '/includes/class/image.class.php';

			$_image = new image( $image, NV_MAX_WIDTH, NV_MAX_HEIGHT );

			if( $imginfo['width'] <= $imginfo['height'] )
			{
				$_image->resizeXY( $width, 0 );

			}
			elseif( ( $imginfo['width'] / $imginfo['height'] ) < $rate )
			{
				$_image->resizeXY( $width, 0 );
			}
			elseif( ( $imginfo['width'] / $imginfo['height'] ) >= $rate )
			{
				$_image->resizeXY( 0, $height );
			}

			//$_image->cropFromCenter( $width, $height );

			$_image->save( NV_ROOTDIR . '/' . NV_TEMP_DIR, $basename, $quality );

			if( file_exists( NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $basename ) )
			{
				$imgsource = NV_BASE_SITEURL . NV_TEMP_DIR . '/' . $basename;
			}
		}
	}
	elseif( nv_is_url( $homeimgfile ) )
	{
		$imgsource = $homeimgfile;
	}
	else
	{
		$imgsource = '';
	}
	return $imgsource;
}
 

