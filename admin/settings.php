<?php 
require('inc/ess.php');
adminLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
    <?php require('inc/links.php'); ?>
</head>

<body class="bg-light">

<?php require('inc/header.php');?>

<div class="container-fluid" id="main-content">
    <div class="row" style="margin-left: 30px;">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">SETTINGS</h3>

            <!-- General settings section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title m-0">General Settings</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#general-s"> 
                            <i class="bi bi-pencil-square"></i> Edit</button>
                    </div>

                    <h6 class="card-subtitle mb-1 fw-bold">Site Title</h6>
                    <p class="card-text" id="site_title">Hiro Hotel</p>

                    <h6 class="card-subtitle mb-1 fw-bold">About</h6>
                    <p class="card-text" id="site_about"></p>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="general-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
                <div class="modal-dialog">
                    <form id="general_s_form">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">General Settings</h5>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Site Title</label>
                                    <input type="text" name="site_title" id="site_title_inp" class="form-control shadow-none">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">About</label>
                                    <textarea name="site_about" id="site_about_inp" class="form-control" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="site_title.value = general_data.site_title, site_about.value = general_data.site_about" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                                <button type="submit" class="btn btn-primary">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title m-0">Contacts Settings</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#contact-s"> 
                           <i class="bi bi-pencil-square"></i> Edit
                        </button>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-1 fw-bold">Address</h6>
                                <p class="card-text" id="address"></p>
                            </div>

                         

                            <div class="mb-4">
                                <h6 class="card-subtitle mb-1 fw-bold">Phone Number</h6>
                                <p class="card-text">
                                    <i class="bi bi-telephone-fill"></i>
                                    <span id="pn"></span>
                                </p>
                            </div>

                            <div class="mb-4">
                                <h6 class="card-subtitle mb-1 fw-bold">Email</h6>
                                <p class="card-text" id="email"></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="card-subtitle mb-1 fw-bold">Social Links</h6>
                                <p class="card-text"><i class="bi bi-facebook"></i> <span id="fb"></span></p>
                                <p class="card-text"><i class="bi bi-twitter-x"></i> <span id="tw"></span></p>
                                <p class="card-text"><i class="bi bi-instagram"></i> <span id="ig"></span></p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="card-subtitle mb-1 fw-bold">Map</h6>
                            <iframe id="iframe" class="border p-2 w-100" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>

           <!-- Contact Modal -->
<div class="modal fade" id="contact-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="contacts_s_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Contact Settings</h5>
                </div>
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Address</label>
                                    <input type="text" name="address" id="address_inp" class="form-control shadow-none" required>
                                </div>

                    

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Phone Number</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                        <input type="number" name="pn1" id="pn1" class="form-control shadow-none" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="text" name="email" id="email_inp" class="form-control shadow-none" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Social Links</label>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                                        <input type="text" name="fb" id="fb_inp" class="form-control shadow-none" required>
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                                        <input type="text" name="ig" id="ig_inp" class="form-control shadow-none" required>
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="bi bi-twitter"></i></span>
                                        <input type="text" name="tw" id="tw_inp" class="form-control shadow-none" required> 
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label fw-bold">iFrame Src</label>
                                        <input type="text" name="iframe" id="iframe_inp" class="form-control shadow-none" required>
                                    </div>

                                </div>
                            </div>


                           
                        
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="resetForm()" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                </div>
            </div>
        </form>
    </div>
</div>


        </div>
    </div>
</div>

<?php require('inc/script.php'); ?>

<script>
let general_data, contacts_data;

let general_s_form = document.getElementById('general_s_form');
let site_title_inp = document.getElementById('site_title_inp');
let site_about_inp  = document.getElementById('site_about_inp');
let contacts_s_form = document.getElementById('contacts_s_form');

