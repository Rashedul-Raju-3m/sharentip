<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .bus-seats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            max-width: 800px;
            margin: 20px auto;
        }

        .seat {
            width: 100%;
            padding: 15px;
            box-sizing: border-box;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
        }

        .seat-booked {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .seat:hover {
            background-color: #f0f0f0;
        }

    </style>
    <title>Bus Seats Booking</title>
</head>
<body>

<h2 style="text-align: center;">Bus Seats Booking</h2>

<div class="bus-seats">
    <?php
      $totalSeats = 32;
      for ($i = 1; $i <= $totalSeats; $i++) {
        echo '<div class="seat" onclick="bookSeat(' . $i . ')" id="seat-' . $i . '">Seat ' . $i . '</div>';
}
?>
</div>

<script>
    function bookSeat(seatNumber) {
        var seat = document.getElementById('seat-' + seatNumber);
        seat.classList.toggle('seat-booked');
    }
</script>

</body>
</html>



<!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .bus-container {
            display: flex;
            flex-wrap: wrap;
            max-width: 400px;
            margin: 20px auto;
        }

        .bus-seat {
            width: 40px;
            height: 40px;
            margin: 5px;
            text-align: center;
            line-height: 40px;
            border: 1px solid #ccc;
            cursor: pointer;
        }

        .bus-seat.selected {
            background-color: #3498db;
            color: #fff;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Array to store the selected seats
            const selectedSeats = [];

            // Function to handle seat click
            function toggleSeat(seat) {
                seat.classList.toggle("selected");
                const seatNumber = seat.getAttribute("data-seat");

                // Update the selected seats array
                const index = selectedSeats.indexOf(seatNumber);
                if (index === -1) {
                    selectedSeats.push(seatNumber);
                } else {
                    selectedSeats.splice(index, 1);
                }

                // Display the selected seats
                document.getElementById("selected-seats").textContent = selectedSeats.join(", ");
            }

            // Add click event listeners to each seat
            const seats = document.getElementsByClassName("bus-seat");
            for (const seat of seats) {
                seat.addEventListener("click", function() {
                    toggleSeat(seat);
                });
            }
        });
    </script>
</head>
<body>
<div class="bus-container">
    &lt;!&ndash; Bus Seats &ndash;&gt;
    <div class="bus-seat" data-seat="1">1</div>
    <div class="bus-seat" data-seat="2">2</div>
    <div class="bus-seat" data-seat="3">3</div>
    <div class="bus-seat" data-seat="4">4</div>
    <div class="bus-seat" data-seat="5">5</div>
    &lt;!&ndash; Add more seats as needed &ndash;&gt;

    &lt;!&ndash; Display selected seats &ndash;&gt;
    <div style="margin-top: 20px;">
        <strong>Selected Seats:</strong> <span id="selected-seats"></span>
    </div>
</div>
</body>
</html>
-->



<!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Seat Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .bus {
            display: flex;
            flex-wrap: wrap;
            max-width: 600px;
            margin: 20px auto;
        }

        .seat {
            width: 40px;
            height: 40px;
            margin: 5px;
            text-align: center;
            line-height: 40px;
            cursor: pointer;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .seat.booked {
            background-color: #FF7272;
            color: #fff;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<h2>Bus Seat Booking</h2>

<div class="bus" id="bus">
    &lt;!&ndash; Seats will be dynamically generated here &ndash;&gt;
</div>

<script>
    // Define the number of rows and columns for the bus
    const rows = 5;
    const cols = 4;

    // Get the bus element
    const bus = document.getElementById('bus');

    // Function to create seats and add event listeners
    function createSeats() {
        for (let row = 1; row <= rows; row++) {
            for (let col = 1; col <= cols; col++) {
                const seat = document.createElement('div');
                seat.classList.add('seat');
                seat.textContent = row + '-' + col;
                seat.setAttribute('data-status', 'available'); // Set initial status
                seat.addEventListener('click', toggleSeat);
                bus.appendChild(seat);
            }
        }
    }

    // Function to toggle seat status on click
    function toggleSeat() {
        const status = this.getAttribute('data-status');
        if (status === 'available') {
            this.classList.add('booked');
            this.setAttribute('data-status', 'booked');
        } else {
            this.classList.remove('booked');
            this.setAttribute('data-status', 'available');
        }
    }

    // Call the function to create seats
    createSeats();
</script>

</body>
</html>
-->




<!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Seat Booking</title>
    <style>
        /* Add your CSS styles here */
        .seat {
            width: 40px;
            height: 40px;
            margin: 5px;
            background-color: #ccc;
            display: inline-block;
            cursor: pointer;
        }
        .seat.booked {
            background-color: #ff0000;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<h2>Bus Seat Booking</h2>
<p>Select a seat to book:</p>

<div id="seat-map">
    &lt;!&ndash; Generate your seats dynamically using JavaScript &ndash;&gt;
</div>

<p>Selected Seat: <span id="selected-seat">None</span></p>
<button onclick="bookSeat()">Book Seat</button>

<script>
    // Add your JavaScript logic here
    const seatMap = document.getElementById('seat-map');
    const selectedSeatDisplay = document.getElementById('selected-seat');
    let selectedSeat = null;

    // Create a 5x5 grid of seats (you can customize this as needed)
    const numRows = 5;
    const numCols = 5;

    for (let row = 1; row <= numRows; row++) {
        for (let col = 1; col <= numCols; col++) {
            const seat = document.createElement('div');
            seat.className = 'seat';
            seat.dataset.row = row;
            seat.dataset.col = col;
            seat.innerText = `${row}-${col}`;
            seat.addEventListener('click', () => selectSeat(row, col));
            seatMap.appendChild(seat);
        }
    }

    function selectSeat(row, col) {
        if (!selectedSeat) {
            selectedSeat = { row, col };
            selectedSeatDisplay.innerText = `${row}-${col}`;
        } else {
            alert('Please unselect the current seat before selecting a new one.');
        }
    }

    function bookSeat() {
        if (selectedSeat) {
            const selectedSeatElement = document.querySelector(`.seat[data-row="${selectedSeat.row}"][data-col="${selectedSeat.col}"]`);
            selectedSeatElement.classList.add('booked');
            selectedSeat = null;
            selectedSeatDisplay.innerText = 'None';
        } else {
            alert('Please select a seat before booking.');
        }
    }
</script>

</body>
</html>
-->
