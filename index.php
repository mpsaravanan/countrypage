<!DOCTYPE html>
<html>

<head>
    <title>Country List</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <style>
        body {
            font-size: 12px;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-8">
                    <h4>Country List</h4>
                </div>
                <div class="col-md-4">
                    <div class="col-md-2" style="margin-left: 47%;">
                        <button class="btn btn-warning btn-sm" data-title="add" data-toggle="modal" data-target="#add">Add New Country</button>
                    </div>
                    <div class="col-md-2" style="margin-left: 18%;">
                        <button class="btn btn-warning btn-sm " data-title="delete" onclick="deleteMultiple();">Delete</button>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table id="mytable" class="table table-bordered">
                    <thead>
                        <th><input type="checkbox" id="select_all" /></th>
                        <th>COUNTRY NAME</th>
                        <th>LATITUDE</th>
                        <th>LONGITUDE</th>
                        <th>ACTION</th>
                    </thead>
                    <tbody id="countrylist">
                    </tbody>
                </table>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    </div>

    <!-- Add Detail Starts here-->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    <h4 class="modal-title custom_align" id="Heading">Add Country Detail</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control " id="countryname" type="text" placeholder="Country Name">
                    </div>
                    <div class="form-group">
                        <input class="form-control " id="latitude" type="text" placeholder="Latitude">
                    </div>
                    <div class="form-group">
                        <input class="form-control " id="longitude" type="text" placeholder="Longitude">
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-warning btn-md" style="width: 100%;" onclick="saveDetail();"><span class="glyphicon glyphicon-ok-sign"></span>Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Add Detail End here-->

    <!-- Edit Detail starts here-->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    <h4 class="modal-title custom_align" id="Heading">Edit Country Detail</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control " id="countryname" type="text" placeholder="Country Name">
                    </div>
                    <div class="form-group">
                        <input class="form-control " id="latitude" type="text" placeholder="Latitude">
                    </div>
                    <div class="form-group">
                        <input class="form-control " id="longitude" type="text" placeholder="Longitude">
                    </div>
                    <input class="form-control " id="rowId" type="hidden" />
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-warning btn-md" style="width: 100%;" onclick="update();"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Edit Detail Ends here-->

    <!-- Delete Detail  starts here-->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-success" onclick="deleteDetail();"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Delete Detail Ends here-->

    <script type="text/javascript">
        function saveDetail() {
            var countryname = $("#add #countryname").val();
            var latitude = $("#add #latitude").val();
            var longitude = $("#add #longitude").val();
            if (countryname != '' && latitude != '' && longitude != '') {
                $.ajax({
                    url: '/details.php',
                    type: "POST",
                    data: {
                        'countryname': countryname,
                        'latitude': latitude,
                        'longitude': longitude,
                        'type': 'add'
                    },
                    success: function(resp) {
                        $('#add').modal('hide');
                        alert(resp);
                        showDetail();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            } else {
                alert("Please enter required values");
            }
        }

        function updateDetail(elem, name, lat, long) {
            $("#edit #countryname").val(name);
            $("#edit #latitude").val(lat);
            $("#edit #longitude").val(long);
            $("#edit #rowId").val(elem);
            $('#edit').modal('show');
        }

        function update() {
            var countryname = $("#edit #countryname").val();
            var latitude = $("#edit #latitude").val();
            var longitude = $("#edit #longitude").val();
            var rowId = $("#edit #rowId").val();
            if (countryname != '' && latitude != '' && longitude != '') {
                $.ajax({
                    url: '/details.php',
                    type: "POST",
                    data: {
                        'rowId': rowId,
                        'countryname': countryname,
                        'latitude': latitude,
                        'longitude': longitude,
                        'type': 'edit'
                    },
                    success: function(resp) {
                        $('#edit').modal('hide');
                        alert(resp);
                        showDetail();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            } else {
                alert("Please enter required values");
            }
        }

        function deleteDetail(elem) {
            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    url: '/details.php',
                    type: "POST",
                    data: {
                        'rowId': elem,
                        'type': 'delete'
                    },
                    success: function(resp) {
                        alert(resp);
                        showDetail();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            } else {
                return false;
            }
        }

        function deleteMultiple() {
            var listval = [];
            $('input[name="checkbox"]:checked').each(function() {
                listval.push(this.value);
            });
            if (confirm('Are you sure you want to delete this records?')) {
                $.ajax({
                    url: '/details.php',
                    type: "POST",
                    data: {
                        'rowIds': JSON.stringify(listval),
                        'type': 'deletemultiple'
                    },
                    success: function(resp) {
                        showDetail();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            } else {
                return false;
            }
        }

        function showDetail() {
            $.ajax({
                url: window.location.href + 'details.php?type=show',
                type: "GET",
                success: function(resp) {
                    myHTML = '';
                    var resp = JSON.parse(resp);
                    if (resp.length > 0) {
                        for (var i = 0; i < resp.length; i++) {
                            myHTML += '<tr>';
                            myHTML += '<td> <input type = "checkbox" name="checkbox" class = "checkbox" value="' + resp[i].rowId + '" /> </td>';
                            myHTML += '<td style="color: #f0ad4e;">' + resp[i].name + '</td>';
                            myHTML += '<td>' + resp[i].latitude + '</td>';
                            myHTML += '<td>' + resp[i].longitude + '</td>';
                            myHTML += '<td>';
                            myHTML += '<p data-placement="top" data-toggle="tooltip" title="Edit" style="float: left;margin:10px;"><button class="btn btn-primary btn-xs" data-title="Edit" onclick="updateDetail(\'' + resp[i].rowId + '\', \'' + resp[i].name + '\', \'' + resp[i].latitude + '\', \'' + resp[i].longitude + '\');"><span class="glyphicon glyphicon-pencil"></span></button></p>';
                            myHTML += '<p data-placement="top" data-toggle="tooltip" title="Delete" style="float: left;margin:10px;"><button class="btn btn-danger btn-xs" data-title="Delete" onclick="deleteDetail(\'' + resp[i].rowId + '\');"><span class="glyphicon glyphicon-trash"></span></button></p>';
                            myHTML += '</td>';
                            myHTML += '<tr>';
                        }
                    } else {
                        myHTML += '<tr ><td colspan="5">No Records Found</td></tr>';
                    }
                    $("#countrylist").html(myHTML);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        $(document).ready(function() {
            showDetail();
            $('#select_all').on('click', function() {
                if (this.checked) {
                    $('.checkbox').each(function() {
                        this.checked = true;
                    });
                } else {
                    $('.checkbox').each(function() {
                        this.checked = false;
                    });
                }
            });

            $('.checkbox').on('click', function() {
                if ($('.checkbox:checked').length == $('.checkbox').length) {
                    $('#select_all').prop('checked', true);
                } else {
                    $('#select_all').prop('checked', false);
                }
            });
        });
    </script>
</body>

</html>