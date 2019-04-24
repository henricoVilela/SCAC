$(function(){
var textfield = $("input[name=user]");
            $('button[name="submit-login"]').click(function(e) {
                //e.preventDefault();
                //little validation just to check username
                /*if (textfield.val() != "") {

                    $("#output").addClass("alert alert-success animated fadeInUp").html("Welcome back " + "<span style='text-transform:uppercase'>" + textfield.val() + "</span>");
                    $("#output").removeClass(' alert-danger');
                    $("input").css({
                    "height":"0",
                    "padding":"0",
                    "margin":"0",
                    "opacity":"0"
                    });
                    //change button text
                    $('button[type="submit"]').html("continue")
                    .removeClass("btn-info")
                    .addClass("btn-default").click(function(){
                    $("input").css({
                    "height":"auto",
                    "padding":"10px",
                    "opacity":"1"
                    }).val("");
                  });*/


                } else {
                    //remove success mesage replaced with error message
                    $("#output").removeClass('alert alert-success');
                    $("#output").addClass("alert alert-danger animated fadeInUp").html("Por favor, entre com um RA caso seja aluno ou com um e-mail caso seja coordenador!");
                }
                //console.log(textfield.val());

            });
});


$(function(){
  var textfield = $("input[name=ra]");

    $('button[name="submit-cad"]').click(function(e) {
      e.preventDefault();
      //little validation just to check username
      if (textfield.val() != "") {

        $("#output").addClass("alert alert-success animated fadeInUp").html("Welcsdd " + "<span style='text-transform:uppercase'>" + textfield.val() + "</span>");
        $("#output").removeClass('alert-danger');

        //change button text
        $('button[name="submit-cad"]').html("Login")
        .removeClass("btn-info")
        .addClass("btn-default").click(function(){
        $("input").css({ "height":"auto", "padding":"10px", "opacity":"1" }).val("");});

      } else {

        $("#output").removeClass('alert alert-success');
        $("#output").addClass("alert alert-danger animated fadeInUp").html("Por favor confira os dadoszxxsas asasas");
      }

    });
});
