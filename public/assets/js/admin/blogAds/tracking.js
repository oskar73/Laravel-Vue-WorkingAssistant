
var table1;

$(function () {
    hashUpdate(window.location.hash);
    $(".select_picker").selectpicker();
    table1 = $('.datatable-all').DataTable(setParam());
    getChatData();
});
$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(table1.ajax.json().recordsTotal)
});
function setParam()
{
    let ajax = {
        url:"/admin/blogAds/listing/tracking/"+listing_id,
        type:"get",
    };

    let columns=[
        { data: 'created_at', name: 'created_at'},
        { data: 'ip', name: 'ip'},
        { data: 'device', name: 'device' },
    ];

    return setTbl(ajax, columns, 0, false);
}

function getChatData()
{
    $.ajax({
        url:"/admin/blogAds/listing/getChart/"+listing_id,
        success:function(result) {
            console.log(result)
            if(result.status===1)
            {
                if(result.data!=null)
                {
                    renderChart(result.data);
                    $(".loading_div").hide();
                }
            }else {
            }
        },
        error:function(err) {
            console.log(err)
        }
    });
}
function renderChart(data)
{
    var dateArea = $("#dateChart").get(0).getContext("2d");
    var areaChart = new Chart(dateArea, {
        type: 'line',
        data: {
            labels:data['dates'],
            datasets:[
                {
                    label: "Tracking by Date",
                    data: data['trackings'],
                    backgroundColor: 'rgba(52, 191, 163, 0.2)',
                    borderColor: 'rgba(52, 191, 163, 1)',
                    borderWidth: 1,
                },
            ],
        },
        options: {
            showScale: true,
            scales: {
                yAxes: [{
                    ticks: {
                        offsetGridLines: true
                    }
                }]
            }
        }
    });
    var deviceArea = $("#deviceChart").get(0).getContext("2d");
    var pieChart = new Chart(deviceArea, {
        type: 'pie',
        data: {
            datasets: [{
                data: data['device_sessions'],
                backgroundColor: data['device_colors'],
            }],
            labels: data['devices']
        }
    });
}
