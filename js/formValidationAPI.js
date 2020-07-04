

/*
	for this function because the html have some kind of format 
	so we can user this
	<div>
		<label>...</label>
		<input >
	</div>

	div is setion 
	sectionErrormessage is a object something like 
	{
		valueMissing: "xxx",
		badInput: "xxx",
		tooShort: "xxx",
		tooLong: "xxx",
		typeMismatch: "xxx",
		patternMismatch: "xxx",
		rangeUnderflow: "xxx",
		rangeOverflow: "xxx"
	}
*/

function LberInputCheck(section, sectionErrorMessage, generalMessage)
{
	let sectionLabel = section.children[0];
	let settionInput = section.children[1];
	clearErrorMessage(sectionLabel, generalMessage);
	return h5Validation(settionInput, sectionLabel, sectionErrorMessage);
}


function h5Validation(input, messageContainer, errorMessageSet)
{

	let defaultErrorMessageSet = 
	{
		valueMissing: "you missing value here",
		badInput: "you input bad value",
		tooShort: "your input is too short",
		tooLong: "your input is too long",
		typeMismatch: "you input worng type",
		patternMismatch: "your partter is not match",
		rangeUnderflow: "value is too small",
		rangeOverflow: "value is too large"
	};


	let validity = input.validity;

	console.log(validity);

	let errorMessage = "";

	if(validity.valueMissing)
	{
		if(typeof(errorMessageSet.valueMissing) == "undefined")
			createErrorMessage(messageContainer, defaultErrorMessageSet.valueMissing);
		else
			createErrorMessage(messageContainer, errorMessageSet.valueMissing);
		return false;
	}

	if(validity.badInput)
	{
		if(typeof(errorMessageSet.badInput) == "undefined")
			createErrorMessage(messageContainer, defaultErrorMessageSet.badInput);
		else
			createErrorMessage(messageContainer, errorMessageSet.badInput);
		return false;
	}

	if(validity.tooShort)
	{
		if(typeof(errorMessageSet.tooShort) == "undefined")
			createErrorMessage(messageContainer, defaultErrorMessageSet.tooShort);
		else
			createErrorMessage(messageContainer, errorMessageSet.tooShort);
		return false;
	}

	if(validity.tooLong)
	{
		if(typeof(errorMessageSet.tooLong) == "undefined")
			createErrorMessage(messageContainer, defaultErrorMessageSet.tooLong);
		else
			createErrorMessage(messageContainer, errorMessageSet.tooLong);
		return false;
	}

	if(validity.typeMismatch)
	{
		if(typeof(errorMessageSet.typeMismatch) == "undefined")
			createErrorMessage(messageContainer, defaultErrorMessageSet.typeMismatch);
		else
			createErrorMessage(messageContainer, errorMessageSet.typeMismatch);
		return false;
	}

	if(validity.patternMismatch)
	{
		if(typeof(errorMessageSet.patternMismatch) == "undefined")
			createErrorMessage(messageContainer, defaultErrorMessageSet.patternMismatch);
		else
			createErrorMessage(messageContainer, errorMessageSet.patternMismatch);
		return false;
	}

	return true;
}


function createErrorMessage(messageContainer, message)
{
	errorMessage = message;
	messageContainer.innerHTML += "  " + errorMessage;
	messageContainer.className = "errorMessage";
}



function clearErrorMessage(label, message)
{
	label.innerHTML = message;
	label.className = "";
}