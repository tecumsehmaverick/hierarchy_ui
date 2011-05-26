(function ($) {
	$('div[data-breadcrumb]')
		.live('initialize', function() {
			var $self = $(this);
			var $list = $self.find('ol');
			var $insert = $('<li />')
				.addClass('insert')
				.text('▼');
			var $clear = $('<li />')
				.addClass('clear')
				.text('✕');
			
			$insert.appendTo($list);
			$clear.prependTo($list);
		})
		
		.live('clear', function() {
			var $self = $(this);
			
			$self.find('ol.items li.item').remove();
			$self.children('input').val('');
		})
		
		.live('open', function() {
			var $self = $(this);
			var $list = $self
				.children('ol');
			var $options = $('<ol />')
				.addClass('options');
			var $item = null;
			var url = Symphony.Context.get('root')
				+ '/symphony/extension/breadcrumb_ui/fetch_options/';
			var attributes = $self.get(0).attributes;
			var data = {}, position;
			
			// Send any "data-breadcrumb" attributes as post data:
			$.each(attributes, function(index, attribute) {
				if (attribute.nodeName.indexOf('data-breadcrumb-') !== 0) return;
				
				var name = attribute.nodeName.substring(16);
				
				data[name] = attribute.nodeValue;
			});
			
			// Pick the correct item:
			if ($list.children('li.item.editing').length) {
				$item = $list.children('li.item.editing');
				data['location'] = $item.prev().attr('data-id');
				position = $item.position().left;
			}
			
			else {
				$item = $list.children('li.item:last');
				data['location'] = $item.attr('data-id');
				position = $list.children('li.insert').position().left;
			}
			
			$.post(url, data, function(options) {
				$.each(options, function(id, title) {
					var $option = $('<li />')
						.appendTo($options)
						.attr('data-id', id)
						.text(title);
					
					if (id == $item.attr('data-id')) {
						$option.addClass('selected');
					}
				});
				
				if (options.length == undefined) {
					$options.css({
						'margin-left': position + 'px'
					})
					$options.appendTo($self);
				}
			});
		})
		
		.live('close', function() {
			var $self = $(this);
			
			$self
				.find('ol.items li.item.editing')
				.removeClass('editing');
			
			$self
				.children('ol.options')
				.remove();
		});
	
	/**
	 * Edit an item.
	 */
	$('div[data-breadcrumb] ol.items li.item:not(.editing)')
		.live('click', function() {
			var $item = $(this);
			var $self = $item.closest('div');
			
			$self.trigger('close');
			$item.addClass('editing');
			$self.trigger('open');
		});
	
	/**
	 * Stop editing an item.
	 */
	$('div[data-breadcrumb] ol.items li.item.editing')
		.live('click', function() {
			$(this).closest('div').trigger('close');
		});
	
	/**
	 * Insert a new item.
	 */
	$('div[data-breadcrumb] ol.items li.insert')
		.live('click', function() {
			var $self = $(this).closest('div[data-breadcrumb]');
			
			$self.trigger('close');
			$self.trigger('open');
		});
	
	/**
	 * Clear the selection
	 */
	$('div[data-breadcrumb] ol.items li.clear')
		.live('click', function() {
			var $self = $(this).closest('div[data-breadcrumb]');
			
			$self.trigger('clear');
		});
	
	/**
	 * Change the selected item in the breadcrumb.
	 */
	$('div[data-breadcrumb] ol.options li')
		.live('click', function() {
			var $option = $(this);
			var $self = $option
				.closest('div[data-breadcrumb]');
			var $item = $self
				.find('ol.items li.item.editing');
			var $input = $self
				.children('input');
			
			$input
				.val($option.attr('data-id'));
			
			// No item is being edited, create a new one:
			if ($item.length == 0) {
				$item = $('<li />')
					.addClass('item editing')
					.attr('data-id', $option.attr('data-id'))
					.text($option.text())
					.insertBefore($self.find('ol.items li:last'));
			}
			
			// Update edited item:
			else {
				$item
					.attr('data-id', $option.attr('data-id'))
					.text($option.text())
					.nextAll('li.item')
					.remove();
			}
			
			$item.trigger('close');
		});
	
	/**
	 * Initialize any select elements.
	 */
	$(document)
		.ready(function() {
			$('div[data-breadcrumb]')
				.trigger('initialize')
				//.trigger('open');
		});
})(jQuery);