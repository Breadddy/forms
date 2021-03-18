@extends('layouts.app')
<title>Результаты формы {{$name}}</title>
@if(!empty($answers))
@section('content')
    <div class="container">
        <center><h1>{{$name}}</h1></center>
        <?$number = 1?>
        @foreach($answers as $lead)
            <h2><b>#{{$number}} Результат формы</b></h2><br>
            @foreach($lead as $pair)
                <h3>Q: {{$questions[$pair['question_id']]}}</h3>
                <h5 style="margin-left: 20px">A: {{$pair['answer']}}</h5>
            @endforeach
            <?$number++?>
            <hr>
        @endforeach
    </div>
@endsection
@else
@section('content')
    <center><h5>Эту форму ещё никто не заполнял, поэтому у вас есть шанс стать первым!</h5></center>
@endsection
@endif
