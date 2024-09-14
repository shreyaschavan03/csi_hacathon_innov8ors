<?php
// Start the session
 

// Database connection settings
$host = "localhost"; // Change this if your MySQL is hosted elsewhere
$username = "root"; // MySQL username
$password = ""; // MySQL password
$dbname = "student"; // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        // Login form submission
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check for user in the database
        $sql = "SELECT * FROM students WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $_SESSION['email'] = $email;
            echo "Login successful! Welcome, $email";
        } else {
            echo "Invalid login credentials";
        }
    } elseif (isset($_POST['signup'])) {
        // Sign-up form submission
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $year = $_POST['year'];
        $university = $_POST['university'];
        $branch = $_POST['branch'];

        // Insert new user into the database
        $sql = "INSERT INTO students (fullname, email, password , year, university, branch) 
                VALUES ('$fullname', '$email', '$password', '$year', '$university', '$branch')";

        if ($conn->query($sql) === TRUE) {
            echo "Sign-up successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login and Sign Up</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 400px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form input,
        form select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #0b79d0;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #065a8c;
        }

        .hidden {
            display: none;
        }

        a {
            color: #0b79d0;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Student Login</h2>
        <form class="login-form">
            <input type="email" placeholder="Email" required>
            <input type="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="#" onclick="toggleForm()">Sign Up</a></p>
        </form>

        <form class="signup-form hidden">
            <input type="text" placeholder="Full Name" required>
            <input type="email" placeholder="Email" required>
            <input type="password" placeholder="Password" required>
            <!-- <input type="text" placeholder="Qualification" required> -->

            <select required>
                <option value="" disabled selected>Select Year</option>
                <option value="FirstYear">F.E.</option>
                <option value="SecondYear">S.E.</option>
                <option value="ThirdYear">T.E.</option>
                <option value="FourthYear">B.E.</option>
                <option value="Graduate">Graduates</option>
            </select>


            <select required>
                <option value="" disabled selected>Select University</option>
                <option value="University A">University of Mumbai (Mumbai University)</option>
                <option value="University B">Savitribai Phule Pune University (Pune University)</option>
                <option value="University C">Shivaji University, Kolhapur</option>
                <option value="University D">Dr. Babasaheb Ambedkar Marathwada University, Aurangabad</option>
                <option value="University E">Swami Ramanand Teerth Marathwada University, Nanded</option>
                <option value="University F">Rashtrasant Tukadoji Maharaj Nagpur University</option>
                <option value="University G">Sant Gadge Baba Amravati University</option>
                <option value="University H">North Maharashtra University, Jalgaon</option>
                <option value="University I">Kavayitri Bahinabai Chaudhari North Maharashtra University, Jalgaon
                </option>
                <option value="University J">Punyashlok Ahilyadevi Holkar Solapur University</option>
            </select>

            <select required>
                <option value="" disabled selected>Select Branch</option>
                <option value="Computer Science">Computer Science</option>
                <option value="Mechanical Engineering">Mechanical Engineering</option>
                <option value="I.T. Engineering">I.T. Engineering</option>
                <option value="Comps(AIML) Engineering">Comps(AIML) Engineering</option>
                <option value="Civil Engineering">Civil Engineering</option>
                <option value="EXTC Engineering">EXTC Engineering</option>
                <option value="ALDS Engineering">AIDS Engineering</option>
            </select>

            <button type="submit">Sign Up</button>
            <p>Already have an account? <a href="#" onclick="toggleForm()">Login</a></p>
        </form>
    </div>

    <script>
        function toggleForm() {
            var loginForm = document.querySelector(".login-form");
            var signupForm = document.querySelector(".signup-form");
            loginForm.classList.toggle('hidden');
            signupForm.classList.toggle('hidden');
        }
    </script>
</body>

</html>