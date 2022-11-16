var ctx = document.getElementById('myChart').getContext('2d');
var data_cabang = [];
var data_jumlah = [];
var warna = [];
var border = [];
var randomColorGenerator = function () {
    return '#' + (Math.random().toString(16) + '0000000').slice(2, 8);
};

$.post("getpercabang",
function(data){
    var obj = JSON.parse(data);
    $.each(obj,function(index,item){
        data_cabang.push(item.cabang.nama_cabang);
        data_jumlah.push(item.total);
        warna.push( randomColorGenerator() );
        border.push( randomColorGenerator() );
    });

        var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: data_cabang,
            datasets: [
                {
                label: "jumlah Request ",
                data: data_jumlah,
                backgroundColor: warna,
                borderColor: border,
                borderWidth: 1
            }]
        }
    });
});
