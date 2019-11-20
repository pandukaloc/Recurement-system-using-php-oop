$(document).ready(function() {
    const data = JSON.parse(localStorage.getItem('user'));
    $.ajax({
        url:'../server/officertenderview.php',
        type:'POST',
        success: function(response) {
            console.log(response);
            var resp=$.parseJSON(response);
            console.log(resp);

            callblockchainpublishedtenders();
            $.each(resp, function(key, val) {

                var tr=$('<tr> </tr>');
                $.each(val, function(k, v){

if(k=="tenderCategory"){
    var cate;
    switch(v) {

        case "cat01":
            cate = "Furniture";
            break;
        case "cat02":
            cate = "Food";
            break;
        case "cat03":
            cate = "Electronic";
            break;

    }
   
    $('<td>'+cate+'</td>').appendTo(tr);
}else{

                    $('<td>'+v+'</td>').appendTo(tr);}


                });

                tr.appendTo('#tbody');
            });
            console.log(response);


        },
        error: function (response, err) {


        }
    });


        $('#logout').on('click', function(e){
            if(confirm("Are you sure you want to logout?"))
                window.location.href = "index.html";
                localStorage.removeItem();

            return false;
        });


});

function callblockchainpublishedtenders() {



   $.ajax({
        url:'http://localhost:3000/api/test.Tender',
        type:'GET',
        contentType: "application/json; charset=utf-8",
        success: function(response,message) {
            $("#reg").prop('disabled', false);
            console.log(response);
        },
        error: function (response, err) {

            $.confirm({
                type: 'red',
                animation: 'zoom',
                animationBounce: 1.5,
                columnClass: 'col-md-6',
                closeAnimation: 'scale',
                title: 'Error',
                content: response+err,
                close: function () {
                    window.location.reload(1);
                }
            });
        }
    });

}