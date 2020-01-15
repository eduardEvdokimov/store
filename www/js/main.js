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


$('.list_comments').on('click', '.btn_response_comment', function(){
    $(this).closest('li').find('.footer_comment').prepend(form_response).validator('destroy').validator();
    $(this).closest('li').find('.footer_response').addClass('disactive');

});

$('.list_comments').on('click', '#close_form_add_response', function(){
    $(this).closest('li').find('.footer_response').removeClass('disactive');
    $(this).closest('.form_add_response').remove();
});


$('.list_comments').on('click', '.btn_view_responses', function(){
    var li = $(this).closest('li');
    var comment_id = li.data('id');
    var regexp = /product\/comments\/(\S+)$/;
    var getAll = false;

    if(regexp.exec(document.location.pathname)){
        getAll = true;
    }

    var alias = document.location.pathname.match(/product\/(\w+)/);
    if(alias){
        alias = alias[1];
    }
    console.log(alias);


    $.ajax({
        url: 'http://' + host + '/comments/getResponse',
        type: 'post',
        data: 'comment_id=' + comment_id + '&getAll=' + getAll + '&alias=' + alias,
        dataType: 'json',
        success: function(data){
            console.log(data);
            var list_responses = '';
            if(data.type == 'success'){
                list_responses += "<ul class='block_responses'><i class='fas fa-times close' id='close_form_responses_response'></i>";
                $.each(data.responses, function(index, item){
                    list_responses += "<li class='response'><p><b class='name_user'>"+item['name']+"</b>";
                    list_responses += "<span class='date_comment'>"+item['date']+"</span></p>";
                    list_responses += "<p style='clear: left;'>"+item['response']+"</p></li>";
                });

                if(data.checkAll){
                    list_responses += "<li style='border-bottom: none; margin-top: 10px;'>";
                    list_responses += "<a href='"+data.hrefGetAll+"' class='view_all_comments'>Смотреть все ответы&nbsp;&#8594;</a></li>";        
                }

                list_responses += "</ul>";

                li.find('.footer_comment').after(list_responses);
                li.find('.footer_response').addClass('disactive');
                
            }
        },
        error: function(){
            alertDanger();
        }
    });
});

$('.list_comments').on('click', '#close_form_responses_response', function(){
    $(this).closest('li').find('.footer_response').removeClass('disactive');
    $(this).closest('li').find('.block_responses').remove();
});

$('.bth_comment').click(function(){

    dumpForm('.form_add_comment');

    $('.form_add_comment').removeClass('disactive');
    $('.header_block_comments').addClass('disactive');
    $('.list_comments').addClass('disactive');
});

$('.close_form_add_comment').click(function(){

    dumpForm('.form_add_comment');

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
                $('.modal-footer').find('.btn_addOrder').removeClass('hidden');
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
            alertDanger();
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
            $('.container').find('table').addClass('hidden');
            $('.container').find('h3').removeClass('hidden');
            $('.btn_addOrder').addClass('hidden');
            $('.clearCart').addClass('hidden');
            $('#countProductCart').html('');
            $('#countProductCart').addClass('hidden');

            if(document.location.pathname == '/order')
                document.location.reload();
        },
        error:function(){
            alertDanger();
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
                $('.container').find('table').addClass('hidden');
                $('.container').find('h3').removeClass('hidden');
                $('.btn_addOrder').addClass('hidden');
                $('.clearCart').addClass('hidden');
                $('#countProductCart').html('');
                $('#countProductCart').addClass('hidden');
            }

            $('#countProductCart').html(data['countCart']);

            var resultCart = "<th scope='row' colspan='2' >Итоговая сумма</th><td></td>";
            resultCart += "<td></td><td class='final_price' style='background: #0280e1;' colspan='2'><span>"+simbolCurrency+'&nbsp;'+data['summCart']+"</span></td>";   
                                
            $('.result_line_catr').html(resultCart);

            if(document.location.pathname == '/order')
                document.location.reload();
            
        },
        error:function()
        {
            alertDanger();
        }
    });
});
let timerId;

$('tbody').on('click', '.delCountProduct', function(){
    var element = $(this).closest('tr');
    var id = $(this).closest('tr').data('id');
    var count = parseInt($(this).closest('tr').find('.box_number').val());
    
    if(!id || count < 2) return;
    clearTimeout(timerId);
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

            timerId = setTimeout(function(){
                if(document.location.pathname == '/order')
                    document.location.reload();
            }, 2000);
        },
        error: function(){
            alertDanger();
        }
    });

});

