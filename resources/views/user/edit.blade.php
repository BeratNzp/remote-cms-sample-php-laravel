@extends('master')
@section('page_title', 'Kullanıcı Düzenle')
@section('page_head')
@endsection
@section('page_content')
    <div class="col-md-12 col-sm-12 ">
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Kullanıcı Düzenle</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> <!-- content -->
                        <form id="userEditForm" action="{{ route('user.edit_action', ['id' => $user->id]) }}"
                              method="POST"
                              data-parsley-validate=""
                              class="form-horizontal form-label-left" novalidate="">
                            <div id="messages"></div>
                            {{ csrf_field() }}
                            <div class="item form-group">
                                <label for="user_id" class="col-form-label col-md-3 col-sm-3 label-align">ID</label>
                                <div class="col-md-6 col-sm-12">
                                    <input type="text" class="form-control has-feedback-left" name="user_id"
                                           id="user_id"
                                           readonly value="{{ $user->id }}">
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
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}"
                                                    @if($user->company_id == $company->id) selected @endif >{{ $company->title }}</option>
                                        @endforeach
                                    </select>
                                    <span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="item form-group">
                                <label for="department_id"
                                       class="col-form-label col-md-3 col-sm-3 label-align">Departman</label>
                                <div class="col-md-6 col-sm-12">
                                    <select class="form-control has-feedback-left" id="department_id"
                                            name="department_id">
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}"
                                                    @if($user->department_id == $department->id) selected @endif >
                                                {{ $department->title }}
                                            </option>
                                        @endforeach
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
                                           id="first_name"
                                           value="{{ $user->first_name }}">
                                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="item form-group">
                                <label for="last_name"
                                       class="col-form-label col-md-3 col-sm-3 label-align">Soyisim</label>
                                <div class="col-md-6 col-sm-12">
                                    <input type="text" class="form-control has-feedback-left" name="last_name"
                                           id="last_name"
                                           value="{{ $user->last_name }}">
                                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="item form-group">
                                <label for="email" class="col-form-label col-md-3 col-sm-3 label-align">Email</label>
                                <div class="col-md-6 col-sm-12">
                                    <input type="email" class="form-control has-feedback-left" name="email" id="email"
                                           value="{{ $user->email }}">
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
                                <label for="password2" class="col-form-label col-md-3 col-sm-3 label-align">Parola
                                    (Tekrar)</label>
                                <div class="col-md-6 col-sm-12">
                                    <input type="password" class="form-control has-feedback-left"
                                           name="password_confirmation"
                                           id="password2">
                                    <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="item form-group">
                                <div class="col-md-6 col-sm-6 offset-md-3">
                                    <button type="submit" id="submit_button" class="btn btn-success float-right">Kaydet
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div> <!-- .content -->
                </div>
            </div>

        </div>
    </div>
@endsection
@section('page_scripts')
    <script type="text/javascript">
        function getDepartmentsOfCompany() {
            $('#department_id').html('');
            $("#department_id").append($("<option></option>").attr("value", "").text('Lütfen önce şirket seçiniz'));
            var company_id = $('#company_id').val();
            if (company_id > 0) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route("getDepartmentsOfCompany") }}",
                    data: {
                        company_id: company_id,
                    },
                    success: function (data) {
                        $('#department_id').html('');
                        var user_department_id = {{ $user->department_id }};
                        var selected = '';
                        $.each(data.departments, function (key, value) {
                            if (value['id'] == user_department_id) {
                                selected = ' selected';
                            }
                            $("#department_id").append($("<option " + selected + "></option>").attr("value", value['id']).text(value['title']));
                            selected = '';
                        });
                    },
                });
            }
        }
    </script>
    <script type="text/javascript">
        $('#userEditForm').submit(function (e) {
            $('#submit_button').prop('disabled', true);
            $('#submit_button').html('<img width="16" height="16" src="{{ asset("images/loading.gif") }}">');
            setTimeout(function () {
                $('#submit_button').prop('disabled', false);
                $('#submit_button').html('Kaydet');
            }, 2000);
            $("#userEditForm #messages").html(null);
            var inputs = $('#userEditForm .form-group');
            inputs.removeClass('has-error');
            inputs.find('.help-block').html(null);
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var form = $('#userEditForm')[0];
            var formData = new FormData(form);
            $.ajax({
                type: "POST",
                url: $(this).attr("action"),
                enctype: "multipart/form-data",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
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
                    var msg_field = '';
                    $.each(data.responseJSON.errors, function (key, value) {
                        var formGroup = $("#userEditForm #" + key).closest(".form-group");
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
                    if (!data.responseJSON.errors) {
                    }
                }
            });
            return false;
        });
    </script>
@endsection
