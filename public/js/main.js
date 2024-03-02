
$(document).ready(function() 
{
	/**************************************************************************/
	/*	Template options													  */
	/**************************************************************************/
	
	var options=
	{
		supersized		:
		{
			slide		: 
			[
				{image	:	'/images/background/01.jpg'},
				{image	:	'/images/background/05.jpg'}
			]		
		},
		/*googleMap		:
		{
			coordinates	:	[53.276698,-6.12562]
		}*/
	}

	/**************************************************************************/
	/*	Forms																  */
	/**************************************************************************/

	$('#login-form').bind('submit',function(e)
	{
		e.preventDefault();
		submitContactForm();
	});

	$('#reg-form').bind('submit',function(e)
	{
		e.preventDefault();
		submitContactFormReg();
	});


	$('textarea').elastic();
	$('form label').inFieldLabels();
	

});