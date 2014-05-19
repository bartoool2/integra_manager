/**
 * jQuery Yii listing plugin file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @amendments Mateusz Stepinski <stepinski.mateusz@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2010 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

(function ($) {
	var methods, listingSettings = [];
	
	methods = {
		/**
		* listing set function.
		* @param options map settings for the listing. Availablel options are as follows:
		* - ajaxUpdate: array, IDs of the containers whose content may be updated by ajax response
		* - ajaxVar: string, the name of the GET variable indicating the ID of the element triggering the AJAX request
		* - pagerClass: string, the CSS class for the pager container
		* - sorterClass: string, the CSS class for the sorter container
		* - updateSelector: string, the selector for choosing which elements can trigger ajax requests
		* - beforeAjaxUpdate: function, the function to be called before ajax request is sent
		* - afterAjaxUpdate: function, the function to be called after ajax response is received
		*/
	       
		init: function (options) {
			var settings = $.extend({
				maxElementsCount: -1,
				onElementsCountChanged: function() {}
			}, options || {});

			return this.each(function() {
				var $listing = $(this);
				var id = $listing.attr('id');

				listingSettings[id] = settings;
				
				if (typeof listingSettings[id].indexNumber == 'undefined')
				{
					listingSettings[id].indexNumber = $('#' + id).listing('getElementsCount');
				}
			});
		},
		
		/**
		 * Adds new element to the grid.
		 */
		
		addElement: function () {
			var id = this.attr('id');
			
			var settings = listingSettings[id];
			
			var row = $('#' + id + ' ul li[data-type=pattern]');
			
			var contents = row.html().replace(/ROW/g, settings.indexNumber).replace(/BEGIN/g, '<').replace(/END/g, '>').replace(/INDEX/g, settings.indexNumber);
			
			contents = contents.replace(/ROW/g, settings.indexNumber).replace(/BEGIN/g, '<').replace(/END/g, '>').replace(/INDEX/g, settings.indexNumber);
			
			$('#' + id + ' ul').append('<li data-index=' + settings.indexNumber + ' class="' + row.attr('class') + '">' + contents + '</li>');
			
			settings.indexNumber++;
			
			settings.onElementsCountChanged();
		},
		
		/**
		 * Deletes specified index from grid.
		 * @param index integer the element index (zero-based index)
		 */
		
		deleteElement: function (index) {
			var id = this.attr('id');
			
			var settings = listingSettings[id];
			
			$('#' + id + ' ul li[data-index=' + index + ']').remove();
			
			settings.onElementsCountChanged();
		},
		
		/**
		 * Returns the grid rows count.
		 * @return integer the rows count.
		 */
		
		getElementsCount: function () {
			var id = this.attr('id');
			
			return $('#' + id + ' ul li').not('[data-type=pattern]').length;
		},
		
		/**
		 * Returns the max lisgint elements count.
		 * @return integer the max elements count.
		 */
		
		getMaxElementsCount: function () {
			var id = this.attr('id');
			
			var settings = listingSettings[id];
			
			return settings['maxElementsCount'];
		}
	};
	
	$.fn.listing = function (method) {
		if (methods[method])
		{
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		}
		else if (typeof method === 'object' || !method)
		{
			return methods.init.apply(this, arguments);
		}
		else
		{
			$.error('Method ' + method + ' does not exist on jQuery.listing');
			return false;
		}
	};
})(jQuery);