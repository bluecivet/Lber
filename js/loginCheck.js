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

		form.submit();
	});

	


	
});