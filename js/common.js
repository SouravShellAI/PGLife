window.addEventListener("load", function () {
    var signup_form = document.getElementById("signup-form");
    if (signup_form) {
        signup_form.addEventListener("submit", function (event) {
            var XHR = new XMLHttpRequest();
            var form_data = new FormData(signup_form);

            XHR.addEventListener("load", signup_success);

            XHR.addEventListener("error", on_error);

            XHR.open("POST", "api/signup_submit.php");

            XHR.send(form_data);

            document.getElementById("loading").style.display = 'block';
            event.preventDefault();
        });
    }

    var login_form = document.getElementById("login-form");
    if (login_form) {
        login_form.addEventListener("submit", function (event) {
            var XHR = new XMLHttpRequest();
            var form_data = new FormData(login_form);

            XHR.addEventListener("load", login_success);

            XHR.addEventListener("error", on_error);

            XHR.open("POST", "api/login_submit.php");

            XHR.send(form_data);

            document.getElementById("loading").style.display = 'block';
            event.preventDefault();
        });
    }
});

var signup_success = function (event) {
    document.getElementById("loading").style.display = 'none';
    var response = JSON.parse(event.target.responseText);

    if (response.success) {
        alert(response.message);
        window.location.href = "index.php";
    } else {
        alert(response.message);
    }
};

var login_success = function (event) {
    document.getElementById("loading").style.display = 'none';
    var response = JSON.parse(event.target.responseText);

    if (response.success) {
        alert("Login successful! Redirecting...");
        window.location.href = "index.php";
    } else {
        alert(response.message);
    }
};

var on_error = function (event) {
    document.getElementById("loading").style.display = 'none';
    alert('Oops! Something went wrong.');
};

var toggle_interest = function (property_id) {
    var XHR = new XMLHttpRequest();

    XHR.addEventListener("load", function (event) {
        var response = JSON.parse(event.target.responseText);

        if (response.is_logged_in) {
            var heart_icons = document.querySelectorAll(".is-interested-image-" + property_id);
            var interest_counts = document.querySelectorAll(".interested-user-count-" + property_id);

            heart_icons.forEach(function(icon) {
                if (response.is_interested) {
                    icon.classList.add("fas");
                    icon.classList.remove("far");
                } else {
                    icon.classList.add("far");
                    icon.classList.remove("fas");
                }
            });

            interest_counts.forEach(function(count) {
                count.innerHTML = response.count;
            });

        } else {
            $('#login-modal').modal('show');
        }
    });

    XHR.addEventListener("error", function (event) {
        alert("Something went wrong");
    });

    XHR.open("GET", "api/toggle_interest.php?property_id=" + property_id);
    XHR.send();
};