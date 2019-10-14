$(document).ready(function(){

$('.list_comments').on('click', '.fa-thumbs-up', function(){

    if(!userAuth){
        alertDanger('Вы не авторизованы!');
        return;
    }

    var comment = $(this).closest('li');
    var id = comment.data('id');
    var item = $(this);
    var type = item.data('type');
    var checkPressDislike = comment.find('.fa-thumbs-down').data('type');
    
    if(type == 'disable')
        return;

    $.ajax({
        url: 'http://' + host + '/comments/like',
        data: 'id=' + id + '&checkPressDislike=' + checkPressDislike,
        type: 'post',
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'success'){
                item.addClass('press').removeClass('like').data('type', 'disable');
                comment.find('.c_like').html(Number(comment.find('.c_like').html()) + 1);
                comment.find('.fa-thumbs-down').removeClass('press').addClass('dislike').data('type', 'enable');
                comment.find('.c_dis').removeClass('press').addClass('counter-dislike');
                comment.find('.c_like').addClass('press');
                
                if(checkPressDislike == 'disable'){
                    if(Number(comment.find('.c_dis').html()) > 1){
                        comment.find('.c_dis').html(Number(comment.find('.c_dis').html()) - 1);
                    }
                    else{
                        comment.find('.c_dis').html(''); 
                    }
                }                
            }
        },
        error: function(){
            alertDanger();
        }
    });
});


$('.list_comments').on('click', '.fa-thumbs-down', function(){
    if(!userAuth){
        alertDanger('Вы не авторизованы!');
        return;
    }
    var comment = $(this).closest('li');
    var id = comment.data('id');
    var item = $(this);
    var type = item.data('type');
    var checkPressLike = comment.find('.fa-thumbs-up').data('type');
   
    if(type == 'disable')
        return;

    $.ajax({
        url: 'http://' + host + '/comments/dislike',
        data: 'id=' + id + '&checkPressLike=' + checkPressLike,
        type: 'post',
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'success'){
                item.addClass('press').removeClass('dislike').data('type', 'disable');
                comment.find('.c_dis').html(Number(comment.find('.c_dis').html()) + 1);
                
                comment.find('.fa-thumbs-up').removeClass('press').addClass('like').data('type', 'enable');
                comment.find('.c_dis').addClass('press');
                comment.find('.c_like').removeClass('press').addClass('counter-like');
                if(checkPressLike == 'disable'){
                    if(Number(comment.find('.c_like').html()) > 1)
                        comment.find('.c_like').html(Number(comment.find('.c_like').html()) - 1);
                    else
                        comment.find('.c_like').html(''); 
                }     
            }
        },
        error: function(){
            alertDanger();
        }

    });
});

$('.list_comments').on('click', '.form_add_response button[type=submit]', function(e){
    e.preventDefault();
    var li = $(this).closest('li');
    var parent_id = li.data('id');

    var fields = map(li.find('form input, textarea'));

    var request = '';
    for(var key in fields){
        request += key + '=' + fields[key] + '&';
    }
    request += 'parent_id=' + parent_id;

    $.ajax({
        url: 'http://' + host + '/comments/addResponse',
        type: 'post',
        data: request,
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'mail_exist'){
                var html = "<span class='message-error-tooltip'>Пользователь с таким адресом эл. почты уже зарегистрирован, авторизируйтесь&nbsp;";
                html += "<a href='http://"+host+"/login'>Войти</a></span>";
                li.find('input[type=email]').closest('.form-group').append(html);
                return;
            }

            if(data.type == 'success'){
                alertSuccess('Ответ успешно добавлен!');
                li.find('.form_add_response').remove();
                li.find('.footer_response').removeClass('disactive');
                
                if(li.find('.btn_view_responses').length != 0){
                    li.find('.btn_view_responses span').html(Number(li.find('.btn_view_responses span').html()) + 1);
                }else{
                    var counter_response = "<p class='btn_view_responses'><i class='far fa-comment'></i>&nbsp;";
                    counter_response += '<span>1</span>&nbsp;ответ</p>';
                    li.find('.btn_response_comment').after(counter_response);
                }                            
            }
        },
        error: function(){
            alertDanger();
        }
    });
});

