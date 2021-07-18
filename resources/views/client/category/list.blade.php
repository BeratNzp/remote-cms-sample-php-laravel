@extends('master')
@section('page_title', 'Kategoriler')
@section('page_head')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="{{ asset("vendors/switchery/dist/switchery.min.css") }}">
@endsection
@section('page_content')
    <div class="col-md-12 col-sm-12 ">
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Kategorileri Listele</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> <!-- content -->
                        <div class="mb-2 mt-2">
                            @if(isset($up_category))
                                <a class="btn btn-secondary btn-sm text-white"
                                   href="{{ route("category.list_sub", $up_category->id) }}">
                                    < {{ $up_category->title }}
                                </a>
                            @endif
                            <a class="btn btn-primary btn-sm text-white" href="{{ route("category.list") }}">
                                Ana Kategoriler
                            </a>
                            <button class="btn btn-success btn-sm float-right" id="newItem">
                                Yeni
                            </button>
                        </div>
                        <table id="datatable-responsive"
                               class="display"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kategori</th>
                                <th>Üst Kategori</th>
                                <th>Tip</th>
                                <th>İşlem</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->title }}</td>
                                        <td>{{ isset($category->up_category) ? $category->up_category->title : '' }}</td>
                                        <td>{{ \App\Enums\CategoryType::getDescription(\App\Enums\CategoryType::parseDatabase($category->type_id)) }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm float-right"
                                                    onclick="runDeleteModal({{ $category->id }},'{{ $category->title }}');">
                                                Sil
                                            </button>
                                            <button class="btn btn-primary btn-sm float-right"
                                                    onclick="detail({{ $category->id }});">
                                                Düzenle
                                            </button>
                                            @if ($category->can_sub_category == 1)
                                                <a class="btn btn-secondary btn-sm float-right"
                                                   href="{{ route("category.list_sub", $category->id) }}">
                                                    Alt Kategoriler
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
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
                            <label for="type_id"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Kategori Tipi</label>
                            <div class="col-md-6 col-sm-12">
                                <select class="form-control has-feedback-left" id="type_id" name="type_id"
                                        onchange="getCategoriesOfType();">
                                    <option value="">Lütfen seçiniz</option>
                                </select>
                                <span class="fa fa-sticky-note-o form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="item form-group">
                            <label for="main_category"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Ana Kategori</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="checkbox" class="js-switch" id="main_category"
                                       onchange="switch_up_category();"
                                       name="main_category"/>
                            </div>
                        </div>
                        <div class="item form-group" id="up_category_block">
                            <label for="up_category_id"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Üst Kategori</label>
                            <div class="col-md-6 col-sm-12">
                                <select class="form-control has-feedback-left" id="up_category_id"
                                        name="up_category_id">
                                </select>
                                <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="item form-group">
                            <label for="title"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Başlık</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="hidden" name="title" id="title_current">
                                <input type="text" class="form-control has-feedback-left" name="title"
                                       id="title">
                                <span class="fa fa-ellipsis-h form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="item form-group">
                            <label for="can_sub_category"
                                   class="col-form-label col-md-3 col-sm-3 label-align">Alt Kategorisi Olabilir</label>
                            <div class="col-md-6 col-sm-12">
                                <input type="checkbox" class="js-switch" id="can_sub_category"
                                       name="can_sub_category"/>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="item">
                            <div class="col-md-6 col-sm-6 offset-md-3">
                                <div id="messages"></div>
                            </div>
                        </div>
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
        function getCategoriesOfType() {
            $('#editItemForm #up_category_id').html('');
            $('#editItemForm #up_category_id').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route("category.categories_of_type") }}",
                data: {
                    type_id: $('#editItemForm #type_id').val(),
                    id: $('#editItemForm #id').val(),
                },
                success: function (data) {
                    $('#editItemForm #up_category_id').html('');
                    $('#editItemForm #up_category_id').val();
                    /////////////
                    var selected_up_category_id = '';
                    if (data.selected_up_category)
                        selected_up_category_id = data.selected_up_category.id;
                    else
                        selected_up_category_id = 0;
                    var selected = '';
                    $.each(data.categories, function (key, value) {
                        if (value['id'] === selected_up_category_id && data.selected_category.title !== "Yeni Kategori") {
                            selected = ' selected';
                        }
                        $("#editItemForm #up_category_id").append($("<option " + selected + "></option>").attr("value", value['id']).text(value['title']));
                        selected = '';
                    });
                },
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
                url: "{{ route("category.delete") }}",
                beforeSend: function () {
                    $('#deleteItemAction').prop('disabled', true);
                    $('#deleteItemAction').html('<img width="16" height="16" src="{{ asset("images/loading.gif") }}"> Sil');
                },
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
                url: "{{ route("category.create") }}",
                @if( isset($request->id) )
                data: {
                    up_category_id: {{ $request->id }}
                },
                @endif
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
        });
    </script>
    <script type="text/javascript">
        $(document).on('click', '#closeEditItem', function () {
            if ($('#editItemForm #title_current').val() === 'Yeni Kategori')
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
                url: "{{ route("category.update") }}",
                enctype: "multipart/form-data",
                data: {
                    id: $('#editItemForm #id').val(),
                    up_category_id: $('#editItemForm #up_category_id').val(),
                    type_id: $('#editItemForm #type_id').val(),
                    title: $('#editItemForm #title').val(),
                    can_sub_category: $('#editItemForm #can_sub_category').prop('checked'),
                    main_category: $('#editItemForm #main_category').prop('checked'),
                },
                success: function (data) {
                    if (data.messages && data.sub_categories) {
                        if (data.sub_categories.length > 0) {
                            var messages = '<div class="text-danger">Mecvut alt kategoriler bulundu. Önce şu kategorileri silmelisiniz ya da başka kategoriye bağlamalısınız;<ul>';
                            $.each(data.sub_categories, function (key, value) {
                                {{--
                                messages += '<li>' + value['title'] + ' <a class="btn btn-danger btn-xs text-white" onclick="runDeleteModal(' + value['id'] + ', \'' + value['title'] + '\');">Sil</a></li>';
                                --}}
                                    messages += '<li>' + value['title'] + '</li>';
                            });
                            messages += '</ul></div>';
                            $("#editItemForm #messages").html(messages);
                        }
                    }
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
            })
            ;
            return false;
        })
        ;
    </script>
    <script type="text/javascript">
        function switch_up_category() {
            if ($('#main_category').is(':checked')) {
                $('#up_category_block').hide();
                //$('#up_category_block').style.maxHeight = '1px';
            } else {
                $('#up_category_block').show();
                //$('#up_category_block').style.maxHeight = '800px';
            }
        }

        function changeSwitcheryForCanSubCategory(element, checked) {
            if ((element.is(':checked') && checked === false) || (!element.is(':checked') && checked === true)) {
                element.parent().find('#can_sub_category').trigger('click');
            }
        }

        function changeSwitcheryForMainCategory(element, checked) {
            if ((element.is(':checked') && checked === false) || (!element.is(':checked') && checked === true)) {
                element.parent().find('#main_category').trigger('click');
            }
        }

        function detail(id) {
            $("#editItemForm #type_id").html(null);
            $("#editItemForm #type_id").append($("<option></option>").attr("value", "").text("Lütfen seçiniz"));
            $("#editItemForm #up_category_id").html(null);
            $("#editItemForm #messages").html(null);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route("category.detail") }}",
                data: {
                    id: id,
                },
                success: function (data) {
                    $('#editItemForm #id').val(data.category.id);
                    var selected_type_id = data.selected_type;
                    var selected = '';
                    $.each(data.types, function (key, value) {
                        if (key === selected_type_id && data.category.title !== "Yeni Kategori") {
                            selected = ' selected';
                        }
                        $("#editItemForm #type_id").append($("<option " + selected + "></option>").attr("value", key).text(value));
                        selected = '';
                    });
                    getCategoriesOfType();
                    var init = $('#can_sub_category');
                    if (data.category.can_sub_category === '0') {
                        changeSwitcheryForCanSubCategory(init, false);
                    } else if (data.category.can_sub_category === '1') {
                        changeSwitcheryForCanSubCategory(init, true);
                    }
                    var init2 = $('#main_category');
                    if (data.category.main_category === '0') {
                        changeSwitcheryForMainCategory(init2, false);
                    } else if (data.category.main_category === '1') {
                        changeSwitcheryForMainCategory(init2, true);
                    }
                    if (data.category.title === "Yeni Kategori")
                        $('#editItemForm #title_current').val(data.category.title);
                    else
                        $('#editItemForm #title').val(data.category.title);
                    if (data.category.title === "Yeni Kategori")
                        $('#editItemForm #delete_button').attr('onclick', 'deleteRequest(' + data.category.id + ');');
                    else
                        $('#editItemForm #delete_button').attr('onclick', 'runDeleteModal(' + data.category.id + ', "' + data.category.title + '");');
                    $('#editItemButton').click();
                },
            });
        }
    </script>
    <!-- Switchery -->
    <script src="{{ asset("vendors/switchery/dist/switchery.min.js") }}"></script>
    <!-- Datatables -->
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#datatable-responsive').DataTable();
        });
    </script>
@endsection
