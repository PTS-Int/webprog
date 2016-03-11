$(document).ready(function(){
	$(".dbDemo-submit-button").click(clickDbDemoSubmit);	
});

function clickDbDemoSubmit(){
	var formId = $(this).closest(".dbDemo-student-form").attr('id');
	var numError = 0;
	$("#"+formId+" .non-blank").each(function(){
		$(this).css("background-color","white");
		var value = $(this).val().trim();
		if(value==""){
			$(this).css("background-color","#ffa4c8");
			numError++;
		}
	});
	if(numError==0){
		$("#"+formId).submit();
	}else{
		alert("Some required values are left blank.");
	}
}