<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addUserModalLabel">Add new user</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('createUser') }}">
                @csrf
                <input type="hidden" name="userId" value="{{ Auth::id() }}" />
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Name</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="exampleFormControlInput1" 
                            name="name" 
                            value="{{ old('name') }}"
                            placeholder="John"
                        >
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput2" class="form-label">Email address</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="exampleFormControlInput2" 
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="name@example.com"
                        >
                    </div>

                    <div class="mb-3 password">
                        <label for="passwordUser" class="col-form-label">Password:</label>
                        <div class="input-group mb-3">
                            <input 
                                type="password" 
                                name="password"
                                value="{{ old('password') }}"
                                class="form-control" 
                                id="passwordUser" 
                                aria-label="Recipient's username" 
                                aria-describedby="passGenerate"
                            >
                            <a class="password-control" onclick="return show_hide_password1(this);"></a>
                            <button class="btn btn-outline-secondary" type="button" id="passGenerate">Generate</button>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create user</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

    // Функция показа пароля

    function show_hide_password1(target){
        let pass = document.getElementById('passwordUser');
        if (pass.getAttribute('type') == 'password') {
            target.classList.add('view');
            pass.setAttribute('type', 'text');
        } else {
            target.classList.remove('view');
            pass.setAttribute('type', 'password');
        }
        return false;
    }

    // Функция генерации пароля с эффектом печатающегося текста

    $("#passGenerate").click(function(){
        let $input = $("#passwordUser");
        $input.val('');
        
        let pass = generatePassword();
        let txt = pass.split("");
        let interval = setInterval(function(){
            if(!txt[0]){
                clearInterval(interval);
            } else {
                $input.val($input.val() + txt.shift());
            }
        }, 50);
    
        return false;
    });
    
    function generatePassword(){
        let length = 8,
        charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~!@-#$";

        if(window.crypto && window.crypto.getRandomValues) {
            return Array(length)
                .fill(charset)
                .map(x => x[Math.floor(crypto.getRandomValues(new Uint32Array(1))[0] / (0xffffffff + 1) * (x.length + 1))])
                .join('');    
        } else {
            res = '';

            for (let i = 0, n = charset.length; i < length; ++i) {
                res += charset.charAt(Math.floor(Math.random() * n));
            }

            return res;
        }
    }
</script>