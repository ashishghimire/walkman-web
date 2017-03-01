$('#photo').on('change', function(){
	if($(this).val().length) {
		$(".remove").removeClass('hidden');
	}
});

$(".remove").on('click', function(){
	$('#photo').val('');
	$(this).addClass('hidden');
})
