<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
           .messagePanel { border: solid 1px black; width: 505px; height: 155px; }

.seat {

    width: 40px;
    height: 40px;
    margin: 5px;
    border: solid 1px black;
    float: left;

}

.clearfix { clear: both;}
.available {
    background-color: #96c131;
}

.hovering{
	background-color: #ae59b3;
}
.selected{
    background-color: red;
}

.change{
    background-color: #dc3545;
}

.normal{
    background-color: #96c131;
}

.inspect{
    background-color: #ffc107;
}

        </style>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script
  src="https://code.jquery.com/jquery-3.6.3.min.js"
  integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
  crossorigin="anonymous"></script>
        </script>


    </head>

    <body>
    <div style="background-color:lightgrey">
        <table width="80%" style="margin: 0 auto; border:1px solid;text-align:center">
            <tr>
                <td>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <th>
                    <img src="{{url('feeder.png')}}" alt="Image" style="width: 40%;"/>
                </th>
            </tr>
            <tr>
                <td>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <th>LINERS LADO A</th>
            </tr>
            <tr>
                <td>
                    <div id="messagePanel" class="messagePanel" style="margin: 0 auto; border:1px solid;text-align:center"></div>
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td>
                <button type="button" class="btn btn-danger" id="change">Cambio</button>
                <button type="button" class="btn btn-success" id="normal">Normal</button>
                <button type="button" class="btn btn-warning" id="inspect">Inspeccionar</button>
                <button type="button" class="btn btn-primary" id="save">Guardar</button>
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;
                </td>
            </tr>
        </table>
    <div>
    </body>

    <script>
    let selectSeat = [];
    $(function(){
        //$('#btnSeating').on('click', createseating);
        createseating();

        $('#change').on('click', function() {
            selectSeat.forEach(value => {
                console.log(value);
                id = '#liner-'+value;
                $(id).addClass( "change" );
                $(id).data( "status", 'change' );
            });
            selectSeat = [];
        });

        $('#normal').on('click', function() {
            selectSeat.forEach(value => {
                console.log(value);
                id = '#liner-'+value;
                $(id).addClass( "normal" );
                $(id).data( "status", 'normal' );
            });
            selectSeat = [];
        });

        $('#inspect').on('click', function() {
            selectSeat.forEach(value => {
                console.log(value);
                id = '#liner-'+value;
                $(id).addClass( "inspect" );
                $(id).data( "status", 'inspect' );
            });
            selectSeat = [];
        });

        $('#save').on('click', function() {
            let seats = [];
            $('.seat').each(index => {
                id = '#liner-'+(index+1);
                const data = $(id).data();
                seats.push(data);
            });

            $.ajax
            ({
                type: "POST",
                //the url where you want to sent the userName and password to
                url: "{{ route('liners.store') }}",
                contentType: 'application/json',
                dataType: 'json',
                async: false,
                //json object to sent to the authentication url
                data: JSON.stringify(seats),
                success: function (data) {
                    alert('Guardado correctamente!');
                    location.reload();
                    //console.log('data: ', data);
                }
            });
        });

    });
//Note:In js the outer loop runs first then the inner loop runs completely so it goes o.l. then i.l. i.l .i.l .i.l. i.l etc and repeat

    function createseating(){

        var seatingValue = [];
        for ( var i = 0; i < 30; i++){

            var seatingStyle = `<div class='seat available' id='liner-${i+1}' data-id='${i+1}' data-status='normal' ></div>`;
            seatingValue.push(seatingStyle);

            if ( i === 29){
                console.log("hi");
                var seatingStyle = "<div class='clearfix'></div>";
                seatingValue.push(seatingStyle);
            }
        }

        $('#messagePanel').html(seatingValue);

        $(function(){
            $('.seat').on('click',function(){
                let data = $(this).data();
                console.log(data);
                selectSeat.push(data.id);
                if($(this).hasClass( "selected" )){
                    $( this ).removeClass( "selected" );
                }else{
                    $( this ).addClass( "selected" );
                }

            });

            $('.seat').mouseenter(function(){
                $( this ).addClass( "hovering" );

                $('.seat').mouseleave(function(){
                    $( this ).removeClass( "hovering" );
                });
            });
        });
    };

    </script>
</html>
