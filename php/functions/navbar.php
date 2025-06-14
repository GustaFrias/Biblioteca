<form action="/Biblioteca/php/functions/pgPesquisa.php" method="get" onsubmit="return validarBusca()">
    <input type="text" id="barraBusca" name="busca" placeholder="Pesquise aqui" autocomplete="off" oninput="buscarInstantaneamente()"/> 
 </form>

<script>
function validarBusca() {
    const termo = document.getElementById('barraBusca').value.trim();
    if (termo.length === 0) {
        alert('Digite algo para busca');
        return false;
    }
    return true;
}
</script>