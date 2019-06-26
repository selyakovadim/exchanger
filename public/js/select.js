(function($) {
    var defaults = { 
		pdiv: false,
	};
    var options;
 
    $.fn.Jselect = function(params){
        options = $.extend({}, defaults, options, params);
        var thet = $(this);
 
		$('select.js_my_sel:not(.jsd)').hide();
		$('select.js_my_sel:not(.jsd)').each(function(){
			var thet = $(this);
			thet.addClass('jsd');
			thet.wrap('<div class="select_js">');
			thet.parents('.select_js').css({'height': thet.height() });
			var opttxt = '';
			var seltitle = '';
		
			thet.find('option').each(function(){
				
				var thesel = $(this).html();
				
				if($(this).prop('selected')){
					opttxt = opttxt + '<div class="select_js_ulli active" data-value="'+ $(this).val() +'">'+ thesel +'</div>';
					seltitle = thesel;
				} else {
					opttxt = opttxt + '<div class="select_js_ulli" data-value="'+ $(this).val() +'">'+ thesel +'</div>';
				}
			});	
			
			var seltxt = '<div class="select_js_title"><div class="select_js_title_ins">'+ seltitle +'</div></div><div class="select_js_ul">' + opttxt + '</div>';
			
			thet.parents('.select_js').find('select').after(seltxt);
			thet.parents('.select_js').after('<div style="clear: both;"></div>');
		
		});
		
		$('select.imager:not(.jsd)').hide();
		$('select.imager:not(.jsd)').each(function(){
			var thet = $(this);
			thet.addClass('jsd');
			thet.wrap('<div class="select_js iselect_js">');
			thet.parents('.select_js').css({'height': thet.height() });
			var opttxt = '';
			var seltitle = '';
			
			thet.find('option').each(function(){
				
				var im = $(this).attr('data-img');
				var thesel = '<div class="select_ico" style="background: url(' + im + ') no-repeat center center"></div><div class="select_txt">' + $(this).html() + '</div><div style="clear: both;"></div>';
				
				if($(this).prop('selected')){
					opttxt = opttxt + '<div class="select_js_ulli active" data-value="'+ $(this).val() +'">'+ thesel +'</div>';
					seltitle = thesel;
				} else {
					opttxt = opttxt + '<div class="select_js_ulli" data-value="'+ $(this).val() +'">'+ thesel +'</div>';
				}
			});	
			
			var seltxt = '<div class="select_js_title"><div class="select_js_title_ins">'+ seltitle +'</div></div><div class="select_js_ul">' + opttxt + '</div>';
			
			thet.parents('.select_js').find('select').after(seltxt);
			thet.parents('.select_js').after('<div style="clear: both;"></div>');
		});	

		$('.select_js_title').on('click', function(){
			$('.select_js_ul').hide();
			$(this).addClass('open');
			$(this).parents('.select_js').find('.select_js_ul').show();
		});		
		
		$('.select_js_ulli').on('click', function(){
			var title = $(this).html();
			var vale = $(this).attr('data-value');
			var def = $(this).parents('.select_js').find('select').val();
			$(this).parents('.select_js').find('.select_js_title_ins').html(title);
			$(this).parents('.select_js').find('select').val(vale);
			$(this).parents('.select_js').find('.select_js_title').removeClass('open');
			$(this).parents('.select_js').find('.select_js_ulli').removeClass('active');
			$(this).addClass('active');
			
			$(this).parents('.select_js').find('.select_js_ul').hide();
			if(def != vale){
				$(this).parents('.select_js').find('select').trigger( "change" );
		    }
		});
		
		$(document).click(function(event) {
			if ($(event.target).closest(".select_js").length) return;
			$('.select_js_ul').hide();
			$('.select_js_title').removeClass('open');
			event.stopPropagation();
		});	
 
        return this;
    };
})(jQuery);