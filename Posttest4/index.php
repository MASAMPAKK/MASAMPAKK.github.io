<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['username'] = htmlspecialchars($_POST['username'], ENT_QUOTES);
    $_SESSION['age'] = htmlspecialchars($_POST['age'], ENT_QUOTES);
    $_SESSION['password'] = htmlspecialchars($_POST['password'], ENT_QUOTES);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Senjata CS:GO</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>CS:GO Weapon List</h1>
            <div class="hamburger" id="hamburger">
                &#9776;
            </div>
            <input type="text" id="search-bar" placeholder="Search...">
        </div>
    </header>

    <nav class="nav-links">
        <ul>
            <li><a href="#" id="home-link">Home</a></li>
            <li><a href="#" id="about-link">About Me</a></li>
            <li><a href="#" id="weapons-link">CS:GO Weapons</a></li>
        </ul>
    </nav>

    <div class="container">
        <aside class="sidebar">
            <h2>Navigation</h2>
            <ul>
                <li><a href="#" id="home-link">Home</a></li>
                <li><a href="#" id="about-link">About Me</a></li>
                <li><a href="#" id="weapons-link">CS:GO Weapons</a></li>
            </ul>
        </aside>

        <main id="home">
            <h2>WELCOME TO CS: Global Offensive weapon list</h2>
            <p>Website ini dibuat untuk menampilkan list senjata yang berada di game counter strike</p>
            <p>silahkan cek page about me dan list senjata</p>

            <h2>input informasi user</h2>
            <form id="info-form" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="age">Age:</label>
                <input type="number" id="age" name="age" min="1" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Submit</button>
            </form>

            <div id="results" style="margin-top: 20px;">
                <h3>Informasi user:</h3>
                <p><strong>Username:</strong> <span id="result-username"></span></p>
                <p><strong>Age:</strong> <span id="result-age"></span></p>
                <p><strong>Password:</strong> <span id="result-password"></span></p>
                <input type="hidden" id="hidden-username" value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username'], ENT_QUOTES) : ''; ?>">
                <input type="hidden" id="hidden-age" value="<?php echo isset($_SESSION['age']) ? htmlspecialchars($_SESSION['age'], ENT_QUOTES) : ''; ?>">
                <input type="hidden" id="hidden-password" value="<?php echo isset($_SESSION['password']) ? htmlspecialchars($_SESSION['password'], ENT_QUOTES) : ''; ?>">
            </div>
        </main>

        <main id="about" style="display: none;">
            <h2>About Me</h2>
            <p>Halo Saya Muhammad Aidil Saputra Anta Maulana Pansurna Alal Kaumil Kafirin</p>
            <p>saya adalah mahasiswa yang menyukai game counter strike</p>
        </main>

        <main id="weapons" style="display: none;">
            <h2>CS:GO Weapons List</h2>
            <table>
                <tr>
                    <th>Weapon Name</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Damage</th>
                    <th>Magazine Size</th>
                </tr>
                <tr>
                    <td>AK-47</td>
                    <td>Rifle</td>
                    <td>$2700</td>
                    <td>36</td>
                    <td>30</td>
                </tr>
                <tr>
                    <td>M4A4</td>
                    <td>Rifle</td>
                    <td>$3100</td>
                    <td>33</td>
                    <td>30</td>
                </tr>
                <tr>
                    <td>AWP</td>
                    <td>Sniper Rifle</td>
                    <td>$4750</td>
                    <td>115</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>Desert Eagle</td>
                    <td>Pistol</td>
                    <td>$700</td>
                    <td>53</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>UMP-45</td>
                    <td>SMG</td>
                    <td>$1200</td>
                    <td>35</td>
                    <td>25</td>
                </tr>
            </table>
        </main>
    </div>

    <footer>
        <p>&copy;2309106042</p>
    </footer>
</body>
</html>
