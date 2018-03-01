<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Job Status viewer</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.css">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        body {
            padding: 25px;
        }

        h1 {
            font-size: 1.5em;
            margin-top: 0;
        }

        .stack {
            font-size: 0.85em;
        }

        .date {
            min-width: 75px;
        }

        .text {
            word-break: break-all;
        }

        a.llv-active {
            z-index: 2;
            background-color: #f5f5f5;
            border-color: #777;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <h1><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Laravel Job Status Viewer</h1>
            <p class="text-muted"><i>by Atlas Wong</i></p>
            <div class="list-group">
                @foreach($types as $job_status)
                    <a href="?l={{ base64_encode($job_status) }}"
                       class="list-group-item">
                        {{$job_status['type']}}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-sm-9 col-md-10 table-container">

            <table id="table-log" class="table table-striped">
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Input</th>
                    <th>Output</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($job_statuses as $key => $job_status)
                    <tr data-display="stack{{$key}}">
                        <td class="text"><span class="glyphicon" aria-hidden="true"></span> &nbsp;{{$job_status['type']}}</td>
                        <td class="text">{{$job_status['status']}}</td>
                        <td class="text">{{json_encode($job_status['input'])}}</td>
                        <td class="text">{{json_encode($job_status['output'])}}</td>
                        <td class="date">{{{$job_status['updated_at']}}}</td>
                        <td class="text">@if ($job_status['status'] == 'failed')<a href="?rq={{base64_encode($job_status['id'])}}">Retry</a>@endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script>
    $(document).ready(function () {
        $('.table-container tr').on('click', function () {
            $('#' + $(this).data('display')).toggle();
        });
        $('#table-log').DataTable({
            "order": [1, 'desc'],
            "stateSave": true,
            "stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("datatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("datatable"));
                if (data) data.start = 0;
                return data;
            },
            "searchDelay": "{{empty($config['seach_delay'])??500}}"
        });
        $('#delete-log, #delete-all-log').click(function () {
            return confirm('Are you sure?');
        });
    });
</script>
</body>
</html>
