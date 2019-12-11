<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans;
        }
        table{border:1px solid rgba(0,0,0,0.1);}
        thead tr th{border-bottom:1px solid rgba(0,0,0,0.1); border-left:1px solid rgba(0,0,0,0.1); height:40px;}
        tbody tr td{border-left:1px solid rgba(0,0,0,0.1); height:30px;}

        th:first-child, td:first-child{width:40px; text-align:center; border-left:0px;}
        th, td{
            text-align:left;
            font-size:12px;
            padding-left:10px;
        }
        td{border-top:1px solid rgba(0,0,0,0.1);}

        .first-one{
            border-left:0px;
            padding:0px;
        }
        .header{
            position:relative;
            left:0px;
            top:0px;
            width:100%;
            height:80px;
        }
        .header img{
            width:60px;
            height:60px;
            top:10px;
        }
        .header .header-text{
            position:absolute;
            left:100px;
            top:-10px;
            width:100%;
            height:80px;
        }
        .header .header-text h4{margin-top:-0px; font-size:20px; margin-bottom:0px;}
        .header .header-text p{margin-top:0px; font-size:12px;}
    </style>
</head>
<body>

<script type="text/php">
    if (isset($pdf)) {
        $text = "Stranica {PAGE_NUM} / {PAGE_COUNT}";
        $size = 10;
        $font = $fontMetrics->getFont("Verdana");
        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
        $x = ($pdf->get_width() - $width) / 2;
        $y = $pdf->get_height() - 35;
        $pdf->page_text($x, $y, $text, $font, $size);
    }
</script>

<div class="header">
    <img src="<?php echo $_SERVER["DOCUMENT_ROOT"].'/images/grb.png';?>"/>
    <div class="header-text">
        <h4>
            Pododjeljenje za ljudske resurse u Brčko Distriktu
        </h4>
        <p>Aplikacija za ljudske resurse FBiH</p>
    </div>
</div>

<table style="width:100%;">
    <thead>
    <tr>
        @for($i=0; $i<count($data['header']) - 1; $i++)
            <th @if($i == 0) class="first-one" @endif>{{$data['header'][$i]}}</th>
        @endfor
    </tr>
    </thead>
    <tbody>
    @foreach($data['data'] as $rows)
        <tr>
            @php $counter = 0; @endphp
            @for($i=0; $i<count($rows); $i++)
                <td @if($i == 0) class="first-one" @endif>{{$rows[$i]}}</td>
            @endfor
            @foreach($rows as $row)
                {{--                <td @if($counter++ == 0) class="first-one" @endif>{{$row}}</td>--}}
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>