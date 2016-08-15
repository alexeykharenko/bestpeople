@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Регистрация</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}"
                    enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                            <label for="login" class="col-md-4 control-label">Логин</label>
                            <div class="col-md-5">
                                <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}"
                                required>
                                <span class="help-block">
                                    Логин должен начинаться с латинской буквы и состоять из
                                    латинских букв и, если пожелаете, цифр.
                                </span>
                                @if ($errors->has('login'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('login') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Пароль</label>
                            <div class="col-md-5">
                                <input id="password" type="password" class="form-control" name="password" maxlength="25" 
                                required>
                                <span class="help-block">
                                    Пароль должен содержать хотя бы одну цифру.
                                </span>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 checkbox">
                                <label for="show-password">
                                    <input id="show-password" type="checkbox" name="show-password" value="show">
                                    Показать пароль
                                </label>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
                            <label for="avatar" class="col-md-4 control-label">Аватар</label>
                            <div class="col-md-5">
                                <input id="avatar" type="file" class="form-control" name="avatar">
                                @if ($errors->has('avatar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sex" class="col-md-4 control-label">Пол</label>
                            <div class="col-md-5">
                                <select class="form-control" id="sex" name="sex" class="col-md-5" size="1">
                                    <option value="male" {{ old('sex')=='male' ? 'selected' : '' }}>Мужской</option>
                                    <option value="female" {{ old('sex')=='female' ? 'selected' : '' }}>Женский</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Зарегистрироваться
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('scripts/auth/showPassword.js') }}"></script>
@endsection
