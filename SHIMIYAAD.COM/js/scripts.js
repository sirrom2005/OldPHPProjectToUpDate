var obj = null;

function checkHover() {
	if (obj) obj.find('ul').fadeOut('fast');
}

jQuery(function() {
	
	/** begin submenu **/
	jQuery('#header ul > li').hover(
		function() {
			if (obj) {
				obj.find('ul')
					.css('display', 'none');
				obj = null;
			}
			jQuery(this).find('ul')
				.fadeIn();
		},
		function() {
			obj = jQuery(this);
			setTimeout("checkHover()", 1000);
		}
	);
	/** end submenu **/
	
	/** begin featured content **/
	jQuery('.featured-img').cycle({
		fx: 'scrollLeft',
		speed: 700,
		timeout: 5000
	});
	/** end featured content **/
	
	/** begin youtube video **/
	var videoEmbedd = "<object width=\""+videoWidth+"\" height=\""+videoHeight+"\"><param name=\"movie\" value=\"http://www.youtube.com/v/"+youtubeID+"&amp;hl=en&amp;fs=1\"></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/"+youtubeID+"&amp;hl=en&amp;fs=1\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\""+videoWidth+"\" height=\""+videoHeight+"\"></embed></object>";
	jQuery('#youtube').html(videoEmbedd);
	/** end youtube video **/
	
	/** begin search **/
	jQuery('#s').attr({ 'value' : searchDefault });
	jQuery('#s').focus(function() {
		var temp = jQuery(this).attr('value');
		color = jQuery(this).css('color');
		jQuery(this).css({ 'color' : searchColor });
		if (temp==searchDefault)
			jQuery(this).attr({ 'value' : '' })
	});
	jQuery('#s').blur(function() {
		if (jQuery(this).attr('value')=='') {
			jQuery(this).attr({ 'value' : searchDefault });
		}
		jQuery(this).css({ 'color' : color });
	});
	/** end search **/
	
});

function GoogleAd(width, height, border, background, link, text, url, type) {
	document.write('<script type="text/javascript"> google_ad_client = "pub-' + adsenseID + '"; google_ad_width = ' + width + '; google_ad_height = ' + height + '; google_ad_format = "' + width + 'x' + height + '_as"; google_ad_type = "' + type + '"; google_color_border = "' + border + '"; google_color_bg = "' + background + '"; google_color_link = "' + link + '"; google_color_text = "' + text + '"; google_color_url = "' + url + '"; </script><script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>');
}
