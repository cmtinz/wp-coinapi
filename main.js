document.addEventListener('DOMContentLoaded', () => {
    const baseURL = document.querySelector("link[rel='https://api.w.org/']").href;
    const main = document.querySelector('main');
    const mensaje = document.createElement('div');
    main.appendChild(mensaje);
    mensaje.classList.add('mensaje');
    mensaje.innerHTML = "Recuperando datos...";
    fetch(baseURL + "cmtinz/v1/coinapi")
    .then(response => {
        if (!response.ok) throw Error(response.statusText);
        return response.json();
    })
    .then(response => {
        const lista = document.createElement('div');
        lista.classList.add('currencies');
        response.coins.forEach(coin => {
            const item = document.createElement('div');
            item.dataset.currency = coin.asset_id;
            item.classList.add('currency')
            item.innerHTML = `<span class="currency-name">${coin.name}</span><span class="currency-id">${coin.asset_id}</span><span class="currency-rate">${coin.rate}</span><span class="currency-rate">${response.base_asset_id}</span>`;
            mensaje.classList.add('d-none');
            lista.appendChild(item);
        })
        main.appendChild(lista);
    })
    .catch(error => {
        console.error('Error:', error)
        mensaje.innerHTML = "Hubo un error en la petición. <br>Consulta con el administrador del sistema";
    });
})