<?php
defined('_JEXEC') or die();

class syndiTemplate {
	private $tabsType		= array();

	function __construct() {
		$this->tabsType		= array('Article', 'Facebook', 'Image', 'Poll', 'QA', 'RSS', 'Twitter', 'Video' );
	}

	
	function _createInputText($label, $id, $value, $class='', $type='', $title='') {
		$class	= empty($class) ? "" : " class = '{$class}'";
		$type 	= empty($type) ? "text" : $type;
		$title	= empty($title) ? "" : " title = '{$title}' placeholder = '{$title}'";

		$value  = stripslashes(htmlspecialchars($value, ENT_QUOTES));
        $output         = "";
        $output         .= "<label>{$label}</label>";
        $output         .= "<input type='{$type}' id='{$id}' name='{$id}' value='{$value}'{$title}{$class}/>";
       
        return $output;
	}
	
	function _createTextArea($label, $id, $value, $class = '', $title='') {
            $output         = "";
            $output         .= "<label>{$label}</label><textarea id='{$id}' name='{$id}' title='{$title}' placeholder='{$title}' {$class}>";
            $output			.= stripslashes($value);
            $output         .= "</textarea>";
           
            return $output;
    }
	
	function _createTabsSelect($name) {
		$output		= "<select name='{$name}' id='{$name}'>";
		
		foreach($this->tabsType as $value) {
			$output		.= "<option value='".strtolower($value)."'>{$value}</option>";
		}
		
		$output		.= "</select>";
		
		return $output;
	}
	
	function _createOption($selectOptions, $selectCheck) {
		$output	= "";

		foreach($selectOptions as $key=>$value) {
			$selected  = ($selectCheck == $key)? " selected='selected'": "";
			$output	.= "<option value='{$key}'{$selected}>{$value}</option>";
		}
		
		return $output;
	}
		
	function _createDropDown($arValues, $name) {
		
			$output		= "<select name='{$name}' id='{$name}'>";
			
			foreach($arValues as $value) {
					$selected	= "";
					$label		= $value;
					$value		= strtolower($value);
					$value		= stripslashes(htmlspecialchars($value, ENT_QUOTES));
					$output		.= "<option value='{$value}'>{$label}</option>";
			}
			$output		.= "</select>";
		
		return $output;
	}
	
	function _createTab($tabsObj) {
		$cont = 1;
		$output 	= "";
		
		$output		.= "<div id='tabs'>";
		$output			.= "<ul>";
		foreach($tabsObj as $tab) {
			$output			.= "<li><a href='#tab{$cont}'>{$tab->title}</a></li>";
			$cont++;
		}
		$output			.= "</ul>";
		$output		.= "</div>";
	
		return $output;
	}
	
