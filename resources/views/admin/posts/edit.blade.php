@extends('layouts.dashboard')

@section('title')
Обратная связь
@stop

@section('content')
<div class="card">
    <div class="card-header">
        Редактирование записи
        <a href="{{route('admin.posts.index')}}" class="btn btn-sm btn-primary float-right"><i class="fa fa-arrow-left"></i></a>
    </div>
    <div class="card-body">
        <form action="{{route('admin.posts.update', $post->id)}}" enctype="multipart/form-data" method="post">
            @csrf
            <input type="hidden" name="_method" value="put">
            <div class="form-group">
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title') ?? $post->title}}" placeholder="Название">
                @error('title')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="form-group">
                <textarea type="text" name="preview_text" class="form-control @error('preview_text') is-invalid @enderror" placeholder="Текст превью">{{old('preview_text') ??  $post->preview_text}}</textarea>
                @error('preview_text')<div class="invalid-feedback">{{$message}}</div>@enderror
            </div>
            <div class="form-group">
                <textarea type="text" rows="6" name="detail_text" class="form-control @error('detail_text') is-invalid @enderror" placeholder="Полный текст">{{old('detail_text') ?? $post->detail_text}}</textarea>
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
        <div class="row mt-3">
            @if($post->preview_picture)
                <div class="col-md-6">
                    <form class="confirm" action="{{route('admin.posts.removePreview', $post->id)}}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <img src="/storage/{{$post->preview_picture}}" class="img-fluid">
                                <button class="btn btn-sm btn-danger position-absolute" style="top: 10px; right: 10px;">Удалить</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
            @if($post->detail_picture)
                <div class="col-md-6">
                    <form class="confirm" action="{{route('admin.posts.removeDetail', $post->id)}}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <img src="/storage/{{$post->detail_picture}}" class="img-fluid">
                                <button class="btn btn-sm btn-danger position-absolute" style="top: 10px; right: 10px;">Удалить</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
        
        
    </div>
</div>
@stop