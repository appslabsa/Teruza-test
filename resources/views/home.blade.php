

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Forex Rates</h1>
    <button id="load-rates">Load Forex Rates</button>
    <table id="forex-rates" border="1" style="display:none;">
        <thead>
            <tr>
                <th>Currency</th>
                <th>Rate</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <h2>Convert Currency</h2>
    <input type="text" id="amount" placeholder="Amount">
    <select id="currency"></select>
    <button id="convert">Convert</button>
    <p id="conversion-result"></p>

    <script>
        $(document).ready(function(){
            // Load Forex Rates
            $('#load-rates').click(function(){
                $.ajax({
                    url: '/api/forex-rates',
                    method: 'GET',
                    success: function(data) {
                        var tbody = $('#forex-rates tbody');
                        tbody.empty();
                        for(var currency in data.rates) {
                            tbody.append('<tr><td>' + currency + '</td><td>' + data.rates[currency] + '</td></tr>');
                        }
                        $('#forex-rates').show();
                    }
                });
            });

            // Load currencies into the dropdown
            $.ajax({
                url: '/api/forex-rates',
                method: 'GET',
                success: function(data) {
                    var currencyDropdown = $('#currency');
                    for(var currency in data.rates) {
                        currencyDropdown.append('<option value="' + currency + '">' + currency + '</option>');
                    }
                }
            });

            // Convert currency
            $('#convert').click(function(){
                var amount = $('#amount').val();
                var currency = $('#currency').val();
                $.ajax({
                    url: '/api/convert',
                    method: 'POST',
                    data: {
                        amount: amount,
                        currency: currency,
                    },
                    success: function(result) {
                        $('#conversion-result').text('Converted Amount: ' + result.converted);
                    }
                });
            });
        });
    </script>
</body>
</html>

