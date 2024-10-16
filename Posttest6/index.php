<?php session_start(); ?>
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
            <li><a href="crud.php" id="crud-link">Manage Weapons</a></li> <!-- CRUD link added -->
        </ul>
    </nav>

    <div class="container">
        <aside class="sidebar">
            <h2>Navigation</h2>
            <ul>
                <li><a href="#" id="home-link">Home</a></li>
                <li><a href="#" id="about-link">About Me</a></li>
                <li><a href="#" id="weapons-link">CS:GO Weapons</a></li>
                <li><a href="crud.php" id="crud-link">Manage Weapons</a></li>
            </ul>
        </aside>

        <main id="home">
            <h2>WELCOME TO CS: Global Offensive Weapon List</h2>
            <p>Website ini dibuat untuk menampilkan list senjata yang berada di game counter strike.</p>
            <p>Silahkan cek page about me dan list senjata.</p>
        </main>

        <main id="about" style="display: none;">
            <h2>About Me</h2>
            <p>Hello! I am a huge fan of CS:GO and love to share my knowledge and insights about the game...</p>
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
                
            </table>
        </main>
    </div>

    <footer>
        <p>&copy;2309106042</p>
    </footer>
</body>
</html>
