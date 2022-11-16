// Data Percabang

var ctx = document.getElementById("barChart");
var ctx2 = document.getElementById("pieChart");
var ctx3 = document.getElementById("pieChart2");

var randomColorGenerator = function () {
    return '#' + (Math.random().toString(16) + '0000000').slice(2, 8);
};

function addData(chart, label, color, data) {
        // chart.data.labels.push(label);
		chart.data.datasets.push({
        label: label,
        backgroundColor: color,
        data: data
        });
    chart.update();
}

// inserting the new dataset after 3 seconds
$.post("chiefstore/getpercabang",
function(data){
    var obj = JSON.parse(data);
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Jumlah Percabang"],
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    $.each(obj,function(index, item){
            addData(barChart, item.cabang.nama_cabang, randomColorGenerator(), [item.total]);
    });
});

//Penyebab

$.post("chiefstore/chartpenyebab",
function(data){
    var total_data = [];
    var label_data = [];
    var warna = [];
    var obj = JSON.parse(data);
    $.each(obj,function(index,item){
        if(item.rel_penyebab != null){
            label_data.push(item.rel_penyebab.penyebab);
            total_data.push(item.total);
            warna.push( randomColorGenerator() );
        }else{
            label_data.push(item.dll_penyebab);
            total_data.push(item.total);
            warna.push( randomColorGenerator() );
        }
    });

        var myChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: label_data,
                datasets: [
                    {
                    // label: "jumlah Request ",
                    data: total_data,
                    backgroundColor: warna,
                    borderWidth: 1
                }]
            },
        });
});

//akibat
$.post("chiefstore/chartakibat",
function(data){
    var total_data = [];
    var label_data = [];
    var warna = [];
    var obj = JSON.parse(data);
    $.each(obj,function(index,item){
        if(item.rel_akibat != null){
            label_data.push(item.rel_akibat.akibat);
            total_data.push(item.total);
            warna.push( randomColorGenerator() );
        }else{
            label_data.push(item.dll_akibat);
            total_data.push(item.total);
            warna.push( randomColorGenerator() );
        }
    });

        var myChart = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: label_data,
                datasets: [
                    {
                    // label: "jumlah Request ",
                    data: total_data,
                    backgroundColor: warna,
                    borderWidth: 1
                }]
            },
        });
});




