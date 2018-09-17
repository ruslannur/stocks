$( document ).ready(function() {
    loadData();
    setInterval(function() {
      loadData();
    }, 15000);  
});

function loadData() {

  var stocksList = $("#stocksList");
  stocksList.html('Загрузка данных...');
  var request = $.ajax({ url: "/stocks",dataType: "json",});

  request.done(function (data) {

    var error_status = data.error;
    if(error_status == 1) {
      stocksList.html('Произошла ошибка получения данных.');
      setButtonAttr(); 
      return;
    }

    var stocks = data.stocks.map(function(item) {
        return "<td>"+item.name + "</td><td>" + item.volume + "</td><td>" + item.amount + "</td>";
      });
    stocksList.empty();

    if (stocks.length) {
        var content = "<tr style=\"height:50px\">" + stocks.join("</tr><tr style=\"height:50px\">") + "</tr>";
        stocksList.append(content);
    }
    setButtonAttr();    
  });

  request.fail(function( jqXHR, textStatus ) {
    stocksList.html('Произошла ошибка получения данных:' + textStatus);
    setButtonAttr(); 
  });

}

$('#refresh').click(function() {
  $(this).attr('class', 'btn btn-default disabled');
  loadData();
});

function setButtonAttr() {
  $('#refresh').attr('class', 'btn btn-primary');
}



