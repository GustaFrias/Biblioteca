let debounceTimeout;

function buscarInstantaneamente() {
    clearTimeout(debounceTimeout);
    const termo = document.getElementById('barraBusca').value.trim();

    if (termo.length >= 2) {
        debounceTimeout = setTimeout(() => {
            fetch('pgPesquisa.php?busca=' + encodeURIComponent(termo))
                .then(response => response.text())
                .then(html => {
                    document.getElementById('resultadosBusca').innerHTML = html;
                })
                .catch(err => {
                    document.getElementById('resultadosBusca').innerHTML = 'Erro na busca.';
                    console.error(err);
                });
        }, 500);
    } else {
        document.getElementById('resultadosBusca').innerHTML = '';
    }
}