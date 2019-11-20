$(document).ready(function() {
    const data = JSON.parse(localStorage.getItem('user'));
    var catId = data["supplycategory"];
    var category;
    switch(catId) {
        case "cat01":
            category = "Furniture";
            break;
        case "cat02":
            category = "Food";
            break;
        case "cat03":
            category = "Electronic";
            break;

    }
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' +
        ((''+month).length<2 ? '0' : '') + month + '-' +
        ((''+day).length<2 ? '0' : '') + day;


    $("#cat").html("<h5>Category: "+ category+"</h5>");
    $.ajax({
        url:'server/supplierviewtender.php',
        type:'POST',

        data:{Data:catId} ,
        success: function(response) {
            console.log(response);
            var resp=$.parseJSON(response);
            callblockchainsuppliertendrs();
            console.log(resp);


            $.each(resp, function(key, val) {

                var tr=$('<tr class="old"> </tr>');
                $.each(val, function(k, v){

                    if(v==output){

                        $(".old").addClass("highlight");

                    }



                    if(k== "hashCode"){
                        $('<td><a href="http://localhost:8081/smarttrdae/smarttrade/singletender.html?tenderhash='+v+'"> View Tender </a></td>').appendTo(tr);
                    }


                    else {
                        $('<td>'+v+'</td>').appendTo(tr);
                    }

                });

                tr.appendTo('#tbody');
            });
            console.log(response);


        },
        error: function (response, err) {


        }
    });
    console.log(catId);

});

function callblockchainsuppliertendrs() {

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