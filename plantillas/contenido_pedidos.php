<script>
const productos = {
    B: { nombre: "Butano", precio: 17.67, cantidad: 0 },
    P: { nombre: "Propano", precio: 14.65, cantidad: 0 },
    N: { nombre: "Nel", precio: 20.85, cantidad: 0 },
    I: { nombre: "Industrial", precio: 79.8, cantidad: 0 },
    K: { nombre: "K6", precio: 17.85, cantidad: 0 },
    C: { nombre: "Carretilla", precio: 23.8, cantidad: 0 }
};
</script>
<script src="funciones.js"></script>
<div id="contenedorPedidos">
    <div id="pedidosIzquierda">
        <div class="pedidos">
            <img src="img/butano.png" alt="Bombona de butano naranja de Repsol">
            <span class="simboloResta" onclick="restarpedido('B')"><i class="fa-solid fa-minus"></i></span><span class="contadorPedido" id="contadorB">0</span><span class="simboloSuma" onclick="sumarpedido('B')"><i class="fa-solid fa-plus"></i></span>
        </div>
        <div class="pedidos">
            <img id="propano" src="img/propano.png" alt="Bombona de propano naranja de Repsol">
            <span class="simboloResta" onclick="restarpedido('P')"><i class="fa-solid fa-minus"></i></span><span class="contadorPedido" id="contadorP">0</span><span class="simboloSuma" onclick="sumarpedido('P')"><i class="fa-solid fa-plus"></i></span>
        </div>
        <div class="pedidos">
            <img id="nel" src="img/nel.png" alt="Bombona de propano naranja de Repsol">
            <span class="simboloResta" onclick="restarpedido('N')"><i class="fa-solid fa-minus"></i></span><span class="contadorPedido" id="contadorN">0</span><span class="simboloSuma" onclick="sumarpedido('N')"><i class="fa-solid fa-plus"></i></span>
        </div>
        <div class="pedidos">
            <img id="industrial" src="img/industrial.png" alt="Bombona de propano naranja de Repsol">
            <span class="simboloResta" onclick="restarpedido('I')"><i class="fa-solid fa-minus"></i></span><span class="contadorPedido" id="contadorI">0</span><span class="simboloSuma" onclick="sumarpedido('I')"><i class="fa-solid fa-plus"></i></span>
        </div>
        <div class="pedidos">
            <img id="k6" src="img/k6.png" alt="Bombona de propano naranja de Repsol">
            <span class="simboloResta" onclick="restarpedido('K')"><i class="fa-solid fa-minus"></i></span><span class="contadorPedido" id="contadorK">0</span><span class="simboloSuma" onclick="sumarpedido('K')"><i class="fa-solid fa-plus"></i></span>
        </div>
        <div class="pedidos">
            <img id="carretilla" src="img/carretilla.png" alt="Bombona de propano naranja de Repsol">
            <span class="simboloResta" onclick="restarpedido('C')"><i class="fa-solid fa-minus"></i></span><span class="contadorPedido" id="contadorC">0</span><span class="simboloSuma" onclick="sumarpedido('C')"><i class="fa-solid fa-plus"></i></span>
        </div class="pedidos">
    </div>
    <div id="pedidosDerecha">
        <div id="resumenSticky">
            <h3>Resumen de pedido</h3>
            <div id="resumenPedido"></div>
            <form method="POST" action="procesar_pedido.php" onsubmit="generarResumenTexto()">
                <input type="hidden" name="pedidoResumen" id="pedidoResumenInput">
                <button type="submit">Enviar pedido</button>
            </form>
        </div> 
    </div>
    
</div>