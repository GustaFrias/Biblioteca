let debounceTimeout;

function buscarInstantaneamente() {
    clearTimeout(debounceTimeout);
    const termo = document.getElementById('barraBusca').value.trim();

    if (termo.length >= 2) {
        debounceTimeout = setTimeout(() => {
            fetch('/Biblioteca/php/functions/pgPesquisa.php?busca=' + encodeURIComponent(termo))
                .then(response => response.text())
                .then(html => {
                    const resultados = document.getElementById('resultadosBusca');
                    if(resultados) {
                        resultados.innerHTML = html;
                    }
                })
                .catch(err => {
                    const resultados = document.getElementById('resultadosBusca');
                    if(resultados) {
                        resultados.innerHTML = 'Erro na busca.';
                    }
                    console.error(err);
                });
        }, 500);
    } else {
        const resultados = document.getElementById('resultadosBusca');
        if(resultados) {
            resultados.innerHTML = '';
        }
    }
}