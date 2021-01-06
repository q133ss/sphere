@extends('layouts.dashboard')

@section('title')
Редактирование материала
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{route('admin.materials.index')}}" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left"></i></a>
        <span>Редактирование материала</span>
    </div>
    <div class="card-body">
        @if($errors->count())
        <div class="alert alert-danger">
            <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
            </ul>
        </div>
        @endif
        <form action="{{route('admin.materials.update', $material->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col"><div class="form-group"><input value="{{ old('name') ? old('name') : $material->name  }}" type="text" name="name" placeholder="Название" required class="form-control"></div></div>
                <div class="col">
                    <select name="subject_id" class="form-control" placeholder="Предмет" required>
                        <option disabled selected value=""></option>
                        @foreach($subjects as $subject)<option value="{{$subject->id}}" @if($subject->id == $material->subject_id) selected @endif>{{$subject->name}}</option>@endforeach
                    </select>
                </div>
                <div class="col"><div class="form-group"><input value="{{ old('price') ? old('price') : $material->price }}" type="number" min="0" name="price" placeholder="Цена" class="form-control"></div></div>
                <div class="col">
                    <select name="available" class="form-control">
                        <option @if($material->available == 'free') selected @endif value="free">Бесплатно</option>
                        <option @if($material->available == 'subscribe') selected @endif value="subscribe">Подписка</option>
                        <option @if($material->available == 'payment') selected @endif value="payment">Покупка</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="custom-file">
                            <input multiple name="book[]" type="file" class="custom-file-input simple-file" id="f1">
                            <label class="custom-file-label" for="f1">Учебники</label>
                            @error('book[]')<div class="invalid-feedback">{{$message}}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="custom-file">
                            <input multiple name="workbook[]" type="file" class="custom-file-input simple-file" id="f2">
                            <label class="custom-file-label" for="f2">Рабочие тетради</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="custom-file">
                            <input multiple name="media[]" type="file" class="custom-file-input simple-file" id="f3">
                            <label class="custom-file-label" for="f3">Медиа</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <button class="btn btn-sm btn-primary">Сохранить</button> -->
        </form>
        <p>Файлы</p>
        @foreach($material->files as $file)
            <div class="row mb-1">
                <div class="col">{{$file->category == 'book' ? 'Учебник' : ($file->category == 'workbook' ? 'Рабочая тетрадь' : 'Медиафайл')}}</div>
                <div class="col">{{$file->name}}</div>
                <div class="col">{{number_format($file->size / 1024, 1, ',', '')}} Kb</div>
                <div class="col">
                    <form action="{{route('admin.files.destroy', $file->id)}}" class="confirm" method="post">
                        <input type="hidden" value="delete" name="_method">
                        @csrf
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@stop