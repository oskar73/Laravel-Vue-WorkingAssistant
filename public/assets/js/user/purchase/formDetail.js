
var fbRenderOptions = {
    container: false,
    dataType: 'json',
    formData: formData,
    render: true,
}

$('#build-wrap').formRender(fbRenderOptions);

if(result!=null&&result!=='')
{
    var formResult = JSON.parse(result);
    for(let field in formResult)
    {
        $('[name="'+field+'"]').val(formResult[field]);
    }
}
