@extends('layouts.Dashboard_app')

@section('content')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/bootstrap-select.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/bootstrap-select.js') }}"></script>

<!-- 以下為登錄驗證 -->
@if (Route::has('login'))
<div class="top-right links">
@auth
<!-- 以上為登錄驗證 -->
    @if (Auth::user()->ranks == 'admin')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                        @if($errors->any())
                            <div class = "success">
                                <p class = "alert alert-info">{{ $errors->first() }}</p>
                            </div>
                        @endif
                            <ul role="tablist" class="nav nav-tabs justify-content-center">
                                <li class = "nav-item">
                                    <a class = "nav-link {{ request()->is('Manager') ? 'active' : null }}" href="{{ url('Manager') }}" role="tab"><h3>Add User</h3></a>
                                </li>
                                <li class = "nav-item">
                                    <a class = "nav-link {{ request()->is('User-Manager') ? 'active' : null }}" href="{{ url('User-Manager') }}" role="tab"><h3>Manage User</h3></a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane {{ request()->is('User-Manager') ? 'active' : null }}" id="{{ url('User-Manager') }}" role="tabpanel">
                                    <table class="TB_COLLAPSE">
                                        <thead>
                                            <tr>
                                                <th>Delete</th>
                                                <th>User Name</th>
                                                <th>User Mail</th>
                                                <th>User Jar</th>
                                                <th>Edite</th>
                                                <th>Created Data</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <div style="display:none">{{ $sum = 0 }}</div>
                                            @foreach($files as $file)
                                                @if ($file->ranks == 'admin')

                                                @else
                                                    <tr>
                                                        <td>
                                                            <button class="btn btn-danger" data-toggle="modal" data-target="#modaldelete-{{ $file->id }}">刪除</button>
                                                            <div class="modal fade" id="modaldelete-{{ $file->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="deleteModalLabel">確定刪除?</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        </div>
                                                                        <div class="modal-body" style = "color:red;">一旦刪除後資料就不可恢復，請再次確認是否要刪除</div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                                                            <a class="btn btn-danger" type="submit" href="/accountdelete/{{ $file->email }}">刪除</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><a>{{ $file->name}}</td>
                                                        <td><a>{{ $file->email}}</td>
                                                        <td><a>{{ $file->userjarid}}</td>
                                                        <td>
                                                            <button class="btn btn-success" data-toggle="modal" data-target="#modaledit-{{ $file->id }}">修改</button>
                                                            <div class="modal fade" id="modaledit-{{ $file->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form action="/accountedit" method="GET">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="editModalLabel">確定修改?</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body" style = "color:red;">請在下方輸入修改數值請依照格式進行輸入！
                                                                                <div class="input-group mb-3">
                                                                                    <input id="editname-{{ $file->id }}" name="editname" type="text" class="form-control" >
                                                                                    <input id="emailname-{{ $file->email }}" name="emailname" type="hidden" class="form-control" value="{{ $file->email }}">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text">EX:1,2,3</span>
                                                                                    </div>
                                                                                </div>
                                                                                <script>
                                                                                    var jarval = "{{ $file->userjarid }}";
                                                                                    $('#editname-{{ $file->id }}').attr("value",jarval);
                                                                                </script>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                                                                <button class="btn btn-success">修改</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><a>{{ $file->created_at}}</td>
                                                    </tr>
                                                @endif
                                            <div style="display:none">{{ $sum += 1 }}</div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane {{ request()->is('Manager') ? 'active' : null }}" id="{{ url('Manager') }}" role="tabpanel">
                                    <table class="TB_COLLAPSE">
                                        <div class="card">
                                            <div class="card-header">{{ __('Register') }}</div>

                                            <div class="card-body">
                                                <form method="POST" action="{{ route('register') }}">
                                                    @csrf

                                                    <div class="form-group row">
                                                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="ranks" class="col-md-4 col-form-label text-md-right">{{ __('User Ranks') }}</label>

                                                        <div class="col-md-6">
                                                            <select class="custom-select" id="ranks" type="ranks" name="ranks">
                                                                <option value="common-user">一般使用者</option>
                                                                <option value="admin">管理員</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                    <label for="userjar" class="col-md-4 col-form-label text-md-right">{{ __('User Jar') }}</label>

                                                    <div class="col-md-6">
                                                        <input type="hidden" id="userjarid" name="userjarid" readonly>
                                                        <select  type="text" id="userjarselect" name="userjarselect" class="selectpicker" multiple data-selected-text-format="count > 3">
                                                            <option value="1">魚缸1</option>
                                                            <option value="2">魚缸2</option>
                                                            <option value="3">魚缸3</option>
                                                            <option value="4">魚缸4</option>
                                                        </select>
                                                        <script>
                                                            $("#userjarselect").change(function(){
                                                                $selectname = $('#userjarselect').val();
                                                                $('#userjarid').attr("value",$selectname);
                                                            });
                                                        </script>
                                                    </div>

                                                    <div class="form-group row mb-0">
                                                        <div class="col-md-6 offset-md-4">
                                                            <button type="submit" class="btn btn-primary">
                                                                {{ __('Register') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger" role="alert" style="font-family:DFKai-SB; text-align:center;" >
            <h3>您帳戶的權限不足預覽此頁面</h3>
        </div>
    @endif

<!-- 以下為登錄驗證 -->
@else
    <div class="alert alert-danger" role="alert" style="font-family:DFKai-SB; text-align:center;" >
        <h3>尚未登錄，請先登錄或註冊</h3>
    </div>
@endauth
</div>
@endif
<!-- 以上為登錄驗證 -->

@endsection




