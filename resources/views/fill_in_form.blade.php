@extends('layouts.app')
<title><?=$name?></title>
@section('content')
    <center><h1><?=$name?></h1></center><br>

    @if(!empty($questions->toArray()))
        <form method="POST" action="{{ route('filling_in_form', ['id' => $form_id]) }}">
            {{ csrf_field() }}
            @foreach ($questions as $key=>$question)
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right"><b><?= $question?></b></label>
                    <div class="col-md-6"><input type="text" name="question_<?=$key?>" value=""
                                                 <?=(array_key_first($questions->toArray()) == $key) ? 'autofocus' : ''?> class="form-control">
                    </div>
                </div>
            @endforeach
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Отправить
                    </button>
                </div>
            </div>
        </form>
    @else
        <center><h5>В этой форме пока нет вопросов, поэтому у вас не получится её заполнить</h5></center>
    @endif
@endsection

