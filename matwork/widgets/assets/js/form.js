
/**
 * jQuery Zii Form plugin file.
 */

(function ($) {
	var methods, formSettings = [];

	methods = {
		
		/**
		 * form set function.
		 * @param options map settings for the form. Available options are as follows:
		 * - ajaxVar: string, the name of the variable added to request
		 * - inputContainer: string, the input container html path
		 * - errorCssClass: string, the name of the error css class
		 * - successCssClass: string, the name of the success css class
		 * - validationsCssClass: string, the name of the validation css class
		 * @return object the jQuery object
		 */
		
		init: function (options)
		{
			var settings = $.extend({
					submitOnEnter: true
				}, options || {});

			return this.each(function ()
			{
				var $form = $(this);
				var id = $(this).attr('id');
				
				formSettings[id] = settings;
				
				if (settings.submitOnEnter)
				{
					$form.keypress(function(e){
						if (e.keyCode == 13)
						{
							$form.form('submit');
						}
					});
				}
			});
		},
		
		/**
		* Submits the form.
		*/
		
		submit: function () {
			var $form = $(this);
			
			$form.submit();
		},
		
		/**
		* Clears the form.
		*/
		
		clear: function () {
			var $form = $(this);

			$form.find(':input').each(function()
			{
				$(this).val('');
			});
		}
	};

	$.fn.form = function (method) {
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
			$.error('Method ' + method + ' does not exist on jQuery.form');
			
			return false;
		}
	};
})(jQuery);