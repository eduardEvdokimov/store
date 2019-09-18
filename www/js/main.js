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
    
    document.location = 'http://' + host + '/currency/change?currency=' + currency;
});


$('.stars_block ul li').mouseover(function(){
    $(this).prevAll().each(function(index, value){
        $(value).find('i').addClass('stars_checked');
        $(value).find('i').removeClass('stars_unchecked');
    });
    $(this).find('i').removeClass('stars_unchecked');
    $(this).find('i').addClass('stars_checked');
});

$('.stars_block ul li').mouseleave(function(){
    $(this).prevAll().each(function(index, value){
        $(value).find('i').removeClass('stars_checked');
        $(value).find('i').addClass('stars_unchecked');

    });

    $(this).find('i').removeClass('stars_checked');
    $(this).find('i').addClass('stars_unchecked');
});

$('.stars_block ul li').click(function(){
    
    $(this).prevAll().each(function(index, value){
        $(value).find('i').css('color', '#0280e1');
        $(value).attr('data-status', 'checked');
    });

    $(this).nextAll().each(function(index, value){
        $(value).find('i').removeAttr('style');
        $(value).removeAttr('data-status');
    });

    $(this).find('i').css('color', '#0280e1');
    $(this).attr('data-status', 'checked');
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
    $(this).closest('li').find('.form_add_response').removeClass('disactive');
    $(this).closest('li').find('#footer_response').addClass('disactive');
});

