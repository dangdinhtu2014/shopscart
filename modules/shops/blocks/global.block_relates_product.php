<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES., JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3/9/2010 23:25
 */

if( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if( ! nv_function_exists( 'creat_thumbs' ) )
{
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
	 
}
if( ! nv_function_exists( 'nv_relates_product' ) )
{
	/**
	 * nv_block_config_relates_blocks()
	 *
	 * @param mixed $module
	 * @param mixed $data_block
	 * @param mixed $lang_block
	 * @return
	 */
	function nv_block_config_relates_blocks( $module, $data_block, $lang_block )
	{
		global $db_config, $site_mods;

		$html = "<tr>";
		$html .= "	<td>" . $lang_block['blockid'] . "</td>";
		$html .= "	<td><select name=\"config_blockid\" class=\"w300 form-control\">\n";
		$sql = "SELECT bid, " . NV_LANG_DATA . "_title," . NV_LANG_DATA . "_alias FROM " . $db_config['prefix'] . "_" . $site_mods[$module]['module_data'] . "_block_cat ORDER BY weight ASC";
		$list = nv_db_cache( $sql, 'catid', $module );
		foreach( $list as $l )
		{
			$sel = ( $data_block['blockid'] == $l['bid'] ) ? ' selected' : '';
			$html .= "<option value=\"" . $l['bid'] . "\" " . $sel . ">" . $l[NV_LANG_DATA . '_title'] . "</option>\n";
		}
		$html .= "	</select></td>\n";
		$html .= "</tr>";

		$html .= "<tr>";
		$html .= "	<td>" . $lang_block['numrow'] . "</td>";
		$html .= "	<td><input type=\"text\" name=\"config_numrow\" size=\"5\" value=\"" . $data_block['numrow'] . "\" class=\"w300 form-control\"/></td>";
		$html .= "</tr>";

		$html .= "<tr>";
		$html .= "	<td>" . $lang_block['cut_num'] . "</td>";
		$html .= "	<td><input type=\"text\" name=\"config_cut_num\" size=\"5\" value=\"" . $data_block['cut_num'] . "\" class=\"w300 form-control\"/></td>";
		$html .= "</tr>";

		return $html;
	}

	/**
	 * nv_block_config_relates_blocks_submit()
	 *
	 * @param mixed $module
	 * @param mixed $lang_block
	 * @return
	 */
	function nv_block_config_relates_blocks_submit( $module, $lang_block )
	{
		global $nv_Request;
		$return = array();
		$return['error'] = array();
		$return['config'] = array();
		$return['config']['blockid'] = $nv_Request->get_int( 'config_blockid', 'post', 0 );
		$return['config']['numrow'] = $nv_Request->get_int( 'config_numrow', 'post', 0 );
		$return['config']['cut_num'] = $nv_Request->get_int( 'config_cut_num', 'post', 0 );
		return $return;
	}

	/**
	 * nv_relates_product()
	 *
	 * @param mixed $block_config
	 * @return
	 */
	function nv_relates_product( $block_config )
	{
		global $site_mods, $global_config, $module_config, $module_name, $module_info, $global_array_cat, $db_config, $my_head, $db, $pro_config;

		$module = $block_config['module'];
		$mod_data = $site_mods[$module]['module_data'];
		$mod_file = $site_mods[$module]['module_file'];
		$array_cat_shops = $global_array_cat;

		if( file_exists( NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/modules/' . $mod_file . '/block.others_product.tpl' ) )
		{
			$block_theme = $global_config['site_theme'];
		}
		else
		{
			$block_theme = 'default';
		}

		if( $module != $module_name )
		{
			$sql = 'SELECT catid, parentid, lev, ' . NV_LANG_DATA . '_title AS title, ' . NV_LANG_DATA . '_alias AS alias, viewcat, numsubcat, subcatid, numlinks, ' . NV_LANG_DATA . '_description AS description, inhome, ' . NV_LANG_DATA . '_keywords AS keywords, groups_view FROM ' . $db_config['prefix'] . '_' . $mod_data . '_catalogs ORDER BY sort ASC';

			$list = nv_db_cache( $sql, 'catid', $module );
			foreach( $list as $row )
			{
				$array_cat_shops[$row['catid']] = array(
					'catid' => $row['catid'],
					'parentid' => $row['parentid'],
					'title' => $row['title'],
					'alias' => $row['alias'],
					'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $row['alias'],
					'viewcat' => $row['viewcat'],
					'numsubcat' => $row['numsubcat'],
					'subcatid' => $row['subcatid'],
					'numlinks' => $row['numlinks'],
					'description' => $row['description'],
					'inhome' => $row['inhome'],
					'keywords' => $row['keywords'],
					'groups_view' => $row['groups_view'],
					'lev' => $row['lev'] );
			}
			unset( $list, $row );

			if( file_exists( NV_ROOTDIR . '/themes/' . $block_theme . '/css/' . $mod_file . '.css' ) )
			{
				$my_head .= '<link rel="StyleSheet" href="' . NV_BASE_SITEURL . 'themes/' . $block_theme . '/css/' . $mod_file . '.css" type="text/css" />';
			}
		}

		$link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=';

		$xtpl = new XTemplate( 'block.others_product.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $mod_file );
		$xtpl->assign( 'WIDTH', $pro_config['blockwidth'] );
		$xtpl->assign( 'BLOCK_TITLE', $block_config['title'] );

		$db->sqlreset()->select( 't1.id, t1.catid, t1.' . NV_LANG_DATA . '_title title, t1.' . NV_LANG_DATA . '_alias alias, t1.addtime, t1.homeimgfile, t1.homeimgthumb, t1.product_price, t1.quantity, t1.money_unit, t1.discount_id, t1.showprice' )->from( $db_config['prefix'] . '_' . $module . '_rows t1' )->join( 'INNER JOIN ' . $db_config['prefix'] . '_' . $module . '_block t2 ON t1.id = t2.id' )->where( 't2.bid= ' . $block_config['blockid'] . ' AND t1.status =1' )->order( 't1.addtime DESC, t2.weight ASC' )->limit( $block_config['numrow'] );

		$list = nv_db_cache( $db->sql(), 'id', $module );
		
		$numslide = ceil( count( $list )/ 6 );
		$lists = array_chunk( $list, 6, true);
		 
		$i = 1;
		$cut_num = $block_config['cut_num'];
		$a = 0;
		foreach( $lists as $key => $value )
		{
 
			foreach( $value as $row )
			{
				if( !empty($row['homeimgfile']) ) //image thumb
				{
					$src_img = creat_thumbs( $row['id'], $row['homeimgfile'], $module , $width = 300, $height = 225, $quality = 90 );
				}		 
				else //no image
				{
					$src_img = NV_BASE_SITEURL . 'themes/' . $global_config['site_theme'] . '/images/shops/no-image.jpg';
				}

				$xtpl->assign( 'LINK', $link . $array_cat_shops[$row['catid']]['alias'] . '/' . $row['alias'] . $global_config['rewrite_exturl'] );
				$xtpl->assign( 'TITLE', nv_clean60( $row['title'], $cut_num ) );
				$xtpl->assign( 'IMG_SRC', $src_img );
				$xtpl->assign( 'TIME', nv_date( 'd-m-Y h:i:s A', $row['addtime'] ) );
				
				if( $pro_config['active_price'] == '1' and $row['showprice'] == '1' )
				{	
					$price = nv_currency_conversion( $row['product_price'], $row['money_unit'], $pro_config['money_unit'], $row['discount_id'] );

					$xtpl->assign( 'PRICE', $price );
					if( $row['discount_id'] and $price['discount_percent'] > 0 )
					{
						$xtpl->parse( 'main.loop.loopitem.price.discounts' );
 					}
					else
					{
						$xtpl->parse( 'main.loop.loopitem.price.no_discounts' );
					}
 
					$xtpl->parse( 'main.loop.loopitem.price' );
				}
 
				$xtpl->parse( 'main.loop.loopitem' );
				++$i;
			}	
			if( $a == 0 )
			{
				$xtpl->assign( 'ACTIVE', 'active');
			}else 
			{
				$xtpl->assign( 'ACTIVE', '');
			}
			$xtpl->assign( 'NUM', $a );
			++$a;
			$xtpl->parse( 'main.loop' );
			$xtpl->parse( 'main.loopnum' );
			
		}
		$xtpl->parse( 'main' );
		return $xtpl->text( 'main' );
	}
}

if( defined( 'NV_SYSTEM' ) )
{
	$content = nv_relates_product( $block_config );
}
