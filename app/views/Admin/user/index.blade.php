@extends('layout.admin')

@section('content')
<div class="container">
    <div class="col-md-10">
        <h2>{{ trans('traduction.members') }}</h2>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Join date</th>
                    <!-- <th>Action</th>-->
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                    <tr>
                        <td><a href="{{ route('admin_user_edit', ['username' => $u->username, 'id' => $u->id]) }}">{{ $u->username }}</a></td>
                        <td>{{ date('d/m/Y', strtotime($u->created_at)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
</div>
@stop
