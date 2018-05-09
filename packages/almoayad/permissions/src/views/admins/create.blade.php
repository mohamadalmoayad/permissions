@extends('permission::layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div>
                        <form method="post" action="{{route('admins-permissions.store')}}">
                            {{csrf_field()}}
                            <select name="user_id">
                                @if(isset($users))
                                    <option selected disabled>select user</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <input type="checkbox" name="is_active" id="active" value="false">
                            <button type="submit">Permit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#active').on('change', function () {
                var check = $(this).val();

                if (check == 'false') {
                    $('#active').val("true");
                } else {
                    $('#active').val("false");
                }

            });
        });
    </script>
@endsection