$('#btn-get-response').click(function(){
    var count = $('.list_comments #list-otzuv').attr('data-count');
    
    var alias = document.location.pathname.match(/product\/comments\/(\w+)/);
    
    if(alias){
        alias = alias[1];
    }
    
    $.ajax({
        url: 'http://' + host + '/comments/get',
        data: 'count=' + count + '&alias=' + alias,
        type: 'post',
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'success'){
                $('.list_comments #list-otzuv').attr('data-count', Number(count) + 20);
                var html = '';
                $.each(data.comments, function(index, item){
                    if(item['type'] == 'otzuv'){
                        html = "<li data-id='"+item['id']+"'><p><b class='name_user'>"+item['name']+"</b>";
                        html += "<div class='widget_stars'><ul>";
                        $.each(item['stars'], function(index, item){
                            html += "<li><i class='fa fa-star"+item+"' style='color: #0280e1;' aria-hidden='true'></i></li>&nbsp;";
                        });

                        html += "</ul></div><span class='date_comment'>"+item['date']+"</span>";
                        html += "</p><p style='clear: left;'>"+item['comment']+"</p>";
                        html += "<p><b style='color: black;'>Достоинства: </b>" + item['good_comment'];
                        html += "</p><p><b style='color: black;' >Недостатки: </b>" + item['bad_comment'];
                        html += "</p><div style='margin-top: 10px;' class='footer_comment'>";
                        html += "<div style='margin-top: 10px;' class='footer_response'>";
                        html += "<button class='btn_response_comment' >&#8617;&nbsp;Ответить</button>";
                        if(item['count_response'] > 0){
                            html += "<p class='btn_view_responses'><i class='far fa-comment'></i>&nbsp;";
                            html += "<span>"+item['count_response']+"</span>&nbsp;ответ</p>";
                        }
                        html += "<div class='block_like_dislike'>";

                        var check = (item['check_press_like'] == 'press') ? 'press' : 'counter-like';
                        var check1 = (item['plus_likes'] > 0) ? item['plus_likes'] : '';
                        var check2 = (item['check_press_like'] == 'press') ? 'disable' : 'enable';
                        var check3 = (item['check_press_dislike'] == 'press') ? 'disable' : 'enable';
                        var check4 = (item['check_press_dislike'] == 'press') ? 'press' : 'counter-dislike';
                        var check5 = (item['minus_likes'] > 0) ? item['minus_likes'] : '';

                        html += "<small class='c_like " + check + " counter-like-dislike'>" + check1 + "</small>";
                        html += "&nbsp;<i class='fas fa-thumbs-up "+item['check_press_like']+"' data-type='" + check2 + "'></i>&nbsp;|&nbsp;";
                        html += "<i class='fas fa-thumbs-down " + item['check_press_dislike'] + "' data-type='" + check3 + "'></i>&nbsp;<small class='c_dis counter-like-dislike ";
                        html += check4 + "'>" + check5 + "</small>";        
                        html += "</div></div></div></li>";
                    }else{
                        html = "<li data-id='"+ item['id'] +"'>";
                        html += "<p><b class='name_user'>"+item['name']+"</b>";
                        html += "<span class='date_comment'>"+item['date']+"</span></p>";
                        html += "<p style='clear: left;'>"+item['comment'] +"</p><div style='margin-top: 10px;' class='footer_comment'>";
                        html += "<div style='margin-top: 10px;' class='footer_response'>";
                        html += "<button class='btn_response_comment'>&#8617;&nbsp;Ответить</button>";
                        if(item['count_response'] > 0){
                            html += "<p class='btn_view_responses'><i class='far fa-comment'></i>&nbsp;";
                            html += "<span>"+item['count_response'] + "</span>&nbsp;ответ</p>";
                        }

                        html += "<div class='block_like_dislike'>";
                        var check = (item['check_press_like'] == 'press') ? 'press' : 'counter-like';
                        var check1 = (item['plus_likes'] > 0) ? item['plus_likes'] : '';
                        var check2 = (item['check_press_like'] == 'press') ? 'disable' : 'enable';
                        var check3 = (item['check_press_dislike'] == 'press') ? 'disable' : 'enable';
                        var check4 = (item['check_press_dislike'] == 'press') ? 'press' : 'counter-dislike';
                        var check5 = (item['minus_likes'] > 0) ? item['minus_likes'] : '';

                        html += "<small class='c_like " + check + " counter-like-dislike'>" + check1 + "</small>";
                        html += "&nbsp;<i class='fas fa-thumbs-up "+item['check_press_like']+"' data-type='" + check2 + "'></i>&nbsp;|&nbsp;";
                        html += "<i class='fas fa-thumbs-down " + item['check_press_dislike'] + "' data-type='" + check3 + "'></i>&nbsp;<small class='c_dis counter-like-dislike ";
                        html += check4 + "'>" + check5 + "</small>"; 
                        html += "</div></div></div></div></li>";
 
                    }
              
                    $('.list_comments #list-otzuv').find('#btn-get-response').closest('li').before(html);                   
                });
                
                if(data.count < 20){
                    $('.list_comments #list-otzuv').find('#btn-get-response').closest('li').addClass('hidden');
                }
            }
        },
        error: function(){
            alertDanger();
        }
    });
});


