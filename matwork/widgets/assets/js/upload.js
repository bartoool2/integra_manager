/**
 * jQuery Yii File plugin upload.
 */

(function ($){
	var methods, uploadSettings = [];

	methods = {
		
		/**
		 * upload set function.
		 * @param options map settings for the multi upload. Available options are as follows:
		 * - maxFiles: int, the max uploads count
		 * - namePrefix: string, the value of the input name prefix
		 * - extensions: array, the list of allowed extensions
		 * @return object the jQuery object
		 */
		
		init: function (options) {
			var settings = $.extend({
					maxFiles: 1,
					namePrefix: 'Files',
					extensions: [],
					wrongExtensionMessage: 'The upload extension is not allowed.',
					limitReachedMessage: 'The uploads limit has been reached.'
				}, options || {});
			
			return this.each(function ()
			{
				var $upload = $(this);
				var id = $upload.attr('id');

				if (typeof settings.rowNumber == 'undefined')
				{
					settings.rowNumber = 0;
				}
				
				if (typeof settings.afterAddingSuccess == 'undefined')
				{
					settings.afterAddingSuccess = function ()
					{
						
					}
				}
				
				if (typeof settings.afterAddingError == 'undefined')
				{
					settings.afterAddingError = function (message)
					{
						
					}
				}
				
				uploadSettings[id] = settings;
			});
		},
		
		/**
		 * Adds a new upload to the uploads list.
		 * @return object the jQuery object
		 */
		
		addRow: function () {
			var $upload = $(this);
			var id = $upload.attr('id');
			var settings = uploadSettings[id];

			if ($upload.upload('getFilesCount') < settings.maxFiles)
			{
				var input;
				
				if (settings.maxFiles > 1)
				{
					input = $('<input type="file" name="' + settings.namePrefix + '[' + settings.rowNumber + ']" style="display: none;">');
				}
				else
				{
					input = $('<input type="file" name="' + settings.namePrefix + '" style="display: none;">');
				}

				$('#' + id).append('<div data-row="' + settings.rowNumber + '"></div>');

				$('#' + id + ' div').last().append(input);

				var allowed = true;

				input.change(function(e)
				{
					var fullName = $(input).val().split('\\');

					var name = 'undefined';
					var extension = 'undefined';

					if (fullName.length > 0)
					{
						name = fullName[fullName.length - 1];

						var information = name.split('.');

						if (information.length > 0)
						{
							extension = information[information.length - 1];
						}
					}

					allowed = $upload.upload('accept', extension);

					if (allowed)
					{
						var close = $('<a class="close" href="javascript: void(0);">&times;</a>');

						close.click(function(){
							$(close).parent().remove();
						});

						$('#' + id + ' div').last().append(close).append(name);
					}
					else
					{
						$('#' + id + ' div').last().remove();

						settings.afterAddingError(settings.wrondExtensionError);
					}
				});

				input.trigger('click');
				
				settings.rowNumber++;
			}
			else
			{
				settings.afterAddingError(settings.limitReachedError);
			}			
		},
		
		/**
		 * Deletes the specified row from uploads list.
		 * @param row int the row number
		 */
		
		deleteRow: function (row) {
			var id = this.attr('id');
			
			$('#' + id + ' div[data-row=' + row + ']').remove();
		},
		
		/**
		 * Returns the uploads count in the uploads list.
		 * @return int the uploads count
		 */
		
		getFilesCount: function ()
		{
			var $upload = $(this);
			
			return $upload.children('div').length;
		},
		
		/**
		 * Checks if the upload extension is allowed.
		 * @param extension string the upload extension
		 * @return boolean whether upload extension is allowed
		 */
		
		accept: function (extension) {
			var $upload = $(this);
			var id = $upload.attr('id');
			
			if (uploadSettings[id].extensions == '*')
			{
				return true;
			}
			
			var allowed = uploadSettings[id].extensions.split(',');
			
			for (var i in allowed)
			{
				if (allowed[i].toLowerCase() == extension)
				{
					return true;
				}
			}
			
			return false;
		}
	};

	$.fn.upload = function (method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.upload');
			return false;
		}
	};
})(jQuery);