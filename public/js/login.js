/******************************************************************************/
/******************************************************************************/

function submitContactForm()
{
	blockForm('login-form','block');
	$.post('/login',$('#login-form').serialize(),submitContactFormResponse,'json');
}

/******************************************************************************/

function submitContactFormResponse(response)
{
	blockForm('login','unblock');
	$('#login-name,#login-mail,#lsubmit').qtip('destroy');

	var tPosition=
	{
		'submit'			: {'my':'right center','at':'left center'},
		'login-mail'		: {'my':'bottom center','at':'top center'},
		'login-password'	: {'my':'bottom center','at':'top center'},
	};

	var error=false;

	if(typeof(response.info)!='undefined')
	{	
		if(response.info.length)
		{	
			for(var key in response.info)
			{
				error=error || response.error;

				var id=response.info[key].fieldId;
				$('#'+response.info[key].fieldId).qtip(
				{
						style:      { classes:(response.error==1 ? 'qtip-error' : 'qtip-success')},
						content: 	{ text:response.info[key].message },
						position: 	{ my:tPosition[id]['my'],at:tPosition[id]['at'] }
				}).qtip('show');				
			}

			window.setTimeout(
				function(){
					blockForm('login-form','unblock');
				},2000
			);
		}
	}

	if(!error) 
	{
		$('#login-mail,#login-password').val('').blur();
		window.setTimeout(function() { $('#submit').qtip('destroy'); window.location.href = '/profile/' +response.id},2000);
	}
}

/******************************************************************************/
/******************************************************************************/