$('#close_form_add_response').click(function(){
    $(this).closest('li').find('.form_add_response').addClass('disactive');
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


$('.addToCart').click(function(){
    var idProduct = $(this).data('id');
    var request = 'id=' + idProduct;

    if(!idProduct) return;

    $.ajax({
        url: 'http://' + host + '/cart/add',
        type: 'post',
        data: request,
        dataType: 'json',
        success: function(data){
            //console.log(data);
            //return;
            //Скрываем надпись 'Корзина пуста'
            if($('.modal-body').find('h3').attr('class') != 'hidden'){
                $('.modal-body').find('h3').addClass('hidden');
                $('.modal-body').find('table').removeClass('hidden');
                $('.modal-footer').find('#btn_addOrder').removeClass('hidden');
                $('.modal-footer').find('.clearCart').removeClass('hidden');
            }
            
            $('.modal-body tbody').html();
            var htmlSummCart = "<tr class='result_line_catr' style='background: #b2ff96;'></tr>";
            $('.modal-body').find('tbody').html(htmlSummCart);

            $.each(data['products'], function(index, item){
                var html = "<tr data-id='"+item['id']+"'><td><img src='http://"+host+"/images/" + item['img'] + "' alt='img' style='width: 60px; '>";
                html += "</td><td style='width: 50%;'><a href='http://"+host+'/product/'+item['alias']+"'>"+ item['title'] +"</a></td>";
                html += "<td class='price'>" + simbolCurrency + '&nbsp;' + item['price'] +"</td><td><div><button class='btn_box_number delCountProduct'>&#8212;</button>";
                html += "<input type='text' class='box_number' maxlength='3' readonly value='"+item['count']+"'><button class='btn_box_number addCountProduct'>+</button></div></td>";
                html += "<td class='summProduct'>" + simbolCurrency + '&nbsp;'+ item['summ'] +"</td>";
                html += "<td><span style='cursor: pointer;' class='glyphicon glyphicon-remove text-danger del-item delProductCart' aria-hidden='true'></span></td></tr>";


                $('.modal-body tbody').prepend(html);
            });
                        
            var resultCart = "<th scope='row' colspan='2' >Итоговая сумма</th><td></td>";
            resultCart += "<td></td><td class='final_price' style='background: #0280e1;' colspan='2'><span>"+simbolCurrency+'&nbsp;'+data['cart.summ']+"</span></td>";   
                                
            $('.result_line_catr').html(resultCart);

            if($('#countProductCart').attr('class') == 'hidden'){
                $('#countProductCart').removeClass('hidden');
                $('#countProductCart').html('1');
            }else{
                var count = Number($('#countProductCart').html());
                count++;
                $('#countProductCart').html(count);
            }

            $('.modal').modal();            
                        

        },
        error: function(){
            alert('Произошла ошибка. Попробуйте позже');
        }
    });
});

$('.clearCart').click(function(){

    $.ajax({
        url: 'http://' + host + '/cart/clear',
        success: function(){
            $('.modal-body').find('tbody').html('');
            var htmlSummCart = "<tr class='result_line_catr' style='background: #b2ff96;'></tr>";
            $('.modal-body').find('tbody').html(htmlSummCart);
            $('.modal-body').find('h3').removeClass('hidden');
            $('.modal-body').find('table').addClass('hidden');
            $('#btn_addOrder').addClass('hidden');
            $('.clearCart').addClass('hidden');
            $('#countProductCart').html('');
            $('#countProductCart').addClass('hidden');
        },
        error:function(){
            alert('Произошла ошибка. Попробуйте позже');
        }
    });

});

$('tbody').on('click', '.delProductCart', function(){
    var item = $(this).closest('tr');
    var id = $(this).closest('tr').data('id');

    if(!id) return;

    $.ajax({
        url: 'http://' + host + '/cart/delItem',
        type: 'post',
        data: 'id='+id,
        dataType: 'json',
        success:function(data){

            item.closest('tr').remove();

            if(data['summCart'] <= 0){
                $('.modal-body').find('tbody').html('');
                var htmlSummCart = "<tr class='result_line_catr' style='background: #b2ff96;'></tr>";
                $('.modal-body').find('tbody').html(htmlSummCart);
                $('.modal-body').find('h3').removeClass('hidden');
                $('.modal-body').find('table').addClass('hidden');
                $('#btn_addOrder').addClass('hidden');
                $('.clearCart').addClass('hidden');
                $('#countProductCart').html('');
                $('#countProductCart').addClass('hidden');
            }

            $('#countProductCart').html(data['countCart']);

            var resultCart = "<th scope='row' colspan='2' >Итоговая сумма</th><td></td>";
            resultCart += "<td></td><td class='final_price' style='background: #0280e1;' colspan='2'><span>"+simbolCurrency+'&nbsp;'+data['summCart']+"</span></td>";   
                                
            $('.result_line_catr').html(resultCart);
            
        },
        error:function()
        {
            alert('Произошла ошибка. Попробуйте позже');
        }
    });
});


$('tbody').on('click', '.delCountProduct', function(){
    var element = $(this).closest('tr');
    var id = $(this).closest('tr').data('id');
    var count = parseInt($(this).closest('tr').find('.box_number').val());
    
    if(!id || count < 2) return;
    
    $.ajax({
        url: 'http://' + host + '/cart/delCountProduct',
        type: 'post',
        data: 'id=' + id,
        dataType: 'json',
        success: function(data){
            element.find('.box_number').val(data['product']['count']);
            element.find('.summProduct').html(simbolCurrency + '&nbsp;' + data['product']['summ']);
            $('.final_price span').html(simbolCurrency+'&nbsp;'+data['cartSumm']);
            $('#countProductCart').html(data['cartCount']);

        },
        error: function(){
            alert('Произошла ошибка. Попробуйте позже');
        }
    });

});

/* custom script */

$('tbody').on('click', '.addCountProduct', function(){
    var element = $(this).closest('tr');
    var id = $(this).closest('tr').data('id');

    if(!id) return;

    $.ajax({
        url: 'http://' + host + '/cart/addCountProduct',
        type: 'post',
        data: 'id=' + id,
        dataType: 'json',
        success: function(data){
            element.find('.box_number').val(data['product']['count']);
            element.find('.summProduct').html(simbolCurrency + '&nbsp;' + data['product']['summ']);
            $('.final_price span').html(simbolCurrency+'&nbsp;'+data['cartSumm']);
            $('#countProductCart').html(data['cartCount']);
        },
        error: function(){
            alert('Произошла ошибка. Попробуйте позже');
        }
    });

});

$('#autocomplete').click(function(){
    $.each($('.autocomplete-suggestions').attr('class').split(' '), function(index, item){
        if(item == 'hidden'){
            $('.autocomplete-suggestions').removeClass('hidden');
        }
    });
    
});

$('#autocomplete').autocomplete({
    serviceUrl: 'http://' + host + '/search/get',
    minChars: 3,
    paramName: 's',
    showNoSuggestionNotice: true,
    noSuggestionNotice: 'Товары не найдены',
    noCache: true,
    onSelect: function (suggestion) {
        document.location = 'http://' + host + '/product/' + suggestion.data;
    } 
});

$(document).on('scroll', function(){
    $('.autocomplete-suggestions').addClass('hidden');
    $('#autocomplete').blur();
});

$('#sub_search').click(function(){
    sendSearch();
});

$('#autocomplete').on('keyup', function(e){
    if(e.keyCode == 13)
        sendSearch();
});


$('#subReg').click(function(e){
    e.preventDefault();
    var formData = map('#form_signup input');
    var regexps = [/[A-ZА-Я]/, /\d+/];
    var emptyField = filterEmptyField(formData);

   

    if(Object.keys(emptyField).length > 0){
        
        for(var key in formData) {
            if(key in emptyField){
                //поле не заполнено
                $('#form_signup input[name=' + key + ']').css('border', '1px solid red');
            }else{
                //поле заполнено
                $('#form_signup input[name=' + key + ']').css('border', '1px solid silver');
            }
        }
        return;
    }
    
    

    var checkValidPassword = false;

    $.each(regexps, function(index, item){
        if(!item.test(formData['password']) || $.trim(formData['password']).length < 6){
            $('#form_signup input[name=password]').css('border', '1px solid red');
            checkValidPassword = true;
        }
    });

    if(checkValidPassword) return;


    

    formData['remember'] = $('.checkbox input[type=checkbox]').is(':checked');

    var request = '';
    for(var key in formData){
        request += key + '=' + formData[key] + '&';
    }

    $.ajax({
        url: 'http://' + host + '/signup/new',
        data: request,
        type: 'post',
        dataType: 'json',
        success: function(data){
            console.log(data);
            if(data.type == 'valid'){
                $('#form_signup input[name=email]').css('border', '1px solid red');
                $('#form_signup .notice-form-error').removeClass('hidden').html(data.msg);
                return;
            }

            if(data.type == 'exist'){
                $('#form_signup .block-notice-form').removeClass('hidden');
                $('#form_signup .block-notice-form p').html(data.msg);
                return;
            }

            if(data == 'success')
                document.location = 'http://' + host;
        },
        error: function(){
            alert('Произошла ошибка. Попробуйте позже');
        },

    });
});

$('#form_login input[type=submit]').click(function(e){
    e.preventDefault();
    var formData = map('#form_login input');
    var emptyField = filterEmptyField(formData);

    if(Object.keys(emptyField).length > 0){
        for(var key in formData) {
            if(key in emptyField){
                //поле не заполнено
                $('#form_login input[name=' + key + ']').css('border', '1px solid red');
            }else{
                //поле заполнено
                $('#form_login input[name=' + key + ']').css('border', '1px solid silver');
            }
        }
        return;
    }
    

    formData['remember'] = $('.checkbox input[type=checkbox]').is(':checked');

    var request = '';
    for(var key in formData){
        request += key + '=' + formData[key] + '&';
    }

    $.ajax({
        url: 'http://' + host + '/login/auth',
        data: request,
        type: 'post',
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'error'){
                $('.block-notice-form').removeClass('hidden');
                $('.block-notice-form p').html(data.msg);
                return;
            }

            if(data.type){
                document.location = 'http://' + host;
            }


        },
        error: function(){
            alert('Произошла ошибка. Попробуйте позже');
        }
    });


});