function get_general() {
    let site_about = document.getElementById('site_about');
    let site_title = document.getElementById('site_title');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        general_data = JSON.parse(this.responseText);
        console.log(general_data);
        site_about.innerText = general_data.site_about;
        site_title.innerText = general_data.site_tittle;
        site_title_inp.value = general_data.site_tittle;
        site_about_inp.value = general_data.site_about;
    }

    xhr.send('get_general');
}

general_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    console.log("đã vào!"+site_title_inp.value + site_about_inp.value);
    upd_general(site_title_inp.value, site_about_inp.value);
});

function upd_general(site_title_val, site_about_val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        let myModal = document.getElementById('general-s');
        let modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == "1") {
            console.log('Data updated');
            get_general();
        } else {
            get_general();
            console.log("No changes");
        }

        
    };

    xhr.send('site_title=' + encodeURIComponent(site_title_val) + '&site_about=' + encodeURIComponent(site_about_val) + '&upd_general=true');
}

function get_contacts() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        let contacts_data = JSON.parse(this.responseText);
        
        contacts_data = Object.values(contacts_data);

      
        let contacts_p_id = ["address", "map", "pn", "email", "fb", "tw", "ig", "iframe"];

        for (let i = 0; i < contacts_p_id.length; i++) {
            let element = document.getElementById(contacts_p_id[i]);

            if (element) {
                if (contacts_p_id[i] === "iframe") {
                    // Nếu là iframe, cập nhật thuộc tính src
                    element.src = contacts_data[i + 1];
                } else {
                    // Cập nhật nội dung text cho các phần tử khác
                    element.innerText = contacts_data[i + 1];
                }
            } else {
                console.warn("Không tìm thấy phần tử có ID:", contacts_p_id[i]);
            }
        }


        contacts_inp(contacts_data);
    };

    xhr.send('get_contacts');
}



function contacts_inp(data) {
    let contacts_inp_id = ["address_inp", "pn1", "email_inp", "fb_inp", "tw_inp", "ig_inp", "iframe_inp"];

    for (let i = 0; i < contacts_inp_id.length; i++) {
        let inputElement = document.getElementById(contacts_inp_id[i]);

        if (inputElement) {
            inputElement.value = data[i+2];  // Gán giá trị input
        } else {
            console.warn("Không tìm thấy input có ID:", contacts_inp_id[i+1]);
        }
    }
    let inputElement = document.getElementById("address_inp");
    inputElement.value = data[1];
}

["address_inp", "pn1", "email_inp", "fb_inp", "tw_inp", "ig_inp", "iframe_inp"];

let address_inp = document.getElementById('address_inp');
let pn1 = document.getElementById("pn1");
let email_inp = document.getElementById('email_inp');
let fb_inp = document.getElementById("fb_inp");
let tw_inp = document.getElementById('tw_inp');
let ig_inp = document.getElementById("ig_inp");
let iframe_inp = document.getElementById("iframe_inp");

contacts_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    console.log("đã vào!");
    upd_general1(address_inp.value, pn1.value, email_inp.value, fb_inp.value, tw_inp.value, ig_inp.value, iframe_inp.value);
});

function upd_general1(address_inp, pn1, email_inp, fb_inp, tw_inp, ig_inp, iframe_inp) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        let myModal = document.getElementById('contact-s');
        let modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == "1") {
            console.log('Data updated');
            get_contacts();
        } else {
            get_contacts();
            console.log("No changes");
        }
        
    };

    xhr.send('address_inp=' + encodeURIComponent(address_inp) + '&pn1=' + encodeURIComponent(pn1) +
    '&email_inp=' + encodeURIComponent(email_inp) + '&fb_inp=' + encodeURIComponent(fb_inp) 
    + '&tw_inp=' + encodeURIComponent(tw_inp) + '&ig_inp=' + encodeURIComponent(ig_inp) + '&iframe_inp=' + encodeURIComponent(iframe_inp) + '&upd_general1=true');
}


window.onload = function() {
    get_general();
    get_contacts();
}
</script>

</body>
</html>
