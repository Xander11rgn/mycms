const nextButtons = document.querySelectorAll(".next");
nextButtons.forEach(el => el.addEventListener("click", function () {
  let step = parseInt(el.parentNode.parentNode.querySelector('.step').innerHTML) + 1;
  const currentPanel = document.querySelector('[data-step="'+(step-1)+'"]');
  const nextPanel = document.querySelector('[data-step="'+step+'"]');
  currentPanel.classList.add('hide');
  nextPanel.classList.remove('hide');
}));

const prevButtons = document.querySelectorAll(".prev");
prevButtons.forEach(el => el.addEventListener("click", function () {
  let step = parseInt(el.parentNode.parentNode.querySelector('.step').innerHTML) - 1;
  const currentPanel = document.querySelector('[data-step="'+(step+1)+'"]');
  const prevPanel = document.querySelector('[data-step="'+step+'"]');
  currentPanel.classList.add('hide');
  prevPanel.classList.remove('hide');
}));

const createButton = document.querySelector('.create');
createButton.addEventListener('click', function(){
  const title = document.querySelector('#title').value;
  const designName = document.querySelector('.panel__design-selected').dataset.designname;
  console.log('designName: ', designName);
  const paymentInputs = document.querySelectorAll('#payment');
  const payments = [];
  for (let i = 0; i < paymentInputs.length; i++) {
    payments[i] = paymentInputs[i].value;
  }
  const deliveryInputs = document.querySelectorAll('#delivery');
  const deliveries = [];
  for (let i = 0; i < deliveryInputs.length; i++) {
    deliveries[i] = deliveryInputs[i].value;
  }
  const contactPhone = document.querySelector('#contactPhone').value;
  const contactMail = document.querySelector('#contactMail').value;

  $.ajax({
    type: "POST",
    data: {
      shopName: title,
      designName: designName,
      payments: payments,
      deliveries: deliveries,
      contactPhone: contactPhone,
      contactMail: contactMail,
      imgSize: 200,
    },
    url: "php/create.php",
    success: function (response) {
      // console.log(response);
      if (response == "Success") {
        alert("Гуд");
        location.href = "panel.php"
        // modal.querySelector(".modal__text").innerHTML =
        //   "Вы успешно зарегистрировались! Теперь Вы можете авторизоваться в системе.";
        // modal.classList.add("modal-active");
        // modal.querySelector('a').href = "login.html";
        // document.querySelector(".panel").style.pointerEvents = "none";
        // document.querySelector(".panel").style.userSelect = "none";
        // [
        //   login,
        //   password,
        //   lastName,
        //   firstName,
        //   middleName,
        //   mail,
        //   phone,
        // ].forEach(el => (el.disabled = true));
      } else if (response == "Successn't") {
        // modal.querySelector(".modal__text").innerHTML =
        //   "Пользователь с таким логином и/или почтой уже зарегистрирован в системе!";
        // modal.classList.add("modal-active");
        // document.querySelector(".panel").style.pointerEvents = "none";
        // document.querySelector(".panel").style.userSelect = "none";
        // [
        //   login,
        //   password,
        //   lastName,
        //   firstName,
        //   middleName,
        //   mail,
        //   phone,
        // ].forEach(el => (el.disabled = true));
      } else {
        alert("Что-то пошло не так...");
      }
    },
  });
})

const maskOptions = {
  mask: "+7 (000)-000-00-00",
  lazy: true,
};
const phone = document.querySelector('#contactPhone');
phoneMask = new IMask(phone, maskOptions);
phone.addEventListener("input", function () {
  Check.checkPhone(phone, phoneMask);
});

const designs = document.querySelectorAll('.panel__design');
designs.forEach(el => el.addEventListener("click", function () {
  const selectedDesign = document.querySelector('.panel__design-selected');
  selectedDesign.classList.remove('panel__design-selected');
  el.classList.add('panel__design-selected');
  })
);