@extends("layouts.users")

@section("info")
    <div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 gap-3 p-6 lg:p-8">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @include("inc.user-add-admin-modal")
        @include("inc.edit-user-admin-modal")
        @include("inc.edit-user-pass-admin-modal")

        <div class="d-flex justify-between">
            <h2 class="text-xl text-gray-900 dark:text-white">Passwords</h2>
            <button 
                type="button"
                class="btn btn-secondary d-flex align-items-center" 
                data-bs-toggle="modal" 
                data-bs-target="#addUserModal" 
                data-bs-whatever="@getbootstrap"
            >
                Add user
            </button>
        </div>

        <div class="border grid gap-3 pb-3">
            <div class="grid grid-cols-8 items-stretch justify-items-stretch text-center border-b min-h-5">
                <div class="border-r grid items-center">Name</div>
                <div class="border-r grid items-center">Email</div>
                <div class="border-r grid items-center">Email verified at</div>
                <div class="border-r grid items-center">Updated at</div>
                <div class="border-r grid items-center">Created at</div>
                <div class="col-span-3 grid items-center">Options</div>
            </div>
            @foreach($data as $el)

                <div class="grid grid-cols-8 items-center text-center justify-items-stretch">
                    <input type="hidden" name="editUserId" value="{{$el->id}}" class="edit-user-id" />
                    <div class="border-r user-name"> 
                        {{ $el->name }}
                    </div>
                    <div class="border-r user-email">
                        {{ $el->email }}
                    </div>
                    <div class="border-r">
                        @if(isset($el->email_verified_at))
                            {{ $el->email_verified_at }}
                        @else
                            Null
                        @endif
                    </div>
                    <div class="border-r">
                        {{ \Carbon\Carbon::parse($el->updated_at)->diffForHumans() }}
                    </div>
                    <div class="border-r">
                        {{ \Carbon\Carbon::parse($el->created_at)->diffForHumans() }}
                    </div>
                    
                    <div class="col-span-3 grid grid-cols-3 px-1 gap-2">
                        <button 
                            type="button" 
                            class="btn btn-info btn-sm pl-2 edit-user-pass-button"
                            data-bs-toggle="modal" 
                            data-bs-target="#editUserPassModal" 
                            data-bs-whatever="@getbootstrap"
                        >
                            Edit password
                        </button>
                        <button 
                            type="button" 
                            class="btn btn-warning btn-sm pl-2 edit-user-button"
                            data-bs-toggle="modal" 
                            data-bs-target="#editUserModal" 
                            data-bs-whatever="@getbootstrap"
                        >
                            Edit
                        </button>
                        <a href="{{ route('deleteUser', $userId = $el->id) }}" type="button" class="btn btn-danger btn-sm pl-2">Delete</a>
                    </div>
                </div>

            @endforeach
        </div>

    </div>
@endsection
