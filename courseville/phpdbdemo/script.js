$(document).ready(function () {
	$(".loader").hide();
	$(".btn").click(function () {
		var cmd = $(this).attr("data-cmd");
		if (cmd != undefined) {
			$("#result").html("");
			$(".loader").show();
			var url = 'process.php';
			var postData = {};
			postData.cmd = cmd;
			if (cmd == "add") {
				postData.firstname = $("#input-firstname").val().trim();
				postData.lastname = $("#input-lastname").val().trim();
			}
			$.ajax({
				method: "POST",
				url: url,
				data: postData
			}).done(function (jsonReturnData) { 
				// Result handler
				returnData = JSON.parse(jsonReturnData);
				$(".loader").hide();
				if (returnData.status == "error") {
					alert("Error");
				} else {
					updateResult(returnData.result);
					
				}
				appendHistory(returnData.q);
				appendMessage(returnData.msg);
			});
		}
	});
});
function updateResult(result) {
	$("#result").html(result);
}
function appendHistory(q) {
	for (var i = 0; i < q.length; i++) {
		$("#query-history").append("<div>" + q[i] + "</div>");
	}
}
function appendMessage(msg) {
	for (var i = 0; i < msg.length; i++) {
		$("#msg-history").append("<div>" + msg[i] + "</div>");
	}
}
