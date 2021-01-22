$(document).ready(function() {
    getTodos();
});
function getTodos(url=`/account/todo/${type}?page=1`)
{
    $.ajax({
        url:url,
        type:"get",
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success:function(result)
        {
            console.log(result);
            if(result.status===1)
            {
                $(".result_area").html(result.data);
            }
        }

    });
}
$(document).on('click', '.pagination a', function(e){
    e.preventDefault();
    getTodos($(this).attr("href"));
});
