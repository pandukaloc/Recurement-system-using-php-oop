$(document).ready(function() {
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

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

setInputFilter(document.getElementById("phonenumber"), function(value) {
    return /^\d*$/.test(value); });


jQuery(function ($) {
    $('#userregister').validate({
        rules: {
            firstName:{
                required: true
            },
            lastName:{
                required: true
            },
            email :{
                required: true,
                email: true
            },
            phoneNumber :{
                required: true,
                number: true,
                minlength:10,
                maxlength:10
            },


            educationlevel:{
                required: true,
                valueNotEquals: "default"
            },
            workingindustry:{
                required: true,
                valueNotEquals: "default"
            },
            workexperience:{
                required: true,
                valueNotEquals: "default"
            }
        },
        messages: {
            firstName:{
                required:"Please enter the first name"
            },
            lastName:{
                required:"Please enter the last name"
            },
            email: {
                required: "Please enter the email address",
                email: "Please enter a valid email address"
            },
            phoneNumber:{
                required: "Please enter the company address",
                number:"Please enter numbers"
            },
            educationlevel:{
                required: "Please select the education qualifications",
                valueNotEquals: "select the education qualifications"

            },

            workingindustry: {
                required: "please select the working industry",
                valueNotEquals: "please select the work industry"
            },
            workexperience: {
                required: "Please enter the work experience",
                valueNotEquals: "please select the work industry"
            }
        }
    });
});

$(document).ready(function() {
    var inputs = $("form#supplierregister input, form#supplierregister textarea");
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


    $("#supplierregister").submit(function(e){
        $("#reg").prop('disabled', true);
        var arlene1= {
            "reqMethod" : '_registerSupplier',
            "companyName": $("#companyName").val(),
            "supplierName": $("#supplierName").val(),
            "companybrc": $("#companybrc").val(),
            "companyAddress": $("#companyAddress").val(),
            "companyEmail": $("#companyEmail").val(),
            "companyContact": $("#companyContact").val(),
            "inputPassword": $("#inputPassword").val(),
            "confirmPassword": $("#confirmPassword").val(),
            "brccopy": $("#brccopy").val(),
            "supplycategory": $("#supplycategory").val(),

        };



        console.log(arlene1);
        e.preventDefault();
        $.ajax({
            url:'server/supplierregister.php',
            type:'POST',
            data: {Data: JSON.stringify(arlene1)},
            success: function(response) {
                $("#reg").prop('disabled', false);

                callblockchain();
                console.log(response);
                $.confirm({
                    type: 'green',
                    animation: 'zoom',
                    columnClass: 'col-md-6',
                    closeAnimation: 'scale',
                    title: 'Success',
                    content: response,
                    close: function () {
                        window.location = "index.html";
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
            }
        });
    });
});

function callblockchain() {
    var category;
    switch($("#supplycategory").val()) {
        case "1":
            category = "furniture";
            break;
        case "2":
            category = "Food";
            break;
        case "3":
            category = "Electronic";
            break;

    }
    var arlene1= {
        "$class" : 'test.TenderCompany',
        "companyId":'sup'+Math.floor(100000 + Math.random() * 900000),
        "companyName": $("#companyName").val(),
        "supplierName": $("#supplierName").val(),
        "companybrc": $("#companybrc").val(),
        "companyAddress": $("#companyAddress").val(),
        "companyEmail": $("#companyEmail").val(),
        "companyContact" : $("#companyContact").val(),
        "supplycategory" : category,
        "isAuth": "false" };

    var request=JSON.stringify(arlene1);
    console.log(request);
    $.ajax({
        url:'http://localhost:3000/api/test.TenderCompany',
        type:'POST',
        contentType: "application/json; charset=utf-8",
        data:request,
        success: function(response) {
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