function read_data() {
  console.log("Load data from API!");
  const tarif1 = `<a href="shop.php">Tarif 1 ... 3098 EUR</a>`;
  $("#tarife").html(tarif1);
}

function validate_region() {
  let region = $("#country").val();
  console.log(region);

  let test = region.indexOf("NO");
  console.log(test);
  if (test === -1) {
    $("#country").blur();
    $("#country").removeClass("err");
    $("#country").addClass("succ");
    $("#msg").html("");
    $("#cat").show();
    //read_data();
  }

  if (test === 0) {
    $("#country").blur();
    $("#country").removeClass("succ");
    $("#country").addClass("err");
    $("#msg").html(alertDiv("Bitte Transportkategorie wählen!!"));
    $("#tarife").html("");
    $("#cat").hide();
  }
}

function alertDiv(text) {
  return `<div class="alert alert-danger">${text}</div>`;
}
/*
$("#test").click(function (e) {
  e.preventDefault();
  alert("Check Form!!");
});
*/
function loadKat(kat) {
  const country = document.getElementById("country").value;

  $.ajax({
    type: "GET",
    url: "ajaxcontrol.php",
    data: {
      kat: kat,
      region: country,
    },
    success: function (succ) {
      $("#category").html(succ);
      $("#kat").removeClass("err");
      if (kat.indexOf("-") === -1) {
        $("#kat").blur();
        $("#kat").addClass("succ");
        $("#category").show();
        //$("#test").show();
      } else {
        $("#kat").blur();
        $("#kat").removeClass("succ");
        $("#kat").addClass("err");
        $("#category").hide();
        //$("#test").hide();
      }
    },
  });
}

function validate_test(val) {
  if (val.indexOf("-") === -1) {
    $("#test").show();
  } else {
    $("#test").hide();
  }
}

// $("#chooser").on("submit", function (e) {
//   e.preventDefault();
//   //alert("Chooser submitted");
//   $.ajax({
//     url: "cart.php",
//     type: "POST",
//     data: new FormData(this),
//     contentType: false,
//     processData: false,
//     success: function (data) {
//       $("#response").html(data);
//       window.location = "shop.php";
//       // $("#formbox").html(golink);
//       // $('.alert').html(`PDF Upload von ${data} erfolgreich!`);
//       //alert("Upload erfolgreich!");
//     },
//   });
// });
