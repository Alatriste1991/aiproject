/******************************************************************************/
/******************************************************************************/

function submitAddOrderFormReg()
{
    blockForm('buy-package-form','block');

    $.post('/add_order',$('#buy-package-form').serialize(),submitaddOrderFormResponseReg,'json');
}

/******************************************************************************/

function submitaddOrderFormResponseReg(response)
{
    blockForm('buy-package','unblock');
    $('#buy-package-id,#buy-package-name,#buy-package-country,#buy-package-county,#buy-package-code,#buy-package-city,#buy-package-address,#buy-package-payment-method,#lsubmit').qtip('destroy');

    var tPosition=
        {
            'submit'			: {'my':'right center','at':'left center'},
            'buy-package-name'		: {'my':'bottom center','at':'top center'},
            'buy-package-country'		    : {'my':'bottom center','at':'top center'},
            'buy-package-county'	    : {'my':'bottom center','at':'top center'},
            'buy-package-code'	    : {'my':'bottom center','at':'top center'},
            'buy-package-city'	    : {'my':'bottom center','at':'top center'},
            'buy-package-address'	    : {'my':'bottom center','at':'top center'},
            'buy-package-payment-method' : {'my':'bottom center','at':'top center'},
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
                    blockForm('buy-package-form','unblock');
                },2000
            );
        }
    }

    if(!error)
    {
        $('#buy-package-id,#buy-package-name,#buy-package-country,#buy-package-county,#buy-package-code,#buy-package-city,#buy-package-address,#buy-package-payment-method').val('').blur();
        window.setTimeout(function() { $('#submit').qtip('destroy'); window.location.href = '/profile/' + response.id},2000);
    }
}