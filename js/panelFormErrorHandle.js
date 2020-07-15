
let personalSettingErrorMessage = 
[
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


//-----------------------------------------------------------------------------



let bankingErrorMessage = 
[
	// adding value
	{
		valueMissing: "empty??",
		rangeUnderflow: "value can not be less then 0"
	},

	// credit card number
	{
		valueMissing: "empty??",
		tooShort: "you must input 12-20 digit",
		tooLong: "you must input 12-20 digit"
	}
]


//-----------------------------------------------------------------------------


let placeOrderErrorMessage = 
[
	// order name
	{
		tooLong: "order name cannot input more than 10 words"
	},

	// carrying
	{
		valueMissing: "carrying cannot be empty"
	},

	// delivery date
	{
		valueMissing: "delivery date cannot be empty"
	},

	// from city
	{
		valueMissing: "you missing you are from what city"
	},

	// from address
	{
		valueMissing: "you missing where you are"
	},

	// to city
	{
		valueMissing: "you missing you are to what city"
	},

	// to address
	{
		valueMissing: "you missing where you are going to"
	},

	// description
	{}
]


//-----------------------------------------------------------------------------


function CheckUtil(form, errorMessageSet)
{
	this.form = form;
	this.errorMessageSet = errorMessageSet;
	this.generalMessage = []; 	// before showing error what to show in normal state
	this.formInputSections = [];		// array for form input div section
	this.inputValidation = [];	// bool array with boolean for checking input validation
	this.initCheckingSection();
}


CheckUtil.prototype = 
{
	constructor: CheckUtil,

	initCheckingSection: function()
	{
		// start at 1 because ignor persional section
		for(let i = 0; i < this.form.children.length - 1; i++) // -1 for ignor button
		{
			this.formInputSections.push(this.form.children[i]);

			// store input section value
			this.generalMessage.push(this.form.children[i].children[0].innerHTML);
		}
	},

	validationCheck: function()
	{
		for(let i = 0; i < this.formInputSections.length; i++)
		{
			// use api to check input validation then store in inputValidation
			this.inputValidation[i] = LberInputCheck(this.formInputSections[i], this.errorMessageSet[i], this.generalMessage[i]);
		}

		// checking input validation array in here
		for(let i = 0; i < this.inputValidation.length; i++)
		{
			if(this.inputValidation[i] == false)
			{
				return  false;	// not return because we want final check
			}
		}

		return true;
	},

	// different from above is I use more lower level api not LberInputCheck()
	validationH5: function(messageContainers)
	{
		for(let i = 0; i < this.formInputSections.length; i++)
		{
			// use api to check input validation then store in inputValidation
			let input = this.formInputSections[i].children[1];
			this.inputValidation[i] = h5Validation(input, messageContainers[i], this.errorMessageSet[i]);
		}

		// checking input validation array in here
		for(let i = 0; i < this.inputValidation.length; i++)
		{
			if(this.inputValidation[i] == false)
			{
				return  false;	// not return because we want final check
			}
		}

		return true;
	}
}



//-----------------------------------------------------------------------------



$(function()
{
	// inital place order error box 
	$(".errorMessageBox").hide();
	let placeOrderMessageBox = document.querySelector(".errorMessageBox ul");
	initPlaceOrderErrorMessageBox(placeOrderMessageBox);

	let placeOrderForm = document.querySelector(".placeOrder .placeOrderForm");
	let placeOrderCheckUtil = new CheckUtil(placeOrderForm, placeOrderErrorMessage);

	$(".placeOrder .placeOrderButton").on("click", function()
	{
		let isValide = placeOrderCheckUtil.validationH5(placeOrderMessageBox.children);
		if(!isValide)
		{
			$(".errorMessageBox").show();
			return;
		}
		
		placeOrderFormSubmit(placeOrderForm);
	});

//----------------------------------------------------------------------------


	// personal setting section
	let personalSettingform = document.querySelector(".personalSetting form");

	let personalCheckUtil = new CheckUtil(personalSettingform, personalSettingErrorMessage);


	$(".personalSetting form .doneButton").on("click", function()
	{
		resetForm();
		let isValide = true;
		isValide = personalCheckUtil.validationCheck();

		//comfirm password
		if(!finalCheck())
			isValide = false;

		if(!isValide)
			return;

		// if pass checking
		personalSettingform.submit();
	});

//----------------------------------------------------------------------------

	// banking setting
	let bankingform = document.querySelector(".banking form");
	
	let bankingCheckUtil = new CheckUtil(bankingform, bankingErrorMessage);

	$(".banking form .addValueButton").on("click", function()
	{
		let isValide = bankingCheckUtil.validationCheck();
		if(!isValide)
			return;
		bankingform.submit();
	});


});




//-----------------------------------------------------------------------------




function initPlaceOrderErrorMessageBox(ul)
{

	// find out how many element in the form
	// -1 is ignoring the button
	let n = document.querySelector(".placeOrderForm").children.length - 1;

	// creating enough li element 
	for(let i = 0; i < n; i++)
	{
		let li = document.createElement("li");
		li.className = "errorMessage";
		ul.appendChild(li);
	}
}



//-----------------------------------------------------------------------------


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