@extends('layouts.app')

@section('content')
@if (session('message'))
    <div class="alert alert-success" role="alert">
        {{ session('message') }}
    </div>
@endif
<table class="table">
    @forelse ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at }}</td>
            <td>{{ $user->role->name }}</td>
            <td>
                @if (!$user->approved_at)
                    @can('approve', $user)
                    <a href="{{ route('admin.users.approve', $user->id) }}"
                        class="btn btn-primary btn-sm">Approve</a>
                    @endcan                                    
                @endif
            </td>
            <td>
                @can('premote', $user)
                <a href="{{ route('admin.users.premote', $user->id) }}"
                    class="btn btn-success btn-sm">Premote</a>
                @endcan
            </td>
            <td>
                @can('demote', $user)
                <a href="{{ route('admin.users.demote', $user->id) }}"
                    class="btn btn-danger btn-sm">Demote</a>
                @endcan
            </td>
            <td>
                @can('suspend', $user)
                <a href="{{ route('admin.users.suspend', $user->id) }}"
                    class="btn btn-warning btn-sm">Suspend</a>
                @endcan
                <td>
                    @can('block', $user)
                    <a href="{{ route('admin.users.block', $user->id) }}"
                        class="btn btn-danger btn-sm">Block</a>
                    @endcan
                    @can('unblock', $user)
                    <a href="{{ route('admin.users.unblock', $user->id) }}"
                        class="btn btn-success btn-sm">Unblock</a>
                    @endcan
                </td>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4">No users found.</td>
        </tr>
    @endforelse
    </table>
@endsection