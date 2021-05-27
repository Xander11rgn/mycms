const menuItems = document.querySelectorAll('[data-item]');
menuItems.forEach(el => el.addEventListener("click", function () {
    const dataItem = el.dataset.item;
    const currentField = document.querySelector('.active');
    const newField = document.querySelector('[data-field="' + dataItem + '"]');
    currentField.classList.remove('active');
    currentField.classList.add('hide');
    newField.classList.add('active');
    newField.classList.remove('hide');
  })
);

const designs = document.querySelectorAll('.workplace__design');
designs.forEach(el => el.addEventListener("click", function () {
  const selectedDesign = document.querySelector('.panel__design-selected');
  selectedDesign.classList.remove('panel__design-selected');
  el.classList.add('panel__design-selected');
  })
);

const okDesignButton = document.querySelector('.workplace__ok.des');
okDesignButton.addEventListener('click', function(){
  const selectedDesignName = document.querySelector('.panel__design-selected').dataset.designname;
  $.ajax({
    type: "POST",
    data: {
      selectedDesignName: selectedDesignName,
    },
    url: "php/getFilesFromGoogleDrive.php",
    success: function (response) {
        alert("UwU");
        document.querySelector('.back').href = "../index.php"
      }
  });
})

const reportButtons = document.querySelectorAll('.workplace__ok.report');
reportButtons.forEach(el => el.addEventListener('click', function(){
  const reportType = el.dataset.reporttype;
  const checkboxes = el.parentNode.parentNode.querySelectorAll('input');
  let fields = [];
  if (checkboxes[0].checked) {fields.push("description");}
  if (checkboxes[1].checked) {fields.push("price");}
  if (checkboxes[2].checked) {fields.push("discount");}
  if (checkboxes[3].checked) {fields.push("count");}
  if (checkboxes[4].checked) {fields.push("dateBuy");}

  $.ajax({
    type: "POST",
    data: {
      reportType: reportType,
      fields: fields,
    },
    url: "php/generateReport.php",
    success: function (response) {
      console.log('response: ', response);
        alert("FOK");
        el.nextElementSibling.style.display = "block";
        el.nextElementSibling.href = response;
      }
  });
}))

const importAvitoProductButton = document.querySelector('.import-avito-product');
importAvitoProductButton.addEventListener('click', function(){
  const url = document.querySelector('#urlAvitoProduct').value;
  $.ajax({
    type: "POST",
    data: {
      url: url,
    },
    url: "php/parserAvitoProduct.php",
    success: function (response) {
      const result = JSON.parse(response);
      let html = "<div><b>Наименование товара:</b> " + result["productName"] + "</div>";
      html += "<div><b>Описание товара:</b> " + result["description"] + "</div>";
      html += "<div><b>Цена:</b> " + result["price"] + " ₽</div>";
      html += "<div class='avito-images'>";
      result["img"].forEach(el => 
        html += "<img width='200px' src='data:image/*;base64," + el + "'>"
      );
      html += "</div><button class='add-product-avito'>Добавить импортированный товар</button>";
      document.querySelector('.import-avito-product-result').innerHTML=html; 
      const addProductAvitoButton = document.querySelector('.add-product-avito');
      addProductAvitoButton.addEventListener('click', function(){
        $.ajax({
          type: "POST",
          data: {
            productName: result["productName"],
            description: result["description"],
            price: result["price"],
            isAvailable: 1,
            count: 1,
            imgData: result["img"],
          },
          url: "php/addProduct.php",
          success: function (response) {
            alert("Oppai");
          }
        });
      })
    }
  });
})


const sizeButton = document.querySelector('.workplace__ok.size');
const sizeInput = document.querySelector('#newSize');
sizeButton.addEventListener('click', function(){
  const size = sizeInput.value;
  $.ajax({
    type: "POST",
    data: {
      size: size,
    },
    url: "php/changeImageSizes.php",
    success: function (response) {
      if (response=="Success") {
        alert("Oppai");
      }
    }
  });
})


