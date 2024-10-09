<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>QR Code Scanner</title>
</head>
<body>
    <h1>QR Code Scanner</h1>

    <!-- This is where the QR code scanner will render -->
    <div id="reader" style="width: 300px; height: 300px;"></div>

    <!-- Display scan results -->
    <p id="result">Scan Result: </p>
    <p id="cameraStatus"></p>

    <script>
        // Function to handle successful QR code scanning
         function onScanSuccess(decodedText, decodedResult) {
            // Display the decoded text (phone number in your case)
            document.getElementById('result').textContent = `Phone Number: ${decodedText}`;
            console.log(`Scan result: ${decodedText}`);

            // Stop the scanner after successful scan to avoid multiple scans
            html5QrCode.stop().then(() => {
                console.log("QR code scanning stopped.");
            }).catch((err) => {
                console.error("Failed to stop camera:", err);
            });
        }

        // Function to handle scan failures (e.g., if no QR code is detected)
        function onScanFailure(error) {
            // Handle scan failure (this function is optional)
            console.warn(`QR code scan error: ${error}`);
            document.getElementById('result').textContent = "Scanning...";
        }

        // Start the QR code scanner
        let html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start(
            { facingMode: "environment" },  // Use the back camera
            {
                fps: 10,  // Frames per second for scanning
                qrbox: { width: 600, height: 600 }  // Scanning box dimensions
            },
            onScanSuccess,
            onScanFailure
        ).then(() => {
            document.getElementById('cameraStatus').textContent = "Camera is activated";
        }).catch((err) => {
            console.error(`Camera initialization error: ${err}`);
            document.getElementById('cameraStatus').textContent = "Camera activation failed: " + err;
        });
    </script>
</body>
</html>
