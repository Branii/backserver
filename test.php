<?php


// $dsn = 'mysql:host=192.168.1.51;dbname=lottery_test'; // Fixed variable name and removed extra space
// $pass = "enzerhub";
// $user = "enzerhub";
// try {
//     $pdo = new PDO($dsn, $user, $pass);
//     //  echo "Connected";
// } catch (\Throwable $th) {
//     echo $th->getMessage();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Range Slider with Percentage and Computed Value</title>
  <!-- jQuery from Google CDN -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <table>
    <tr>
      <td>
        <!-- Number Input -->
        <input type="number" value="7000" min="0" max="10000" step="0.1" class="odds-input" id="oddsInput" />
        <span id="percentDisplay">100%</span>
        <br>

        <!-- Range Slider -->
        <input type="range" value="10" min="0" max="10" step="0.1" class="odds-slider" id="oddsSlider" />
      
        <span id="computedValue">Computed Value: 7000</span>
      </td>
    </tr>
  </table>

  <script>
    $(document).ready(function() {
      const maxValue = 7000;

      // Function to update the percentage and computed value
      function updateValue() {
        // Get the value from the slider or input
        let value = parseFloat($('.odds-slider').val());
        if ($('.odds-input').val()) {
          value = parseFloat($('.odds-input').val());
        }

        // Calculate the percentage
        const percentage = (value / maxValue) * 100;

        // Update the percentage display
        $('#percentDisplay').text(`${Math.round(percentage)}%`);

        // Calculate the computed value based on the percentage of maxValue
        const calculatedValue = (percentage / 100) * maxValue;

        // Update the computed value display
        $('#computedValue').text(`Computed Value: ${Math.round(calculatedValue)}`);

        // Update the input value when the slider changes
        $('.odds-inputt').val(Math.round(calculatedValue));
      }

      // When the input field changes, update the slider
      $('.odds-input').on('input', function() {
        let inputValue = parseFloat($(this).val());
        if (inputValue > maxValue) {
        $(this).val(maxValue);  // Set the input value to maxValue if exceeded
    }
        // Update the slider position based on the input value
        let percentage = (inputValue / maxValue) * 100;
        let sliderValue = (percentage / 100) * 10; // Map percentage to slider range (0 to 10)
        $('.odds-slider').val(sliderValue);
        updateValue();
      });

      // When the slider changes, update the input field
      $('.odds-slider').on('input', function() {
        let sliderValue = parseFloat($(this).val());
        // Update the input value based on the slider value
        let percentage = (sliderValue / 10) * 100; // Map slider value to percentage
        let inputValue = (percentage / 100) * maxValue; // Calculate the value based on the max value
        $('.odds-input').val(Math.round(inputValue));
        updateValue();
      });

      // Initialize values on page load
      updateValue();
    });
  </script>
</body>
</html>

