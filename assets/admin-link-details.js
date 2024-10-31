function initializeColorPicker() {
    jQuery('.color-picker').wpColorPicker();
}

function initializeCoverImagePicker() {
    jQuery('#select-cover-image').on('click', function (e) {
        e.preventDefault();
        const imageFrame = wp.media({
            title: 'Select or Upload Cover Image',
            button: {text: 'Use this image'},
            multiple: false
        });
        imageFrame.on('select', function () {
            const attachment = imageFrame.state().get('selection').first().toJSON();
            jQuery('#cover_image_id').val(attachment.id);
            jQuery('#cover-image-preview').html('<img src="' + attachment.sizes.thumbnail.url + '"  alt=""/>');
        });
        imageFrame.open();
    });
}

jQuery(document).ready(function () {
    initializeColorPicker();
    initializeCoverImagePicker();
});