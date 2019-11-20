$(document).ready(function() {




    function get(name){
        if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
            return decodeURIComponent(name[1]);
    }





    var tenderhash = get('tenderhash');



    $.ajax({
        url:'server/supplierviewsingletender.php',
        type:'POST',
        data:{tenderHash:tenderhash} ,
        success: function(response) {
            getSingletenderfromblockchain(tenderhash);

            var resp=$.parseJSON(response);
            console.log(resp);
            var json = JSON.parse(response);
            $('#tenderName span').text(json['tenderName']);
            $("textarea#tenderDescription").val(json['tenderDescription']);
            $("#tenderBidstartdate").val(json['tenderBidstartdate']);
            $("#expectedAmount").val(json['tenderAmount']);
            $("#requiredQuentity").val(json['tenderQuentity']);
            $("#bidClosedate").val(json['tenderClosedate']);
            document.getElementById("tenderfile").setAttribute('data', 'tednders/'+json['filepath']);

            console.log(json['hashCode']);
        },
        error: function (response, err) {


        }
    });


});

function getSingletenderfromblockchain(tenderhash) {
    $.ajax({
        url:'http://localhost:3000/api/test.Tender/ten'+tenderhash,
        type:'GET',
        contentType: "application/json; charset=utf-8",
        success: function(response) {

            console.log(response);
        },
        error: function (response, err) {
            console.log(response, err);

        }


    });
}
