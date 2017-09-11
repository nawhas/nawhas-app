@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <form method="post" action="http://api.nawhas.app/v1/reciters" enctype="multipart/form-data">
            Name: <input type="text" name="name" class="form-control">
            <br>
            Description: <textarea name="description" class="form-control"></textarea>
            <br>
            Image: <input type="file" name="image_path" class="form-control">
            <br>
            <input type="submit" name="submit" value="Create" class="btn btn-success">
        </form>
    </div>
</div>
@endsection
