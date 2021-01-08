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
                    @if(isset($message))
                    <div class = "success">
                        <p class = "alert alert-info">{{ $message }}</p>
                    </div>
                    @endif
                    <form class = "form" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group col-md-12">
                            <h2 class="h2">Manage Files</h2>
                        </div>
                        <hr>
                        <ul role="tablist" class="nav nav-tabs justify-content-center">
                            <li class = "nav-item">
                                <a class = "nav-link {{ request()->is('Upload') ? 'active' : null }}" href="{{ url('Upload') }}" role="tab"><h3>Upload Patient Data</h3></a>
                            </li>
                            <li class = "nav-item">
                                <a class = "nav-link {{ request()->is('Upload-Control') ? 'active' : null }}" href="{{ url('Upload-Control') }}" role="tab"><h3>Upload Evaluation Base</h3></a>
                            </li>
                            <li class = "nav-item">
                                <a class = "nav-link {{ request()->is('Example-File') ? 'active' : null }}" href="{{ url('Example-File') }}" role="tab"><h3>Upload Examples</h3></a>
                            </li>
                        </ul>
                        <!-- <nav>
                            <div id="nav-tab" role="tablist" class="nav nav-tabs justify-content-center">
                                <a data-toggle="tab" href="#Upload-File" class="nav-item nav-link active show">
                                    <h3>Upload File</h3>
                                </a>
                                <a data-toggle="tab" href="#Upload-Control-File" class="nav-item nav-link">
                                    <h3>Upload Control File</h3>
                                </a>
                                <a data-toggle="tab" href="#Example-File" class="nav-item nav-link">
                                    <h3>Example File</h3>
                                </a>
                            </div>
                        </nav> -->
                        <div class="tab-content">
                            <div class="tab-pane {{ request()->is('Upload') ? 'active' : null }}" id="{{ url('Upload') }}" role="tabpanel">
                                <div class="form-group col-md-6">
                                    <label class="col-form-label">Upload Patient Data：</label>
                                    <input class = "form-control-file" type = "File" name = "File[]" accept = ".txt, .csv" multiple>
                                </div>
                                <div class="form-group col-md-6">
                                    <button type="submit" class="btn btn-lg btn-success">
                                        Upload
                                    </button>
                                </div>
                            </div>
                            <div class="tab-pane {{ request()->is('Upload-Control') ? 'active' : null }}" id="{{ url('Upload-Control') }}" role="tabpanel">
                                <div class="form-group col-md-6">
                                    <label class="col-form-label">Upload Evaluation Base：</label>
                                    <input class = "form-control-file" type = "File" name = "ControlFile[]" accept = ".txt, .csv" multiple>
                                </div>
                                <div class="form-group col-md-6">
                                    <button type="submit" class="btn btn-lg btn-success">
                                        Upload
                                    </button>
                                </div>
                            </div>
                            <div class="tab-pane {{ request()->is('Example-File') ? 'active' : null }}" id="{{ url('Example-File') }}" role="tabpanel">
                                <div class="form-group col-md-6">
                                    <label class="col-form-label"><h4>Upload Patient Data 上傳範例</h4>
                                    <p>
                                        <h6>#在Genes那欄下面放病人基因#</h6></label>
                                    <p>
                                    <a href="/download_Example/Abiraterone_Example.csv">任意檔名.csv</a>
                                </div>
                                <hr />
                                <div class="form-group col-md-6">
                                    <label class="col-form-label"><h4>Upload Evaluation Base 上傳範例</h4>
                                    <p>
                                        <h6>#依照這個檔名和格式，Weight一定要換成小數點#</h6>
                                    </label>
                                    <p>
                                    Abiraterone : <a href="/download_Example/Abiraterone.csv">Abiraterone.csv</a>
                                    <p>
                                    Enzalutamide : <a href="/download_Example/Enzalutamide.csv">Enzalutamide.csv</a>
                                </div>
                            </div>
                        </div>
                    </form>
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