
let ErrorMessage = 
[
	// first name
	{
		valueMissing: "empty??",
	},

	// last name
	{
		valueMissing: "empty??",
	},

	// age
	{
		valueMissing: "empty??",
		rangeUnderflow: "too old?",
		rangeOverflow: "too young?"
	},

	// birth date
	{
		valueMissing: "empty??",
	},

	// email 
	{
		patternMismatch: "this is not a correct email format",
	},

	// phone
	{
		valueMissing: "you must input your phone",
		badInput: "come on you need number here",
		tooShort: "Hey, at least 8 digit",
		tooLong: "too many digit"
	},

	// user name 
	{
		valueMissing: "user name can not be empty",
		tooShort: "you user name have least 1 letter",
		tooLong: "user name should bot be longer than 20 letters"
	},

	// password
	{
		valueMissing: "password can not be empty",
		tooShort: "password must have at least 3 letters",
		tooLong: "password should bot be longer than 20 letters"
	},

	// confirm password
	{
		valueMissing: "you need to comfirm your password",
		tooShort: "password must have at least 3 letters",
		tooLong: "password should bot be longer than 20 letters"
	}
]







$(function()
{
	let form = document.querySelector("form");

	let checkPersonal = true;

	let generalMessage = [];

	let formInputSections = [];	// array for form input div section

	let personalSection = form.children[1];	// div persional class

	let inputValidation = [];	// array with boolean for checking input validation

	// init above array

	for(let i = 0; i < personalSection.children.length; i++)
	{
		formInputSections.push(personalSection.children[i]);

		// store peronal input section label value
		generalMessage.push(personalSection.children[i].children[0].innerHTML);

		// if we need to check personal section like if user have account already
		if(checkPersonal)
			inputValidation.push(false);
		else
			inputValidation.push(true);
	}


	// start at 1 because ignor persional section
	for(let i = 2; i < form.children.length - 1; i++) // -1 for ignor button
	{
		formInputSections.push(form.children[i]);

		// store input section value
		generalMessage.push(form.children[i].children[0].innerHTML);
	}

	// finish init array 



	$("#hasAccount").on("change", function()
	{
		let option = $(this).val();
		if(option == "yes")
		{
			checkPersonal = false;
			$(".personalInformation input").attr("disabled", "disabled");
		}
		else
		{
			checkPersonal = true;
			$(".personalInformation input").removeAttr("disabled");
		}
	});



	$("form .loginButton").on("click", function()
	{
		resetForm();

		let isValide = true;

		for(let i = 0; i < formInputSections.length; i++)
		{
			// if donot need to check personal section
			if(i == 0 && !checkPersonal)	
			{
				i = personalSection.length - 1;
				continue;
			}

			// use api to check then store in inputValidation
			inputValidation[i] = LberInputCheck(formInputSections[i], ErrorMessage[i], generalMessage[i]);
		}

		// checking in here
		for(let i = 0; i < inputValidation.length; i++)
		{
			if(inputValidation[i] == false)
			{
				isValide = false;	// not return because we want final check
				break;
			}
		}

		//comfirm password
		if(!finalCheck())
			isValide = false;

		if(!isValide)
			return;

		// if pass checking
		form.submit();
	});

	
});


// the below should be a pair


function resetForm()
{
	// this should be only comfirm password 
	// the rest reset in APU

	$(".confirmPassword label").html("comfirm password:");
	$(".confirmPassword label").toggleClass("errorMessage");

}


function finalCheck()
{
	console.log("compare password")
	if($(".password input").val() !== $(".confirmPassword input").val())
	{
		console.log("enter no equal");
		$(".confirmPassword label").html("comfirm password: you enter a different passowrd");
		$(".confirmPassword label").toggleClass("errorMessage");
		return false;
	}

	return true;
}