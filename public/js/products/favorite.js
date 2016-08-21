$(function () {
    $('.product .favorite_toggle').click(function (e) {
        // Find the closest div with class .product and attribute data-id
        var productPanel = $(this).closest('.product[data-id]');

        var productId = productPanel.attr('data-id');

        var icon = $('.favorite_toggle i', productPanel);

        var button = $('.favorite_toggle', productPanel);

        $.getJSON('/products/' + productId + '/favorite', function (data) {
            icon.toggleClass('fa-star-o fa-star')
            button.toggleClass('notfavorite favorite')
        });
    });
});