/* custom script */

$('tbody').on('click', '.addCountProduct', function(){
    
    var element = $(this).closest('tr');
    var id = $(this).closest('tr').data('id');

    if(!id) return;
    clearTimeout(timerId);
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

            timerId = setTimeout(function(){
                if(document.location.pathname == '/order')
                    document.location.reload();
            }, 2000);
        },
        error: function(){
            alertDanger();
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

            if(data == 'success'){
                document.location = 'http://' + host + '/profile';
            }
        },
        error: function(){
            alertDanger();
        },

    });
});

$('#form-login-user input[type=submit]').click(function(e){
    e.preventDefault();
    var formData = map('#form-login-user input');
    var emptyField = filterEmptyField(formData);

    if(Object.keys(emptyField).length > 0){
        for(var key in formData) {
            if(key in emptyField){
                //поле не заполнено
                $('#form-login-user input[name=' + key + ']').css('border', '1px solid red');
            }else{
                //поле заполнено
                $('#form-login-user input[name=' + key + ']').css('border', '1px solid silver');
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

            if(data.type == 'success'){
                document.location = 'http://' + host;
            }


        },
        error: function(){
            alertDanger();
        }
    });


});

$('.form_add_comment button[type=submit]').click(function(e){
    e.preventDefault();
   
    
    var form = $(this).closest('.base_form_comment');

    var formData = map(form.find('form input, textarea'));
    formData['type'] = form.data('type');

    var emptyField = filterEmptyField(formData);
    
    if(Object.keys(emptyField).length > 0){
        alert('Заполните все поля формы.');
        return;
    }

    if(form.find('form input[type=checkbox]').is(':checked')){
        formData['notice_response'] = 1;
    }else{
        formData['notice_response'] = 0;
    }

    formData['rating'] = form.find('li[data-status]').length;
    if(formData['rating'] < 1 && formData['type'] == 'otzuv'){
        alertNotice('Вы не указали во сколько звезд оцениваете товар!');
        return;
    }
    formData['product_id'] = $('.form_add_comment').data('id');

    var request = '';
    for(var key in formData){
        request += key + '=' + formData[key] + '&';
    }

    console.log(request);

    $.ajax({
        url: 'http://' + host + '/comments/add',
        type: 'post',
        data: request,
        dataType: 'json',
        success: function(data){
            console.log(data);
            if(data.type == 'mail_exist'){
                if(form.find('.form-group .message-error-tooltip').length < 1){
                    var html = "<span class='message-error-tooltip'>Пользователь с таким адресом эл. почты уже зарегистрирован, авторизируйтесь&nbsp;";
                    html += "<a href='http://"+host+"/login'>Войти</a></span>";
                    form.find('input[type=email]').closest('.form-group').append(html);
                }
            }

            if(data.type == 'success'){

                var html = '';
                if(formData['type'] == 'otzuv'){
                    html += "<li data-id='"+data.id+"'><p><b class='name_user'>"+data.data['name']+"</b>";
                   
                    html += "<div class='widget_stars'><ul>";

                    for(var x = 0; x < 5; x++){
                        if(x < formData['rating']){
                            html += " <li><i class='fa fa-star' style='color: #0280e1;' aria-hidden='true'></i></li>";
                        }else{
                            html += " <li><i class='fa fa-star-o' style='color: #0280e1;' aria-hidden='true'></i></li>";
                        }
                    }

                    html += "</ul></div>";
                    html += "<span class='date_comment'>"+data.data['date']+"</span></p><p style='clear: left;'>"+data.data['comment']+"</p>";
                    html += "<p><b style='color: black;'>Достоинства: </b>"+data.data['good_comment']+"</p>";
                    html += "<p><b style='color: black;'>Недостатки: </b>"+data.data['bad_comment']+"</p>";
                   
                }else{
                    html += "<li data-id='"+data.id+"'><p><b class='name_user'>"+data.data['name']+"</b>";
                    html += "<span class='date_comment'>"+data.data['date']+"</span></p><p style='clear: left;'>"+data.data['comment']+"</p>";
                }

                html += "<div style='margin-top: 10px;' class='footer_comment'>";
                html += "<div style='margin-top: 10px;' class='footer_response'><button class='btn_response_comment'>&#8617;&nbsp;Ответить</button><div class='block_like_dislike'>";
                html += "<small class='c_like counter-like counter-like-dislike'></small>&nbsp;<i class='fas fa-thumbs-up like' data-type='enable'></i>&nbsp;|&nbsp;";
                html += "<i class='fas fa-thumbs-down dislike' data-type='enable'></i>&nbsp;<small class='counter-like-dislike c_dis counter-dislike'></small>";
                html += "</div></div></div></li>";

            
                                    
                                
                $('.header_block_comments h3').find('p').html(Number($('.header_block_comments h3').find('p').html()) + 1);
                
                $('.form_add_comment').addClass('disactive');
                $('.header_block_comments').removeClass('disactive');
                $('.list_comments').removeClass('disactive');
                $('.list_comments > ul').prepend(html);

                if(formData['type'] == 'otzuv')
                    alertSuccess('Отзыв успешно добавлен!');
                else
                    alertSuccess('Комментарий успешно добавлен!');
                          
            }
        },
        error: function(){
            alertDanger();
        },
    });
});


