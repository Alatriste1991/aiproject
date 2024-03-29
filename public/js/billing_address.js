/******************************************************************************/
/******************************************************************************/

function submitBillingDataFormReg()
{
    blockForm('add-billing-data-form','block');

    $.post('/add_billing_address',$('#add-billing-data-form').serialize(),submitBillingDataFormResponseReg,'json');
}

function submiteditBillingDataFormReg()
{
    blockForm('edit-billing-data-form','block');

    $.post('/edit_billing_address/'+$('#billing_data_id').val(),$('#edit-billing-data-form').serialize(),submiteditBillingDataFormResponseReg,'json');
}

/******************************************************************************/

function submitBillingDataFormResponseReg(response)
{
    blockForm('add-billing-data','unblock');
    $('#add-billing-data-name,#add-billing-data-country,#add-billing-data-county,#add-billing-data-code,#add-billing-data-city,#add-billing-data-address,#lsubmit').qtip('destroy');

    var tPosition=
        {
            'submit'			: {'my':'right center','at':'left center'},
            'add-billing-data-name'		: {'my':'bottom center','at':'top center'},
            'add-billing-data-country'		    : {'my':'bottom center','at':'top center'},
            'add-billing-data-county'	    : {'my':'bottom center','at':'top center'},
            'add-billing-data-code'	    : {'my':'bottom center','at':'top center'},
            'add-billing-data-city'	    : {'my':'bottom center','at':'top center'},
            'add-billing-data-address'	    : {'my':'bottom center','at':'top center'},
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
                    blockForm('add-billing-data-form','unblock');
                },2000
            );
        }
    }

    if(!error)
    {
        $('#add-billing-data-name,#add-billing-data-country,#add-billing-data-county,#add-billing-data-code,#add-billing-data-city,#add-billing-data-address').val('').blur();
        window.setTimeout(function() { $('#submit').qtip('destroy'); window.location.href = '/billing_address/' +response.id},2000);
    }
}

function submiteditBillingDataFormResponseReg(response)
{
    blockForm('edit-billing-data','unblock');
    $('#add-billing-data-name,#add-billing-data-country,#add-billing-data-county,#add-billing-data-code,#add-billing-data-city,#add-billing-data-address,#lsubmit').qtip('destroy');

    var tPosition=
        {
            'submit'			: {'my':'right center','at':'left center'},
            'add-billing-data-name'		: {'my':'bottom center','at':'top center'},
            'add-billing-data-country'		    : {'my':'bottom center','at':'top center'},
            'add-billing-data-county'	    : {'my':'bottom center','at':'top center'},
            'add-billing-data-code'	    : {'my':'bottom center','at':'top center'},
            'add-billing-data-city'	    : {'my':'bottom center','at':'top center'},
            'add-billing-data-address'	    : {'my':'bottom center','at':'top center'},
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
                    blockForm('add-billing-data-form','unblock');
                },2000
            );
        }
    }

    if(!error)
    {
        $('#add-billing-data-name,#add-billing-data-country,#add-billing-data-county,#add-billing-data-code,#add-billing-data-city,#add-billing-data-address').val('').blur();
        window.setTimeout(function() { $('#submit').qtip('destroy'); window.location.href = '/billing_address/' +response.id},2000);
    }
}
/******************************************************************************/
/******************************************************************************/