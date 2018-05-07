    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div>
                        <form method="post" action="{{route('get-permissions')}}">
                            {{csrf_field()}}
                            <select name="user">
                                @if(isset($users))
                                    <option selected disabled>select user</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <button type="submit">get permissions</button>
                        </form>

                    </div>

                    @if(isset($links))
                        <div class="card-header">Dashboard</div>
                        <div class="card-body">
                            <form method="post" action="{{route('permissions.store')}}">
                                <div>
                                    {{csrf_field()}}
                                    <input type="hidden" name="user" value="{{$user}}">
                                    <table>
                                        <tr>
                                            <th>#</th>
                                            <th>link</th>
                                            <th>prefix</th>
                                            <th>permissions</th>
                                        </tr>
                                        @for($i = 0; $i < count($links); $i++)
                                            <tr>
                                                <td>{{$i+1}}</td>
                                                <td>{{$links[$i]}}<input type="hidden" name="link-{{$i+1}}"
                                                                         value="{{$links[$i]}}"></td>
                                                <td>{{$prefixes[$i]}}</td>
                                                <td>
                                                    index
                                                    <input type="checkbox" id="index-{{$i}}"
                                                           @if($indexes[$i] == true) checked
                                                           @endif class="checkbox">
                                                    <input type="hidden" id="inp-index-{{$i}}" name="index-{{$i+1}}"
                                                           value="{{$indexes[$i]}}">
                                                    create
                                                    <input type="checkbox" id="create-{{$i}}"
                                                           @if($creates[$i] == true) checked
                                                           @endif class="checkbox">
                                                    <input type="hidden" id="inp-create-{{$i}}" name="create-{{$i+1}}"
                                                           value="{{$creates[$i]}}">
                                                    edit
                                                    <input type="checkbox" id="edit-{{$i}}"
                                                           @if($edits[$i] == true) checked
                                                           @endif class="checkbox">
                                                    <input type="hidden" id="inp-edit-{{$i}}" name="edit-{{$i+1}}"
                                                           value="{{$edits[$i]}}">
                                                    show
                                                    <input type="checkbox" id="show-{{$i}}"
                                                           @if($shows[$i] == true) checked
                                                           @endif class="checkbox">
                                                    <input type="hidden" id="inp-show-{{$i}}" name="show-{{$i+1}}"
                                                           value="{{$shows[$i]}}">
                                                    delete
                                                    <input type="checkbox" id="destroy-{{$i}}"
                                                           @if($destroys[$i] == true) checked
                                                           @endif class="checkbox">
                                                    <input type="hidden" id="inp-destroy-{{$i}}" name="destroy-{{$i+1}}"
                                                           value="{{$destroys[$i]}}">
                                                </td>
                                            </tr>
                                        @endfor
                                    </table>
                                </div>
                                <button type="submit">save</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
        });
    </script>




