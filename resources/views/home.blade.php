<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
<body>
@foreach($users->data as $data)
    <p>{{$data->id}} - {{ $data->name }}</p>
    <p><img src="{{ $data->picture->data->url }}" alt=""></p>
    <br/>
@endforeach
</body>
</html>