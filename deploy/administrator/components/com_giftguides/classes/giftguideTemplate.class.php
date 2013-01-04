<?php
defined('_JEXEC') or die();
/**
* 
*/
class giftguideTemplate {
	
	function _folderName($filename) {
		return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($filename, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
	}
	
	function _createInputText($label, $id, $value, $class='', $type='', $title='') {
		$class	= empty($class) ? "" : " class = '{$class}'";
		$type	= empty($type) ? "text" : $type;
		$title	= empty($title) ? "" : " title = '{$title}' placeholder = '{$title}'";
		
		$value	= stripslashes(htmlspecialchars($value, ENT_QUOTES));
		$output		= "";
		$output		.= "<label>{$label}</label>";
		$output		.= "<input type='{$type}' id='{$id}' name='{$id}' value='{$value}'{$title}{$class}/>";
		
		return $output;
	}
	
	function _createTextArea($label, $id, $value, $class = '', $title='') {
		$output		= "";
		$output		.= "<label>{$label}</label><textarea id='{$id}' name='{$id}' title='{$title}' placeholder='{$title}' {$class}>";
		$output			.= stripslashes($value);
		$output		.= "</textarea>";
		
		return $output;
	}
	
	function _productTemplate($product = '', $cid = '') {
	
		//$image			= !empty($product) ? "<a href='#' id='product_edit_img'><img src='{$product->img_large}'/></a>" : "<img src='components/com_giftguides/images/giftguide_placeholder.jpg'/>";
		$image			= !empty($product) ? "<img src='{$product->img_large}'/>" : "<img src='components/com_giftguides/images/giftguide_placeholder.jpg'/>";

		$title			= !empty($product) ? "<label>Title</label><span>{$product->title}</span>" : $this->_createInputText('Title', 'title', '', '', '', JText::_('TOOLTIP_PRODUCT_TITLE'));
		$description	= !empty($product) ? "<label>Description</label><span>".stripslashes($product->description)."</span>" : $this->_createTextArea('Description', 'description', '', '', JText::_('TOOLTIP_PRODUCT_DESCRIPTION'));
		$price			= !empty($product) ? "<label>Price</label><span>{$product->price}</span>" : $this->_createInputText('Price', 'price', '', '', '', JText::_('TOOLTIP_PRODUCT_PRICE'));
		$url			= !empty($product) ? "<label>Buy Link</label><a href='{$product->url}' target='_blank'>{$product->url}</a>" : $this->_createInputText('Buy Link', 'url', '', '', '', JText::_('TOOLTIP_PRODUCT_BUY_LINK'));
		$img_large		= !empty($product) ? "" : "<input type='hidden' id='img_large' name='img_large'/>";
		$img_upload		= !empty($product) ? "" : "<input type='file' id='img_upload_{$cid}' name='img_upload'/>";
		
		$pid			= !empty($product) ? "<input type='hidden' name='id[]' value='{$product->id}'/>" : "";
		$alias			= "<input type='hidden' name='alias' value='{$product->alias}'/>";
		$cid			= !empty($product) ? "<input type='hidden' name='cid' value='{$product->cid}'/>" : "";
		
		$edit			= !empty($product) ? "<a href='#productEdit' id='product_edit' class='controls'>Edit</a>" : "";
		$delete			= !empty($product) ? "<a href='#' id='product_delete' class='controls'>Delete</a>" : "";
	
		$descCollapse	= !empty($product) ? " collapse": "";
		$order			= !empty($product) ? "<input type='hidden' id='product_order' name='product_order' value='{$product->product_order}'/>": "";
		
		$tmpl		= "";
		$tmpl		.= "<div class='gg_product_wrapper'>";
		$tmpl			.= "<div class='gg_product_image'>";
		$tmpl				.= $image;
		$tmpl				.= $img_large;
		$tmpl				.= $img_upload;
		$tmpl			.= "</div>";
		$tmpl			.= "<div class='gg_product_data'>";
		$tmpl				.= "<div class='gg_product'>";
		$tmpl					.= "<div class='title list'>{$title}</div>";
		$tmpl					.= "<div class='price list'>{$price}</div>";
		$tmpl					.= "<div class='description list{$descCollapse}'>{$description}</div>";
		$tmpl					.= "<div class='url list'>{$url}</div>";
		$tmpl				.= "</div>";
		$tmpl			.= "</div>";
		$tmpl			.= $pid;
		$tmpl			.= $alias;
		$tmpl			.= $cid;
		$tmpl			.= $order;
		$tmpl			.= "{$delete}{$edit}";
		$tmpl		.= "</div>";
		
		return $tmpl;
	}

	function _categoryTemplate($category_obj, $productObj) {
		$productEmpty		= empty($productObj)? " gg_empty" : "";
		
		$edit				= "<a href='#' id='category_edit' class='controls'>Edit</a>";
		$delete				= "<a href='#' id='category_delete' class='controls'>Delete</a>";
	
		$tmpl		= "";
		$tmpl		.= "<div class='gg_category' id='category_{$category_obj->id}'>";
		$tmpl			.= "<div class='gg_category_left'>";
		$tmpl			.= "<div class='gg_category_meta'>";
		$tmpl				.= "<fieldset>";
		$tmpl					.= "<legend class='gg_category_collapse'>".JText::_('EDIT_CATEGORY_LEGEND')."</legend>";
		$tmpl					.= "<div style='display: none;'>";
		$tmpl						.= "<ul>";
		$tmpl							.= "<li>{$this->_createInputText(JText::_('EDIT_CATEGORY_LABEL'), 'category_name', $category_obj->category_name, '', '', JText::_('TOOLTIP_CATEGORY_NAME'))}</li>";
		$tmpl							.= "<li>{$this->_createInputText(JText::_('EDIT_CATEGORY_PIXEL'), 'tracking_pixel', $category_obj->tracking_pixel, '', '', JText::_('TOOLTIP_CATEGORY_PIXEL'))}</li>";
		$tmpl							.= "<li><input type='button' id='category_name_edit' value='".JText::_('EDIT_CATEGORY_SAVE')."'/><input type='button' id='category_name_delete' value='".JText::_('EDIT_CATEGORY_DELETE')."'/></li>";
		$tmpl						.= "</ul>";
		$tmpl						.= "<input type='hidden' name='cid' value='{$category_obj->id}'/>";
		$tmpl					.= "</div>";
		$tmpl				.= "</fieldset>";
		$tmpl			.= "</div>";
		$tmpl			.= "<div class='gg_product_add'>";
		$tmpl				.= "<fieldset>";
		$tmpl					.= "<legend>".JText::_('ADD_PRODUCT')."</legend>";
		$tmpl						.= "<form id='productForm' class='productForm'>";
		$tmpl							.= $this->_productTemplate('', $category_obj->id);
		$tmpl							.= "<input type='hidden' name='gid' value='{$category_obj->gid}'/>";
		$tmpl							.= "<input type='hidden' name='cid' value='{$category_obj->id}'/>";
		$tmpl							.= "<input type='hidden' name='id'/>";
		$tmpl							.= "<input type='hidden' name='category_folder' id='category_folder_{$category_obj->id}' value='{$category_obj->id}'/>";
		$tmpl							.= "<input type='hidden' name='task' value='saveProduct'/>";
		$tmpl							.= "<input type='button' name='product_clear' id='product_clear_{$category_obj->id}' value='".JText::_('ADD_PRODUCT_CLEAR')."' class='button_left'/>";
		$tmpl							.= "<input type='button' name='product_submit' id='product_submit_{$category_obj->id}' value='".JTEXT::_('ADD_PRODUCT_SAVE')."' class='button_right'/>";
		$tmpl						.= "</form>";
		$tmpl				.= "</fieldset>";
		$tmpl			.= "</div>";
		$tmpl			.= "</div>";
		$tmpl			.= "<div class='gg_category_right'>";
		$tmpl			.= "<div class='gg_product_view{$productEmpty}'>";
		$tmpl				.= "<fieldset>";
		$tmpl					.= "<legend>".JText::_('ADD_PRODUCT_LIST')."</legend>";
		
		if(!empty($productObj)) {
			$tmpl				.= "<div class='feature_select'>";
			$tmpl					.= "<input type='hidden' name='cid' value='{$category_obj->id}'/>";
			$tmpl					.= "<label>Featured Product</label>";
			$tmpl					.= "<select name='product_featured' id='product_featured'>";
			$tmpl						.= "<option value='null'>Select Featured product</option>";
		
			foreach($productObj as $products) {
				$selected	= $products->id == $category_obj->featured ? " SELECTED" : "";
				$tmpl					.= "<option value='{$products->id}'{$selected}>{$products->title}</option>";
			}
			$tmpl					.= "</select>";
			$tmpl				.= "</div>";
			$tmpl				.= "<form id='product_list'>";
			$tmpl					.= "<ol>";
			foreach($productObj as $value) {
				$tmpl					.= "<li><div class='product_drag'></div>".$this->_productTemplate($value)."</li>";
			}
			$tmpl					.= "</ol>";
			$tmpl				.= "</form>";
			
		} else {
				$tmpl			.= "<p>".JText::_('VIEW_PRODUCT_NONE')."</p>";
		}
		$tmpl				.= "</fieldset>";
		$tmpl			.= "</div>";
		//$tmpl			.= "{$delete}{$edit}";
		$tmpl		.= "</div>";
		$tmpl		.= "</div>";
		
		return $tmpl;
	}


	function responseCategory($category = '', $giftguidesModel = '') {
		$output		= "";
		
		if(!empty($category)) {
			$output	.= "<ul class='tabs'>";
			foreach($category as $value) {
				$idName		= $this->_folderName("{$value->alias}_{$value->id}");
				$output		.= "<li><a href='#{$idName}'>{$value->category_name}</a><input type='hidden' name='cid[]' value='{$value->id}'/></li>";
			}
			$output	.= "</ul>";
			$output	.= "<a href='#' name='productEdit'></a>";
			foreach($category as $value) {
				$idName				= $this->_folderName("{$value->alias}_{$value->id}");
				$product			= $giftguidesModel->getProduct($value->id);
				
				$output		.= "<div id='{$idName}' class='tab_content'>";
				$output			.= $this->_categoryTemplate($value, $product);
				$output		.= "</div>";
			}
		} else {
			$output	.= "<p style='text-align: center; font-style: italic'>".JText::_('CATEGORY_EMPTY')."</p>";
		}
		
		return $output;		
	}

}