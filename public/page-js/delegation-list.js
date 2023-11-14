$(document).ready(function () {

    $("#delegation-list").hide();
    $("#button-get-delegation-report").click(function () {

        var data = new Object();

        $.ajax({
            method: "GET",
            url: 'api/delegationreport/' + $("#form-userid").val(),
        }).done(function (response) {

            if (response.success == true) {
                $("#delegation-list-body").html('');
                $("#delegation-list").show();

                if (response.type == 'error') {
                    $("#delegation-list").hide();
                    Swal.fire({
                        icon: response.type,
                        title: response.message,
                        showConfirmButton: true,
                    });
                }
                for (delegation in response.data) {
                    $("#delegation-list-body").append(
                        "<tr>" +
                        "<th scope='row'>" + (1 * delegation + 1) + "</th>" +
                        "<td>" + response.data[delegation].start + "</td>" +
                        "<td>" + response.data[delegation].end + "</td>" +
                        "<td>" + response.data[delegation].country + "</td>" +
                        "<td>" + response.data[delegation].amount_due + "</td>" +
                        "<td>" + response.data[delegation].currency + "</td>" +
                        "</tr>"
                    );
                }
            }
        }).fail(function (response) {
            Swal.fire({
                icon: "error",
                title: "Internal error !\n Please provide correct User Id",
                showConfirmButton: true,
                timer: 5000
            });
        });
    });
});