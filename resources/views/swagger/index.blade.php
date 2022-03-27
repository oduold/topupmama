<html>
<head>
    <title>{{ config('app.name') }} | Frontend API's Swagger</title>
    <link href="{{url('swagger/style.css')}}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{url('swagger/favicon-32x32.png')}}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{url('swagger/favicon-16x16.png')}}" sizes="16x16" />
    <style>
        html
        {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }
        *,
        *:before,
        *:after
        {
            box-sizing: inherit;
        }
        body {
            margin:0;
            background: #fafafa;
        }
    </style>
</head>
<body>
<div id="swagger-ui"></div>
<script src="{{url('swagger/jquery-2.1.4.min.js')}}"></script>
<script src="{{url('swagger/swagger-bundle.js')}}"></script>
<script type="application/javascript">
    const ui = SwaggerUIBundle({
        url: "{{ url('swagger/swagger.yaml') }}",
        dom_id: '#swagger-ui',
    });
</script>
</body>
</html>
