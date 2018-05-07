@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <form method="post" action="{{route('links-prefixes.store')}}">
                            <div>
                                {{csrf_field()}}
                                <select name="link">
                                    <option selected disabled>select link</option>
                                    @foreach($links as $link)
                                        <option value="{{$link}}">{{$link}}</option>
                                    @endforeach
                                </select>
                                <input name="prefix">
                            </div>

                            <button type="submit">save</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
