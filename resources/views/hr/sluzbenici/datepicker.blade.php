<!DOCTYPE html>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script defer src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

    <script src="{{ asset('js/datepicker.js') }}"></script>
,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,

    <link href="{{ asset('css/datepicker.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script>
        $(function() {
            $('.dates #usr1').datepicker({
                format: 'dd/mm/yyyy',
                'autoclose': true
            });
        });
    </script>
</head>

<body>
<div class="container">

    <div class="dates" style="margin-top:100px; color:#2471a3;">
        <label>Choose DOB</label>
        <input type="text" style="width:200px; " class="form-control" id="usr1" name="event_date" placeholder="DD-MM-YYYY" autocomplete="off" >
    </div>
</div>

</body>
</html>