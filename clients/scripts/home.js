document.addEventListener('DOMContentLoaded', async () => {
    const token = localStorage.getItem('token');

    if (!token) {
        window.location.href = '../pages/login.html';
        return;
    }

    try {

        const response = await axios.post(
            'http://localhost/DigitalWalletPlatform/server/user/v1/home.php',
            {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            }
        );

        if (response.data.status === 'success') {
            const user = response.data.user;
            const verificationContainer = document.querySelector('.validation-status-container');
            if (user.verified !== "unverified") {
                verificationContainer.style.display = 'none';
            }

            const balanceAmount = document.querySelector('.balance-amount');
            const currencySelector = document.querySelector('#currency-selector');

            const updateBalance = () => {
                const selectedCurrency = currencySelector.value;
                const selectedWallet = user.wallets.find(wallet => wallet.currency === selectedCurrency);

                if (selectedWallet) {
                    balanceAmount.textContent = selectedCurrency == 'USD' ? `$${selectedWallet.balance.toFixed(2)}` : `${selectedWallet.balance.toFixed(2)} LBP`;

                } else {
                    balanceAmount.textContent = selectedCurrency == 'USD' ? '$0.00' : '0.00 LBP';
                }
            };

            updateBalance();

            currencySelector.addEventListener('change', updateBalance);

        }
    } catch (error) {
        console.error('Error fetching user data:', error);
        if (error.response?.status === 401) {
            localStorage.removeItem('token');
            window.location.href = './login.html';
        }
    }
});