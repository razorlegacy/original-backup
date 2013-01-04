jQuery.noConflict();

jQuery(document).ready(function(){
	GiftGuide.init();
});

var GiftGuide = {
	init: function() {
		GiftGuide.category.init();
		GiftGuide.upload.init();
		GiftGuide.tabs.init();
		GiftGuide.product.init();
		GiftGuide.collapse.init();
		GiftGuide.formHelper.init();
		GiftGuide.createPage.init();
		
		jQuery('textarea').elastic();
		jQuery('input[type="text"]').each(function() {
			jQuery(this).placeholder();
		});
		
		g_gid		= jQuery('#categoryForm input[name="gid"]').val();	
	},
	//Reloads data and re-inits page
	refresh: function(data) {
		//jQuery('#giftguide_category').tabs('destroy');
		jQuery('#category_name').val('');		
		jQuery('#giftguide_category').empty();
		jQuery('#giftguide_category').html(data);
		
		GiftGuide.upload.init();
		GiftGuide.tabs.init();
		GiftGuide.collapse.init();
		GiftGuide.product.order();
		GiftGuide.formHelper.init();
		
		//Change a delegate
		jQuery('textarea').elastic();
		jQuery('input[type="text"]').each(function() {
			jQuery(this).placeholder();
		});
	},
	//sanitizes string: replace space with underscore and converts to lowercase
	sanitize: function(string) {
		string	= string.replace(/ /g,"_").toLowerCase();
		return string;
	},
	message: function(message, messageType) {
		var messageOut;
		
		//Clear old message
		jQuery('#system-message').remove();
		
		messageOut		= "";
		messageOut		+= "<dl id='system-message'>";
		messageOut			+= "<dt class='message'>Message</dt>";
		messageOut			+= "<dd class='"+messageType+" message fade'>";
		messageOut				+= "<ul>";
		messageOut					+= "<li>"+message+"</li>";
		messageOut				+= "</ul>";
		messageOut			+= "</dd>";
		messageOut		+= "</dl>";
		
		jQuery(messageOut).insertBefore('#element-box');
		setTimeout(function() { 
			//jQuery('#system-message').animate({opacity: 0});
			jQuery('#system-message').fadeOut('slow'); 
			}, 2000);		
	}
};

GiftGuide.createPage = {
	init: function() {
		this.banner_select();
		this.twitter_textarea();
	},
	banner_select: function() {
		jQuery('#banner_option').change(function() {
			jQuery('#gg_banner').toggle(function() {
				if(jQuery('#banner_option').val() == 0) {
					jQuery('#super_banner').val('').placeholder();
					jQuery('#super_banner_static').val('').placeholder();
					
				}
			});
		});
	},
	twitter_textarea: function() {
		jQuery('#twitter_description').NobleCount('#twitter_count', {
			max_chars: 120,
			block_negative: true
		});
	}
}


GiftGuide.formHelper = {
	init: function() {
		jQuery('.productForm :input[type="text"], #adminForm :input[type="text"], .gg_category_meta :input[type="text"], :input[type="textarea"]').tooltip({
			position: 'center right',
			effect: 'fade',
			opacity: .7
		});
		
		jQuery('#categoryForm :input[type="text"]').tooltip({
			position: 'top center',
			effect: 'fade',
			offset: [-5, 0],
			opacity: .7
		});
	}
}

GiftGuide.collapse = {
	init: function() {
		this.meta();
		this.category();
		this.product();
	},
	product: function() {
		//default
		jQuery('.gg_product_view .collapse span').hide();
	
		jQuery('.gg_product_view .collapse label').collapser({
			target: 'next',
			effect: 'slide',
			expandHtml: 'Description <small>[click to expand]</small>',
			collapseHtml: 'Description <small>[click to expand]</small>'
		},
		function(){
			jQuery('.gg_product_view .collapse span').slideUp();
		});

	},
	meta: function() {
		//meta_collapse
		jQuery('#meta_collapse').collapser({
			target: '#giftguide_meta',
			effect: 'slide',
			//changeText: true,
			expandHtml: 'Developer Settings [show]',
			collapseHtml: 'Developer Settings [hide]',
		});
	},
	category: function() {
		jQuery('.gg_category_collapse').collapser({
			target: 'next',
			effect: 'slide',
			expandHtml: 'Edit Category [show]',
			collapseHtml: 'Edit Category [hide]',
		});	
	}
};

GiftGuide.tabs = {
	init: function() {
		var that	= this;
		jQuery('#giftguide_category').tabs('destroy');
		jQuery('#giftguide_category').tabs().find('.ui-tabs-nav').sortable({
			axis: 'x',
			update: function() {
				that.saveOrder(this);
			}
		});
	},
	//Sets selected tab as active
	active: function(tabID) {
		if(tabID.length > 0) {
			jQuery('#giftguide_category').tabs("select", tabID);
		} else {
			var tab 	= jQuery('#giftguide_category ul.tabs li').last().find('a').attr('href');
			jQuery('#giftguide_category').tabs("select", tab);
		}
	},
	//Returns current active tab
	current: function() {
		var currentTab		= jQuery('#giftguide_category ul.tabs li.ui-state-active a').attr('href');
		
		if(currentTab != undefined) {
			currentTab		= currentTab.replace('#', '');
		} else {
			currentTab		= '';
		}
		return currentTab;
	},
	saveOrder: function(path) {
		var dataString	= jQuery(path).find('input[name="cid[]"]').serialize();
		GiftGuide.category.save('order_category', dataString);
	}
};	

