document.addEventListener("DOMContentLoaded", function () {
	var eventCalllback = function (e) {
		var el = e.target,
			clearVal = el.dataset.phoneClear,
			pattern = el.dataset.phonePattern,
			matrix_def = "+7 (___) ___-__-__",
			matrix = pattern ? pattern : matrix_def,
			i = 0,
			def = matrix.replace(/\D/g, ""),
			val = e.target.value.replace(/\D/g, "");
		if (clearVal !== 'false' && e.type === 'blur') {
			if (val.length < matrix.match(/([\_\d])/g).length) {
				e.target.value = '';
				return;
			}
		}
		if (def.length >= val.length) val = def;
		e.target.value = matrix.replace(/./g, function (a) {
			return /[_\d]/.test(a) && i < val.length ? val.charAt(i++) : i >= val.length ? "" : a
		});
	}
	var phone_inputs = document.querySelectorAll('[data-phone-pattern]');
	for (let elem of phone_inputs) {
		for (let ev of ['input', 'blur', 'focus']) {
			elem.addEventListener(ev, eventCalllback);
		}
	}
});



function validate_form ( )
{
	valid = true;

        if ( document.contact_form.phone.value == "" )
        {
                alert ( "Пожалуйста заполните поле 'Телефон'." );
                valid = false;
        }

        return valid;
}

function validate_form_pc ( )
{
	valid = true;

        if ( document.contact_form_pc.phone.value == "" )
        {
                alert ( "Пожалуйста заполните поле 'Телефон'." );
                valid = false;
        }

        return valid;
}




