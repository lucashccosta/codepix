const formatBrCoin = (value) => {
    const formatter = new Intl.NumberFormat(
        'pt-br', 
        { style: 'currency', currency: 'BRL' }
    );

    return formatter.format(value);
};

module.exports = { formatBrCoin };