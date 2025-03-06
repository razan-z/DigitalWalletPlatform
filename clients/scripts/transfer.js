document.addEventListener('DOMContentLoaded', () => {
    const token = localStorage.getItem('token');

    if (!token) {
        window.location.href = '../pages/login.html';
        return;
    }


    const user = JSON.parse(localStorage.getItem('user'));
    const wallets = JSON.parse(localStorage.getItem('wallets'));

    if (!user || !wallets) {
        console.error('User or wallet data not found');
        return;
    }

    if (user.verified === 'unverified') {
        alert('You must verify your account to transfer money.');
        window.location.href = '../pages/verification.html';
        return;
    }


    const availableBalance = document.querySelector('.available-balance p');
    const currencySelector = document.querySelector('.available-balance select');

    const updateBalance = () => {
        const selectedCurrency = currencySelector.value;
        const selectedWallet = wallets.find(wallet => wallet.currency === selectedCurrency);

        if (selectedWallet) {
            availableBalance.textContent = selectedCurrency === 'USD'
                ? `$${selectedWallet.balance.toFixed(2)}`
                : `${selectedWallet.balance.toFixed(2)} LBP`;
        } else {
            availableBalance.textContent = selectedCurrency === 'USD' ? '$0.00' : '0.00 LBP';
        }
    };

    updateBalance();
    currencySelector.addEventListener('change', updateBalance);


    const transferForm = document.querySelector('form');
    transferForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const recipient = document.getElementById('recipient').value;
        const amount = parseFloat(document.getElementById('amount').value);
        const currency = currencySelector.value;
        const transferType = document.querySelector('input[name="transfer_type"]:checked').value;

        if (!recipient || !amount || !currency || !transferType) {
            alert('All fields are required');
            return;
        }

        try {
            const response = await axios.post(
                'http://localhost/DigitalWalletPlatform/server/user/v1/transfer.php',
                { recipient, amount, currency, transferType },
                {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                }
            );

            if (response.data.status === 'success') {
                alert('Transfer successful');
                window.location.reload();
            } else {
                alert(response.data.message);
            }
        } catch (error) {
            console.error('Error during transfer:', error);
            alert('An error occurred during the transfer');
        }
    });
});