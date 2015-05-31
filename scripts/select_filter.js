/**
 * 
 */

$('#id_subject').on('change', function(){
	
	var filter = $(this).val();
	if(filter == 0){
		filter = "";
	}
	$.ajax({
		url: "filter.php",
		data: {
			filter: filter
		},
		dataType: 'json'
	})
	.done(function( data ) {
		$('#id_book').html('');
		for(key in data){
			$('#id_book').append('<option value="'+data[key]['id']+'">'+data[key]['titulo']+'</option>');
		}
		
	});

});