GiftGuide.upload = {
	init: function() {
		jQuery('input[id^="img_upload"]').each(function() {
			var that	= this;
			
			var giftguideFolder		= jQuery('#folder_name').attr('value');
			var categoryFolder		= jQuery(this).parent().parent().parent().find('input[id^="category_folder"]').attr('value');
			
			var folderPath			= "/assets/components/com_giftguides/"+giftguideFolder+"/"+categoryFolder;	
						
			jQuery(this).uploadify({
				'uploader'  	: '/administrator/components/com_giftguides/swf/uploadify.swf',
				'script'    	: '/administrator/components/com_giftguides/classes/uploadify.php',
				'cancelImg' 	: '/administrator/components/com_giftguides/images/cancel.png',
				'folder'    	: folderPath,
				'auto'      	: true,
				'buttonText'	: 'Upload Image',
				'onComplete'	: function (event, ID, fileObj, response, data) {
					
					jQuery(that).parent().find('img').attr('src', fileObj.filePath);
					jQuery(that).parent().find('#img_large').attr('value', fileObj.filePath);
				}
			});
		});
    }
};

GiftGuide.category = {

	init: function() {
		var that	= this;
		jQuery('#category_submit').live('click', function() {
		
			//Checks for input
			if(jQuery('#category_name').val().length > 0) {
				that.save('category', this);
			} else {
				GiftGuide.message('Please enter a Category name', 'notice');
			}
		});
		
		jQuery('#category_name_edit').live('click', function() {
			var currentTab		= jQuery('#'+GiftGuide.tabs.current());
			var categoryVal		= jQuery(currentTab).find('#category_name').val();
			var categoryPixel	= jQuery(currentTab).find('#tracking_pixel').val();	
					
			if(categoryVal.length > 0) {
				if(categoryPixel.length > 0) {
					//Sanitize tracking code (remove <img>)
					if(categoryPixel.charAt(0) == "<") {
						categoryPixel	= jQuery(categoryPixel).attr('src');					
					}

					categoryVal	+= '&tracking_pixel='+categoryPixel;
				}
				that.save('category_save', categoryVal);
			} else {
				GiftGuide.message('Please enter a category name', 'notice');
			}
		});
		
		jQuery('#category_name_delete').live('click', function() {
			var categoryPath	= this;
			
			jQuery(this).fastConfirm({
				position: "right",
				questionText: "Confirm category deletion (this will remove all associated products)",
				onProceed: function() {
					//that.delete(jQuery(productPath));
					that.save('category_delete', '');
				}
			});
		});
	},
	save: function(type, path) {
		var that			= this;
		var currentTab		= GiftGuide.tabs.current();
		
		switch(type) {
			case 'category': 		var dataString 	= jQuery('#categoryForm').serialize();
									var message		= 'Category Added';
									break;
			case 'product':			var dataString	= jQuery(path).parent().serialize();
									var message		= 'Product Saved';
									break;
			case 'category_save':	var cid			= jQuery('#'+currentTab).find('.gg_category_meta input[name="cid"]').val();
									var dataString	= '&task=saveCategory&category_name='+path+'&id='+cid+'&gid='+g_gid;
									var currentTab	= path+'_'+cid;
										currentTab	= GiftGuide.sanitize(currentTab);
									var message		= 'Category Saved';
									break;
			case 'category_delete':	var cid			= jQuery('#'+currentTab).find('.gg_category_meta input[name="cid"]').val();
									var dataString	= '&task=deleteCategory&id='+cid+'&gid='+g_gid;
									var message		= 'Category Removed';
									break;
			case 'order_product':	var dataString	= '&task=saveProductOrder&gid='+g_gid+'&'+path;
									var message		= 'Product Order Updated';
									break;
			case 'order_category':	var dataString	= '&task=saveCategoryOrder&gid='+g_gid+'&'+path;
									var message		= 'Category Order Updated';
									break;
		}
				
		jQuery.ajax({
			url: 'index.php?option=com_giftguides&format=raw',
			data: dataString,
			type: 'post',
			success: function(output) {
				GiftGuide.refresh(output);
				GiftGuide.message(message, 'message');
				
				//if adding category, go to latest tab
				switch(type) {
					case 'category':		GiftGuide.tabs.active('');
											break;
					case 'category_save':
					case 'product':
					case 'order_product':
					case 'order_category':	GiftGuide.tabs.active(currentTab);
											break;
				}
				
				//GiftGuide.formHelper.init();
			}
		});		
		return false;
	}
};

