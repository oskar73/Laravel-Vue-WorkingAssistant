function setParam() {
    let ajax = {
        url: "/admin/contacts/get",
        type: "get"
    };

    let columns = [
        {data: 'first_name', name: 'first_name'},
        {data: 'last_name', name: 'last_name'},
        {data: 'email', name: 'email'},
        {data: 'subject', name: 'subject'},
        {data: 'date', name: 'date'},
        {data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 0);
}

$(function () {
    $('#contacts_table').DataTable(setParam());
});

let deleteUrl
$(document).on("click", '.delete-contact', function () {
    deleteUrl = $(this).data("url");
    askToast.question('Confirm', 'Do you really want to delete this contact?', 'deleteContact');
});

function deleteContact() {
    $('#delete_contact').attr('action', deleteUrl).submit();
}
