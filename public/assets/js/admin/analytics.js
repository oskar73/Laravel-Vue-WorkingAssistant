$.ajax({
    url:"/admin/dashboard/analytics",
    success:function(result) {
        console.log(result)
        if(result.status===1)
        {
            if(result.data!=null)
            {
                analytics(result.data);
                $(".loading_div").hide();
            }
        }else {
            itoastr("error", "Something error! Did you set correct analytics view id and upload exact config file?")
        }
    },
    error:function(err) {
        console.log(err)
    }
});
function analytics(data) {
    var pageArea = $("#areaChart").get(0).getContext("2d");
    var areaChart = new Chart(pageArea, {
        type: 'line',
        data: {
            labels:data['dates'],
            datasets:[
                {
                    label: "Page views",
                    data: data['pageViews'],
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
    var visitorArea = $("#visitorChart").get(0).getContext("2d");
    var visitorChart = new Chart(visitorArea, {
        type: 'line',
        data: {
            labels:data['dates'],
            datasets:[
                {
                    label: "Visitor counts",
                    data: data['visitors'],
                    backgroundColor: 'rgba(113, 106, 202, 0.2)',
                    borderColor: 'rgba(113, 106, 202, 1)',
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
    var browserArea = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(browserArea, {
        type: 'pie',
        data: {
            datasets: [{
                data: JSON.parse(data['browserjson'])['value'],
                backgroundColor: JSON.parse(data['browserjson'])['color'],
            }],
            labels: JSON.parse(data['browserjson'])['label']
        }
    });
    var countryArea = $("#lineChart").get(0).getContext("2d");
    var lineChart = new Chart(countryArea, {
        type: 'line',
        data: {
            labels:data['country'],
            datasets:[
                {
                    label: "Visitor counts",
                    data: data['country_sessions'],
                    backgroundColor: 'rgba(113, 106, 202, 0.2)',
                    borderColor: 'rgba(113, 106, 202, 1)',
                    borderWidth: 1,
                },
            ],
        },
    });
};
