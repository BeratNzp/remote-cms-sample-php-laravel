@extends('master')
@section('page_title', 'Servisler')
@section('page_head')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section('page_content')
    <div class="col-md-12 col-sm-12 ">
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Servisleri Listele</h2>
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
                                <th>Durum</th>
                                <th>Şirket</th>
                                <th>Servis Adı</th>
                                <th>Sonraki Ödeme</th>
                                <th>Son Ödemeye Kalan Gün</th>
                                <th>Fiyat</th>
                                <th>İşlem</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($services as $service)
                                @php
                                    if(isset($service))
                                    {
                                        if($service->status == 0)
                                            $status_img = 'light_red.png';
                                        elseif ($service->status == 1)
                                            $status_img = 'light_green.png';
                                        elseif ($service->status == 2)
                                            $status_img = 'light_yellow.png';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $service->id }}</td>
                                    <td><img src="{{ asset("images/".$status_img) }}"></td>
                                    <td>{{ $service->company->title }}</td>
                                    <td>{{ $service->title }}</td>
                                    <td>{{ $service->next_payment_time()['tr'] }}</td>
                                    <td>{{ $service->days_left() }}</td>
                                    <td>{{ $service->price }} {{ isset($service->currency->title) ? $service->currency->title : '' }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" onclick="detail({{ $service->id }});">
                                            Düzenle
                                        </button>
                                        <button class="btn btn-danger btn-sm"
                                                onclick="runDeleteModal({{ $service->id }},'{{ $service->title }}');">
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
                                <select class="form-control has-feedback-left" id="company_id" name="company_id">
                                    <option value="">Lütfen seçiniz</option>
                                </select>
                                <span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="title"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Servis Adı</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="hidden" name="title" id="title_current">
                                <input type="text" class="form-control has-feedback-left" name="title"
                                       id="title">
                                <span class="fa fa-server form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="price"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Fiyat</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="number" class="form-control has-feedback-left" name="price"
                                       id="price">
                                <span class="fa fa-credit-card form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="currency_id"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Para Birimi</label>
                            <div class="col-md-6 col-sm-12">
                                <select class="form-control has-feedback-left" id="currency_id" name="currency_id">
                                    <option value="">Lütfen seçiniz</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->title }}</option>
                                    @endforeach
                                </select>
                                <span class="fa fa-money form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="first_payment_time"
                                   class="col-form-label col-md-3 col-sm-3 label-align">İlk Ödeme</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="date" class="form-control has-feedback-left" name="first_payment_time"
                                       id="first_payment_time">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="last_payment_time"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Son Ödeme</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="date" class="form-control has-feedback-left" name="last_payment_time"
                                       id="last_payment_time">
                                <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item form-group">
                            <label for="status"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Durum</label>
                            <div class="col-md-6 col-sm-12">
                                <select class="form-control has-feedback-left" id="status" name="status">
                                    <option value="">Lütfen seçiniz</option>
                                </select>
                                <span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="item">
                            <label for="next_payment_time"
                                   class="col-form-label col-md-3 col-sm-12 label-align">Sonraki Ödeme</label>
                            <div class="col-form-label col-md-6 col-sm-12">
                                <div id="next_payment_time"></div>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="item">
                            <label for="days_left"
                                   class="col-form-label col-md-3 col-sm-12 label-align">Sonraki Ödemeye Kalan
                                Gün</label>
                            <div class="col-form-label col-md-6 col-sm-12">
                                <div id="days_left"></div>
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
        function calculate_next_payment_time(last_payment_time) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                data: {
                    last_payment_time: last_payment_time,
                },
                url: "{{ route("service.calculate_next_payment_time") }}",
                success: function (data) {
                    console.log(data);
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
        function runDeleteModal(id, title) {
            $('#closeEditItem').click();
            var html_delete_body = '<strong>' + id + '</strong> numaralı <strong>' + title + '</strong> servisini silmek istediğinize emin misiniz ?';
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
                url: "{{ route("service.delete") }}",
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
                url: "{{ route("service.create") }}",
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
            if ($('#editItemForm #title_current').val() === 'Yeni Servis')
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
                url: "{{ route("service.update") }}",
                enctype: "multipart/form-data",
                data: {
                    id: $('#editItemForm #id').val(),
                    company_id: $('#editItemForm #company_id').val(),
                    title: $('#editItemForm #title').val(),
                    price: $('#editItemForm #price').val(),
                    currency_id: $('#editItemForm #currency_id').val(),
                    first_payment_time: $('#editItemForm #first_payment_time').val(),
                    last_payment_time: $('#editItemForm #last_payment_time').val(),
                    status: $('#editItemForm #status').val(),
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
                url: "{{ route("service.detail") }}",
                data: {
                    id: id,
                },
                success: function (data) {
                    $('#editItemForm #id').val(data.service.id);
                    var selected_company_id = data.selected_company.id;
                    var selected = '';
                    $.each(data.companies, function (key, value) {
                        if (value['id'] === selected_company_id && data.service.title !== "Yeni Servis") {
                            selected = ' selected';
                        }
                        $("#editItemForm #company_id").append($("<option " + selected + "></option>").attr("value", value['id']).text(value['title']));
                        selected = '';
                    });
                    if (data.service.title === "Yeni Servis")
                        $('#editItemForm #title_current').val(data.service.title);
                    else
                        $('#editItemForm #title').val(data.service.title);
                    $('#editItemForm #price').val(data.service.price);
                    $('#editItemForm #currency_id').val(data.service.currency_id);
                    $('#editItemForm #first_payment_time').val(data.service.first_payment_time);
                    $('#editItemForm #last_payment_time').val(data.service.last_payment_time);
                    $('#editItemForm #next_payment_time').html(data.next_payment_time);
                    var service_status = data.service_status;
                    var selected = '';
                    $.each(data.status_values, function (key, value) {
                        if (key == service_status) {
                            selected = ' selected';
                        }
                        $("#editItemForm #status").append($("<option " + selected + "></option>").attr("value", key).text(value));
                        selected = '';
                    });
                    $('#editItemForm #days_left').html(data.days_left);
                    if (data.service.title === "Yeni Servis")
                        $('#editItemForm #delete_button').attr('onclick', 'deleteRequest(' + data.service.id + ');');
                    else
                        $('#editItemForm #delete_button').attr('onclick', 'runDeleteModal(' + data.service.id + ', "' + data.service.title + '");');
                    $('#editItemButton').click();
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