$('#form-change-password button[type=submit]').click(function(e){
    e.preventDefault();
    var regexps = [/[A-ZА-Я]/, /\d+/];
    var form = $('#form-change-password');
    
    var password = form.find('input[type=password]').val();
    var checkValidPassword = false;

    $.each(regexps, function(index, item){
        if(!item.test(password) || $.trim(password).length < 6){
            checkValidPassword = true;
        }
    });

    if(checkValidPassword){
        $('.notice-form').css('color', 'red');
        return; 
    }else{
        $('.notice-form').css('color', '#999');
    } 

    $.ajax({
        url: 'http://' + host + '/profile/set-password',
        data: 'password=' + password,
        type: 'post',
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'success'){
                alertSuccess('Пароль успешно изменен!');
            }

            setTimeout(function(){
                document.location = 'http://' + host + '/profile';
            }, 4000);

        }, 
        error: function(){
            alertDanger();
        }
    });
});




//Скрытие модальных окон после прогрузки страницы
setTimeout(function(){
        $('.alert').remove(); 
    }, 5000);



$('.login-body').on('click', '#form-restore-password input[type=submit]', function(e){
    e.preventDefault();
    

    var form = $('#form-restore-password');

    var email = form.find('input[name=email]').val();
    
    if(email.match(/^\s*$/)){
        //поле пустое
        form.find('input[name=email]').css('border', '1px solid red');
        return;
    }else{
        //поле заполнено
        form.find('input[name=email]').css('border', '1px solid silver');
    }
    
    $.ajax({
        url: 'http://' + host + '/login/restore',
        data: 'email=' + email,
        type: 'post',
        dataType: 'json',
        success: function(data){
            console.log(data);
            if(data.type == 'error'){
                $('.block-notice-form').removeClass('hidden').find('p').html(data.msg);
            }

            if(data.type == 'success'){
                $('.block-notice-form').addClass('hidden').find('p').html('');
                form.find('input[name=email]').addClass('hidden');
                form.find('span').html('На Вашу почту отправлено письмо с кодом восстановления.');
                form.find('input[type=submit]').val('Подтвердить');
                form.find('input[name=code]').removeClass('hidden');
                form.prop('action', 'http://' + host + '/login/checkCodeRestore').prop('id', 'form-check-code-restore');

            }

        },
        error: function(){
            alertDanger();
        }
    });
});


$('.login-body').on('click', '#form-check-code-restore input[type=submit]', function(e){
    e.preventDefault();

    var form = $('#form-check-code-restore');

    var code = form.find('input[name=code]').val();
    
    if(code.match(/^\s*$/)){
        //поле пустое
        form.find('input[name=code]').css('border', '1px solid red');
        return;
    }else{
        //поле заполнено
        form.find('input[name=code]').css('border', '1px solid silver');
    }

    $.ajax({
        url: 'http://' + host + '/login/checkCodeRestore',
        data: 'code=' + code,
        type: 'post',
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'error'){
                $('.block-notice-form').removeClass('hidden').find('p').html(data.msg);
            }

            if(data.type == 'success')
                document.location = 'http://' + host + '/profile/restorePassword';

        },
        error: function(){
            alertDanger();
        }
    });

});

