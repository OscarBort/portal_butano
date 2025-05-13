
document.getElementById("usuario").addEventListener("blur", validarUsuario);
document.getElementById("usuario").addEventListener("keyup", validarUsuario);
document.getElementById("nombre").addEventListener("blur", validarUsuarioForm);
document.getElementById("nombre").addEventListener("keyup", validarUsuarioForm);
document.getElementById("correo").addEventListener("blur", compCorreo);
document.getElementById("correo").addEventListener("keyup", compCorreo);

function validarUsuario(){
    var nombre = document.getElementById("usuario");
    let regex = /^[A-Za-zÑñÁáÉéÍíÓóÚú]+$/;
    let boton = document.getElementById("boton");
    if ((nombre.value.length <= 2 || nombre.value.length > 15) || !regex.test(nombre.value)) {
        nombre.style.backgroundColor = "red";
        boton.disabled = true;
    }
    else {
        nombre.style.backgroundColor = "";
        boton.disabled = false;
    }
}

function validarUsuarioForm(){
    var nombre = document.querySelector("#nombre");
    let regex = /^[A-Za-zÑñÁáÉéÍíÓóÚú]+$/;
    let boton = document.querySelector("#botonForm");
    if ((nombre.value.length <= 2 || nombre.value.length > 15) || !regex.test(nombre.value)) {
        nombre.style.backgroundColor = "red";
        boton.disabled = true;
    }
    else {
        nombre.style.backgroundColor = "";
        boton.disabled = false;
    }
}

function compCorreo(){
    let correo = document.getElementById("correo").value,
        regex = /^(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])+$/;
    let boton = document.getElementById("botonForm");

    if (correo.match(regex)){
        document.getElementById("correo").style.backgroundColor = "";
        boton.disabled = false;
    }
    else{
        document.getElementById("correo").style.backgroundColor = "red";
        boton.disabled = true;
    }
}
// Funciones para la página pedidos
/*function restarpedidoB(){
    if (contadorB > 0){
    contadorB--;
    document.getElementById("contadorB").innerText = contadorB; }
}
function sumarpedidoB(){
    contadorB++;
    document.getElementById("contadorB").innerText = contadorB;
}
function restarpedidoP(){
    if (contadorP > 0){
    contadorP--;
    document.getElementById("contadorP").innerText = contadorP;}
}
function sumarpedidoP(){
    contadorP++;
    document.getElementById("contadorP").innerText = contadorP;
}
function restarpedidoN(){
    if (contadorN > 0){
    contadorN--;
    document.getElementById("contadorN").innerText = contadorN;}
}
function sumarpedidoN(){
    contadorN++;
    document.getElementById("contadorN").innerText = contadorN;
}
function restarpedidoI(){
    if (contadorI > 0){
    contadorI--;
    document.getElementById("contadorI").innerText = contadorI;}
}
function sumarpedidoI(){
    contadorI++;
    document.getElementById("contadorI").innerText = contadorI;
}
function restarpedidoK(){
    if (contadorK > 0){
    contadorK--;
    document.getElementById("contadorK").innerText = contadorK;}
}
function sumarpedidoK(){
    contadorK++;
    document.getElementById("contadorK").innerText = contadorK;
}
function restarpedidoC(){
    if (contadorC > 0){
    contadorC--;
    document.getElementById("contadorC").innerText = contadorC;}
}
function sumarpedidoC(){
    contadorC++;
    document.getElementById("contadorC").innerText = contadorC;
}*/
function sumarpedido(clave) {
    productos[clave].cantidad++;
    actualizarContador(clave);
    actualizarResumen();
}

function restarpedido(clave) {
    if (productos[clave].cantidad > 0) {
        productos[clave].cantidad--;
        actualizarContador(clave);
        actualizarResumen();
    }
}
function actualizarContador(clave) {
    document.getElementById(`contador${clave}`).textContent = productos[clave].cantidad;
}
function actualizarResumen() {
    const resumen = document.getElementById("resumenPedido");
    resumen.innerHTML = ""; // Limpiar contenido anterior

    let totalGeneral = 0;

    for (const clave in productos) {
        const prod = productos[clave];
        if (prod.cantidad > 0) {
            const subtotal = prod.cantidad * prod.precio;
            totalGeneral += subtotal;

            const linea = document.createElement("div");
            linea.textContent = `${prod.nombre}: ${prod.cantidad} x ${prod.precio}€ = ${subtotal}€`;
            resumen.appendChild(linea);
        }
    }

    // Línea del total
    if (totalGeneral > 0) {
        const totalLinea = document.createElement("div");
        totalLinea.style.marginTop = "10px";
        totalLinea.style.fontWeight = "bold";
        totalLinea.textContent = `Total: ${totalGeneral}€`;
        resumen.appendChild(totalLinea);
    }
}
