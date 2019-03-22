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

    $('#delete_library').click(function(e) {
        e.preventDefault()
        $('#delete_library_form').submit();
    })

    // return book
    $('.return-book').click(function(e) {
        e.preventDefault();

        swal({
            title: "Are you sure you want to return this book?",
            icon: "info",
            buttons: ["Cancel", "Proceed"],
        }).then((willReturn) => {
            if (willReturn) {
                next = $(this).next('.collapse')[0];
                next.click();
            }
        });

    })

    $('.search').click(function(e) {
        e.preventDefault()
        searchType = e.target.dataset.id;
        searchFormElementContainer = $('.collapse');
        searchFormElement = $('#inlineFormInputGroupUsername');

        setupSearchFormOption(searchType, searchFormElement);
        parent = $(this).parent().parent();
        parent.slideUp();
        searchFormElementContainer.delay(400).fadeIn();
    });

    function setupSearchFormOption(searchType, searchTarget) {
        switch (searchType) {
            case 'library':
                searchFormSetup('Library', searchTarget);
                break;
            case 'section':
                searchFormSetup('Section', searchTarget);
                break;
            case 'book':
                searchFormSetup('Book', searchTarget);
                break;
            default:
                break;
        }
    }

    function searchFormSetup(option, searchTarget) {
        message = 'Enter ' + option + ' name or ID';
        searchTarget.attr('placeholder', message);

        form = $('#searchForm');
        console.log(form);
        route = '/search/' + option.toLowerCase();

        $('#searchForm').attr('action', route);
    }

    $('.search-append').click(function() {
        $('#searchForm').submit();
    })

    $('#searchForm').submit(function(e) {
        if ($('#inlineFormInputGroupUsername').val() == ' ' || $('#inlineFormInputGroupUsername').val() == "") {
            return false;
        }
    });

});