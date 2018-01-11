$(function () {

    'use strict';

    var console = window.console || {log: function () {
        }},
    $alert = $('.docs-alert'),
            $message = $alert.find('.message'),
            showMessage = function (message, type) {
                $message.text(message);

                if (type) {
                    $message.addClass(type);
                }

                $alert.fadeIn();

                setTimeout(function () {
                    $alert.fadeOut();
                }, 3000);
            };

    // Demo
    // -------------------------------------------------------------------------

    (function () {
        var $image = $('.img-container > img'),
                $dataX = $('#dataX'),
                $dataY = $('#dataY'),
                $dataHeight = $('#dataHeight'),
                $dataWidth = $('#dataWidth'),
                $dataRotate = $('#dataRotate'),
                options = {
                    crop: function (data) {
                        $dataX.val(Math.round(data.x));
                        $dataY.val(Math.round(data.y));
                        $dataHeight.val(Math.round(data.height));
                        $dataWidth.val(Math.round(data.width));
                        $dataRotate.val(Math.round(data.rotate));
                    }
                };

        $image.on({
            'build.cropper': function (e) {
                console.log(e.type);
            },
        }).cropper(options);


        // Import image
        var $inputImage = $('#inputImage'),
                URL = window.URL || window.webkitURL,
                blobURL;

        if (URL) {
            $inputImage.change(function () {
                var files = this.files,
                        file;

                if (files && files.length) {
                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {
                        blobURL = URL.createObjectURL(file);
                        $image.one('built.cropper', function () {
                            URL.revokeObjectURL(blobURL); // Revoke when load complete
                        }).cropper('reset', true).cropper('replace', blobURL);
                        $inputImage.val('');
                    } else {
                        showMessage('Please choose an image file.');
                    }
                }
            });
        } else {
            $inputImage.parent().remove();
        }

    }());

});
