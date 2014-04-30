window.addEvent('domready', function()
{
	// Check if Browser supports the "placeholder" attribute
	if (!('placeholder' in new Element('input', {type:'text'})))
	{
		Element.implement('cleardefault', function()
		{
			var el = this;
			if (el.get('tag') == 'input' && el.get('type') == 'password')
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
			else if (el.get('placeholder') && ((el.get('tag') == 'input' && ['text', 'search', 'url', 'tel', 'email'].contains(el.get('type'))) || (el.get('tag') == 'textarea')))
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

		document.getElements('input[placeholder], textarea').cleardefault();
	}

	// Provide an empty "cleardefault" function for modern browsers, so a call to el.cleardefault() will not throw an error
	else
	{
		Element.implement('cleardefault', function(){});
	}
});