$('#sort-product li a').click(function(e){
    e.preventDefault();
    var item = $(this);
    var sort = item.data('sort');

    if(item.is('.active'))
        return;

    //Доделать сортировку

});



$('#add-wish-list').click(function(){
    
    if(!userAuth){
        alertDanger('Вы не авторизованы!');
        return;
    }

    if($(this).attr('data-type') == 'added'){
        document.location = 'http://' + host + '/profile/desires';
        return;
    }

    var id = $(this).closest('.container').data('id');
    
    $.ajax({
        url: 'http://' + host + '/wishlist/addProduct',
        type: 'post',
        data: 'id=' + id,
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'success'){
                alertSuccess('Товар добавлен в список желаний!');

                if($('#wishlist').find('span').length){     
                    $('#wishlist').find('span').html(Number($('#wishlist').find('span').html()) + 1);
                }
                else{
                    $('#wishlist button').after('<span>1</span>');
                }

                $('#add-wish-list').html('<i class="fas fa-heart"></i>&nbsp;' + 'В списке желаний');
                $('#add-wish-list').attr('data-type', 'added');
            }
        },
        error: function(){
            alertDanger();
        }
    });
});

$('#comparison').click(function(){
    document.location = 'http://' + host + '/comparison';
});

$('#wishlist').click(function(){
     if(!userAuth){
        alertNotice('Чтобы использовать список желаний необходимо авторизоваться!');
        return;
     }
     document.location = 'http://' + host + '/profile/desires';
});

$('#btn-add-wishlist').click(function(){
    if($('#block-add-wishlist').is('.hidden')){
        $('#block-add-wishlist').removeClass('hidden');
    }
    $('.container-add-wishlist').find('input[name=name]').focus();
});

$('#block-add-wishlist #exit').click(function(){
    $('#block-add-wishlist').addClass('hidden');
    $('.container-add-wishlist').find('input[type=text]').val('');
    $('.container-add-wishlist').find('.form-group').removeClass('has-error')

});

$('#block-add-wishlist #save').click(function(e){
    e.preventDefault();
    var name = $(this).prev('.form-group').find('input').val();
    var regexp = /\S+/;

    if(!regexp.test(name)){
        $(this).prev('.form-group').addClass('has-error');
        return;
    }

    $(this).prev('.form-group').removeClass('has-error');

    $.ajax({
        url: 'http://' + host + '/wishlist/addList',
        type: 'post',
        data: 'name=' + name, 
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'success'){
                $('.container-add-wishlist').find('input[type=text]').val('');
                var html = "<div class='products-row wishlist' data-id='"+data.id+"'><div class='container-head-list'>";
                html += "<div class='head-list'><h3>" + data.name + "</h3>";
                html += "<i class='far fa-edit' title='Переименовать список желаний'></i><p class='btn-wishlist' id='btn-del-wishlist'>Удалить список</p>";
                if(data.default)
                    html += "<p><i class='fas fa-check'></i>&nbsp;Список по умолчанию</p>";
                else
                    html += "<p class='btn-wishlist' id='select-def-wishlist'>Сделать по умолчанию</p>";

                html += "</div></div><div class='container-change-name-wishlist hidden'></div><p id='msg-empty-wishlist'>Ваш список желаний пока пуст</p></div>";

                $('#cont-body #block-add-wishlist').after(html);
                $('#block-add-wishlist').addClass('hidden');
                $('.msg-empty').addClass('hidden');
                alertSuccess('Список желаний успешно создан!');
            }
        },
        error: function(){
            alertDanger();
        }
    });
});