$('#otzuv_o_tovare button[type=submit]').click(function(e){
    e.preventDefault();
    var formData = map('#otzuv_o_tovare form input, textarea');
    

    var emptyField = filterEmptyField(formData);
    
    if(Object.keys(emptyField).length > 0){
        alert('Заполните все поля формы.');
        return;
    }

    formData['notice_response'] = $('#otzuv_o_tovare form input[type=checkbox]').is(':checked');
    formData['rating'] = $('#otzuv_o_tovare li[data-status]').length;

    


    console.log(formData);


});


});


function map(item_src)
{
    var formData = new Array();
    
    $(item_src).each(function(index, item){
        if($(item).attr('type') != 'submit' && $(item).attr('type') != 'checkbox'){
            if($(item).attr('name') != undefined)
                formData[$(item).attr('name')] = $(item).val();
        }
    });

    return formData; 
}

function filterEmptyField(items)
{
    var emptyField = new Array();
    
    for(var key in items) {
        if(items[key].match(/^\s*$/)){
            //поле не заполнено
            emptyField[key] = items[key];
        }
    }

    return emptyField;
}



function sendSearch()
{
    var input = $('#autocomplete').val();

    if(!input || input == ' ') return;

    document.location = 'http://' + host + '/search?text=' + input;
}


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



