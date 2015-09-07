;jQuery(function($) {

	// Popups
	$.extend($.fancybox.defaults, {
		title: null,
		padding: [15, 80, 15, 80],
		width: 350,
		arrows: false,
		closeBtn: false,
		helpers: {
			overlay: {
				locked: false
			}
		}
	});
	$('.fancybox').fancybox();

	$('.photos__item a').fancybox({
        type: 'ajax'
    });
	$('body').on('click', '.popup__close', function() {
		$.fancybox.close();
	});

	// Forms validation
	$.validator.setDefaults({
		highlight: function(element) {
			$(element).addClass('form__error');
		},
		unhighlight: function(element) {
			$(element).removeClass('form__error');
		},
		errorPlacement: function(error, element) {
			if($(element).is('input, textarea')) {
				error.appendTo(element.parent());
			} else if($(element).is('select')) {
				error.appendTo(element.prev());
			}
		}
	});

	function FormValidation(formID) {
		if($(formID).length) {
			var validationRules = {};
			if ($(formID)[0].nodeName.toLowerCase() === 'form') {
				var form = $(formID);
			} else {
				var form = $(formID).closest('form');
			}
			$(form).attr('novalidate', true).find('[required]').each(
				function(index, elem) {
					var name = $(elem).attr('name');
					if(($(elem).attr('type') === 'email' || $(elem).attr('name')) === 'email') {
						validationRules[name] = {
							required : true,
							email : true
						};
					} else if ($(elem).attr('multiple')) {
						validationRules[name] = {
							required : true,
							minlength: 1
						};
					}
					else {
						validationRules[name] = {required : true};
					}
				}
			);
			$(form).validate({
				rules : validationRules
			});
		}
	}
	$('form').each(
		function() {
			new FormValidation(this);
		}
	);

	// Load more
	function LoadMore(container) {
		var container = $(container);
		var list = container.find('ul');
		container.on('click', '.load-more', function(e) {
			e.preventDefault();
			var loadMore = $(this);
			var text = $(this).text();
			loadMore.addClass('active').text('Loading');
			$.ajax({
				url: loadMore.attr('href'),
				data: {
					'pages': container.find('li').length
				},
				type: 'get',
				dataType: 'html',
				cache: false,
				success: function(data) {
					list.append(data);
				},
				error: function() {

				},
				complete: function() {
					loadMore.removeClass('active');
					loadMore.text(text);
				}
			});
		});
	}
	$('.pagination').each(
		function() {
			new LoadMore(this);
		}
	);

	// File upload
	$('.input__file input').on('change', function() {
		var input = this;
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				//$('.input__file-name').html(input.files[0].name);
				//$('.input__file-image').html('<img src="' + e.target.result + '">')
			};
			reader.readAsDataURL(input.files[0]);
		}
	});

	// Buy tickets
	$('.buy-tickets').each(function() {
		var button = $(this).find('.buy-tickets__button'),
			form = $(this).find('.buy-tickets__form');
		button.on('click', function(e) {
			if(!form.hasClass('active')) {
				e.preventDefault();
				form.addClass('active').animate({'height' : 'show', 'opacity' : 'show'}, 200);
			}
		});
	});

	// Input number
	$('.input__number').each(function() {
		var container = $(this),
			input = container.find('input');
		container.on('click', '.input__number-control', function() {
			var val = parseInt(input.val());
			if($(this).hasClass('input__number-control--minus') && val != 0) {
				input.val(val-1);
			} else if ($(this).hasClass('input__number-control--plus')) {
				input.val(val+1);
			}
		});
		input.on('keypress', function(e) {
			return e.charCode >= 48 && e.charCode <= 57
		})
	});

	// Dashboard
	$('.dashboard__list').on('click', '.dashboard__title', function() {
		$(this).closest('.dashboard__item').toggleClass('active');
	});
	$('.modalButton').click(function () {
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
	});
});

function submitFormMoreTime($form) {
	$.post(
		$form.attr("action"), // serialize Yii2 form
		$form.serialize()
	)
		.done(function (result) {
			$("#modal").modal("show")
				.find("#modalContent").html(result);
		})
		.fail(function () {
			console.log("server error");
			$form.replaceWith("<button class=\'newType\'>Fail</button>").fadeOut()
		});
	return false;
}