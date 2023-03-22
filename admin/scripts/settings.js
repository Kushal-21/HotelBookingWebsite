let general_data, contacts_data;
let general_form = document.getElementById('general_form');
let site_title_input = document.getElementById('site_title_input');
let site_about_input = document.getElementById('site_about_input');
let contacts_form = document.getElementById('contacts_form');
let team_form = document.getElementById('team_form');
let member_name_inp = document.getElementById('member_name_inp');
let member_picture_inp = document.getElementById('member_picture_inp');

//general setting function
function get_general() {
    let site_title = document.getElementById('site_title');
    let site_about = document.getElementById('site_about');

    let shutdown_toggle = document.getElementById('shutdown-toggle');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/setting_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //when data onloded, then call the function and convert the data into json format
    xhr.onload = function () {
        general_data = JSON.parse(this.responseText);
        //dynamically providing the content from the database
        site_title.innerText = general_data.site_title;
        site_about.innerText = general_data.site_about;

        //providing the content user want to give
        site_title_input.value = general_data.site_title;
        site_about_input.value = general_data.site_about;

        //check if shutdown value is 1 or 0
        if (general_data.shutdown == 0) {
            shutdown_toggle.checked = false;
            shutdown_toggle.value = 0;
        } else {
            shutdown_toggle.checked = true;
            shutdown_toggle.value = 1;
        }
    }
    xhr.send('get_general');
}

//event listeners
general_form.addEventListener('submit', function (e) {
    e.preventDefault(); //prevent it from submiting the form
    //onclicking the submit buttonpage will not refresh and data will remain same
    upd_general(site_title_input.value, site_about_input.value)
});

contacts_form.addEventListener('submit', function (e) {
    e.preventDefault(); //prevent it from submiting the form
    //onclicking the submit button data will be changed acc to the data given by user 
    upd_contacts(site_title_input.value, site_about_input.value)
});

team_form.addEventListener('submit', function (e) {
    e.preventDefault(); //prevent it from submiting the form
    add_member();
});

//update general setting function
function upd_general(site_title_val, site_about_val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/setting_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //when data oloded, then call the function and convert the data into json format
    xhr.onload = function () {

        var myModal = document.getElementById('general-set');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide(); //modal will be hide and data will be submitted
        if (this.responseText == 1) {
            alert1('success', 'Changes saved!');
            get_general();
        } else {
            alert1('error', 'No Changes made!');
        }
    }
    xhr.send('site_title=' + site_title_val + '&site_about=' + site_about_val + '&upd_general');
}

//shoutdown function
function upd_shutdown(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/setting_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //when data oloded, then call the function and convert the data into json format
    xhr.onload = function () {
        if(this.responseText == 1 && general_data.shutdown == 0) {
            alert1('success', 'Shutdown mode is on!');
        } else {
            alert1('success', 'Shutdown mode is off!');
        }
        get_general();
    }
    xhr.send('upd_shutdown=' + val);
}

//contact data function
function get_contacts() {
    //storing al the ids in array form
    let contacts_ids = ['address', 'gm', 'pn1', 'pn2', 'email', 'fb', 'ins', 'tw'];
    let iframe = document.getElementById('iframe');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/setting_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    //when data onloded, then call the function and convert the data into json format
    xhr.onload = function () {
        contacts_data = JSON.parse(this.responseText);
        contacts_data = Object.values(contacts_data); //value of contacts_data will store in it self
        //for loop to access the data and displaying them
        for (i = 0; i < contacts_ids.length; i++) {
            document.getElementById(contacts_ids[i]).innerText = contacts_data[i + 1];
        }
        iframe.src = contacts_data[9];
        //contacts input function
        contacts_inp(contacts_data);
    }
    xhr.send('get_contacts');
}

function contacts_inp(data) {
    let contacts_inp_id = ['address_inp', 'gm_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'fb_inp', 'ins_inp', 'tw_inp', 'iframe_inp'];
    //for loop to access the data and displaying them
    for (i = 0; i < contacts_inp_id.length; i++) {
        document.getElementById(contacts_inp_id[i]).value = data[i + 1];
    }
}

//update contact setting function
function upd_contacts() {
    let index = ['address', 'gm', 'pn1', 'pn2', 'email', 'fb', 'ins', 'tw', 'iframe'];
    let contacts_inp_id = ['address_inp', 'gm_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'fb_inp', 'ins_inp', 'tw_inp', 'iframe_inp'];
    let data_str = "";
    //for loop to access the data and displaying them
    for (i = 0; i < index.length; i++) {
        data_str += index[i] + "=" + document.getElementById(contacts_inp_id[i]).value + '&';
    }
    data_str += "upd_contacts";
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/setting_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        var myModal = document.getElementById('contact-set');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
            alert1('success', 'Changes saved!');
        } else {
            alert1('error', 'No changes made!');
        }

    }
    xhr.send(data_str);
}

//add member function
function add_member() {
    //loading the file through ajax
    let data = new FormData();
    data.append('member_name', member_name_inp.value);
    data.append('picture', member_picture_inp.files[0]);
    data.append('add_member', '');
    //ajax call
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/setting_crud.php", true);
    xhr.onload = function () {
        
        var myModal = document.getElementById('team-set');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 'inv_img') {
            alert1('error', 'Only jpg and png images are allowed!');
            get_general();
        } else if (this.responseText == 'inv_size') {
            alert1('error', 'Image should be less than 2MB!');
        } else if (this.responseText == 'upd_failed') {
            alert1('error', 'Image upload faied. Server down!');
        } else {
            alert1('success', 'New member added!');
            member_name_inp.value = '';
            member_picture_inp.value = '';
            get_members();
        }

    }
    xhr.send(data);
}

function get_members() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/setting_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('team-data').innerHTML = this.responseText;
    }
    xhr.send('get_members');
}
function remove_member(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/setting_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.responseText == 1) {
            alert1('success', 'Member removed!');
            get_members();
        } else {
            alert1('error', 'Server down!');
        }
    }
    xhr.send('remove_member=' + val);

}


window.onload = function () {
    get_general(); //this function will onlode(display) the data
    get_contacts(); //this function will onlode(dispaly) the data
    get_members();
}