$('#cont-body').on('click', '#btn-del-wishlist', function(){
    var list = $(this).closest('.wishlist');
    var c_items = list.find('.product-grids');
    var list_id = list.data('id');

    $.ajax({
        url: 'http://' + host + '/wishlist/remove',
        type: 'post',
        data: 'id=' + list_id,
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'success'){
                list.remove();
                alertSuccess('Список успешно удален!');

                if(!$('.product-grids').length)
                    $('#wishlist span').remove();
                else
                    $('#wishlist span').html(Number($('#wishlist span').html()) - c_items);

                if(!$('.wishlist').not('#block-add-wishlist').length){
                    $('#block-add-wishlist').after("<h3 class='msg-empty'>У вас пока нет списка желаний</h3>");
                }
            }
        },
        error: function(){
            alertDanger();
        }
    });
});

$('#cont-body').on('click', '#select-def-wishlist', function(){
    var list = $(this).closest('.wishlist');
    var list_id = list.data('id');

    $.ajax({
        url: 'http://' + host + '/wishlist/newDefault',
        type: 'post',
        data: 'id=' + list_id,
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'success'){
                alertSuccess('Список по умолчанию успешно изменен!');

                $('.head-list p .fa-check').closest('p').html('Сделать по умолчанию').attr('id', 'select-def-wishlist').addClass('btn-wishlist');
                list.find('#select-def-wishlist').html('<i class="fas fa-check"></i>&nbsp;Список по умолчанию');
                list.find('.head-list p .fa-check').closest('p').removeAttr('id').removeClass('btn-wishlist');


                if(!$('.wishlist').not('#block-add-wishlist').length){
                    $('#block-add-wishlist').after("<h3 class='msg-empty'>У вас пока нет списка желаний</h3>");
                }
            }
        },
        error: function(){
            alertDanger();
        }
    });
});

$('#cont-body').on('click', '.fa-edit', function(){
    var list = $(this).closest('.wishlist');
    var name = list.find('.container-head-list .head-list h3').html();

    $(document).find('.container-change-name-wishlist').html('').addClass('hidden');
    $(document).find('.container-head-list').removeClass('hidden');

    list.find('.container-change-name-wishlist').removeClass('hidden').html(form_change_name_wishlist).find('#newName').val(name).select();
    list.find('.container-head-list').addClass('hidden');
});

$('#cont-body').on('click', '.container-change-name-wishlist #exit', function(e){
    $(this).closest('.container-change-name-wishlist').addClass('hidden').html('');
    $('.container-head-list').removeClass('hidden');
});

$('#cont-body').on('click', '.container-change-name-wishlist #save', function(e){
    e.preventDefault();
    
    var list = $(this).closest('.wishlist');
    var list_id = list.data('id');
    var name = list.find('.container-change-name-wishlist input[type=text]').val();

    var regexp = /\S+/;

    if(!regexp.test(name)){
        list.find('.form-group').addClass('has-error');
        return;
    }

    list.find('.form-group').removeClass('has-error');
    
    $.ajax({
        url: 'http://' + host + '/wishlist/changeName',
        type: 'post',
        data: 'id=' + list_id + '&name=' + name,
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'success'){
                list.find('.head-list h3').html(data.name);
                list.find('.container-change-name-wishlist').html('').addClass('hidden');
                list.find('.container-head-list').removeClass('hidden');
                alertSuccess('Название списка успешно изменено!');
            }

        },
        error: function(){
            alertDanger();
        }
    });
});


$('.wishlist .fa-times-circle').click(function(){
    var item = $(this).closest('.product-grids');
    var product_id = item.data('id');
    var list_id = item.closest('.wishlist').data('id');

    $.ajax({
        url: 'http://' + host + '/wishlist/delItem',
        type: 'post',
        data: 'product_id=' + product_id + '&list_id=' + list_id,
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'success'){
                if(data.count > 0){
                    var p = item.closest('.wishlist').find('.container-head-list .final-summ p');
                    console.log(p);
                    p.find('#count-product-wishlist').html(data.count);
                    p.find('#price').html(data.summ+'&nbsp;'+simbolCurrency);
                    $('#wishlist').find('span').html(Number($('#wishlist').find('span').html()) - 1);
                }else{
                    item.closest('.wishlist').find('.container-head-list .final-summ').remove();
                    item.closest('.wishlist').find('.container-change-name-wishlist').after("<p id='msg-empty-wishlist'>Ваш список желаний пока пуст</p>");
                    $('#wishlist button').next('span').remove();
                }

                item.remove();
            }
        },
        error: function(){
            alertDanger();
        }
    });
});

