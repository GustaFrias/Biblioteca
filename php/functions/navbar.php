<form action="busca.php" method="get" onsubmit="return validarBusca()">
    <input type="text" name="busca" id="barraBusca" placeholder="Buscar livros..." oninput="buscarInstantaneamente()">
</form>

<script>
function validarBusca() {
    const termo = document.getElementById('barraBusca').value.trim();
    return termo.length > 0;
}

function buscarInstantaneamente() {
    const termo = document.getElementById('barraBusca').value;
    if (termo.length >= 2) {
        window.location.href = 'pgPesquisa.php?busca=' + encodeURIComponent(termo);
    }
}
</script>