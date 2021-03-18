@extends('layouts.app')
<title>{{ $name ?? 'Новая форма' }}</title>
@if(Auth::check())
@section('content')
    <div class="container">
        <center><h1>{{ $name ?? 'Новая форма' }}</h1></center>
        <br>
        @if(isset($form_id))
            <form method="POST" action="{{ route('edit_form', ['id' => $form_id]) }}">
                @else
                    <form method="POST" action="{{ route('create_form') }}">
                        @endif
                        {{ csrf_field() }}
                        @if(isset($questions))
                            <center><h3>Вопросы:</h3></center><br>
                            <?$i = 1;?>
                            @foreach ($questions as $key => $question)
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right"><b>Вопрос <?=$i?></b></label>
                                    <div class="col-md-6"><input type="text" name="<?='question_' . $key?>"
                                                                 value="<?=$question?>"
                                                                 autofocus="autofocus" class="form-control"></div>
                                </div>
                                <?$i++?>
                            @endforeach
                            <br><br><br>
                        @endif
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right"><b>Название формы</b></label>
                            <div class="col-md-6"><input type="text" name="name" value="<?=$name ?? ''?>"
                                                         required="required"
                                                         autofocus="autofocus" class="form-control"></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right"><b>Новый вопрос</b></label>
                            <div class="col-md-6"><input type="text" name="new_question" value=""
                                                         <?=(!empty($name)) ? 'autofocus' : 'required'?> class="form-control">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Отправить
                                </button>
                            </div>
                        </div>
                    </form>
    </div>
@endsection
@else
@section('content')
    <h4><a href="{{ route('register') }}">Зарегистрируйтесь</a> или <a href="{{ route('login') }}">войдите</a>,
        чтобы иметь возможность создать или изменить форму</h4>
@endsection
@endif

