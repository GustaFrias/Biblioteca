document.getElementById('formComprar').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch('/Biblioteca/php/functions/comprar.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(res => {
        if (res.status === 'sucesso') {
            Swal.fire({
                icon: 'success',
                title: 'Compra realizada!',
                text: res.mensagem,
                confirmButtonText: 'OK'
            }).then(() => {
                
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: res.mensagem,
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Erro de conexão',
            text: 'Não foi possível conectar ao servidor.',
            confirmButtonText: 'OK'
        });
    });
});
