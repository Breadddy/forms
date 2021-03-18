@extends('layouts.app')
<title>Все формы</title>
@if(!empty($questions))
@section('content')
    <div class="container">
        <center><h1>Все формы</h1><br></center>
        @foreach($ids as $id)
            <div class="col-md-12">
                <br><span class="row">
                    <a id="rotating_link{{$id}}" onclick="rotateFunction(<?=$id?>)"
                       class="btn btn-lg btn-default dropdown-toggle" data-toggle="collapse" href="#form{{$id}}"
                       role="button" aria-expanded="false" aria-controls="form{{$id}}"></a>
                <h4><b><?= $names[$id]?></b></h4>
                    @if(Auth::check())
                        <a style="margin-left: 20px" class="btn btn-outline-primary btn-sm" role="button"
                           href="{{route('form_results', ['id' => $id])}}">Результаты формы</a>
                        <a style="margin-left: 20px" class="btn btn-outline-primary btn-sm" role="button"
                           href="{{route('edit_form', ['id' => $id])}}">Редактировать форму</a>
                    @endif
                    <a style="margin-left: 20px" class="btn btn-outline-primary btn-sm" role="button"
                       href="{{route('fill_in_form', ['id' => $id])}}">Заполнить форму</a>
                </span>
                @if(isset($questions[$id]))
                    <div class="collapse" id="form{{$id}}">
                        @foreach ($questions[$id] as $question)
                            <div style="font-size: 20px">{{ $question}}</div>
                        @endforeach
                    </div>
                @endif
            </div>
            <hr>
        @endforeach
    </div>
@endsection
@else
@section('content')
    <center><h5>Форм не найдено</h5></center>
@endsection
@endif


