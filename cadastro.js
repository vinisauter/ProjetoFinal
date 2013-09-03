//function to validate fields
function validateField(oEvent) {
    oEvent = oEvent || window.event;
    var txtField = oEvent.target || oEvent.srcElement;
    var oXmlHttp = zXmlHttp.createRequest();
    oXmlHttp.open("get", "cadastro.php?" + txtField.name + "=" + encodeURIComponent(txtField.value), true);
    oXmlHttp.onreadystatechange = function() {
        if (oXmlHttp.readyState == 4) {
            if (oXmlHttp.status == 200) {
                var arrInfo = oXmlHttp.responseText.split("||");
                var imgErro = document.getElementById("imgErro" + txtField.id.substring(3));
                var btnCadastro = document.getElementById("btnCadastro");

                if (!eval(arrInfo[0])) {
                    imgErro.title = arrInfo[1];
                    imgErro.style.display = "";
                    txtField.valid = false;
                } else {
                    imgErro.style.display = "none";
                    txtField.valid = true;
                }

                btnCadastro.disabled = !isFormValid();
            } else {
                alert("Ocorreu um erro ao tentar entrar em contato com o servidor.");
            }
        }
    };
    oXmlHttp.send(null);
}
;

function isFormValid() {
    var frmMain = document.forms[0];
    var blnValid = true;

    for (var i = 0; i < frmMain.elements.length; i++) {
        if (typeof frmMain.elements[i].valid == "boolean") {
            blnValid = blnValid && frmMain.elements[i].valid;
        }
    }
    return blnValid;
}

//if Ajax is enabled, disable the submit button and assign event handlers
window.onload = function() {
    if (zXmlHttp.isSupported()) {
        var btnCadastro = document.getElementById("btnCadastro");
        var txtUsername = document.getElementById("txtUsername");
        var txtNascimento = document.getElementById("txtNascimento");
        var txtEmail = document.getElementById("txtEmail");

        btnCadastro.disabled = true;
        txtUsername.onchange = validateField;
        txtNascimento.onchange = validateField;
        txtEmail.onchange = validateField;
        txtUsername.valid = false;
        txtNascimento.valid = false;
        txtEmail.valid = false;
    }
};