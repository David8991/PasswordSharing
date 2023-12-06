<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('createPass') }}" method="post" id="formElem">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="userId" value="{{ Auth::id() }}" />
                    <div class="mb-3 password">
                        <label for="password" class="col-form-label">Password:</label>
                        <div class="input-group mb-3">
                            <input 
                                type="password" 
                                name="password"
                                value="{{ old('password') }}"
                                class="form-control" 
                                id="password" 
                                aria-label="Recipient's username" 
                                aria-describedby="inputGenerate"
                            >
                            <a class="password-control" onclick="return show_hide_password(this);"></a>
                            <button class="btn btn-outline-secondary" type="button" id="inputGenerate">Generate</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="accessLevel" class="col-form-label">Password access:</label>
                        <select id="accessLevel" name="accessLevel" class="form-select">
                            <option selected value="all">All</option>
                            <option value="me">Only me</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

    // Функция показа пароля

    function show_hide_password(target){
        let pass = document.getElementById('password');
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

    $("#inputGenerate").click(function(){
        let $input = $("#password");
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