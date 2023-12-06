<div class="modal fade" id="editUserModal" tabi="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editUserModalLabel">Edit User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formEditUser">
                @csrf
                <input type="hidden" name="userId" value="{{ Auth::id() }}" />
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="userEditInput1" class="form-label">Name</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="userEditInput1" 
                            name="name" 
                            placeholder="John"
                        >
                    </div>

                    <div class="mb-3">
                        <label for="userEditInput2" class="form-label">Email address</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="userEditInput2" 
                            name="email"
                            placeholder="name@example.com"
                        >
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    setTimeout(() => 
    {
        let editBtn = document.querySelectorAll(".edit-user-button"),
            userName = document.querySelectorAll(".user-name"),
            userEmail = document.querySelectorAll(".user-email"),
            modalName = document.getElementById("userEditInput1"),
            modalEmail = document.getElementById("userEditInput2"),
            editUserId = document.getElementsByClassName("edit-user-id"),
            formEditUser = document.getElementById("formEditUser")
        ;

        for (let i = 0; i < editBtn.length; i++) 
        {
            editBtn[i].addEventListener("click", () => 
            {   
                modalName.value = userName[i].innerText;
                modalEmail.value = userEmail[i].innerText;
                
                //fetch запрос с данными формы и id редактируемого пользователя
                formEditUser.onsubmit = async (e) => 
                {
                    e.preventDefault(); 

                    try 
                    {
                        let formData = new FormData(formEditUser);
                        formData.append('editUserId', editUserId[i].value);

                        let response = await fetch('/editUser', {
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
</script>