@extends('layouts.dashboard')

@section('title')
Блог
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Новая запись
        <a href="{{route('admin.posts.index')}}" class="btn btn-sm btn-primary float-right"><i class="fa fa-arrow-left"></i></a>
    </div>
    <div class="card-body">
        <form action="{{route('admin.posts.store')}}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="form-group">
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title')}}" placeholder="Название">
                @error('title')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="form-group">
                <textarea type="text" name="preview_text" class="form-control @error('preview_text') is-invalid @enderror" value="{{old('preview_text')}}" placeholder="Текст превью"></textarea>
                @error('preview_text')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="form-group">
                <textarea type="text" rows="6" name="detail_text" class="form-control @error('detail_text') is-invalid @enderror" value="{{old('detail_text')}}" placeholder="Полный текст"></textarea>
                @error('detail_text')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <div class="custom-file @error('preview_picture') is-invalid @enderror">
                            <input type="file" class="custom-file-input simple-file" name="preview_picture" id="preview" ref="input">
                            <label class="custom-file-label" for="preview">Картинка превью</label>
                            @error('preview_picture')<div class="invalid-feedback">{{$message}}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <div class="custom-file @error('detail_picture') is-invalid @enderror">
                            <input type="file" class="custom-file-input simple-file" name="detail_picture" id="detail" ref="input">
                            <label class="custom-file-label" for="detail">Детальная картинка</label>
                            @error('detail_picture')<div class="invalid-feedback">{{$message}}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-sm btn-primary">Сохранить</button>
        </form>
    </div>
</div>
@stop