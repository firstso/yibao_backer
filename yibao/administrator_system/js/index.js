$(document).ready(function() {
	// $("a[href='features/goods.html']").click(function(event) {


	// 	htmlobj=$.ajax({
	// 		type: "POST",
	// 		url: "https://interface.fty-web.com/Goods/show_goods_by_content",
	//         data: {
	// 			"jwt":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzbm8iOjY3MTg2MDYsImV4cCI6MTUxMzcwMDA1Mn0.xD5MTPEIEZ0sHLUKbhHNQTjWRC6xyROQHp-8iDVhyDs",
	// 			"type":0,
	// 			"page":0
	// 	    },
	//         dataType: "jsonp",
	//         success: function (message) {
	//             alert(message);
	//         },
	//         error : function(error) {
	//         	alert("错误");
	//         }
	// 	});

	// });
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

});