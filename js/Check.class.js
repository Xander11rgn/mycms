class Check {
  static checkLetter(input) {
    try {
      const selectionIndex = input.selectionStart - 1;
      const str = input.value;
      const lastChar = str[selectionIndex];
      const pattern = /^[а-яА-Я|a-zA-Z|-]/;
      if (!lastChar.match(pattern)) {
        input.value = str.replace(lastChar, "");
        input.selectionStart = selectionIndex;
        input.selectionEnd = selectionIndex;
      } 
    } catch {}
  }

  static checkEmail(input) {
    const mailText = input.value;
    const template = /.+@.+\..+/i;
    if (!mailText.match(template)) {
      input.nextElementSibling.classList.remove("vh");
      console.log('input.nextElementSibling: ', input.nextElementSibling);
      //alert("Введённый почтовый адрес некорректен!");
    } else {
      input.nextElementSibling.classList.add("vh");
    }
  }

  static checkSpace(input) {
    const inputText = input.value;
    const template = /\s/g;
    input.value = inputText.replace(template,"");
  }

  static checkEmpty(input) {
    if (input.value.replace(/\s/gi, "") == "") {
      input.nextElementSibling.classList.remove("vh");
    } else {
      input.nextElementSibling.classList.add("vh");
    }
  }

  static checkPhone(input, mask) {
    const selectionStart = input.selectionStart;
    const selectionEnd = input.selectionEnd;

    if (
      (selectionStart <= 5 || selectionEnd <= 5) &&
      !(selectionStart == 5 && selectionEnd > 5)
    ) {
      input.selectionStart = input.value.length;
      input.selectionEnd = input.value.length;
    }

    let str = input.value;
    const lastChar = str[str.length - 1];
    str = str.slice(0, str.length - 1);

    if (str == "+7 (") {
      if (lastChar != "9") {
        input.value = "+7 (";
        mask.updateValue();
      }
    }
  }

  // static checkNumber(input) {
  //   try {
  //     const selectionIndex = input.selectionStart - 1;
  //     const str = input.value;
  //     const lastChar = str[selectionIndex];
  //     const pattern = /^[0-9]/;
  //     if (!lastChar.match(pattern)) {
  //       input.value = str.replace(lastChar, "");
  //       input.selectionStart = selectionIndex;
  //       input.selectionEnd = selectionIndex;
  //     }
  //   } catch {}
  // }

  // static checkMoney(input) {
  //   let selectionIndex = input.selectionStart;
  //   // console.log("selectionIndex: ", selectionIndex);
  //   const lastChar = input.value[selectionIndex - 1];
  //   // console.log("lastChar: ", lastChar);
  //   // console.log(input.value.length);

  //   if (input.value[0] == "0" && input.value.length > 1) {
  //     input.value = input.value.replace(input.value[0], "");
  //     input.selectionStart = selectionIndex - 1;
  //     input.selectionEnd = selectionIndex - 1;
  //   }

  //   try {
  //     if (!lastChar.match(/[0-9]/)) {
  //       input.value = input.value.replace(/[^0-9]/g, "");
  //     }
  //   } catch {}

  //   let strWithoutSpaces = input.value.replace(/[^0-9]/g, "");
  //   const ost = strWithoutSpaces.length / 3;
  //   const spaceCount = !Number.isInteger(ost) ? Math.floor(ost) : ost - 1;

  //   if (strWithoutSpaces.length > 3) {
  //     const firstSigns = strWithoutSpaces.length - spaceCount * 3;
  //     let spacedValue = strWithoutSpaces.substr(0, firstSigns);
  //     for (let i = firstSigns; i <= strWithoutSpaces.length - 3; i += 3) {
  //       spacedValue += " " + strWithoutSpaces.substr(i, 3);
  //     }
  //     strWithoutSpaces = spacedValue;
  //   }

  //   input.value = strWithoutSpaces == "" ? "" : strWithoutSpaces;

  //   if (
  //     selectionIndex == 1 ||
  //     (selectionIndex >= 4 && input.value.length == 6) ||
  //     (selectionIndex >= 5 && input.value.length == 7) ||
  //     (selectionIndex == 5 && input.value.length == 9)
  //   ) {
  //     input.selectionStart = selectionIndex;
  //     input.selectionEnd = selectionIndex;
  //   }
  //   if (
  //     (selectionIndex >= 2 && selectionIndex <= 4 && input.value.length == 5) ||
  //     (selectionIndex >= 2 &&
  //       selectionIndex <= 7 &&
  //       selectionIndex != 5 &&
  //       input.value.length == 9)
  //   ) {
  //     input.selectionStart = selectionIndex + 1;
  //     input.selectionEnd = selectionIndex + 1;
  //   }
  //   if (
  //     (selectionIndex == 3 && input.value.length == 6) ||
  //     (selectionIndex == 4 && input.value.length == 7)
  //   ) {
  //     input.selectionStart = selectionIndex - 1;
  //     input.selectionEnd = selectionIndex - 1;
  //   }
  // }

  

  // static checkSignsNumber(input, placeholder) {
  //   const maxLength = 300;
  //   const textLength = input.value.length;
  //   const remaining = maxLength - textLength;
  //   placeholder.innerHTML = "Осталось " + remaining + " символов";
  // }

  

  // static checkNameInput(input, error) {
  //   if (input.value.replace(/ /g, "").length == 0) {
  //     Error.activateError(error.error);
  //   } else {
  //     Error.deactivateError(error.error);
  //   }
  // }

  // static checkTelInput(input, error) {
  //   if (input.value.length != 18) {
  //     Error.activateError(error.error);
  //   } else {
  //     Error.deactivateError(error.error);
  //   }
  // }

  

  
}
