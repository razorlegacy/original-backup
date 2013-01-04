<?php
	class TemplateUtils {
		var $menu;
		var $menu_page;
		var $pageid;
		var $view;
		var $section;
		var $category;
		var $type;
		var $errorpage;

		public function __construct($app = false) {
			$this->menu			= $this->get_menu();
			$this->menu_page	= $this->get_menu_page();
			$this->pageid		= $this->get_id();
			$this->view			= $this->get_view();
			$this->section		= $this->get_section();
			$this->category		= $this->get_category();
			$this->type			= $this->get_type();

			if ($app) {
				$this->app = $app;
				$this->app->template_dir	= JURI::base() . "templates/" . $this->app->template;
				$this->app->setGenerator(null);

				if (isset($app->_error) && $app->_error->code == '404') {
					$this->errorpage = true;
					$this->modules = array();
				}	
			}
		}

		private function get_menu() {
			return JSite::getMenu();
		}

		private function get_menu_page() {
			return $this->menu->getActive();
		}

		private function get_id() {
			return JRequest::getInt('id');
		}

		private function get_type() {
			$type = '';

			// If we're dealing with an article, check the originating component to see what our type should be
			if ($this->view == 'article' && isset($this->menu_page->component)) {
				if ($this->menu_page->component == 'com_joomgallery')	$type = 'photo';
				if ($this->menu_page->component == 'com_content')		$type = 'article';
			}

			if ($this->view =='tag') $type='tag';

			// And we have a hacky way of handling videos
			if (isset($this->menu_page)) {
				if ($this->view == 'section' && $this->menu_page->alias == 'videos')	$type = 'video';
			}

			return $type;
		}

		private function get_view() {
			if (JRequest::getCmd('view')) {
				return JRequest::getCmd('view');
			} else if (!empty($this->pageid)) {
				return $this->pageid ? 'article' : 'frontpage';
			} else {
				return false;
			}
		}

		private function get_section() {
			if (!isset($this->menu)) $this->get_menu();
			$zone = '';

			// Check to see if we're on the homepage
			if ($this->is_front_page()) {
				$zone = 'home';
			// Otherwise try to find the section
			} elseif (!empty($this->menu_page->route)) {
				if (is_array(explode('/',$this->menu_page->route))) {
					$zone = array_shift(explode('/',$this->menu_page->route));
				} else {
					$zone = $this->menu_page->route;
				}

				$zone = strtolower(str_replace('-', '_', implode('_',explode(' ', $zone))));
			}

			return $zone;
		}





		public function is_front_page() {
			if ($this->menu_page == $this->menu->getDefault()) {
				return true;
			} else {
				return false;
			}
		}

		public function body_class($getArray=false) {
			if ($this->errorpage) return 'error';

			$classes = Array();

			// Find our section
			if (!empty($this->section)) {
				$classes[] = 'sect_' . $this->section;
			}

			// Add our component and view as com_component and com_component_view if they exist
			if (!empty($this->menu_page->component)) {
				$classes[] = $this->menu_page->component;
				if (!empty($this->view)) {
					$classes[] = $this->menu_page->component . '_' . $this->view;

					// And the whole sheebang in case we need it
					if (!empty($this->section)) $classes[] = $this->section . '_' . $this->menu_page->component . '_' . $this->view;
				}

			// Otherwise, just try and fetch the view
			} else {
				if (!empty($this->view)) $classes[] = 'view_' . $this->view;
			}

			// Find our content type
			if (!empty($this->type)) $classes[] = 'type_' . $this->type;

			// Find our content ID
			if (!empty($this->pageid)) $classes[] = 'id_' . $this->pageid;

			if (!empty($this->category)) $classes[] = $this->category;

			// Return a full class set if we have it, or an empty array otherwise
			if ($getArray) {
				return $classes;
			} else {
				return implode(' ', $classes);
			}
		}

		public function nice_searchterm() {
			$search = $_SERVER['REQUEST_URI'];

			// index.php?option=com_missing yadda yadda....
			if (strpos('index.php?', $search) !== false) {
				$params = explode('&', $search);
				$search = '';

				// We expect to find a title in the form of id=12314:Real%20title%20here
				foreach ($params as $param) {
					if (strpos($param,'id=') == 0) {
						$search = substr($param, (strpos($param,':') + 1));
						$search = str_replace('%20', ' ', $search);
					}
				}

			// thefashionspot.com/missing-article-123 yadda yadda....
			} else {
				$search = array_pop(explode('/',$search));
				$search = explode('-', $search);

				// Drop numerics off the front and end
				if (is_numeric ($search[count($search) -1])) array_pop($search);
				if (is_numeric ($search[0])) array_shift($search);

				$search = implode(' ', $search);
			}

			return ucwords($search);
		}

		public function set_pagination() {
			global $joomlaplatform_current_page_number;

			if (!empty($_GET['startpage']) && $_GET['startpage'] > 1) {
				$page_number = $_GET['startpage'];
			} elseif (!empty($_GET['page']) && $_GET['page'] > 1) {
				$page_number = $_GET['page'];
			} else {
				$page_number = ($joomlaplatform_current_page_number > 1) ? $joomlaplatform_current_page_number : '';
			}

			// Append page number to page title if applicable
			if ($page_number != '') {
				$document =& JFactory::getDocument();
				$document->setTitle($document->title . ' - ' . JText::_( 'Page' ) . ' ' . $page_number);
			}

			$joomlaplatform_current_page_number = null;
		}

		public function get_category() {
			$db = &JFactory::getDBO();

			$option	= JRequest::getCmd('option');
			$view   = JRequest::getCmd('view');

			$temp   = JRequest::getString('id');
			$temp   = explode(':', $temp);
			$id		= $temp[0];

			/* Checking if we are making up an article page */
			if ($option == 'com_content' && $view == 'article' && $id) {
				/* Trying to get CATEGORY title from DB */
				$db->setQuery('SELECT cat.title FROM #__categories cat RIGHT JOIN #__content cont ON cat.id = cont.catid WHERE cont.id='.$id);
				$category_title = $db->loadResult();

				/* Printing category title*/
				if ($category_title) {
					return str_replace(' ', '_', strtolower($category_title));
				} else {
					return '';
				}
			}
		}

		public function get_sitename() {
			$config =& JFactory::getConfig();
			echo $config->getValue('config.sitename');
		}

		public function get_header() {
			if ($this->errorpage) return true;

			echo '<jdoc:include type="head" />';
		}

		public function get_module($position, $style, $params=array()) {
			if ($this->errorpage) {
				$this->get_module_force($position, $style);
			} else {
				echo '<jdoc:include type="modules" style="'.$style.'" name="'.$position.'" />';
			}	
		}

		public function get_module_force($position, $style=-2) {
			$document	= &JFactory::getDocument();
			$renderer	= $document->loadRenderer('module');
			$params		= array('style'=>$style);

			$contents = '';
			foreach (JModuleHelper::getModules($position) as $mod)  {
				$contents .= $renderer->render($mod, $params);
			}

			echo $contents;
		}

		public function countModules($position) {
			if ($this->errorpage) {
				return count(JModuleHelper::getModules($position));
			} else {
				return $this->app->countModules($position);
			}
		}
	}

	if (!function_exists('modChrome_springboard')) {
		function modChrome_springboard( $module, &$params, &$attribs ) {
			$output  = '';
			$header  = (!isset($attribs['header'])) ? 'h3' : $attribs['header'];
			$class_sfx = $params->get('moduleclass_sfx');

			$class	 = "module";
			if (!empty($class_sfx)) {
				$classes = explode(' ', $class_sfx);
				foreach ($classes as $new_class) {
					$class .= " mod_$new_class";
				}
			}

			$class .= ' ' . str_replace('mod_', 'type_', $module->module);

			$output .= "<div class='$class'>";

			if ($module->showtitle) {
				$output .= "<{$header}>$module->title</{$header}>";
			}

			$output .= $module->content;
			$output .= "</div>";

			echo $output;
		}
	}
?>
