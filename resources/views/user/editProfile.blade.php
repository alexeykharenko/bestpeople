@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Профиль</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/edit_profile') }}"
                    enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="hidden" name="_method" value="PUT">

                        <div class="form-group">
                            <label class="col-md-4 control-label">Мой логин</label>

                            <div class="col-md-5">
                                <p class="form-control-static">{{ $user->login }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-md-4 control-label"></label>

                            <div class="col-md-5">
                                <img src="{{ asset('uploads/avatars') . '/' . $user->avatar }}" width="50" height="50">
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('avatar') ? ' has-error' : '' }}">
                            <label for="avatar" class="col-md-4 control-label">Сменить аватар</label>

                            <div class="col-md-5">
                                <input id="avatar" type="file" class="form-control" name="avatar">

                                @if ($errors->has('avatar'))
                                    <span class="help-block">
                                        {{ $errors->first('avatar') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sex" class="col-md-4 control-label">Мой пол</label>

                            <div class="col-md-5">
                                <select class="form-control" id="sex" name="sex" class="col-md-5" size="1">
                                    <option value="male" {{ $user->sex == 'male' ? 'selected' : '' }}>Мужской</option>
                                    <option value="female" {{ $user->sex == 'female' ? 'selected' : '' }}>Женский</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn"></i> Сохранить изменения
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection