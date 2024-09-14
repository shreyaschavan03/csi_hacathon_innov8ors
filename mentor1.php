<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$dbname = "mentoracad";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);

        $sql = "SELECT * FROM mentors WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $_SESSION['email'] = $email;
            $mentor_data = $result->fetch_assoc();
            $branch = $mentor_data['branch'];

            // Redirect to mentor.html with branch parameter
            header("Location: mentor.html?branch=$branch");
            exit;
        } else {
            echo "<script>alert('Invalid login credentials');</script>";
        }
    } elseif (isset($_POST['signup'])) {
        $fullname = $conn->real_escape_string($_POST['fullname']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $qualification = $conn->real_escape_string($_POST['qualification']);
        $university = $conn->real_escape_string($_POST['university']);
        $branch = $conn->real_escape_string($_POST['branch']);

        $checkEmail = "SELECT * FROM mentors WHERE email='$email'";
        $checkResult = $conn->query($checkEmail);
        
        if ($checkResult->num_rows > 0) {
            echo "<script>alert('Email already exists. Please login.');</script>";
        } else {
            $sql = "INSERT INTO mentors (fullname, email, password, qualification, university, branch) 
                    VALUES ('$fullname', '$email', '$password', '$qualification', '$university', '$branch')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Sign-up successful! You can now log in.');</script>";
            } else {
                echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Login and Sign Up</title>
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
        <h2>Mentor (Academics) Login</h2>
        <form class="login-form" action="" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
            <p>Don't have an account? <a href="#" onclick="toggleForm()">Sign Up</a></p>
        </form>

        <form class="signup-form hidden" action="" method="POST">
            <input type="text" name="fullname" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="qualification" placeholder="Qualification" required>

            <select name="university" required>
                <option value="" disabled selected>Select University</option>
                <option value=" mumbai">University of Mumbai (Mumbai University)</option>
                <option value="Pune">Savitribai Phule Pune University (Pune University)</option>
                <option value="Kolhapur">Shivaji University, Kolhapur</option>
                <option value="Aurangabad">Dr. Babasaheb Ambedkar Marathwada University, Aurangabad</option>
                <option value="Nanded">Swami Ramanand Teerth Marathwada University, Nanded</option>
                <option value="Nagpur">Rashtrasant Tukadoji Maharaj Nagpur University</option>
                <option value="Amravati">Sant Gadge Baba Amravati University</option>
                <option value="Jalgaon">North Maharashtra University, Jalgaon</option>
                <option value="Jalgaon">Kavayitri Bahinabai Chaudhari North Maharashtra University, Jalgaon</option>
                <option value="Solapur">Punyashlok Ahilyadevi Holkar Solapur University</option>
            </select>

            <select name="branch" required>
                <option value="" disabled selected>Select Branch</option>
                <option value="Computer Science">Computer Science</option>
                <option value="Mechanical Engineering">Mechanical Engineering</option>
                <option value="I.T. Engineering">I.T. Engineering</option>
                <option value="Comps(AIML) Engineering">Comps(AIML) Engineering</option>
                <option value="Civil Engineering">Civil Engineering</option>
                <option value ="EXTC Engineering">EXTC Engineering</option>
                <option value="ALDS Engineering">AIDS Engineering</option>
            </select>

            <button type="submit" name="signup">Sign Up</button>
            <p>Already have an account? <a href="#" onclick="toggleForm()">Login</a></p>
        </form>

        <script>
            function toggleForm() {
                var loginForm = document.querySelector(".login-form");
                var signupForm = document.querySelector(".signup-form");
                loginForm.classList.toggle('hidden');
                signupForm.classList.toggle('hidden');
            }
        </script>
    </div>
</body>

</html>