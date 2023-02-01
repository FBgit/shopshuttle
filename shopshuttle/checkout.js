function pasteB2B() {
  const ageber = document.getElementById("ageber");
  const addressBlock = `<p class="pt-3">Ducati Leipzig GmbH<br>Lucas Dörrer<br>Industriepalast<br>Dohnanyistraße 11<br><br>04103 Leipzig</p>`;
  ageber.innerHTML = `<h3 class="pt-3">Auftraggeber B2B</h3>${addressBlock}`;
  let p = document.createElement("p");
  p.innerText = "Daten werden aus der B2B Tabelle gezogen!";
  ageber.append(p);
}

function pastePrivate() {
  const ageber = document.getElementById("ageber");
  const addressBlock = `<p class="pt-3">Ernst Bommel<br>Traumzauberweg 56<br>11999 Berlin</p>`;
  ageber.innerHTML = `<h3 class="pt-3 text-primary">Auftraggeber Privat</h3>${addressBlock}`;
}

$("#chk-form").on("submit", function (e) {
  e.preventDefault();
  console.log("Prevented?");
  //let formData = $('#shopform').serialize();
  let formData = $(this).serialize();
  console.log(formData);
  $.ajax({
    type: "POST",
    url: "ajaxcheckout.php",
    data: formData,
    success: function (res) {
      $("#response").html(res);
      if (res.indexOf("fehlen") === -1) {
        const helpStr = `<p>Erst wenn alles ausgefüllt wurde werden die Daten zwischengespeichert und an euch versendet!</p>`;
        const testButton = `<div><a href="clearing.php" class="btn btn-danger">Test neu starten</a></div>`;
        const templ_str = `<h3>Prüfen Sie Ihre Bestellung!</h3>${helpStr}<div class="card mb-3"><div class="card-body">${res}</div></div>${testButton}`;
        $("#response").html(templ_str);
        $("#checkoutform").hide();
        $("#button-bar").hide();
      }
    },
  });
});
