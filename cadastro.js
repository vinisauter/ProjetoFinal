//function to validate fields
function validateField(oEvent) {
    oEvent = oEvent || window.event;
    var txtField = oEvent.target || oEvent.srcElement;
    var oXmlHttp = zXmlHttp.createRequest();
    oXmlHttp.open("get", "cadastroSubTrot.php?" + txtField.name + "=" + encodeURIComponent(txtField.value), true);
    oXmlHttp.onreadystatechange = function() {
        if (oXmlHttp.readyState == 4) {
            if (oXmlHttp.status == 200) {
                var arrInfo = oXmlHttp.responseText.split("||");
                var labelErro = document.getElementById("Erro" + txtField.id.substring(3));
                var btnCadastro = document.getElementById("btnCadastro");

                if (!eval(arrInfo[0])) {
                    labelErro.innerHTML = ' ⨉' + arrInfo[1];
                    txtField.valid = false;
                    txtField.style.border = "2px solid black";
                    txtField.style.backgroundColor = "rgba(255,0,0,0.25)";
                } else {
                    labelErro.innerHTML = ' ✓' + arrInfo[1];
                    txtField.valid = true;
                    txtField.style.border = "2px solid black";
                    txtField.style.backgroundColor = "rgba(0,255,0,0.25)";
                }

                btnCadastro.disabled = !isFormValid();
            } else {
                alert("Ocorreu um erro ao tentar entrar em contato com o servidor.");
            }
        }
    };
    oXmlHttp.send(null);
}

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

//se ajax estiver ativado, desative o botão submit e atribuir manipuladores de eventos
window.onload = function() {
    if (zXmlHttp.isSupported()) {
        var txtNome = document.getElementById("txtNome");
        var txtEmail = document.getElementById("txtEmail");
        var txtUsername = document.getElementById("txtUsername");
        var txtSenha1 = document.getElementById("txtSenha1");
        var btnCadastro = document.getElementById("btnCadastro");

        txtNome.onchange = validateField;
        txtEmail.onchange = validateField;
        txtUsername.onchange = validateField;
        txtSenha1.onchange = validateField;

        txtNome.valid = false;
        txtEmail.valid = false;
        txtUsername.valid = false;
        txtSenha1.valid = false;

        btnCadastro.disabled = true;
    }
};