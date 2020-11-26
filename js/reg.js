const regButton = document.querySelector(".reg");
const modal = document.querySelector(".modal");
const modalButton = document.querySelector(".modal__button");

modalButton.addEventListener("click", function () {
  modal.classList.remove("modal-active");
})
regButton.addEventListener("click", function () {
  const reg = new RegForm();
  const login = reg.Login;
  const password = reg.Password;
  const lastName = reg.LastName;
  const firstName = reg.FirstName;
  const middleName = reg.MiddleName;
  const mail = reg.Mail;
  const phone = reg.Phone;

  $.ajax({
    type: "POST",
    data: {
      login: login,
      password: password,
      lastName: lastName,
      firstName: firstName,
      middleName: middleName,
      mail: mail,
      phone: phone,
      groupID: 1,
    },
    url: "../php/reg.php",
    success: function (response) {
      console.log(response);
      if (response == "Success"){
          modal.classList.add("modal-active");
      }
      else
      { 
        alert("Что-то пошло не так...")
      }
    },
  });
});

const letterInputs = document.querySelectorAll(".letterInput");
letterInputs.forEach(el => el.addEventListener('input',function(){
  Check.checkLetter(el);
}))

const mailInput = document.querySelector("#mail");
mailInput.addEventListener('blur', function(){
  Check.checkEmail(mailInput, null);
})

const maskOptions = {
  mask: "+7 (000)-000-00-00",
  lazy: true,
};
const phoneInput = document.querySelector("#phone");
phoneInputMask = new IMask(phoneInput, maskOptions);
phoneInput.addEventListener('input', function(){
  Check.checkPhone(phoneInput, phoneInputMask);
})