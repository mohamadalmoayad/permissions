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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div id="get-user-div" class="col-md-12 justify-content-center">
                    <form method="post" action="{{route('get-permissions')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="view" value="permissions.create">
                        <div class="form-group align-items-center">
                            @if(isset($users))
                                <select class="form-control" name="user" id="userID">
                                    <option selected disabled>select user</option>
                                    @foreach($users as $unit)
                                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                                    @endforeach
                                </select>
                            @elseif(isset($user))
                                <label class="input-group-text">{{$user->name}}</label>
                            @endif
                        </div>
                        @if(!isset($user))
                            <button class="btn btn-info btn-block" type="submit">get permissions</button>
                        @endif
                    </form>
                </div>
                @if(isset($permissions))
                    <form method="post" action="{{route('permissions.store')}}">
                        <div>
                            {{csrf_field()}}
                            <input type="hidden" name="user" value="{{$user->id}}">
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>link</th>
                                    <th>prefix</th>
                                    <th>index</th>
                                    <th>create</th>
                                    <th>edit</th>
                                    <th>show</th>
                                    <th>delete</th>
                                    <th style="color: red">action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permissions as $permission)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$permission['link']}}<input type="hidden" name="link-{{$loop->iteration}}"
                                                                          value="{{$permission['link']}}"></td>
                                        <td>{{$permission['prefix']}}</td>
                                        <td>
                                            <input type="checkbox" id="index-{{$loop->index}}"
                                                   @if($permission['index'] == true) checked
                                                   @endif class="checkbox">
                                            <input type="hidden" id="inp-index-{{$loop->index}}"
                                                   name="index-{{$loop->iteration}}"
                                                   value="{{$permission['index']}}">
                                        </td>
                                        <td>
                                            <input type="checkbox" id="create-{{$loop->index}}"
                                                   @if($permission['create'] == true) checked
                                                   @endif class="checkbox">
                                            <input type="hidden" id="inp-create-{{$loop->index}}"
                                                   name="create-{{$loop->iteration}}"
                                                   value="{{$permission['create']}}">
                                        </td>
                                        <td>
                                            <input type="checkbox" id="edit-{{$loop->index}}"
                                                   @if($permission['edit'] == true) checked
                                                   @endif class="checkbox">
                                            <input type="hidden" id="inp-edit-{{$loop->index}}"
                                                   name="edit-{{$loop->iteration}}"
                                                   value="{{$permission['edit']}}">
                                        </td>
                                        <td>
                                            <input type="checkbox" id="show-{{$loop->index}}"
                                                   @if($permission['show'] == true) checked
                                                   @endif class="checkbox">
                                            <input type="hidden" id="inp-show-{{$loop->index}}"
                                                   name="show-{{$loop->iteration}}"
                                                   value="{{$permission['show']}}">
                                        </td>
                                        <td>
                                            <input type="checkbox" id="destroy-{{$loop->index}}"
                                                   @if($permission['destroy'] == true) checked
                                                   @endif class="checkbox">
                                            <input type="hidden" id="inp-destroy-{{$loop->index}}"
                                                   name="destroy-{{$loop->iteration}}"
                                                   value="{{$permission['destroy']}}">
                                        </td>
                                        <td>
                                            @if($permission['id'] != 0)
                                                <button type="button" id="{{$permission['id']}}"
                                                        class="btn btn-danger remove-permission">remove
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-dark btn-block" type="submit">save</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('.checkbox').on('change', function () {
                let id = $(this).attr('id');
                let inputVal = $('#inp-' + id).val();
                if (inputVal == 1) {
                    $('#inp-' + id).val(0);
                } else {
                    $('#inp-' + id).val(1);
                }
            });

            $('.remove-permission').on('click', function () {
                let id = $(this).attr('id');
                $.ajax({
                    type: "post",
                    url: "/permissions/" + id,
                    data: {
                        _method: "delete",
                    }
                }).done(function () {
                    location.reload();
                });
            });
        });
    </script>
@endsection




