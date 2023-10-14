document.addEventListener("DOMContentLoaded", function() {
    console.log("DOMContentLoaded se ha disparado correctamente.");
    
    const selectElement = document.getElementById("evaluado");
    if (selectElement) {
        selectElement.addEventListener("change", function() {
            mostrarNombre();
        });
    } else {
        console.error("Elemento con ID 'evaluado' no encontrado.");
    }

    function mostrarNombre() {
        const selectElement = document.getElementById("evaluado");
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const selectedPersonName = selectedOption.getAttribute("data-name");
        const nombreEvaluadoElement = document.getElementById("nombreEvaluado");
        if (nombreEvaluadoElement) {
            nombreEvaluadoElement.textContent = selectedPersonName;
        } else {
            console.error("Elemento con ID 'nombreEvaluado' no encontrado.");
        }
    }
    

    document.getElementById("register-btn").addEventListener("click", function () {
        document.getElementById("registro-form").style.display = "block";
        document.getElementById("login-form").style.display = "none";
    });

    document.getElementById("login-btn").addEventListener("click", function () {
        document.getElementById("registro-form").style.display = "none";
        document.getElementById("login-form").style.display = "block";
    });

    document.getElementById('login-form').addEventListener('submit', function() {
        document.getElementById('confirmation').style.display = 'block';
    });
});
