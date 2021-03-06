$(document).on('change', '#photo', function () {
    if ($(this).val().length) {
        $(".remove").removeClass('hidden');
    }
});

$(".remove").on('click', function () {
    $('#photo').val('');
    $(this).addClass('hidden');
})

$("#remove-image").on('click', function () {
    if (confirm('Are you sure?')) {
        $("#image-wrap").empty();
        $("#image-wrap").append('<input id="photo" class="form-control" type="file" name="photo" accept="image/*">');
        $("#image-wrap").append('<input type="hidden" name="image-deleted" value=true>');
    }
});

function confirmDelete() {
    return confirm("Are you sure you want to delete?");
}

function confirmResolve() {
    return confirm("Are you sure you want to resolve this gift?");
}
