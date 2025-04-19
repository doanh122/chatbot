
window.addEventListener('load', () => {
    const user = localStorage.getItem("user");
    var s1 = document.querySelector(".chuadangnhap");
    if(!user){
        s1.innerHTML = `<button style="width: 65px;" type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-3" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Login
                    </button>

                    <button style="width: 90px;" type="button" class="btn btn-outline-dark shadow-none  me-lg-3 me-3" data-bs-toggle="modal" data-bs-target="#registerModal">
                        Register
                    </button>`;
    } else {
        s1.innerHTML = `<button onclick="logout()" style="width: 80px;" type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-3">
                        Logout
                    </button>`;
    }
});


function logout(){
    var s1 = document.querySelector(".chuadangnhap");
    s1.innerHTML = `<button style="width: 65px;" type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-3" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Login
                    </button>

                    <button style="width: 90px;" type="button" class="btn btn-outline-dark shadow-none  me-lg-3 me-3" data-bs-toggle="modal" data-bs-target="#registerModal">
                        Register
                    </button>`;
    localStorage.clear();
}