$(":checkbox").change(function(){
    if(this.checked){
        $(this).closest('.product-grids').attr('data-check', 'check');
    }else{
        $(this).closest('.product-grids').attr('data-check', 'uncheck');
    }

    //console.log($(this).closest('.chkbox-wishlist').find('h6').html());

    //var price = Number($(this).closest('.chkbox-wishlist').find('h6').html().match(/&nbsp;([0-9.]+)&nbsp;/)[1]);
    var price = 0;
    var count = 0;
    console.log($(this).closest('.wishlist').find('.product-grids[data-check=check]'));
    $.each($(this).closest('.wishlist').find('.product-grids[data-check=check]'), function(index, item){
        price += Number($(item).find('h6').html().match(/&nbsp;([0-9.]+)&nbsp;/)[1]);
        count++;
    });
    price = Math.round(price * 100) / 100;
    $(this).closest('.wishlist').find('.final-summ #count-product-wishlist').html(count);
    var newPrice = $(this).closest('.wishlist').find('.final-summ #price').html().replace(/([0-9.]+)(.*)/, price+'$2');
    $(this).closest('.wishlist').find('.final-summ #price').html(newPrice);



    if(price == 0){
        var count = $(this).closest('.wishlist').find('.product-grids').length;
        var price = 0;
        $.each($(this).closest('.wishlist').find('.product-grids'), function(index, item){
            price += Number($(item).find('h6').html().match(/&nbsp;([0-9.]+)&nbsp;/)[1]);
        });
        price = Math.round(price * 100) / 100;
        var newPrice = $(this).closest('.wishlist').find('.final-summ #price').html().replace(/([0-9.]+)(.*)/, price+'$2');
        $(this).closest('.wishlist').find('.final-summ #count-product-wishlist').html(count);
        $(this).closest('.wishlist').find('.final-summ #price').html(newPrice);
        $(this).closest('.wishlist').find('#btn-del-arr-wishlist').addClass('hidden');
    }else{
        $(this).closest('.wishlist').find('#btn-del-arr-wishlist').removeClass('hidden');
    }
});

$('#cont-body').on('click', '#btn-del-arr-wishlist', function(){
    var list = $(this).closest('.wishlist');
    var list_id = list.data('id');
    var product_ids = new Array;
    $.each(list.find('.product-grids[data-check=check]'), function(index, item){
        product_ids.push($(item).data('id'));
    });
    
    $.ajax({
        url: 'http://' + host + '/wishlist/delProducts',
        type: 'post',
        data: 'list_id=' + list_id + '&product_ids=' + product_ids,
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'success'){
                var c_product = list.find('.product-grids').length;

                $.each(list.find('.product-grids[data-check=check]'), function(index, item){
                    $(item).remove();
                });

                if(list.find('.product-grids').length > 0){
                    
                    var price = 0;
                    $.each(list.find('.product-grids'), function(index, item){
                        price += Number($(item).find('h6').html().match(/&nbsp;([0-9.]+)&nbsp;/)[1]);
                    });

                    price = Math.round(price * 100) / 100;
                    var newPrice = list.find('.final-summ #price').html().replace(/([0-9.]+)(.*)/, price+'$2');
                    list.find('.final-summ #price').html(newPrice);

                    $('#wishlist span').html(c_product - product_ids.length);
                    
                    list.find('#count-product-wishlist').html(c_product - product_ids.length);
                }else{
                    $('#wishlist span').remove();
                    list.find('.container-head-list .final-summ').remove();
                    list.find('.container-change-name-wishlist').after("<p id='msg-empty-wishlist'>Ваш список желаний пока пуст</p>");
                }

                list.find('#btn-del-arr-wishlist').addClass('hidden');
                alertSuccess('Товары успешно удалены из списка!');
            }
        },
        error: function(){
            alertDanger();
        }
    });
});

