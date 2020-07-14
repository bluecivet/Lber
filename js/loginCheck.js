$(function()
{
	let form = document.querySelector("form");

	let userErrorMessage = 
	{
		valueMissing: "user name can not be empty",
		tooShort: "you user name have least 1 letter",
		tooLong: "user name should bot be longer than 20 letters"
	};

	let passwordErrorMessage = 
	{
		valueMissing: "password can not be empty",
		tooShort: "password must have at least 3 letters",
		tooLong: "password should bot be longer than 20 letters"
	};



	$("form .loginButton").on("click", function()
	{
		
		let userSection = document.querySelector(".userName");
		let passwordSection = document.querySelector(".password");

		let userPass = LberInputCheck(userSection, userErrorMessage, "user:");
		let passwordPass = LberInputCheck(passwordSection, passwordErrorMessage, "password:");

		if(!userPass || !passwordPass)
		{
			return;
		}

		submitLoginForm(form);
	});


});


function submitLoginForm(form)
{
	let url = "";
	if(form.id == "userLoginForm")
		url = "php/login/userLogin.php";
	else if(form.id == "driverLoginForm")
		url = "php/login/driverLogin.php";

	let formData = new FormData(form);
	$.ajax(
	{
		type: "POST",
		url: url,
		data: formData,
		processData: false,
		contentType: false,
		error: function(response)
		{
			console.log(response);
		},

		success: function(response)
		{
			if(response == "good")
			{
				if(form.id == "userLoginForm")
					window.location.replace("./html/userPanel.html");
				else if(form.id == "driverLoginForm")
					window.location.replace("./html/driverPanel.html");
				return;
			}

			// if for submit not success will return error message
			try
			{
				let errObj = JSON.parse(response);

				for(key in errObj)
				{
					let labelClass = "." + key + " label";
					$(labelClass).html(errObj[key]);
					$(labelClass).toggleClass("errorMessage");
				}
			}
			catch(e)
			{
				console.log(response);
			}

		}
	});
}