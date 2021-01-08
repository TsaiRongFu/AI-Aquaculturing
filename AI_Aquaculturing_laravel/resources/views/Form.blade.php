@extends('layouts.app')

@section('content')

<!-- 以下為登錄驗證 -->
@if (Route::has('login'))
<div class="top-right links">
@auth
<!-- 以上為登錄驗證 -->
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
                            <a class = "nav-link {{ request()->is('Form') ? 'active' : null }}" href="{{ url('Form') }}" role="tab"><h3>Patient</h3></a>
                        </li>
                        <li class = "nav-item">
                            <a class = "nav-link {{ request()->is('Control-Form') ? 'active' : null }}" href="{{ url('Control-Form') }}" role="tab"><h3>Evaluation Base</h3></a>
                        </li>
                    </ul>
                    <!-- <nav>
                        <div id="nav-tab" role="tablist" class="nav nav-tabs justify-content-center">
                            <a data-toggle="tab" href="#Form" class="nav-item nav-link active show">
                                <h3>Form</h3>
                            </a>
                            <a data-toggle="tab" href="#Control-Form" class="nav-item nav-link">
                                <h3>Control Form</h3>
                            </a>
                        </div>
                    </nav> -->
                    <div class="tab-content">
                        <div class="tab-pane {{ request()->is('Form') ? 'active' : null }}" id="{{ url('Form') }}" role="tabpanel">
                            <table id="sort-table" data-toggle="table" class="TB_COLLAPSE">
                                <thead>
                                    <tr>
                                        <th data-field="Delete">Delete</th>
                                        <th data-field="File Name" data-sortable="true">File Name</th>
                                        <th data-field="Upload By" data-sortable="true">Upload By</th>
                                        <th data-field="Upload Time" data-sortable="true">Upload Time</th>
                                        <th data-field="Score">Score</th>
                                        <th data-field="Result">Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($file as $item)
                                    <div style="display:none">{{ $sum = 0 }}</div>
                                        <tr>
                                            <td>
                                                <button class="btn btn-danger" data-toggle="modal" data-target="#modaldelete-{{ $item->id }}">刪除</button>
                                                <div class="modal fade" id="modaldelete-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="deleteModalLabel">確定刪除?</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            </div>
                                                            <div class="modal-body" style = "color:red;">一旦刪除後資料就不可恢復，請再次確認是否要刪除</div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                                                <a class="btn btn-danger" type="submit" href="/delete/{{$item->filename}}">刪除</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><a href="/download/{{$item->filename}}" class="text-primary">{{ $item->filename }}</td>
                                            <td>{{ $item->user_name }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td><a class="btn btn-primary" type="submit" href="/score/{{$item->filename}}">評分</td>
                                            <td><a class="btn btn-primary" type="submit" href="/GeneShow/{{$file->currentpage()}}/{{$item->filename}}">結果</td>
                                        </tr>
                                    <div style="display:none">{{ $sum += 1 }}</div>
                                @endforeach
                                </tbody>
                            </table>
                            <br>
                            <div class="d-flex justify-content-center">
                                {{ $file -> links() }}
                            </div>
                        </div>
                        <div class="tab-pane {{ request()->is('Control-Form') ? 'active' : null }}" id="{{ url('Control-Form') }}" role="tabpanel">
                            <table id="sort-table" data-toggle="table" class="TB_COLLAPSE">
                                <thead>
                                    <tr>
                                        <th data-field="Delete">Delete</th>
                                        <th data-field="File Name" data-sortable="true">File Name</th>
                                        <th data-field="Upload By" data-sortable="true">Upload By</th>
                                        <th data-field="Upload Time" data-sortable="true">Upload Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($control as $item1)
                                    <tr>
                                        <td>
                                            <button class="btn btn-danger" data-toggle="modal" data-target="#modaldelete-{{ $item1->id }}">刪除</button>
                                            <div class="modal fade" id="modaldelete-{{ $item1->id }}" tabIndex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="deleteModalLabel">確定刪除?</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        </div>
                                                        <div class="modal-body" style = "color:red;">一旦刪除後資料就不可恢復，請再次確認是否要刪除</div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                                            <a class="btn btn-danger" type="submit" href="/control_delete/{{ $item1->filename }}">刪除</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="/control_download/{{$item1->filename}}" class="text-primary">{{$item1->filename}}</td>
                                        <td>{{ $item1->user_name }}</td>
                                        <td>{{ $item1->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <br>
                            <div class="d-flex justify-content-center">
                                {{ $control -> links() }}
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>



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