$('#add-to-cart-from-wishlist').click(function(){

    var list = $(this).closest('.wishlist');
    var ids = new Array;

    if(list.find('.product-grids[data-check=check]').length){
        //есть отмеченные товары
        $.each(list.find('.product-grids[data-check=check]'), function(index, item){
            ids.push($(item).data('id'));
        });
    }else{
        $.each(list.find('.product-grids'), function(index, item){
            ids.push($(item).data('id'));
        });
    }

    $.ajax({
        url: 'http://' + host + '/cart/addListItems',
        type: 'post',
        data: 'ids=' + ids,
        dataType: 'json',
        success: function(data){
            console.log(data);

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
                $('#countProductCart').html(ids.length);
            }else{
                var count = Number($('#countProductCart').html());
                count += ids.length;
                $('#countProductCart').html(count);
            }

            $.each(list.find('.product-grids[data-check=check]'), function(index, item){
                $(item).attr('data-check', 'uncheck');
                $(item).find('#container input[type=checkbox]').removeAttr('checked');
            });

            list.find('#count-product-wishlist').html(list.find('.product-grids').length);
            var price = 0;
            $.each(list.find('.product-grids'), function(index, item){
                price += Number($(item).find('h6').html().match(/&nbsp;([0-9.]+)&nbsp;/)[1]);
            });

            price = Math.round(price * 100) / 100;
            var newPrice = list.find('.final-summ #price').html().replace(/([0-9.]+)(.*)/, price+'$2');
            list.find('.final-summ #price').html(newPrice);

            list.find('#btn-del-arr-wishlist').addClass('hidden');
            $('.modal').modal();
        },
        error: function(){
            alertDanger();
        }
    });
});

$(document).scroll(function(){
    var r = /comparison\/[0-9]+/;
    if(r.test(document.location.pathname))
        toggleHeader();
    
});

$('#add-comparison-list').click(function(){
    if($(this).attr('data-type') == 'press')
        document.location = 'http://' + host + '/profile/comparison';

    var id = $(this).closest('.container').data('id');

    $.ajax({
        url: 'http://' + host + '/comparison/add',
        type: 'post',
        data: 'id=' + id,
        dataType: 'json',
        success: function(data){
            console.log(data);

            if(data.type == 'max_lenght'){
                alertNotice('Превышен лимит (5 товаров) для сравнения в одной категории!');
                return;
            }

            if(data.type == 'success'){
                alertSuccess('Товар добавлен в список сравнений!');
                $('#add-comparison-list').html('<i class="fas fa-balance-scale"></i>&nbsp;Сравнивается').attr('data-type', 'press');

                if($('#comparison').find('span').length){     
                    $('#comparison').find('span').html(Number($('#comparison').find('span').html()) + 1);
                }
                else{
                    $('#comparison button').after('<span>1</span>');
                }
            }
        },
        error: function(){
            alertDanger();
        }
    });
});

$('.btn-del-comparison-product').click(function(){
    var item = $(this);
    var product_id = item.closest('.product-grids').data('id');
    var key = item.closest('.comparison-list').data('id');

    $.ajax({
        url: 'http://' + host + '/comparison/delItem',
        type: 'post',
        data: 'product_id=' + product_id + '&key=' + key,
        dataType: 'json',
        success: function(data){
            console.log(data);
        
            if(data.removeList){
                item.closest('.comparison-list').prev('h3').remove();
                item.closest('.comparison-list').next('.clearfix').remove();
                item.closest('.list-content').remove();
            }

            if(data.checkOne){
                item.closest('.list-content').find('.comparison-products').remove();
            }

            item.closest('.product-grids').remove();

            if(Number($('#comparison').find('span').html()) > 1){
                $('#comparison').find('span').html(Number($('#comparison').find('span').html()) - 1);
            }else{
                $('#comparison').find('span').remove();
            }

            if($('.container').find('.list-content').length < 1){
                $('.container .w3ls-title').after('<h3>У вас пока нет товаров для сравнения</h3>');
            }
        },
        error: function(){
            alertDanger();
        }
    });
});

});


function toggleHeader(){

    var scroll_status = $(document).scrollTop();
    s_top = $(window).scrollTop();
    yes = $(".table-sravneniy thead").offset().top;

    var tables = $('.container').find('.table-sravneniy');
    $.each($(tables[0]).find('thead tr th'), function(index, item){
        $($(tables[1]).find('thead tr th')[index]).width($(item).width());;
    });
    
    if(s_top > yes){
        $("#test").removeClass('hidden').css('width', $('.container').width());
        var heightFooter = $('.footer').height() - 250;

        if($(window).scrollTop() > $(document).height() - ($(window).height() + heightFooter))
            $("#test").addClass('hidden');
        else
            $("#test").removeClass('hidden');
    }else{
        $("#test").addClass('hidden');
    }
}