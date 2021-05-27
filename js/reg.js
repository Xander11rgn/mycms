const regButton = document.querySelector(".reg");
const modal = document.querySelector(".modal");
const modalButton = document.querySelector(".modal__button");
const reg = new RegForm();
const login = reg.Login;
const password = reg.Password;
const lastName = reg.LastName;
const firstName = reg.FirstName;
const middleName = reg.MiddleName;
const mail = reg.Mail;
const phone = reg.Phone;

modalButton.addEventListener("click", function () {
  modal.classList.remove("modal-active");
  document.querySelector(".panel").style.pointerEvents = "all";
  document.querySelector(".panel").style.userSelect = "all";
  [login, password, lastName, firstName, middleName, mail, phone].forEach(
    el => (el.disabled = false)
  );
});

regButton.addEventListener("click", function () {
  [login, password, lastName, firstName, mail].forEach(el =>
    Check.checkEmpty(el)
  );
  Check.checkEmail(mail);
  if (document.querySelectorAll(".error.vh").length == 5) {
    $.ajax({
      type: "POST",
      data: {
        login: login.value,
        password: password.value,
        lastName: lastName.value,
        firstName: firstName.value,
        middleName: middleName.value,
        mail: mail.value,
        phone: phone.value,
        groupID: 1,
      },
      url: "php/reg.php",
      success: function (response) {
        // console.log(response);
        if (response == "Success") {
          modal.querySelector(".modal__text").innerHTML =
            "Вы успешно зарегистрировались! Теперь Вы можете авторизоваться в системе.";
          modal.classList.add("modal-active");
          modal.querySelector('a').href = "login.html";
          document.querySelector(".panel").style.pointerEvents = "none";
          document.querySelector(".panel").style.userSelect = "none";
          [
            login,
            password,
            lastName,
            firstName,
            middleName,
            mail,
            phone,
          ].forEach(el => (el.disabled = true));
        } else if (response == "Successn't") {
          modal.querySelector(".modal__text").innerHTML =
            "Пользователь с таким логином и/или почтой уже зарегистрирован в системе!";
          modal.classList.add("modal-active");
          document.querySelector(".panel").style.pointerEvents = "none";
          document.querySelector(".panel").style.userSelect = "none";
          [
            login,
            password,
            lastName,
            firstName,
            middleName,
            mail,
            phone,
          ].forEach(el => (el.disabled = true));
        } else {
          alert("Что-то пошло не так...");
        }
      },
    });
  }
});

const letterInputs = document.querySelectorAll(".letterInput");
letterInputs.forEach(el =>
  el.addEventListener("input", function () {
    Check.checkLetter(el);
  })
);

mail.addEventListener("input", function () {
  Check.checkEmail(mail);
});

[password, mail].forEach(el =>
  el.addEventListener("input", function () {
    Check.checkSpace(el);
  })
);

const maskOptions = {
  mask: "+7 (000)-000-00-00",
  lazy: true,
};
phoneMask = new IMask(phone, maskOptions);
phone.addEventListener("input", function () {
  Check.checkPhone(phone, phoneMask);
});

[login, password, lastName, firstName, mail].forEach(el =>
  el.addEventListener("blur", function () {
    Check.checkEmpty(el);
  })
);
