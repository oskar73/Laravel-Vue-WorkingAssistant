var page = 1;
$(document).ready(function() {
    getReplies();
});
function getReplies()
{
    $('.item_result').load(`/account/ticket/reply/${item_id}`);
}
$(document).on('click', '.pagination_area .pagination a', function(e){
    e.preventDefault();
    $('.item_result').load($(this).attr("href"));
});

