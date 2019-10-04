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

    




});



});