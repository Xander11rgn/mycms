const logButton = document.querySelector(".log");
const modal = document.querySelector(".modal");
const modalButton = document.querySelector(".modal__button");
const log = new LogForm();
const login = log.Login;
const password = log.Password;

modalButton.addEventListener("click", function () {
  modal.classList.remove("modal-active");
  document.querySelector(".panel").style.pointerEvents = "all";
  document.querySelector(".panel").style.userSelect = "all";
  [login, password].forEach(el => (el.disabled = false));
});

logButton.addEventListener("click", function () {
  [login, password].forEach(el => Check.checkEmpty(el));
  if (document.querySelectorAll(".error.vh").length == 2) {
    $.ajax({
      type: "POST",
      data: {
        login: login.value,
        password: password.value,
      },
      url: "php/log.php",
      success: function (response) {
        if (response == true) {
          modal.querySelector(".modal__text").innerHTML = "Вход в систему выполнен!";
          modal.classList.add("modal-active");
          modal.querySelector('a').href = "creation.html";
          document.querySelector(".panel").style.pointerEvents = "none";
          document.querySelector(".panel").style.userSelect = "none";
          [login, password].forEach(el => (el.disabled = true));
        } else if (response == false) {
          modal.querySelector(".modal__text").innerHTML =
            "Такого пользователя не существует либо введен неверный пароль! Проверьте правильность введённых данных.";
          modal.classList.add("modal-active");
          document.querySelector(".panel").style.pointerEvents = "none";
          document.querySelector(".panel").style.userSelect = "none";
          [login, password].forEach(el => (el.disabled = true));
        } else {
          alert("Что-то пошло не так...");
        }
      },
    });
  }
});

password.addEventListener("input", function () {
  Check.checkSpace(password);
});

[login, password].forEach(el =>
  el.addEventListener("blur", function () {
    Check.checkEmpty(el);
  })
);
