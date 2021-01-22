$(document).ready(function() {
    $.ajax({
        url:"/admin/getTodoCount",
        success: function(result)
        {
            console.log(result)
            if(result.status===1)
            {
                if(result.data!=0)
                {
                    $(".sidebar_todo_count").show().html(result.data);
                }else {
                    $(".sidebar_todo_count").hide().html("");
                }
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
})
