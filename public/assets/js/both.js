$(document).on('click', ".tab-link", function() {
    var hash = this.hash;
    hashUpdate(hash);
});
function hashUpdate(hash) {
    if(hash!=='')
    {
        var a = hash.split("/");
        $(".tab-link").removeClass("tab-active");
        $(".tab_area").removeClass("area-active");
        $('.tab-link[data-area="'+a[0]+a[1]+'"]').addClass("tab-active");
        $(a[0]+a[1]+"_area").addClass("area-active");
        if(a[2]==null)
        {
            $(a[0]+a[1]+"_area").addClass("area-active");
        }else {
            $('.tab-link[data-area="'+a[0]+a[1]+a[2]+'"]').addClass("tab-active");
            $(a[0]+a[1]+a[2]+"_area").addClass("area-active");
        }
    }
}

jQuery('.tipso1').tipso({
    useTitle: false,
    width:'150',
    tooltipHover: true,
    background: '#000',
});
jQuery(".tipso2").tipso({
    speed             : 400,
    background        : '#000',
    titleBackground   : '#86bc42',
    color             : '#ffffff',
    titleColor        : '#ffffff',
    titleContent      : '',
    size: 'default',
    showArrow         : true,
    position: 'top',
    width: '300',
    maxWidth          : '350',
    delay             : 200,
    hideDelay         : 0,
    animationIn       : '',
    animationOut      : '',
    offsetX           : 0,
    offsetY           : 0,
    tooltipHover      : true,
    content           : null,
    ajaxContentUrl    : null,
    contentElementId  : null,
    useTitle          : false,
    templateEngineFunc: null,
    onBeforeShow      : null,
    onShow            : null,
    onHide            : null
});

function dispErrors($errors)
{
    for(var key in $errors)
    {
        var error = $errors[key];
        itoastr('error', error);
    }
}
function dispValidErrors(message)
{
    $.each(message, function(index, item) {
        $(".error-"+index).html(item);
    });
}

function itoastr(title,message,type=null){
    if(type==null)
    {
        type=title.toLowerCase();
    }
    if(type == 'info') {
        iziToast.info({
            title: title,
            message: message,
            position: 'topCenter',
        });
    }else if(type == 'error'){
        iziToast.error({
            title: title,
            message: message,
            position: 'topCenter',
        });
    }
    else if(type == 'success'){
        iziToast.success({
            title: title,
            message: message,
            position: 'topCenter',
        });
    }
}

const askToast = {

    info:function(title, msg, action)
    {
        var obj = setObj(title, msg, action);
        iziToast.info(obj);
    },
    success:function(title, msg, action)
    {
        var obj = setObj(title, msg, action);
        iziToast.success(obj);
    },
    question:function(title, msg, action)
    {
        var obj = setObj(title, msg, action);
        iziToast.question(obj);
    },
    error:function(title, msg, action)
    {
        var obj = setObj(title, msg, action);
        iziToast.error(obj);
    },
}

function setObj(title, msg, action)
{
    return {
        timeout: 20000,
        close: false,
        overlay: true,
        displayMode: 'once',
        id: 'question',
        zindex: 999,
        message:msg,
        title:title,
        position: 'center',
        buttons:[
            ['<button><b>YES</b></button>', function (instance, toast) {

                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                window[action]();
            }, true],
            ['<button>NO</button>', function (instance, toast) {

                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

            }],
        ],
    }
}

function pickDate(picked, period)
{
    var result = [];
    var start = 0;
    var end = 0;
    if(period===365) {
        start = moment(picked).startOf('year');
        end = moment(picked).endOf('year');
    }else if(period===180) {
        var month = moment(picked).month();
        if(month<3)
        {
            start = moment(picked).startOf('year');
            end = moment(picked).add(3, 'M').endOf('quarter');
        }else if(month<6) {
            start = moment(picked).startOf('year');
            end = moment(picked).endOf('quarter');
        }else if(month<9) {
            start = moment(picked).startOf('quarter');
            end = moment(picked).endOf('year');
        }else {
            start = moment(picked).sub(3, 'M').startOf('quarter');
            end = moment(picked).endOf('year');
        }
    }else if(period===90) {
        start = moment(picked).startOf('quarter');
        end = moment(picked).endOf('quarter');
    }else if(period===30)
    {
        start = moment(picked).startOf('month');
        end = moment(picked).endOf('month');
    }else if(period===14)
    {
        var weeknumber = moment(picked).week();
        if(isEven(weeknumber))
        {
            start = moment(picked).weekday(-7);
            end = moment(picked).endOf('week');
        }else {
            start = moment(picked).startOf('week');
            end = moment(picked).weekday(13);
        }

    }else if(period===7)
    {
        start = moment(picked).startOf('week');
        end = moment(picked).endOf('week');
    }else if(period===1)
    {
        start = moment(picked);
        end = moment(picked);
    }
    result[0] = start.format('YYYY-MM-DD');
    result[1] = end.format('YYYY-MM-DD');

    return result;
}

function isEven(value) {
    if (value%2 === 0)
        return true;
    else
        return false;
};

function clearError()
{
    $(".form-control-feedback").html("");
}
function btnLoading(object='.smtBtn')
{
    $(object).append(" <i class='fa fa-spinner fa-spin loading_div'></i>").attr("disabled", true);
}
function btnLoadingStop(object='.smtBtn')
{
    $(object).attr("disabled", false);
    $(object).find(".loading_div").remove();
}
function redirectAfterDelay(url)
{
    setTimeout(function() {
        window.location.href=url
    }, 1000);
}
function reloadAfterDelay(url)
{
    setTimeout(function() {
        window.location.reload();
    }, 1000);
}
function roundFloat(num)
{
    return Math.round((num + Number.EPSILON) * 100) / 100;
}
