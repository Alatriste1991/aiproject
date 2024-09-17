/******************************************************************************/
/******************************************************************************/

function submitGenerateFormReg()
{
    $("#images").fadeOut();
    $("hr").fadeOut();
    blockForm('image-generation','block');
    $.post('/generate',$('#image-generation').serialize(),submitGenerateFormResponseReg,'json');
}

/******************************************************************************/

function submitGenerateFormResponseReg(response)
{
    blockForm('image-generation','unblock');
    $('#reg-name,#reg-mail,#lsubmit').qtip('destroy');

    var tPosition=
        {
            'submit'			: {'my':'right center','at':'left center'},
            'generation-text'		: {'my':'bottom center','at':'top center'},
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
                    blockForm('image-generation','unblock');
                },2000
            );
        }
    }

    if(!error)
    {
        $('#generation-text').val('').blur();
        //window.setTimeout(function() { $('#submit').qtip('destroy'); window.location.href = '/image/'+response.id},2000);
        window.setTimeout(function() {
            $('#submit').qtip('destroy');
            $('#image_1').attr('src','data:image/png;base64,'+ response.id);
            $('#image_1_download').attr('href',response.url);
            $("#images").fadeIn(1800);
            $("hr").fadeIn(1800);
        },
        1000);
    }
}

/******************************************************************************/
/******************************************************************************/