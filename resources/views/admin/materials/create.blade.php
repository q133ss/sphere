@extends('layouts.dashboard')

@section('title')
Новый материал
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{route('admin.materials.index')}}" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left"></i></a>
        <span>Новый материал</span>
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
        <form action="{{route('admin.materials.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group"><input type="text" name="name" placeholder="Название" required class="form-control"></div>
                    <div class="form-group">
                        <select name="subject_id" class="form-control" placeholder="Предмет" required>
                            <option disabled selected value="">Предмет</option>
                            @foreach($subjects as $subject)<option value="{{$subject->id}}">{{$subject->name}}</option>@endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="custom-file">
                            <input name="book" type="file" class="custom-file-input simple-file" id="f1">
                            <label class="custom-file-label" for="f1">Учебники</label>
                            @error('book[]')<div class="invalid-feedback">{{$message}}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-file">
                            <input name="workbook" type="file" class="custom-file-input simple-file" id="f2">
                            <label class="custom-file-label" for="f2">Рабочие тетради</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-file">
                            <input multiple name="media[]" type="file" class="custom-file-input simple-file" id="f3">
                            <label class="custom-file-label" for="f3">Медиа</label>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-sm btn-primary">Сохранить</button>
        </form>
    </div>
</div>
@stop