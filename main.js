document.addEventListener('DOMContentLoaded', () => {
    const baseURL = " https://rest.coinapi.io/";
    const apiKey = "2AC3FF0F-8C4F-49F4-9888-7C9DD660E404";
    const baseAssetId = "USD";
    const coins = [{
            assetId: "BTC",
            name: "Bitcoin"
        },
        {
            assetId: "ETH",
            name: "Etherum"
        },
        {
            assetId: "XRP",
            name: "Ripple"

        },
        {
            assetId: "LTC",
            name: "Litecoin"
        },
        {
            assetId: "ADA",
            name: "Cardano"
        }
    ];
    const basePrice = 1;
    coins.forEach((coin, index) => {
        fetch(baseURL + `v1/exchangerate/${baseAssetId}/${coin.assetId}`, {
                headers: {
                    'X-CoinAPI-Key': apiKey
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw Error(response.statusText)
                };
                return response.json();
            })
            .then(response => {
                coins[index].exhange = response.rate
            })
            .catch(error => console.error('Error:', error));
    })
})