GiftGuide.product = {
	init: function() {
		var that = this;
		
		that.order();
		
		jQuery('input[name="product_submit"]').live('click', function() {
			var basePath	= jQuery(this).parent();
			
			if(basePath.find('#title').val().length > 0) {
				GiftGuide.category.save('product', this);
			} else {
				GiftGuide.message('Please enter a product title', 'notice');
			}

			return false;
		});
		
		jQuery('input[name="product_clear"]').live('click', function() {
			that.editClear();
		});
		
		jQuery('#product_edit').live('click', function() {
			that.edit(jQuery(this));
		});
		
		jQuery('#product_edit_img').live('click', function() {
			that.edit(jQuery(this).parent());
			return false;
		});
		
		jQuery('#product_delete').live('click', function() {
			//that.delete(jQuery(this));
			var productPath	= this;
			jQuery(this).fastConfirm({
				position: "right",
				questionText: "Confirm product deletion",
				onProceed: function() {
					that.delete(jQuery(productPath));
				}
			});
			return false;
		});
		
		jQuery('#product_featured').live('change', function() {
			var featuredVal	= jQuery(this).val();
			var cid			= jQuery(this).parent().find('input[name="cid"]').val();
									
			if(featuredVal != 'null') {
				that.featured(featuredVal, cid);
			}
		});
	},
	order: function() {
		//Drag and drop reordering
		jQuery('.gg_product_view ol').dragsort({
			dragSelector: '.product_drag, .gg_product_image',
			dragEnd: function() {
				var dataString	= jQuery(this).parent().find('input[name="id[]"]').serialize();
				
				GiftGuide.category.save('order_product', dataString);
			}
		});
	},
	edit: function(path) {
		var pathToProduct		= jQuery(path).parent();
		var productID			= pathToProduct
		
		jQuery('#productForm input[id="title"]').attr('value', pathToProduct.find('.title span').html());
		jQuery('#productForm textarea[id="description"]').attr('value', pathToProduct.find('.description span').html());
		jQuery('#productForm input[id="price"]').attr('value', pathToProduct.find('.price span').html());
		jQuery('#productForm input[id="url"]').attr('value', pathToProduct.find('.url a').attr('href'));
		jQuery('#productForm input[name="id"]').attr('value', pathToProduct.find('input[name="id[]"]').val());
		jQuery('#productForm input[name="alias"]').attr('value', pathToProduct.find('input[name="alias"]').val());
		jQuery('#productForm .gg_product_image img').attr('src', pathToProduct.find('.gg_product_image img').attr('src'));
		jQuery('#productForm .gg_product_image #img_large').attr('value', pathToProduct.find('.gg_product_image img').attr('src'));
		
		jQuery('#productForm input[type="text"]').each(function() {
			jQuery(this).removeClass('placeholder');
		});
		
		//Wipe custom input classes
		//GiftGuide.formHelper.cleanupBulk('#productForm');
		jQuery('textarea').elastic();
	},
	editClear: function () {
		jQuery('#productForm input[id="title"]').val('');
		jQuery('#productForm textarea[id="description"]').val('');
		jQuery('#productForm input[id="price"]').val('');
		jQuery('#productForm input[id="url"]').val('');
		jQuery('#productForm input[name="id"]').val('');
		jQuery('#productForm input[name="alias"]').val('');
		jQuery('#productForm .gg_product_image img').attr('src', 'components/com_giftguides/images/giftguide_placeholder.jpg');
		jQuery('#productForm .gg_product_image #img_large').val('');
		
		//Wipe custom input classes (just in case)
		jQuery('#productForm input').each(function() {
			jQuery(this).removeClass('form_helper_default');
		});
		
		//GiftGuide.formHelper.init();
	},
	delete: function(path) {		
		var productID		= jQuery(path).parent().find('input[name="id[]"]').val();
		var categoryID		= jQuery(path).parent().find('input[name="cid"]').val();
		var giftguideID		= jQuery('#categoryForm input[name="gid"]').val();
		var dataString		= 'id='+productID+'&cid='+categoryID+'&gid='+giftguideID;
		var currentTab		= GiftGuide.tabs.current();
		
		jQuery.ajax({
			url: 'index.php?option=com_giftguides&format=raw&task=deleteProduct',
			data: dataString,
			type: 'post',
			success: function(output) {
				GiftGuide.refresh(output);
				GiftGuide.tabs.active(currentTab);
				GiftGuide.message('Product Deleted', 'message');
				//jQuery(GiftGuide.message('Product Deleted')).insertBefore('#element-box');
			}
		});
	},
	featured: function(featured, cid) {
		var dataString		= '&task=saveFeatured&featured='+featured+'&id='+cid;
		
		jQuery.ajax({
			url: 'index.php?option=com_giftguides&format=raw',
			data: dataString,
			type: 'post',
			success: function(output) {
				//console.log('1');
				GiftGuide.message('Featured Product Set', 'message');
			}
		});	
		
	}
};