    $(document).ready(function() {
    $ ('.num-order').change(function() {
        var id = $(this).attr('data-id');
        var qty = $(this).val();
        var data = {id: id, qty: qty};
        $.ajax({
            url: '?mod=cart&controller=index&action=updateajax',
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function (data) {
                // console.log(data);
                $('.sub_total_' + id).text(data.sub_total);
                $('#total-price span').text(data.total);
                //trên icon
                $('#btn-cart span').text(data.num_order);
                $('#dropdown .desc span').text(data.num_order);
                
                $('.qty_' + id).text('Số lượng: ' +data.qty);
                $('#dropdown div.total-price p.price').text(data.total);
            }
        });
    });
});