$(function(){
  
});

$(document).ready(function () {

 var bookId = 0;
 var bookName = 0; 
 var dataS = "";

 $("#findBook").autocomplete({
      source: function( request, response ) {
        $.ajax( {
          url: "\/bookhero\/www\/book\/list?do=autocomplete",
          dataType: "json",
          data: {
            term: request.term
          },
          success: function( data ) {
            response( data );
            dataS = data;
          }
        } );
      },
      minLength: 2,
      select: function( event, ui ) {
        bookId = ui.item.id;
        bookName = ui.item.label; 
      }
 });

$("#searchBtn" ).click(function() {
	if ($("#findBook").val() != bookName)
	{
		id = findId(dataS, $("#findBook").val());
		if (id != false || bookId != 0) {
			window.location.href = "\/bookhero\/www\/book\/show\/"+id;
		}
		else 
		{
			alert("Hledaná kniha neexistuje!");
		}
		return false; 

	}
  else
    {
      if (bookId == 0)
      {
        alert("Hledaná kniha neexistuje!");
      }
      else
      {
        window.location.href = "\/bookhero\/www\/book\/show\/"+bookId;
      }
      
	    return false;
    }
});
   if (window.location.pathname.indexOf('/edit/') > 0)
   {
    $("#frm-addBookForm-name").autocomplete({
        source: "\/bookhero\/www\/book\/list?do=autocomplete",
        minLength: 2
    });

   }
   



            $('#frm-addBookForm-image').on('change',function(){
                var fileName = $(this).val();
                $(this).next('.custom-file-label').html(fileName);
            })

});

function findId(data, value)
{
	id = false; 
	for (var k in data) {
	   if (data[k]["value"] == value)
	   {
	   	 id = data[k]["id"]; 
	   }
	}

	return id;
}


