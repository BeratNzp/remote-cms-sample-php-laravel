@extends('master')
@section('page_title', 'Veritabanı Bağlantıları')
@section('page_head')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section('page_content')
    <div class="col-md-12 col-sm-12 ">
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Veritabanı Bağlantılarını Listele</h2>
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
                                <th>ID</th>
                                <th>Şirket</th>
                                <th>Veritabanı</th>
                                <th>İşlem</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($databases as $database)
                                <tr>
                                    <td>{{ $database->id }}</td>
                                    <td>{{ isset($database->company->title) ? $database->company->title : '' }}</td>
                                    <td>{{ $database->database }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" onclick="detail({{ $database->id }});">
                                            Düzenle
                                        </button>
                                        <button class="btn btn-danger btn-sm"
                                                onclick="runDeleteModal({{ $database->id }},'{{ $database->title }}');">
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
                            <input type="hidden" id="migrateItemButton" data-toggle="modal" data-target="#migrateItem">
                        </form>
                    </div> <!-- .content -->
                </div>
            </div>
        </div>
    </div>
    <!-- Migrate Modal -->
    <div class="modal fade" id="migrateItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sıfırla & Güncelle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="migrateItemModalBody">
                </div>
                <div class="modal-footer">
                    <button type="button" id="migrateItemAction" class="btn btn-danger">Sıfırla & Güncelle</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
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
                                <select class="form-control has-feedback-left" id="company_id" name="company_id">
                                    <option value="">Lütfen seçiniz</option>
                                </select>
                                <span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="ipv4"
                                   class="col-form-label col-md-3 col-sm-3 label-align">IPv4</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="text" class="form-control has-feedback-left" name="ipv4"
                                       id="ipv4" onchange="checkConnection();">
                                <span class="fa fa-plug form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="port"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Port</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="text" class="form-control has-feedback-left" name="port"
                                       id="port" onchange="checkConnection();">
                                <span class="fa fa-sitemap form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="username"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Kullanıcı Adı</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="text" class="form-control has-feedback-left" name="username"
                                       id="username" onchange="checkConnection();">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="password"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Parola</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="password" class="form-control has-feedback-left" name="password"
                                       id="password" onchange="checkConnection();">
                                <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="database"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Veritabanı</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="hidden" name="title" id="database_current">
                                <input type="text" class="form-control has-feedback-left" name="database"
                                       id="database" onchange="checkConnection();">
                                <span class="fa fa-database form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="item">
                            <label for="check_connection"
                                   class="col-form-label col-md-3 col-sm-12 label-align">Veritabanı Vağlantısı
                                Testi</label>
                            <div class="col-form-label col-md-6 col-sm-12">
                                <div id="check_connection"></div>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="item form-group">
                            <div class="col-md-6 col-sm-6 offset-md-3">
                                <button type="button" id="migrate_button" class="btn btn-danger">Sıfırla & Güncelle
                                </button>
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
        function checkConnection() {
            $('#check_connection').html(null);
            var inputs = $('#editItemForm .form-group');
            inputs.removeClass('has-error');
            inputs.find('.help-block').html(null);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                data: {
                    ipv4: $('#editItemForm #ipv4').val(),
                    port: $('#editItemForm #port').val(),
                    username: $('#editItemForm #username').val(),
                    password: $('#editItemForm #password').val(),
                    database: $('#editItemForm #database').val(),
                },
                url: "{{ route("database.check") }}",
                beforeSend: function () {
                    $('#submit_button').prop('disabled', true);
                    $('#migrate_button').prop('disabled', true);
                    $('#migrateItemAction').prop('disabled', true);
                    $('#check_connection').html('<img width="16" height="16" src="{{ asset("images/loading.gif") }}"> Bağlantı testi yapılıyor... Lütfen bekleyin');
                },
                success: function (data) {
                    if (data == true) {
                        $('#submit_button').prop('disabled', false);
                        $('#migrate_button').prop('disabled', false);
                        $('#migrateItemAction').prop('disabled', false);
                        $('#check_connection').html('<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i> Başarılı.</span>');
                    } else {
                        $('#check_connection').html('<span class="text-danger"><i class="fa fa-check" aria-hidden="true"></i> Bağlantı kurulamadı. Lütfen ayarlarınızı kontrol edin.</span>');
                    }
                },
                error: function (data) {
                    $('#check_connection').html(data);
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
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#migrate_button').prop('disabled', true);
        });

        function runMigrateModal(id, title) {
            $('#closeEditItem').click();
            var html_migrate_body = '<strong>' + id + '</strong> numaralı <strong>' + title + '</strong> veritabanı sıfırlamak ve güncellemek istediğinize emin misiniz ?';
            $('#migrateItemModalBody').html(html_migrate_body);
            $('#migrateItemAction').attr('onclick', 'migrateRequest(' + id + ');');
            $('#migrateItemButton').click();
        }
    </script>
    <script type="text/javascript">
        function migrateRequest(id) {
            $('#migrateItemAction').prop('disabled', true);
            $('#migrateItemAction').html('<img width="16" height="16" src="{{ asset("images/loading.gif") }}"> Sıfırla & Güncelle');
            setTimeout(function () {
                $('#migrateItemAction #migrate_button').prop('disabled', false);
                $('#migrateItemAction #migrate_button').html('Sıfırla & Güncelle');
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
                url: "{{ route("database.migrate") }}",
                success: function (data) {
                    new PNotify({
                        title: data.messages.title,
                        text: data.messages.message,
                        type: data.messages.status,
                        delay: 3000,
                        styling: 'bootstrap3'
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
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
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                }
            });
            return false;
        }
    </script>
    <script type="text/javascript">
        function runDeleteModal(id, title) {
            $('#closeEditItem').click();
            var html_delete_body = '<strong>' + id + '</strong> numaralı <strong>' + title + '</strong> veritabanı bağlantısını silmek istediğinize emin misiniz ?';
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
                url: "{{ route("database.delete") }}",
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
            return false;
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
                url: "{{ route("database.create") }}",
                success: function (data) {
                    detail(data);
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
            return false;
        });
    </script>
    <script type="text/javascript">
        $(document).on('click', '#closeEditItem', function () {
            if ($('#editItemForm #database_current').val() === 'Yeni Veritabanı Bağlantısı')
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
                url: "{{ route("database.update") }}",
                enctype: "multipart/form-data",
                data: {
                    id: $('#editItemForm #id').val(),
                    company_id: $('#editItemForm #company_id').val(),
                    ipv4: $('#editItemForm #ipv4').val(),
                    port: $('#editItemForm #port').val(),
                    username: $('#editItemForm #username').val(),
                    password: $('#editItemForm #password').val(),
                    database: $('#editItemForm #database').val(),
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route("database.detail") }}",
                data: {
                    id: id,
                },
                success: function (data) {
                    $('#editItemForm #id').val(data.database.id);
                    var selected_company_id = data.selected_company.id;
                    var selected = '';
                    $.each(data.companies, function (key, value) {
                        if (value['id'] === selected_company_id && data.database.title !== "Yeni Veritabanı Bağlantısı") {
                            selected = ' selected';
                        }
                        $("#editItemForm #company_id").append($("<option " + selected + "></option>").attr("value", value['id']).text(value['title']));
                        selected = '';
                    });
                    $('#editItemForm #ipv4').val(data.database.ipv4);
                    $('#editItemForm #port').val(data.database.port);
                    $('#editItemForm #username').val(data.database.username);
                    $('#editItemForm #password').val(data.database.password);
                    if (data.database.database === "Yeni Veritabanı Bağlantısı")
                        $('#editItemForm #database_current').val(data.database.database);
                    else
                        $('#editItemForm #database').val(data.database.database);
                    if (data.database.database === "Yeni Veritabanı Bağlantısı")
                        $('#editItemForm #delete_button').attr('onclick', 'deleteRequest(' + data.database.id + ');');
                    else
                        $('#editItemForm #delete_button').attr('onclick', 'runDeleteModal(' + data.database.id + ', "' + data.database.database + '");');
                    if (data.database.database === "Yeni Veritabanı Bağlantısı")
                        $('#editItemForm #migrate_button').attr('onclick', 'migrateRequest(' + data.database.id + ');');
                    else
                        $('#editItemForm #migrate_button').attr('onclick', 'runMigrateModal(' + data.database.id + ', "' + data.database.database + '");');
                    $('#editItemButton').click();
                    checkConnection();
                },
            });
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
