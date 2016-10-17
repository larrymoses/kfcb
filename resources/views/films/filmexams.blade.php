@extends('layouts.moderator')
@section('title', 'Film Management')
@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <h3 class="page-title"> Films
                <small>All films in the System</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="{{url('films')}}">Films</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>Films Examiners</span>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN TAB PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <a class="btn green btn-outline sbold uppercase" id="create" href="#" data-toggle="modal" data-target="#createModal" data-backdrop="static" data-keyboard="false">
                                <i class="fa fa-plus "></i> Create New
                            </a>
                            <span class="red sbold uppercase">
                                {{$films->name}}</span>
                            <button class="btn blue btn-outline sbold pull-right" onclick="window.print()"><span
                                        class="fa fa-print"></span></button>
                        </div>
                        @include('common.success')
                        <div class="portlet-body">
                            <table id="filmExaminersTable"
                                   class="display table table-striped table-bordered responsive">
                                <thead>
                                <tr>
                                    <th>Examiners Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--Group Deactivate Windows--}}
    <div class="modal fade bs-example-modal-remove"  tabindex="-1" role="dialog" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header panel panel-success">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                        <h4 class="modal-title">Remove User </h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert" id="removeNotification" style="display: none;">
                            <ul id="ul" class="ul">    </ul>
                        </div>
                        <form id="frmRemove" class="form-horizontal form-bordered">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <p> Are you sure you want to Approve <code><label id="username"></label></code> from Examining <code>{{$films->name}}</code>?</p>
                                    <input type="hidden" id="userID">
                                </div>
                            </div><!-- panel -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"  id="btnRemove" class="btn btn-success">Delete User</button>
                        <a href="#" type="button"  class="btn btn-default btnClose" >Close</a>
                    </div>
                </div>
            </div>
        </div>
    {{--End of Group Deactivate Modal Window--}}
@endsection
@section('pagelevel')
    <script src="{{asset('assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('assets/js/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/datatables/media/assets/js/datatables.min.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('assets/js/datatables/extras/TableTools/media/js/TableTools.min.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('assets/js/datatables/extras/TableTools/media/js/ZeroClipboard.min.js')}}"></script>
    <script src="{{asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('assets/global/plugins/jquery.sparkline.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/pages/scripts/profile.min.js')}}" type="text/javascript"></script>
    <script src="../assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js"
            type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-file-upload/js/vendor/load-image.min.js"
            type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js"
            type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js"
            type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js"
            type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js"
            type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js"
            type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-file-upload/js/jquery.fileupload-audio.js"
            type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-file-upload/js/jquery.fileupload-video.js"
            type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js"
            type="text/javascript"></script>
    <script src="../assets/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js"
            type="text/javascript"></script>
    <script type='text/javascript' charset="utf-8">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            oTable = $('#filmExaminersTable').DataTable({
                responsive: true,
                stateSave: true,
                "sAjaxSource": "<?php echo 'get_films_examiners/'.$films->id?>",
                "aoColumns": [
                    {mData: 'name'},
                    {mData: 'actions'}
                ]
            });
        });
        $(document).on('change', '.checkMe', function () {
            var name = $(this).data('name'); // get the Name
            var filmID = "<?php echo $films->id; ?>"; //get film id
            var userID= $(this).data('id');
            var token = $(this).data('token');
            var dataString = {filmID: filmID, userID: userID, name: name, _token: token};

            if(this.checked) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo url('storefilmexaminer'); ?>",
                    data: dataString,
                    cache: false,
                    success: function(data, status){
                        // alert(data.message);

                    }
                });
            }else{
                $.ajax({
                    type: "DELETE",
                    url: "<?php echo url('removefilmexaminer'); ?>",
                    data: {_method: 'delete', _token :token,filmID: filmID, userID: userID,name:name},
                    cache: false,
                    success: function(data, status){
                        // alert(data.message);

                    }
                });
            }
        });
        $(document).on("click", ".upload", function () {

            var id = $(this).data('id');
            var name = $(this).data('name');
            var sname = $(this).data('sname');
            document.getElementById('videoID').value = id;
            document.getElementById('videoName').innerHTML = name;
            document.getElementById('videosName').innerHTML = sname;
        });
        $(document).on("click", ".remove", function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            document.getElementById('userID').value = id;
            document.getElementById('username').innerHTML = name;
        });
        $("#btnRemove").click(function () {
            var editNotification = $("#removeNotification");
            editNotification.hide();
            var frm = $("#frmRemove");
            var filmID= "<?php echo $films->id ?>";
            var userID = document.getElementById('userID').value; //Status code for Active
            $.ajax({
                method: "POST",
                url: "remove",
                data: {filmID: filmID,userID:userID},
                success: function (data, status) {
                    switch (status) {
                        case "success":
                            if (data.status === '00') {
                                frm.hide();
                                editNotification.html('<div class="alert alert-success" >' + 'User Successfully <code> Removed </code>' + '</div>');
                                editNotification.show();
                                $("#btnRemove").hide();
                            } else if (data.status === '01') {
                                editNotification.hide().find('#ul').empty();
                                $.each(data.errors,function(index,error){
//                                        editNotification.find('#ul').append('<li>'+ data.error +'</li>');
                                    editNotification.html('<div class="alert alert-danger">'+'<li>'+data.error+'</li>' +'</div>');
                                });
                                createNotification.show();
                            }
                            break;
                        case "failed":
                            editNotification.html('<div class="alert alert-danger">' + data.message + ' </div>');
                            editNotification.show();
                            frm.hide();
                            break;
                        default :
                            alert("do nothing");
                    }
                }
            });
        });
        $("#newClose").click(function () {
            pageReload();
        });
        $("#editClose").click(function () {
            pageReload();
        });
        $("#viewClose").click(function () {
            pageReload();
        });
        $(".btnClose").click(function () {
            pageReload();
        });

        function pageReload() {
            document.location.reload();
        }
    </script>
@endsection