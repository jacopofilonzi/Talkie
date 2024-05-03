if (getQuery()["error"]) {
    alert(getQuery()["error"].split("%20").join(" "));
}

const Form = {
    f: document.forms["RegistrationForm"],
    fields: {
        name: document.forms["RegistrationForm"]["Name"],
        surname: document.forms["RegistrationForm"]["Surname"],
        dataOfBirth: document.forms["RegistrationForm"]["DateOfBirth"],
        email: document.forms["RegistrationForm"]["Email"],
        password: document.forms["RegistrationForm"]["Password"],
        passwordConfirm: document.forms["RegistrationForm"]["PasswordConfirm"],
        ToSacknowledge: document.forms["RegistrationForm"]["ToSacknowledge"]
    }
}

function validateForm() {
    const name = Form.fields.name.value;
    const surname = Form.fields.surname.value;
    const dataOfBirth = Form.fields.dataOfBirth.value;
    const email = Form.fields.email.value;
    const password = Form.fields.password.value;
    const passwordConfirm = Form.fields.passwordConfirm.value;
    

    // Validate name
    if (name.length < 3 || name.length > 40) {
        alert("Name must be between 3 and 40 characters.");
        return false;
    }

    // Validate surname
    if (surname.length < 3 || surname.length > 40) {
        alert("Surname must be between 3 and 40 characters.");
        return false;
    }

    // Validate birthday
    const currentDate = new Date();
    const minAgeDate = new Date();
    minAgeDate.setFullYear(minAgeDate.getFullYear() - 13);
    const birthdayDate = new Date(dataOfBirth);
    if (birthdayDate > minAgeDate) {
        alert("You must be at least 13 years old to register.");
        return false;
    }

    // Validate email using regex
    const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
    if (!emailRegex.test(email)) {
        alert("Invalid email address.");
        return false;
    }

    // Validate password
    if (password.length < 8) {
        alert("Password must be at least 8 characters.");
        return false;
    }

    // Validate password confirm
    if (password !== passwordConfirm) {
        alert("Password confirmation does not match.");
        return false;
    }

    // All validations passed
    return true;
}

Form.f.addEventListener("submit", function(event) {
    event.preventDefault();
    if (validateForm()) {
        // Submit the form
        Form.f.submit();
    }
});