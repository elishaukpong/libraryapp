$(document).ready(function() {
    $('#img-select').click(function(e) {
        e.preventDefault();
        $('#book_avatar').trigger('click');
        showImage(src, target);
    });

    var src = document.getElementById("book_avatar");
    var target = document.getElementById("target");

    function showImage(src, target) {
        var fr = new FileReader();
        // when image is loaded, set the src of the image where you want to display it
        fr.onload = function(e) { target.src = this.result; };
        src.addEventListener("change", function() {
            // fill fr with image data
            fr.readAsDataURL(src.files[0]);
        });
    }

    $('.form-check input').click(function(e) {
        $this = $(this)[0];
        $parent = $(this).parent();

        if ($this.checked) {
            $parent.removeClass('border-secondary');
            $parent.removeClass('text-secondary');

            $parent.addClass('bg-success');
            $parent.addClass('text-white');
        } else {
            $parent.removeClass('bg-success');
            $parent.removeClass('text-white');

            $parent.addClass('border-secondary');
            $parent.addClass('text-secondary');

        }
    })

});