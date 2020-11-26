const logButton = document.querySelector(".log");
const modal = document.querySelector(".modal");
const modalButton = document.querySelector(".modal__button");

modalButton.addEventListener("click", function () {
  modal.classList.remove("modal-active");
})
logButton.addEventListener("click", function () {
  const log = new LogForm();
  const login = log.Login;
  const password = log.Password;

  $.ajax({
    type: "POST",
    data: {
      login: login,
      password: password,
    },
    url: "../php/log.php",
    success: function (response) {
      if (response == true){
          modal.classList.add("modal-active");
      }
      else
      { 
        alert("Такого пользователя не существует! Проверьте правильность введённых данных.");
      }
    },
  });
});