$('#send_code_confirm_email').click(function(e){
    e.preventDefault();
    $.ajax({
        url: 'http://' + host + '/profile/sendCodeConfirmEmail',
        type: 'post',
        dataType: 'json',
        success: function(data){
            if(data.type == 'success')
                alertNotice('На Вашу почту отправленно письмо.');
        },
        error: function(){
            alertDanger();
        }
    });



});

$('#form-change-name-user button[type=submit]').click(function(e){
    e.preventDefault();
    var form = $('#form-change-name-user');
    var field = map(form.find('input'));
    var emptyField = filterEmptyField(field);
    
    if(!emptyField){
        alertDanger('Заполните поля!');
        return;
    } 

    var request = '';
    for(var key in field){
        request += key + '=' + field[key] + '&';
    }
    console.log(request);

    $.ajax({
        url: 'http://' + host + '/profile/change-name',
        data: request,
        type: 'post',
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'success'){
                alertSuccess('Изменения успешно применены!');

            }
        },
        error: function(){
            alertDanger();
        }


    });
});


$('#block-change-pass button[type=submit]').click(function(e){
    e.preventDefault();
    var regexps = [/[A-ZА-Я]/, /\d+/];
    var form = $('#block-change-pass');
    var field = map(form.find('input'));
    var emptyField = filterEmptyField(field);
    
    if(!emptyField){
        alertDanger('Заполните поля!');
        return;
    } 

    var password = form.find('input[name=newPass]').val();
    
    var checkValidPassword = false;

    $.each(regexps, function(index, item){
        if(!item.test(password) || $.trim(password).length < 6){
            checkValidPassword = true;
        }
    });

    if(checkValidPassword){
        $('.notice-form').css('color', 'red');
        return; 
    }else{
        $('.notice-form').css('color', '#999');
    } 

    var request = '';
    for(var key in field){
        request += key + '=' + field[key] + '&';
    }
    console.log(request);

    $.ajax({
        url: 'http://' + host + '/profile/setNewPassword',
        data: request,
        type: 'post',
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'error'){
                form.find('#notice').removeClass('hidden');
                return;
            }
            $('#notice').addClass('hidden');

            if(data.type == 'success'){
                alertSuccess('Пароль успешно изменен!');
            }
        }, 
        error: function(){
            alertDanger();
        }
    });
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

function alertDanger(msg = 'Произошла ошибка. Попробуйте позже.'){
    $('.alert').remove(); 
    var alert = "<div class='alert alert-danger'><i class='fas fa-exclamation-circle'></i>&nbsp;"+msg;
    alert += "<button type='button' class='close' data-dismiss='alert'>×</button></div>";
        
    $('body').append(alert);                                                      
    
    setTimeout(function(){
        $('.alert').remove(); 
    }, 5000);
}


function alertNotice(msg){
    $('.alert').remove(); 
    var alert = "<div class='alert alert-warning'><i class='fas fa-exclamation-circle'></i>&nbsp;"+msg;
    alert += "<button type='button' class='close' data-dismiss='alert'>×</button></div>";

    $('body').append(alert);                                                      
    
    setTimeout(function(){
        $('.alert').remove();
    }, 5000);
}


function alertSuccess(msg){
    $('.alert').remove(); 
    var alert = "<div class='alert alert-success'><i class='fa fa-check-circle'></i>&nbsp;"+msg;
    alert += "<button type='button' class='close' data-dismiss='alert'>×</button></div>";
        
    $('body').append(alert);                                                      
    
    setTimeout(function(){
        $('.alert').remove(); 
    }, 5000);
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


function dumpForm(form)
{
    var form = $(form);


    form.find('.stars_block ul li').removeAttr('data-status').find('i').removeAttr('style');
    
    form.find('input, textarea').each(function(index, item){
        $(item).val('');
        $(item).closest('.form-group').removeClass('has-error').removeClass('has-danger');
    });

    if(form.find('.form-group input[type=email][readonly]').val() != undefined){
        form.find('.form-group input[type=email][readonly]').val(userEmail);
        form.find('.form-group input[type=email][readonly]').closest('.form-group')
        .prev('.form-group')
        .find('input[name=name]')
        .val(userName);
    }

    form.find('button[type=submit]').addClass('disabled');
    form.find('input[type=checkbox]').prop('checked', 'checked');
}
