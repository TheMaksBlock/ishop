$('.delete').click(function(){
    var res = confirm('Подтвердите действие');
    if(!res) {
        return false;
    }
});

$('body').on('change', '.get-confirmed-orders input', function(){

    var checked = $('.get-confirmed-orders input:checked');

    $.ajax({
        url: location.href,
        data: {confirmed_orders: checked.length>0},
        type: 'POST',
        beforeSend: function(){
            $('.preload').fadeIn(300,function(){
                $('.order-content').hide();
            });
        },
        success: function(res){
            $('.order-content').html(res).show();
        },
        error: function(){
            alert("Error");
        }

    })
    $('.preload').fadeOut(300);
});