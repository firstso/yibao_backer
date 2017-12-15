$(document).ready(function() {
	$("button").click(function(event) {
		var username = $("input[name='login_username']").val();
		var password = $("input[name='login_password']").val();
		if (username == '' || password == '') {
			$(".alert").removeClass('hide');
			$(".alert").addClass('show');
			$("p").html("用户名或密码不能为空");
			return false;
		}else if (username.length < 3) {
			$(".alert").removeClass('hide');
			$(".alert").addClass('show');
			$("p").html("用户名不能小于3位");
			return false;
		}
	});


	//上一页
	$("#previous").click(function(event) {
		if ($("#page").val() > 0) {
			var page = $("#page").val();
			page = parseInt(page) - 1;
			$("#page").val(page);
		}
		if ($("#page").val() == 0) {
			$("#previous").parent().addClass('disabled');
		}
	});
	//下一页
	$("#next").click(function(event) {
		var page = $("#page").val();
		page = parseInt(page) + 1;
		$("#page").val(page);

		if ($("#page").val() != 0) {
		$("#previous").parent().removeClass('disabled');
	}
	});
	//判断是否为第一页
	if ($("#page").val() <= 0) {
		$("#previous").parent().addClass('disabled');
	}

});