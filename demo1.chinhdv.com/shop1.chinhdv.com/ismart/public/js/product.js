$(document).ready(function() {
    //Xử lí lọc theo giá
    
    $('.r-price').change(function() {
        var url = $("div.section-detail form#form_filter").attr("data-url");
        console.log(url);
        var price = $(this).val();
        // console.log(price);
        var data = {price: price};
        // console.log(data);
        
        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            dataType: 'text',
            success : function(data, status, jqXHR){
                console.log(data);
                $("#filter").html(data);
            }
        });
    });
});

