<div class="modal fade" id="editUserPassModal" tabindex="-1" aria-labelledby="editUserPassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editUserPassModalLabel">Edit Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formEditUserPass">
                @csrf
                <input type="hidden" name="userId" value="{{ Auth::id() }}" />
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editUserPassInput2" class="form-label">Current Password</label>
                        <input 
                            type="password" 
                            class="form-control" 
                            id="editUserPassInput2" 
                            name="current_password" 
                        >
                    </div>

                    <div class="mb-3 password">
                        <label for="newPasswordUser" class="col-form-label">New password</label>
                        <div class="input-group mb-3">
                            <input 
                                type="password" 
                                name="password"
                                class="form-control" 
                                id="newPasswordUser" 
                                aria-label="Recipient's username" 
                                aria-describedby="newPassGenerate"
                            >
                            <a class="password-control" onclick="return show_hide_password2(this);"></a>
                            <button class="btn btn-outline-secondary" type="button" id="newPassGenerate">Generate</button>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

setTimeout(() => 
    {
        let editUserPassBtn = document.querySelectorAll(".edit-user-pass-button"),
            editUserId = document.getElementsByClassName("edit-user-id"),
            formEditUserPass = document.getElementById("formEditUserPass")
        ;

        for (let i = 0; i < editUserPassBtn.length; i++) 
        {
            editUserPassBtn[i].addEventListener("click", () => 
            {   
                //fetch запрос с данными формы и id редактируемого пароля пользователя
                formEditUserPass.onsubmit = async (e) => 
                {
                    e.preventDefault(); 

                    try 
                    {
                        let formData = new FormData(formEditUserPass);
                        formData.append('editUserId', editUserId[i].value);

                        let response = await fetch('/updateUserPassword', {
                            method: 'POST',
                            body: formData
                        });
                    
                        let result = await response.json();

                    } catch (error) 
                    {
                        console.error("Ошибка:", error);
                    }

                    await location.reload();
                };
            })
        }
    }, 100);

    // Функция показа пароля

    function show_hide_password2(target){
        let pass = document.getElementById('newPasswordUser');
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

    $("#newPassGenerate").click(function(){
        let $input = $("#newPasswordUser");
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