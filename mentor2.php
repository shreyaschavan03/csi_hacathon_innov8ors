<?php
// Database connection settings
$host = 'localhost';
$db = 'mentor_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        // Login logic
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM mentor WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $mentor = $result->fetch_assoc();
            if (password_verify($password, $mentor['password'])) {
                echo "Login successful! Welcome " . $mentor['full_name'];
            } else {
                echo "Incorrect password!";
            }
        } else {
            echo "No account found with that email!";
        }

    } elseif (isset($_POST['signup'])) {
        // Signup logic
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
        $qualification = $_POST['qualification'];
        $university = $_POST['university'];
        $branch = $_POST['branch'];

        // Check if email already exists
        $sql = "SELECT * FROM mentor WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // Insert new mentor into the database
            $sql = "INSERT INTO mentor (full_name, email, password, qualification, university, branch) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssss', $full_name, $email, $password, $qualification, $university, $branch);

            if ($stmt->execute()) {
                echo "Sign up successful! You can now login.";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "An account with this email already exists!";
        }
    }
}

$conn->close();
?>

<!-- HTML form structure remains the same, only add the form action and method -->


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
        <h2>Mentor(Career Guidance) Login</h2>
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
            <input type="text" placeholder="Qualification" required>

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