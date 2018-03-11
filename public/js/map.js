$('g').click(function(){
	$('#commentbox').hide().html('').slideDown('slow').css('display','block').append('Sumqayıt<hr>Rəsulzadə pros.4');
	//var regionID = ($(this).attr('id'));
});
$('g').mouseout(function(){
	$('#commentbox').slideUp('slow');
});