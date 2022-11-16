$(document).ready(function(){
    $('#solved').click(function(e){
        e.preventDefault();
        var id = $(this).attr('href');
        $('form#form-solved').attr('action',id);
        $('#myModal').modal('show');
    });

    var count = 0;
    loadcount();


    setInterval(function(){
        $.ajax({
            url : 'getcountinfra',
            success:function(data){
                if(count != data){
                    $jumlah = parseInt(data) - parseInt(count);
                    $('.notify').append('<span class="heartbit"></span> <span class="point"></span>');
                    $('h5#jumlahreq').text($jumlah + ' Request Baru');
                    $('.message-center').show();
                }else{
                    count = data;
                }

            }
        })
    },3000);

    function loadcount(){
        $.ajax({
            url : 'getcountinfra',
            success:function(data){
               count = data;
            }
        })
    }
})
