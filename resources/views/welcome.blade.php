<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{asset('js/libs.js')}}"></script>
    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <button type="button" id="click">do magic</button>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#click').click(function () {
            $.ajax({
                type      : "POST",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader ("Authorization", "Basic " + btoa('Rosendo76@Rolfson.info' + ":" + '123456'));
                },
                url       : '{{url('api/admin/users/admins')}}',
                data      : {},
                success   : function (data) {
                    console.log(data);
                },
                error     : function (data) {
                    console.log(data);
                },
                dataType  : "JSON"
            });
        });
    });
</script>
</body>
</html>
