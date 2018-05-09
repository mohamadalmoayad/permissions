@extends('permissions::layouts.master')
@section('style')
    <style>
        #permissions-div {
            margin-top: 75px;
        }

        #get-user-div {
            margin: 15px 0;
            padding: 15px;
            border: #636b6f 1px solid;
            border-radius: 4px;
        }

        label {
            display: block !important;
            color: #ca6768 !important;
            font-weight: bold !important;
            font-size: larger !important;
            text-align: center;
        }
    </style>
@endsection
@section('content')
    <div class="container" id="permissions-div">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div id="get-user-div" class="col-md-12 justify-content-center">
                    <form method="post" action="{{route('get-permissions')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="view" value="permissions.show">
                        <div class="form-group align-items-center">
                            @if(isset($users))
                                <select class="form-control" name="user" id="userID">
                                    <option selected disabled>select user</option>
                                    @foreach($users as $unit)
                                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <button class="btn btn-info btn-block" type="submit">get permissions</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection





