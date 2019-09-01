jQuery(document).ready(function($){
	//open/close mega-navigation
	$('.cd-dropdown-trigger').on('click', function(event){
		event.preventDefault();
		toggleNav();
	});

	//close meganavigation
	$('.cd-dropdown .cd-close').on('click', function(event){
		event.preventDefault();
		toggleNav();
	});

	//on mobile - open submenu
	$('.has-children').children('a').on('click', function(event){
		//prevent default clicking on direct children of .has-children 
		//event.preventDefault();
		var selected = $(this);
		selected.next('ul').removeClass('is-hidden').end().parent('.has-children').parent('ul').addClass('move-out');
	});

	//on desktop - differentiate between a user trying to hover over a dropdown item vs trying to navigate into a submenu's contents
	var submenuDirection = ( !$('.cd-dropdown-wrapper').hasClass('open-to-left') ) ? 'right' : 'left';
	$('.cd-dropdown-content').menuAim({
        activate: function(row) {
        	$(row).children().addClass('is-active').removeClass('fade-out');
        	if( $('.cd-dropdown-content .fade-in').length == 0 ) $(row).children('ul').addClass('fade-in');
        },
        deactivate: function(row) {
        	$(row).children().removeClass('is-active');
        	if( $('li.has-children:hover').length == 0 || $('li.has-children:hover').is($(row)) ) {
        		$('.cd-dropdown-content').find('.fade-in').removeClass('fade-in');
        		$(row).children('ul').addClass('fade-out')
        	}
        },
        exitMenu: function() {
        	$('.cd-dropdown-content').find('.is-active').removeClass('is-active');
        	return true;
        },
        submenuDirection: submenuDirection,
    });

	//submenu items - go back link
	$('.go-back').on('click', function(){
		var selected = $(this),
			visibleNav = $(this).parent('ul').parent('.has-children').parent('ul');
		selected.parent('ul').addClass('is-hidden').parent('.has-children').parent('ul').removeClass('move-out');
	}); 

	function toggleNav(){
		var navIsVisible = ( !$('.cd-dropdown').hasClass('dropdown-is-active') ) ? true : false;
		$('.cd-dropdown').toggleClass('dropdown-is-active', navIsVisible);
		$('.cd-dropdown-trigger').toggleClass('dropdown-is-active', navIsVisible);
		if( !navIsVisible ) {
			$('.cd-dropdown').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',function(){
				$('.has-children ul').addClass('is-hidden');
				$('.move-out').removeClass('move-out');
				$('.is-active').removeClass('is-active');
			});	
		}
	}



/* custom script */

$('.currency').click(function(){
    var currency = $(this).find('a').data('curr');
    var cookie = getCookie('currency');
    if(cookie == currency)
        return;
        
    setCookie('currency', currency, {'max-age': 60 * 60 * 24 * 2});
    document.location.reload(true);
});


$('.stars_block ul li').mouseover(function(){
    $(this).prevAll().each(function(index, value){
        $(value).find('i').css('color', '#0280e1');
    });

    $(this).find('i').css('color', '#0280e1');
});

$('.stars_block ul li').mouseleave(function(){
    $(this).prevAll().each(function(index, value){
        $(value).find('i').css('color', '#d2d2d2');
    });

    $(this).find('i').css('color', '#d2d2d2');
});


$('#tabs li').click(function(){

    
    if($(this).attr('class') == 'active')
        return;
    
    var dataType = $(this).data('type');
    
    if(dataType == 'kommentariy'){
        
        $('#kommentariy').addClass('disactive');
        $('#otzuv_o_tovare').removeClass('disactive');
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
    }else{

        $(this).siblings().removeClass('active');
        $(this).addClass('active');

        $('#kommentariy').removeClass('disactive');
        $('#otzuv_o_tovare').addClass('disactive');  
    }
});



$('.btn_response_comment').click(function(){
    $(this).closest('li').find('.form_add_comment').removeClass('disactive');
    $(this).closest('li').find('#footer_response').addClass('disactive');
});

$('#close_form_add_response').click(function(){
    $(this).closest('li').find('.form_add_comment').addClass('disactive');
    $(this).closest('li').find('#footer_response').removeClass('disactive');
});

$('.btn_view_responses').click(function(){
    $(this).closest('li').find('.block_responses').removeClass('disactive');
    $(this).closest('li').find('#footer_response').addClass('disactive');

});

$('#close_form_responses_response').click(function(){
    $(this).closest('li').find('.block_responses').addClass('disactive');
    $(this).closest('li').find('#footer_response').removeClass('disactive');
});

$('.bth_comment').click(function(){
    $('.form_add_comment').removeClass('disactive');
    $('.header_block_comments').addClass('disactive');
    $('.list_comments').addClass('disactive');
});

$('.close_form_add_comment').click(function(){
    $('.form_add_comment').addClass('disactive');
    $('.header_block_comments').removeClass('disactive');
    $('.list_comments').removeClass('disactive');
});


/* custom script */

	 
});

function getCookie(name) {
  let matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name, value, options = {}) {

  options = {
    path: '/',
    expires: new Date(Date.now() + 86400e3)
  };

  if (options.expires.toUTCString) {
    options.expires = options.expires.toUTCString();
  }

  let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

  for (let optionKey in options) {
    updatedCookie += "; " + optionKey;
    let optionValue = options[optionKey];
    if (optionValue !== true) {
      updatedCookie += "=" + optionValue;
    }
  }

  document.cookie = updatedCookie;
}