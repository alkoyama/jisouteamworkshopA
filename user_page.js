fetch('userdatathread_7tha.php')
  .then(response => response.json())
  .then(data => {
    // Decode UTF-8 encoded data (if needed)
    const decodedName = decodeURIComponent(escape(data.Name));
    const decodedAddress = decodeURIComponent(escape(data.Address));

    // Access and display user information
    document.getElementById('CID').textContent = decodedCID;
    document.getElementById('Name').textContent = decodedName;
    document.getElementById('Address').textContent = decodedAddress;
    document.getElementById('Phone').textContent = data.Phone;
    // ... Add elements for other user details

    // **Handle sensitive information:**
    // Consider masking a portion of the credit card number for security reasons.
    const maskedCard = data.Card_info.slice(0, -4) + '****';
    document.getElementById('card_info').textContent = maskedCard; // (Optional)
  });
