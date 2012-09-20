$(function() {

	var docWidth = $(document).width();
	var docHeight = $(document).height();
	
	$('#nav li').click(function() {
		top.window.location = '/index.php?p='+$(this).attr('id');
	});

	$('.pic').fancybox(); // Fancybox All Gallery Images

	/**********************************************/
	/*
		Login and Register Modal's
	*/
	/*////////////////////////////////////////////*/
	$('#login-box a.modal_link').click(function() {
		var ele = $(this).attr('href');
		if(ele == '#login_modal') {
			$('#register_modal').hide();
			if($('#login_modal').is(':visible')) {
				for(var i = 0; i < 2; i++) {
					$('#login_modal').animate({'left': '+=10px'}, 'fast').animate({'left': '-=10px'}, 'fast');
				}
			}
		} else {
			$('#login_modal').hide();
		}

		$(ele).show();

		return false;
	});

	$('.close a').click(function() {
		$(this).parent().parent('div').hide();
	});

	$('.modal input').focus(function() {
		$(this).val('').css('color','#000');
	});

	$('.modal input').blur(function() {
		if($(this).val() == '') {
			var ele = $(this).attr('id');
			switch(ele)
			{
				case 'user_email':
					$(this).val('E-Mail Address').css('color','#c0c0c0');
				break;

				case 'user_password':
					$(this).val('Password').css('color','#c0c0c0');
				break;

				case 'register_email':
					$(this).val('E-Mail Address').css('color','#c0c0c0');
				break;

				case 'register_password':
					$(this).val('Password').css('color','#c0c0c0');
				break;

				case 'photo_title':
					$(this).val('Photo Caption').css('color', '#c0c0c0');
				break;
			}
		}
	});

	$('#login_form').ajaxForm({
		dataType: 'json',
		type: 'POST',
		success: function(res) {
			console.log(res);
			if(res.status == 'success') {
				window.location.reload(true);
			} else if (res.status == 'fail') {
				var ele = $('.error');
				for(error in res.errors) {
					ele.appendTo(error);
				}
			}
		}
	});

	/**** END LOGIN AND REGISTER MODALS ****/

	// EDIT LINKS FOR EDIT MODAL
	$('.edit_link').click(function() {
		var	myWidth		= $('#edit_modal').width(),
			myHeight	= $('#edit_modal').height(),
			myOffset	= $(this).offset(),
			thisY		= myOffset.top,
			thisX		= myOffset.left,
			id		= $(this).attr('id');

		id = id.substr(5);
		$('#edit_modal #photo_id').val(id); 

		if((thisX + myWidth) >= docWidth - 50) {
			thisX = thisX - myWidth - 5;
			$('#edit_modal').css({'left': thisX + 'px'});
		} else {
			$('#edit_modal').css({'left': thisX + 30 + 'px'});
		}

		if((thisY + myHeight) >= docHeight) {
			thisY = thisY - myHeight;
			$('#edit_modal').css({'top': thisY + 'px'});
		} else {
			$('#edit_modal').css({'top': thisY + 'px'});
		}

		$('#edit_modal').show();

		return false;
	});

	// EDIT FORM SUBMISSION
	$('#edit_form').ajaxForm({
		dataType: 'json',
		type: 'POST',
		success: function(res) {
			if(res.status == 'success') {

			} else {

			}
		}
	});
});
	
function safe(s) {
	return s.replace(/&/g, '&amp;').replace(/>/g, '&gt;').replace(/</g, '&lt;');
}
