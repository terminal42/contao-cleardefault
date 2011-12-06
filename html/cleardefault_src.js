window.addEvent('domready', function()
{
	// Check if Browser supports the "placeholder" attribute
	if (!('placeholder' in new Element('input', {type:'text'})))
	{
		document.getElements('input[placeholder]').each( function(el)
		{
			if (el.get('type') == 'password')
			{
				var text = new Element('input', {
					'type': 'text',
					'class': (el.get('class')+' cleardefault'),
					'value': el.get('placeholder'),
					'events': {
						'focus': function() {
							text.hide();
							el.show().focus();
						}
					}
				}).inject(el, 'before');
				
				el.hide().addEvent('blur', function()
				{
					if (el.value == '')
					{
						el.hide();
						text.show();
					}
				});
			}
			else
			{
				if (el.value == '')
				{
					el.addClass('cleardefault');
					el.value = el.get('placeholder');
				}
				
				el.addEvents(
				{
					'focus': function()
					{
						if (el.value == el.get('placeholder'))
						{
							el.removeClass('cleardefault');
							el.value = '';
						}
					},
					'blur': function()
					{
						if (el.value == '')
						{
							el.addClass('cleardefault');
							el.value = el.get('placeholder');
						}
					}
				});
			}
		});
	}
});