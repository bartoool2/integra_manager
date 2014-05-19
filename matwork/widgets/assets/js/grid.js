(function ($){
	var methods, gridSettings = [];

	methods = {
		/**
		 * grid set function.
		 * @param options map settings for the grid view. Available options are as follows:
		 * - maxRowsNumber: array, IDs of the containers whose content may be updated by ajax response
		 * - onRowsNumberChanged: function, the function to be called after adding and deleting row
		 * @return object the jQuery object
		 */
		
		init: function (options) {
			var settings = $.extend({
				minRowsCount: -1,
				maxRowsCount: -1,
				onRowsCountChanged: function() {}
			}, options || {});

			return this.each(function () {
				var $grid = $(this);
				
				var id = $grid.attr('id');

				gridSettings[id] = settings;
				
				if (typeof gridSettings[id].rowNumber == 'undefined')
				{
					gridSettings[id].rowNumber = $('#' + id).grid('getRowsCount');
				}
			});
		},
		
		/**
		 * Adds new row to the grid.
		 */
		
		addRow: function () {
			var id = this.attr('id');
			
			var settings = gridSettings[id];
			
			var row = $('#' + id + ' table tbody tr[data-type=pattern]').html().replace(/ROW/g, settings.rowNumber).replace(/BEGIN/g, '<').replace(/END/g, '>');
			
			$('#' + id + ' table tbody').append('<tr data-row=' + settings.rowNumber + '>' + row + '</tr>');
			
			settings.rowNumber++;
			
			settings.onRowsCountChanged();
		},
		
		/**
		 * Deletes specified row from grid.
		 * @param row integer the row number (zero-based index)
		 */
		
		deleteRow: function (row) {
			var id = this.attr('id');
			
			var settings = gridSettings[id];
			
			$('#' + id + ' table tbody tr[data-row=' + row + ']').remove();
			
			settings.onRowsCountChanged();
		},
		
		/**
		 * Returns the grid rows count.
		 * @return integer the rows count.
		 */
		
		getRowsCount: function () {
			var id = this.attr('id');
			
			return $('#' + id + ' table tbody tr').not('[data-type=pattern]').length;
		},
		
		/**
		 * Returns the min grid rows count.
		 * @return integer the min rows count.
		 */
		
		getMinRowsCount: function () {
			var id = this.attr('id');
			
			var settings = gridSettings[id];
			
			return settings['minRowsCount'];
		},
		
		/**
		 * Returns the max grid rows count.
		 * @return integer the max rows count.
		 */
		
		getMaxRowsCount: function () {
			var id = this.attr('id');
			
			var settings = gridSettings[id];
			
			return settings['maxRowsCount'];
		},
		
		/**
		 * Checks all checkboxes in specified column.
		 * @param column integer the column number (zero-based index)
		 */
		
		checkAll: function (column) {
			var id = this.attr('id');

			$('#' + id + ' table tbody').find('td[data-column=' + column + '] input[type=checkbox]').attr('checked', true);
		},
		
		/**
		 * Unchecks all checkboxes in specified column.
		 * @param column integer the column number (zero-based index)
		 */
		
		uncheckAll: function (column) {
			var id = this.attr('id');

			$('#' + id + ' table tbody').find('td[data-column=' + column + '] input[type=checkbox]').attr('checked', false);
		},
		
		/**
		 * Applies grid selection.
		 * @param form string the form id to apply selection
		 * @param action string the action to be assigned to form
		 */
		
		applySelection: function (form, action) {
			$('#' + form).attr('action', action);
			$('#' + form).submit();
		}
	};

	$.fn.grid = function (method) {
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
			$.error('Method ' + method + ' does not exist on jQuery.grid');
			return false;
		}
	};
})(jQuery);