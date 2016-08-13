$(function () {
    var maySubmit = false;
    var form = $('form[name="register"]');
    var latInput = $('input[name="lat"]');
    var lngInput = $('input[name="lng"]');
    console.log(latInput, lngInput);
    form.submit(function (e) {
        if (!maySubmit)
            e.preventDefault();

        var formData = serializeForm(form);
        var address = `${formData.street} ${formData.nr}, ${formData.zip} ${formData.city}`;
        console.log(latInput);
        console.log(formData);
        geocodeAddress(address).then(function (geocode) {
            console.log(geocode);
            var lat = geocode.geometry.location.lat();
            var lng = geocode.geometry.location.lng();
            console.log(lat, lng);
            latInput.val(lat);
            lngInput.val(lng);
            console.log(latInput, lngInput);
            maySubmit = true;
            form.submit();
        });
    });
});

function geocodeAddress(address) {
    var geocoder = new google.maps.Geocoder();
    return new Promise(function (resolve, reject) {
        geocoder.geocode({'address': address}, function (results, status) {
            if (status === 'OK') {
                resolve(results[0]);
            } else {
                reject('Geocode was not successful for the following reason: ' + status);
            }
        });
    });
}

function serializeForm(form) {
    var formData = {};
    $(form).serializeArray().forEach(function (field) {
        formData[field.name] = field.value;
    });
    return formData;
}