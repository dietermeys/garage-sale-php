$(function() {
    // Delete the product image by clicking
    $('form[name="products.update"] .product_image').click(function(e) {
        // Fetch the clicked image
        var image = $(this);
        var imageId = image.attr('data-id');

        $.getJSON('/products/images/'+ imageId +'/delete', function(data) {
            if (data.response === 'ok') {
                image.remove();
            }
        });
    });
});