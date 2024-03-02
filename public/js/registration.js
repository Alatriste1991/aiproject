/******************************************************************************/
/******************************************************************************/

function submitContactFormReg()
{
    blockForm('reg-form','block');
    $.post('/registration',$('#reg-form').serialize(),submitContactFormResponseReg,'json');
}

/******************************************************************************/

function submitContactFormResponseReg(response)
{
    blockForm('reg','unblock');
    $('#reg-name,#reg-mail,#lsubmit').qtip('destroy');

    var tPosition=
        {
            'submit'			: {'my':'right center','at':'left center'},
            'reg-username'		: {'my':'bottom center','at':'top center'},
            'reg-mail'		    : {'my':'bottom center','at':'top center'},
            'reg-password1'	    : {'my':'bottom center','at':'top center'},
            'reg-password2'	    : {'my':'bottom center','at':'top center'},
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
                    blockForm('reg-form','unblock');
                },2000
            );
        }
    }

    if(!error)
    {
        $('#reg-mail,#reg-username,#reg-password1,#reg-password2').val('').blur();
        window.setTimeout(function() { $('#submit').qtip('destroy'); window.location.href = '/profile/' +response.id},2000);
    }
}

/******************************************************************************/
/******************************************************************************/