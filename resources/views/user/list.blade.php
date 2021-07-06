@extends('master')
@section('page_title', 'Kullanıcılar')
@section('page_head')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section('page_content')
    <div class="col-md-12 col-sm-12 ">
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Kullanıcıları Listele</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> <!-- content -->
                        <div class="float-right">
                            <button class="btn btn-success btn-sm" id="newItem">
                                Yeni
                            </button>
                        </div>
                        <table id="datatable-responsive"
                               class="display"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="5">Şirket</th>
                                <th width="5">Departman</th>
                                <th width="27">İsim</th>
                                <th width="27">Soyisim</th>
                                <th width="16">Email</th>
                                <th width="15%">İşlem</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->company()['title'] }}</td>
                                    <td>{{ $user->department()['title'] }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" onclick="detail({{ $user->id }});">
                                            Düzenle
                                        </button>
                                        <button class="btn btn-danger btn-sm"
                                                onclick="runDeleteModal({{ $user->id }},'{{ $user->first_name }} {{ $user->last_name }}');">
                                            Sil
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form>
                            <input type="hidden" id="editItemButton" data-toggle="modal" data-target="#editItem">
                            <input type="hidden" id="deleteItemButton" data-toggle="modal" data-target="#deleteItem">
                        </form>
                    </div> <!-- .content -->
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="deleteItemModalBody">
                </div>
                <div class="modal-footer">
                    <button type="button" id="deleteItemAction" class="btn btn-danger">Sil</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade bd-example-modal-lg" id="editItem" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Düzenle</h5>
                    <button type="button" class="close" id="closeEditItem" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> <!-- Modal Content -->
                    <form id="editItemForm"
                          data-parsley-validate=""
                          class="form-horizontal form-label-left" novalidate="">
                        <div id="messages"></div>
                        {{ csrf_field() }}
                        <div class="item form-group">
                            <label for="id" class="col-form-label col-md-3 col-sm-3 label-align">ID</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="text" class="form-control has-feedback-left" name="id"
                                       id="id"
                                       readonly>
                                <span class="fa fa-id-card-o form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="company_id"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Şirket</label>
                            <div class="col-md-6 col-sm-12">
                                <select class="form-control has-feedback-left" id="company_id" name="company_id"
                                        onchange="getDepartmentsOfCompany();">
                                    <option value="">Lütfen seçiniz</option>
                                </select>
                                <span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="department_id"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Departman</label>
                            <div class="col-md-6 col-sm-12">
                                <select class="form-control has-feedback-left" id="department_id" name="department_id">
                                    <option value="">Lütfen seçiniz</option>
                                </select>
                                <span class="fa fa-sitemap form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="first_name"
                                   class="col-form-label col-md-3 col-sm-3 label-align">İsim</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="text" class="form-control has-feedback-left" name="first_name"
                                       id="first_name">
                                <span class="fa fa-user-secret form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="last_name"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Soyisim</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="text" class="form-control has-feedback-left" name="last_name"
                                       id="last_name">
                                <span class="fa fa-user-secret form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="email"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Email</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="email" class="form-control has-feedback-left" name="email"
                                       id="email">
                                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="password"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Parola</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="password" class="form-control has-feedback-left" name="password"
                                       id="password">
                                <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="password_confirmation"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Parola (Tekrar)</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="password" class="form-control has-feedback-left"
                                       name="password_confirmation"
                                       id="password_confirmation">
                                <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="item form-group">
                            <div class="col-md-6 col-sm-6 offset-md-3">
                                <button type="submit" id="submit_button" class="btn btn-success float-right">Kaydet
                                </button>
                                <button type="button" id="delete_button" class="btn btn-danger float-right">
                                    Sil
                                </button>
                            </div>
                        </div>
                    </form>
                </div> <!-- .Modal Content -->
            </div>
        </div>
    </div>
@endsection
@section('page_scripts')
    <script type="text/javascript">
        function runDeleteModal(id, title) {
            $('#closeEditItem').click();
            var html_delete_body = '<strong>' + id + '</strong> numaralı <strong>' + title + '</strong> kullanıcısını silmek istediğinize emin misiniz ?';
            $('#deleteItemModalBody').html(html_delete_body);
            $('#deleteItemAction').attr('onclick', 'deleteRequest(' + id + ');');
            $('#deleteItemButton').click();
        }
    </script>
    <script type="text/javascript">
        function deleteRequest(id) {
            $('#deleteItemAction').prop('disabled', true);
            $('#deleteItemAction').html('<img width="16" height="16" src="{{ asset("images/loading.gif") }}"> Sil');
            setTimeout(function () {
                $('#deleteItemAction #submit_button').prop('disabled', false);
                $('#deleteItemAction #submit_button').html('Sil');
            }, 2000);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                data: {
                    id: id,
                },
                url: "{{ route("user.delete") }}",
                success: function (data) {
                    new PNotify({
                        title: data.messages.title,
                        text: data.messages.message,
                        type: data.messages.status,
                        delay: 3000,
                        styling: 'bootstrap3'
                    });
                    if (data.messages.status === 'success') {
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function (data) {
                    var msg_field = data.responseJSON.message;
                    new PNotify({
                        title: 'Hata',
                        text: msg_field,
                        type: 'warning',
                        delay: 1500,
                        styling: 'bootstrap3'
                    });
                }
            });
        }
    </script>
    <script type="text/javascript">
        $(document).on('click', '#newItem', function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route("user.create") }}",
                success: function (data) {
                    detail(data);
                    $('#editItemButton').click();
                },
                error: function (data) {
                    var msg_field = data.responseJSON.message;
                    new PNotify({
                        title: 'Hata',
                        text: msg_field,
                        type: 'warning',
                        delay: 1500,
                        styling: 'bootstrap3'
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).on('click', '#closeEditItem', function () {
            if ($('#editItemForm #first_name').val() === 'İsim' && $('#editItemForm #last_name').val() === 'Soyisim')
                deleteRequest($('#editItemForm #id').val());
        });
    </script>
    <script type="text/javascript">
        $('#editItemForm').submit(function (e) {
            $('#editItemForm #submit_button').prop('disabled', true);
            $('#editItemForm #submit_button').html('<img width="16" height="16" src="{{ asset("images/loading.gif") }}"> Kaydet');
            setTimeout(function () {
                $('#editItemForm #submit_button').prop('disabled', false);
                $('#editItemForm #submit_button').html('Kaydet');
            }, 2000);
            $("#editItemForm #messages").html(null);
            var inputs = $('#editItemForm .form-group');
            inputs.removeClass('has-error');
            inputs.find('.help-block').html(null);
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route("user.update") }}",
                enctype: "multipart/form-data",
                data: {
                    id: $('#editItemForm #id').val(),
                    company_id: $('#editItemForm #company_id').val(),
                    department_id: $('#editItemForm #department_id').val(),
                    first_name: $('#editItemForm #first_name').val(),
                    last_name: $('#editItemForm #last_name').val(),
                    email: $('#editItemForm #email').val(),
                    password: $('#editItemForm #password').val(),
                    password_confirmation: $('#editItemForm #password_confirmation').val(),
                },
                success: function (data) {
                    new PNotify({
                        title: data.messages.title,
                        text: data.messages.message,
                        type: data.messages.status,
                        delay: 3000,
                        styling: 'bootstrap3'
                    });
                    if (data.messages.status === 'success') {
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function (data) {
                    if (data.responseJSON.errors) {
                        var msg_field = '';
                        $.each(data.responseJSON.errors, function (key, value) {
                            var formGroup = $("#editItemForm #" + key).closest(".form-group");
                            formGroup.addClass('has-error');
                            formGroup.find('.help-block').html(value[0]);
                            msg_field += '<li>' + value[0] + '</li>';
                        });
                        new PNotify({
                            title: 'Hata',
                            text: msg_field,
                            type: 'warning',
                            delay: 1500,
                            styling: 'bootstrap3'
                        });
                    } else {
                        var msg_field = data.responseJSON.message;
                        new PNotify({
                            title: 'Hata',
                            text: msg_field,
                            type: 'warning',
                            delay: 1500,
                            styling: 'bootstrap3'
                        });
                    }
                }
            });
            return false;
        });
    </script>
    <script type="text/javascript">
        function detail(id) {
            $("#editItemForm #company_id").html(null);
            $("#editItemForm #company_id").append($("<option></option>").attr("value", "").text("Lütfen seçiniz"));
            $("#editItemForm #department_id").html(null);
            $("#editItemForm #department_id").append($("<option></option>").attr("value", "").text("Lütfen önce şirket seçiniz"));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route("user.detail") }}",
                data: {
                    id: id,
                },
                success: function (data) {
                    $('#editItemForm #id').val(data.user.id);
                    var selected_company_id = data.selected_company.id;
                    var selected_company = '';
                    $.each(data.companies, function (key, value) {
                        if (value['id'] === selected_company_id && data.user.first_name !== 'İsim' && data.user.last_name !== 'Soyisim') {
                            selected_company = ' selected';
                        }
                        $("#editItemForm #company_id").append($("<option " + selected_company + "></option>").attr("value", value['id']).text(value['title']));
                        selected_company = '';
                    });
                    var selected_department_id = data.selected_department.id;
                    var selected_department = '';
                    $("#editItemForm #department_id").html(null);
                    $("#editItemForm #department_id").append($("<option></option>").attr("value", "").text("Lütfen seçiniz"));
                    $.each(data.departments_of_category, function (key, value) {
                        if (value['id'] === selected_department_id && data.user.first_name !== 'İsim' && data.user.last_name !== 'Soyisim') {
                            selected_department = ' selected';
                        }
                        $("#editItemForm #department_id").append($("<option " + selected_department + "></option>").attr("value", value['id']).text(value['title']));
                        selected_department = '';
                    });
                    $('#editItemForm #first_name').val(data.user.first_name);
                    $('#editItemForm #last_name').val(data.user.last_name);
                    var user_email = data.user.email;
                    if (user_email.substr(0, 29) !== 'randomEmailForNewUsersOfRCMS@')
                        $('#editItemForm #email').val(data.user.email);
                    $('#editItemForm #delete_button').attr('onclick', 'runDeleteModal(' + data.user.id + ', "' + data.user.first_name + ' ' + data.user.last_name + '");');
                    $('#editItemButton').click();
                },
            });
        }
    </script>
    <script type="text/javascript">
        function getDepartmentsOfCompany() {
            $('#editItemForm #department_id').val();
            $("#editItemForm #department_id").append($("<option></option>").attr("value", "").text('Lütfen seçiniz'));
            var company_id = $('#editItemForm #company_id').val();
            if (company_id > 0) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route("company.departments") }}",
                    data: {
                        id: company_id,
                    },
                    success: function (data) {
                        $('#editItemForm #department_id').html('');
                        $('#editItemForm #department_id').val();
                        $("#editItemForm #department_id").append($("<option></option>").attr("value", "").text('Lütfen seçiniz'));
                        $.each(data.departments, function (key, value) {
                            $("#editItemForm #department_id").append($("<option></option>").attr("value", value['id']).text(value['title']));
                        });
                    },
                });
                return false;
            }
        }
    </script>
    <!-- Datatables -->
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#datatable-responsive').DataTable();
        });
    </script>
@endsection
