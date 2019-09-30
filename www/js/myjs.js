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
            if(data.type == 'success'){
                alertSuccess('Ответ успешно добавлен!');
                li.find('.form_add_response').remove();
                li.find('.footer_response').removeClass('disactive');
                
                if(li.find('.btn_view_responses').length != 0){
                    alert('+');
                    li.find('.btn_view_responses span').html(Number(li.find('.btn_view_responses span').html()) + 1);
                }else{
                    alert('-');
                    var counter_response = "<p class='btn_view_responses'><i class='far fa-comment'></i>&nbsp;";
                    counter_response += '<span>1</span>&nbsp;ответа</p>';
                    li.find('.btn_response_comment').after(counter_response);
                }

                
                                            
                                            
                                       
            }
        },
        error: function(){
            alertDanger();
        }
    });



});


});