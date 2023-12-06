<div class="modal fade" id="dashboardEditPass" tabindex="-1" aria-labelledby="dashboardEditPassLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="dashboardEditPassLabel">Edit password and access</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formElem2">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="userId" value="{{ Auth::id() }}" />
                    <div class="mb-3 password">
                        <label for="dashboardEditPassword" class="col-form-label">Password:</label>
                        <div class="input-group mb-3">
                            <input 
                                type="password" 
                                name="password"
                                class="form-control" 
                                id="dashboardEditPassword" 
                                aria-label="Recipient's username" 
                                aria-describedby="dashboardEditPassGenerate"
                            >
                            <a class="password-control" onclick="return show_hide_password3(this);"></a>
                            <button class="btn btn-outline-secondary" type="button" id="dashboardEditPassGenerate">Generate</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="accessLevelEdit" class="col-form-label">Password access:</label>
                        <select id="accessLevelEdit" name="accessLevel" class="form-select">
                            <option selected value="all">All</option>
                            <option value="me">Only me</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

    // Код обновления пароля и уровня доступа
    setTimeout(() => 
    {
        let editPass = document.querySelectorAll(".edit-pass"),
            editPassId = document.querySelectorAll(".edit-pass-id")
            passwordInput = document.getElementById("dashboardEditPassword")
        ;

        for (let i = 0; i < editPass.length; i++) {
            
            editPass[i].addEventListener("click", async () => 
            {
                // fetch запрос для расшифровки пароля и вставка в поле input 
                try 
                {
                    let response = await fetch('/viewPass', {
                        method: 'POST',
                        body: new FormData(passForm[i])
                    });
                
                    let result = await response.json();
                    passwordInput.value = result;

                } catch (error) 
                {
                    console.error("Ошибка:", error);
                }

                // Отправка редактируемых данных формы на сервер
                formElem2.onsubmit = async (e) => 
                {
                    e.preventDefault(); 

                    try 
                    {
                        let formData = new FormData(formElem2);
                        // Добавление id пароля
                        formData.append('editPassId', editPassId[i].value);

                        let response = await fetch('/editPass', {
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

    function show_hide_password3(target){
        let pass = document.getElementById('dashboardEditPassword');
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

    $("#dashboardEditPassGenerate").click(function(){
        let $input = $("#dashboardEditPassword");
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