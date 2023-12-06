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

    @include("inc.dashboard-add-password-modal")
    @include("inc.dashboard-edit-pass-modal")

    <div class="d-flex justify-between">
        <h2 class="text-xl text-gray-900 dark:text-white">Passwords</h2>
        <button 
            type="button"
            class="btn btn-secondary d-flex align-items-center" 
            data-bs-toggle="modal" 
            data-bs-target="#exampleModal" 
            data-bs-whatever="@getbootstrap"
        >
            Add password
        </button>
    </div>

        <!-- Статьи которые видны администратору кроме статуса Only me от пользователя -->
        @if(Auth::id() === $admin->id)
            <div class="border grid gap-3 pb-3">
                <div class="grid grid-cols-7 items-stretch justify-items-stretch text-center border-b min-h-5">
                    <div class="border-r grid items-center">Name</div>
                    <div class="border-r grid items-center">Password</div>
                    <div class="border-r grid items-center">Updated at</div>
                    <div class="border-r grid items-center">Created at</div>
                    <div class="border-r grid items-center">Access Level</div>
                    <div class="col-span-2 grid items-center">Options</div>
                </div>
                @foreach($data as $el)
            
                    @if($el->accessLevel !== 1)
                        <form class="pass-form-post">
                            @csrf
                            <input type="hidden" name="passId" value="{{ $el->id }}" class="edit-pass-id"/>
                            <div class="grid grid-cols-7 items-center text-center justify-items-stretch">
                                <div class="border-r"> 
                                    {{ $el->user_name }}
                                </div>
                                <div class="pass-container border-r">
                                    ********
                                </div>
                                <div class="border-r">
                                    {{ \Carbon\Carbon::parse($el->updated_at)->diffForHumans() }}
                                </div>
                                <div class="border-r">
                                    {{ \Carbon\Carbon::parse($el->created_at)->diffForHumans() }}
                                </div>
                                <div class="border-r">
                                    @if($el->accessLevel === 0)
                                        Only user: {{$el->user_name}}
                                    @else
                                        All Users
                                    @endif
                                </div>
                                <div class="col-span-2 grid grid-cols-2 px-1 gap-2">
                                    <button type="button" class="view-pass btn btn-info btn-sm pl-2">View</button>
                                    <button 
                                        type="button" 
                                        class="edit-pass btn btn-warning btn-sm pl-2"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#dashboardEditPass" 
                                        data-bs-whatever="@getbootstrap"
                                    >
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif

                @endforeach
            </div>
            
        @else
            <!-- Статьи которые видны всем пользователям и конкретно аутентифицированного пользователя -->
            <h5 class="text-gray-900 text-center my-3 dark:text-white">Your Passwords</h5>
            <div class="border grid gap-3 pb-3">
                <div class="grid grid-cols-7 items-stretch justify-items-stretch text-center border-b min-h-5">
                    <div class="border-r grid items-center">Name</div>
                    <div class="border-r grid items-center">Password</div>
                    <div class="border-r grid items-center">Updated at</div>
                    <div class="border-r grid items-center">Created at</div>
                    <div class="border-r grid items-center">Access Level</div>
                    <div class="col-span-2 grid items-center">Options</div>
                </div>

                @foreach($data as $el)

                    @if(Auth::id() === $el->user_id)
                        <form class="pass-form-post">
                            @csrf
                            <input type="hidden" name="passId" value="{{ $el->id }}"  class="edit-pass-id"/>
                            <div class="grid grid-cols-7 items-center text-center justify-items-stretch">
                                <div class="border-r"> 
                                    {{ $el->user_name }}
                                </div>
                                <div class="pass-container border-r">
                                    ********
                                </div>
                                <div class="border-r">
                                    {{ \Carbon\Carbon::parse($el->updated_at)->diffForHumans() }}
                                </div>
                                <div class="border-r">
                                    {{ \Carbon\Carbon::parse($el->created_at)->diffForHumans() }}
                                </div>
                                <div class="border-r">
                                    @if($el->accessLevel === 1)
                                        Only user: {{$el->user_name}}
                                    @else
                                        All Users
                                    @endif
                                </div>
                                <div class="col-span-2 grid grid-cols-2 px-1 gap-2">
                                    <button type="button" class="view-pass btn btn-info btn-sm pl-2">View</button>
                                    <button 
                                        type="button" 
                                        class="edit-pass btn btn-warning btn-sm pl-2"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#dashboardEditPass" 
                                        data-bs-whatever="@getbootstrap"
                                    >
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif

                @endforeach
            </div>

            <h5 class="text-gray-900 text-center my-3 dark:text-white">Users Passwords</h5>
            <div class="border grid gap-3 pb-3">
                <div class="grid grid-cols-5 items-stretch justify-items-stretch text-center border-b border-t min-h-5">
                    <div class="border-r grid items-center">Name</div>
                    <div class="border-r grid items-center">Password</div>
                    <div class="border-r grid items-center">Updated at</div>
                    <div class="border-r grid items-center">Created at</div>
                    <div class="grid items-center">Options</div>
                </div>

                @foreach($data as $el)

                    @if(Auth::id() !== $el->user_id && $el->accessLevel !== 0 && $el->accessLevel !== 1)
                        <form class="pass-form-post">
                            @csrf
                            <input type="hidden" name="passId" value="{{ $el->id }}"  class="edit-pass-id"/>
                            <div class="grid grid-cols-5 items-center text-center justify-items-stretch">
                                <div class="border-r"> 
                                    {{ $el->user_name }}
                                </div>
                                <div class="pass-container border-r">
                                    ********
                                </div>
                                <div class="border-r">
                                    {{ \Carbon\Carbon::parse($el->updated_at)->diffForHumans() }}
                                </div>
                                <div class="border-r">
                                    {{ \Carbon\Carbon::parse($el->created_at)->diffForHumans() }}
                                </div>
                                <div class="grid px-1 gap-2">
                                    <button type="button" class="view-pass btn btn-info btn-sm pl-2">View</button>
                                </div>
                            </div>
                        </form>
                    @endif

                @endforeach
            </div>
        @endif
    </div>
    
</div>

<script>

    // Код просмотра пароля
    
    let viewPass = document.querySelectorAll(".view-pass"),
    passForm = document.querySelectorAll(".pass-form-post"),
    passContainer = document.querySelectorAll(".pass-container");

    for (let i = 0; i < viewPass.length; i++) {
        viewPass[i].addEventListener("click", async () => {
            if (passContainer[i].innerText === "********")
            {
                try 
                {
                    let response = await fetch('/viewPass', {
                        method: 'POST',
                        body: new FormData(passForm[i])
                    });
                
                    let result = await response.json();
                    passContainer[i].innerText = result;

                } catch (error) 
                {
                    console.error("Ошибка:", error);
                }
            } else 
            {
                passContainer[i].innerText = "********";
            }
        }) 
    }

</script>