		function _pollTemplate($pollObj, $productObj) {
                //$productEmpty           = empty($productObj)? " gg_empty" : "";
               
                $edit                           = "<a href='#' id='poll_edit' class='controls'>Edit</a>";
                $delete                        = "<a href='#' id='poll_delete' class='controls'>Delete</a>";
       
                $tmpl           = "";
                $tmpl           .= "<div class='s_poll' id='poll_{$poll_obj->pid}'>";
                $tmpl                   .= "<div class='s_poll_left'>";
                $tmpl                   .= "<div class='s_poll_meta'>";
                $tmpl                           .= "<fieldset>";
                //$tmpl                                   .= "<legend class='s_poll_collapse'>".JText::_('')."</legend>";
                //$tmpl                                   .= "<div style='display: none;'>";
				$tmpl                                   .= "<legend class='s_poll_collapse'>".JText::_('Edit Poll')."</legend>";
				$tmpl                                   .= "<div>";
                $tmpl                                           .= "<ul>";
                $tmpl                                                   .= "<li>{$this->_createInputText(JText::_('Poll Name'), 'name', $poll_obj->name, '', '', JText::_('POLL NAME'))}</li>";
                $tmpl                                                   .= "<li>{$this->_createInputText(JText::_('Poll Alias'), 'alias', $poll_obj->alias, '', '', JText::_('POLL ALIAS'))}</li>";
				$tmpl                                                   .= "<li>{$this->_createInputText(JText::_('Submit Script'), 'submitScript', $poll_obj->submitScript, '', '', JText::_('SUBMIT SCRIPT'))}</li>";
				$tmpl                                                   .= "<li>{$this->_createInputText(JText::_('Result Script'), 'resultScript', $poll_obj->resultScript, '', '', JText::_('RESULT SCRIPT'))}</li>";
				$tmpl                                                   .= "<li><input type='button' id='poll_name_edit' value='".JText::_('Update')."'/><input type='button' id='poll_name_delete' value='".JText::_('Delete')."'/></li>";
                $tmpl                                           .= "</ul>";
                $tmpl                                           .= "<input type='hidden' name='pid' value='{$poll_obj->pid}'/>";
                $tmpl                                   .= "</div>";
                $tmpl                           .= "</fieldset>";
                $tmpl                   .= "</div>";
                $tmpl                   .= "<div class='s_poll_add'>";
                $tmpl                           .= "<fieldset>";
                $tmpl                                   .= "<legend>".JText::_('Add Question')."</legend>";
                /*$tmpl                                           .= "<form id='questionForm' class='questionForm'>";
                $tmpl                                                   .= $this->_questionTemplate('', $poll_obj->pid);
                $tmpl                                                   .= "<input type='hidden' name='sid' value='{$poll_obj->sid}'/>";
                $tmpl                                                   .= "<input type='hidden' name='pid' value='{$poll_obj->pid}'/>";
                $tmpl                                                   .= "<input type='hidden' name='id'/>";
                //$tmpl                                                   .= "<input type='hidden' name='category_folder' id='category_folder_{$category_obj->id}' value='{$category_obj->id}'/>";
                $tmpl                                                   .= "<input type='hidden' name='task' value='saveQuestion'/>";
                $tmpl                                                   .= "<input type='button' name='product_clear' id='product_clear_{$category_obj->id}' value='".JText::_('ADD_PRODUCT_CLEAR')."' class='button_left'/>";
                $tmpl                                                   .= "<input type='button' name='product_submit' id='product_submit_{$category_obj->id}' value='".JTEXT::_('ADD_PRODUCT_SAVE')."' class='button_right'/>";
                $tmpl                                           .= "</form>";*/
                $tmpl                           .= "</fieldset>";
                $tmpl                   .= "</div>";
                $tmpl                   .= "</div>";
                $tmpl                   .= "<div class='gg_category_right'>";
                $tmpl                   .= "<div class='gg_product_view{$productEmpty}'>";
                $tmpl                           .= "<fieldset>";
                $tmpl                                   .= "<legend>".JText::_('ADD_PRODUCT_LIST')."</legend>";
               
                if(!empty($productObj)) {
                        $tmpl                           .= "<div class='feature_select'>";
                        $tmpl                                   .= "<input type='hidden' name='cid' value='{$category_obj->id}'/>";
                        $tmpl                                   .= "<label>Featured Product</label>";
                        $tmpl                                   .= "<select name='product_featured' id='product_featured'>";
                        $tmpl                                           .= "<option value='null'>Select Featured product</option>";
               
                        foreach($productObj as $products) {
                                $selected       = $products->id == $category_obj->featured ? " SELECTED" : "";
                                $tmpl                                   .= "<option value='{$products->id}'{$selected}>{$products->title}</option>";
                        }
                        $tmpl                                   .= "</select>";
                        $tmpl                           .= "</div>";
                       /* $tmpl                           .= "<form id='product_list'>";
                        $tmpl                                   .= "<ol>";
                        foreach($productObj as $value) {
                                $tmpl                                   .= "<li><div class='product_drag'></div>".$this->_productTemplate($value)."</li>";
                        }
                        $tmpl                                   .= "</ol>";
                        $tmpl                           .= "</form>";
                       */
                } else {
                                $tmpl                   .= "<p>".JText::_('VIEW_PRODUCT_NONE')."</p>";
                }
                $tmpl                           .= "</fieldset>";
                $tmpl                   .= "</div>";
                //$tmpl                 .= "{$delete}{$edit}";
                $tmpl           .= "</div>";
                $tmpl           .= "</div>";
               
                return $tmpl;
        }
		
		


}