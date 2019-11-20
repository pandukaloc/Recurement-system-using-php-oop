$(document).ready(function() {
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

});


$("#tenderAmount").on("keyup", function(){
    var valid = /^\d{0,4}(\.\d{0,2})?$/.test(this.value),
        val = this.value;

    if(!valid){
        console.log("Invalid input!");
        this.value = val.substring(0, val.length - 1);
    }
});

function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
        textbox.addEventListener(event, function() {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            }
        });
    });
}

setInputFilter(document.getElementById("tenderQuentity"), function(value) {
    return /^\d*$/.test(value); });


jQuery(function ($) {
    $('#newtender').validate({
        rules: {
            tenderName:{
                required: true
            },
            tenderDescription:{
                required: true
            },
            tenderAmount :{
                required: true
            },
            biddingDate :{
                required: true
            },
            tenderClosedate :{
                required: true

            },
            tenderQuentity: {
                required: true

            },
            tendercategory: {
                required: true,
                valueNotEquals: "default"

            }
        },
        messages: {
            tenderName:{
                required:"Please enter the tender name"
            },
            tenderDescription:{
                required:"Please enter the description"
            },
            tenderAmount: {
                required: "Please enter the ender amount"
            },
            biddingDate:{
                required: "Please enter the idding date"
            },
            tenderClosedate:{
                required: "Please enter the company contact"

            },

            tenderQuentity: {
                required: "Please enter the email address"
            },
            tendercategory: {
                required: "Please enter the password",
                valueNotEquals: "please Select the supply category"
            }

        }
    });
});

$(document).ready(function() {



    var inputs = $("form#newtender input, form#newtender textarea");

    var validateInputs = function validateInputs(inputs) {
        var validForm = true;
        inputs.each(function(index) {
            var input = $(this);
            if (!input.val()  ) {
                $("#reg").attr("disabled", "disabled");
                validForm = false;
            }
        });
        return validForm;
    }


    inputs.change(function() {
        if (validateInputs(inputs)) {
            $("#reg").removeAttr("disabled");
        }
    });








    $("#newtender").submit(function(e){
        $("#reg").prop('disabled', true);

        var formData = new FormData(this);
        formData.set('reqMethod', "_newTender");
        formData.set('tendercategory',$("#tendercategory").val())


        console.log();
        e.preventDefault();
        $.ajax({
            url:'../server/newtender.php',
            type:'POST',
            data: formData,
            success: function(response) {
                $("#reg").prop('disabled', false);

                var res = response.split("+");
                var restext = response.split("+", 1);
                res = res[res.length-1];


                callblockchainfornewtender(res);
                console.log(response);
                $.confirm({
                    type: 'green',
                    animation: 'zoom',
                    columnClass: 'col-md-6',
                    closeAnimation: 'scale',
                    title: 'Success',
                    content: restext,
                    close: function () {
                        window.location.reload(1);
                    }
                });



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
            },   cache: false,
            contentType: false,
            processData: false
        });
    });
});

function callblockchainfornewtender(res) {
    var tencategory;
    switch($("#tendercategory").val()) {
        case "1":
            tencategory = "Furniture";
            break;
        case "2":
            tencategory = "Food";
            break;
        case "3":
            tencategory = "Electronic";
            break;

    }





    var biddingDate = new Date($("#biddingDate").val());
    var tenderClosedate = new Date($("#tenderClosedate").val());
    var message = {
        "response":"tender has placed on smarttradenetwork"

    };
    var arlene1= {
        "$class" : 'test.Tender',
        "tenderId":'ten'+res,
        "tenderName": $("#tenderName").val(),
        "tenderDescription": $("#tenderDescription").val(),
        "tenderAmount": $("#tenderAmount").val(),
        "biddingDate": biddingDate.toISOString(),
        "tenderClosedate": tenderClosedate.toISOString(),
        "tenderQuentity": $("#tenderQuentity").val(),
        "tendercategory" : tencategory,
        "appliedCompnies": [],
        "proposedAmmounts": [],
        "isAllocated": "false",
        "isOpen": "true" };

    var request=JSON.stringify(arlene1);
    var message=JSON.stringify(message);
    console.log(request);
    $.ajax({
        url:'http://localhost:3000/api/test.Tender',
        type:'POST',
        contentType: "application/json; charset=utf-8",
        data:request,
        success: function(response,message) {
            $("#reg").prop('disabled', false);


            console.log(response);

            console.log(message);



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