const importAvitoCatalogButton = document.querySelector('.import-avito-catalog');
importAvitoCatalogButton.addEventListener('click', function(){
  const url = document.querySelector('#urlAvitoCatalog').value;
  $.ajax({
    type: "POST",
    data: {
      url: url,
    },
    url: "php/parserAvitoCatalog.php",
    success: function (response) {
      const result = JSON.parse(response);
      // console.log('result: ', result);
      let html = "";
      for (let i=0; i<result.length; i++){
        html += '<div class="pesontedan"><input id="pesontedan-'+ i +'" type="checkbox" class="chkbx" name="pesontedans"><label class="lbl" for="pesontedan-'+ i +'">' + result[i]["productName"] + '</label><div class="pesontedan-content">';
        html += "<div><b>Наименование товара:</b> " + result[i]["productName"] + "</div>";
        html += "<div><b>Описание товара:</b> " + result[i]["description"] + "</div>";
        html += "<div><b>Цена:</b> " + result[i]["price"] + " ₽</div>";
        html += "<div class='avito-images'>";
        result[i]["img"].forEach(el => html += "<img width='200px' src='data:image/*;base64," + el + "'>");
        html += '</div><input id="product' + i + '" type="checkbox" checked><label for="product' + i + '">Добавить товар</label></div></div>';
      }
      html += "<button class='add-product-catalog-avito'>Добавить импортированные товары</button>";
      document.querySelector('.import-avito-catalog-result').innerHTML=html;

      const addProductCatalogAvitoButton = document.querySelector('.add-product-catalog-avito');
      addProductCatalogAvitoButton.addEventListener('click', function(){
        let data = [];
        for (let i=0; i<result.length; i++){
          if (document.querySelector('#product' + i).checked) {
            data.push(result[i]);
          }
        }
        if (data.length != 0){
          $.ajax({
            type: "POST",
            data: {
              data: data,
              isAvailable: 1,
              count: 1,
            },
            url: "php/addProducts.php",
            success: function (response) {
              alert("Oppai");
            }
          });
        }
      })
    }
  });
})


const orderButton = document.querySelector('.workplace__ok.orders');
orderButton.addEventListener('click', function(){
  $.ajax({
    type: "POST",
    url: "php/getOrders.php",
    success: function (response) {
      const result = JSON.parse(response);
      let html = "";
      const length = result.length;
      for (let i=0; i<length; i++){
        html += '<div class="pesontedan"><input id="pesontedan-'+ i +'" type="checkbox" class="chkbx" name="pesontedans"><label';
        if (result[i][0]["statusID"] == "2") {
          html += ' id="got-work"';
        }
        html += ' class="lbl" for="pesontedan-'+ i +'">Заказ №'+ result[i][0]["orderID"];
        if (result[i][0]["statusID"] == "2") {
          html += ' (в работе)';
        }
        html += '</label><div class="pesontedan-content">';
        
        html += '<table border=1> \
                  <caption>Параметры заказа</caption> \
                  <tr> \
                      <th>Адрес доставки</th> \
                      <th>Оплата</th> \
                      <th>Доставка</th> \
                      <th>ФИО</th> \
                      <th>E-mail</th> \
                      <th>Телефон</th> \
                      <th>Комментарий</th> \
                      <th>Дата</th> \
                  </tr>';
        html += '<tr> \
                      <td>' + result[i][0]["address"] + '</td> \
                      <td>' + result[i][0]["payName"] + '</td> \
                      <td>' + result[i][0]["delName"] + '</td> \
                      <td>' + result[i][0]["lastName"] + ' ' + result[i][0]["firstName"] + ' ' + result[i][0]["middleName"] + '</td> \
                      <td>' + result[i][0]["mail"] + '</td> \
                      <td>' + result[i][0]["phone"] + '</td> \
                      <td>' + result[i][0]["comment"] + '</td> \
                      <td>' + result[i][0]["dateBuy"] + '</td></tr>';
        html += '</table><br>';
        
        html += '<table border=1> \
                    <caption>Состав заказа</caption> \
                    <tr> \
                        <th>№</th> \
                        <th>Наименование товара</th> \
                        <th>Стоимость</th> \
                        <th>Скидка</th> \
                        <th>Количество</th> \
                    </tr>';
        let orderLength = result[i].length;
        for (let j=0; j<orderLength; j++){
          html += '<tr> \
                      <td>' + (j+1) + '</td> \
                      <td>' + result[i][j]["productName"] + '</td> \
                      <td>' + result[i][j]["price"] + '</td> \
                      <td>' + result[i][j]["discount"] + '%</td> \
                      <td>' + result[i][j]["count"] + '</td></tr>';
        }
        html += '</table><br>';
        if (result[i][0]["statusID"] == "1") {
          html += '<button data-orderid=' + result[i][0]["orderID"] + ' id="order' + i + '">Взять в работу</button>';
        }
        html += '</div></div>';
      }
      document.querySelector('.orders-result').innerHTML=html;

      const workButtons = document.querySelectorAll('[data-orderid]');
      workButtons.forEach(el => el.addEventListener('click', function(){
        const orderID = el.dataset.orderid;
        $.ajax({
          type: "POST",
            data: {
              orderID: orderID,
              statusID: 2,
            },
            url: "php/changeOrderStatus.php",
            success: function (response) {
              el.parentNode.parentNode.querySelector('.lbl').id = 'got-work';
              el.parentNode.parentNode.querySelector('.lbl').innerHTML += ' (в работе)';
              el.parentNode.removeChild(el);
              alert("Заказ взят в работу.");
            }
        })
      }))
      alert("Oppai");
    }
  });
})
