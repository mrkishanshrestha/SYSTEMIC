var qr;


(function() {
        qr = new QRious({
        element: document.getElementById('qr-code'),
        size: 200,
        value: 'Systemic'
    });
})();

function generateQRCode(dataString) {
    var qrtext = dataString;
    qr.set({
        foreground: 'black',
        size: 200,
        value: qrtext
    });
}

generateQRCode('SYSTEMIC IS COOL');