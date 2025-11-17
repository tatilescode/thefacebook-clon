<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Thefacebook</title>

<style>
    body {
        background-color: #ececec;
        font-family: "Tahoma", sans-serif;
        margin: 0;
        padding: 0;
    }

    .top-title {
        background-color: #4b6c9b;
        color: white;
        padding: 20px;
        font-size: 32px;
        font-weight: bold;
        text-align: center;
    }

    .nav-bar {
        background-color: #3b5480;
        padding: 6px;
        text-align: right;
        color: white;
        font-size: 14px;
    }

    .nav-bar a {
        color: white;
        margin: 0 8px;
        text-decoration: none;
        font-weight: bold;
    }

    .main-container {
        width: 800px;
        margin: auto;
        background-color: white;
        border: 1px solid #a7a7a7;
        margin-top: 20px;
        padding-bottom: 30px;
    }

    .left-login-box {
        width: 250px;
        float: left;
        padding: 15px;
        margin-right: 10px;
        border-right: 1px solid #ccc;
    }

    .left-login-box input {
        width: 95%;
        margin-bottom: 8px;
    }

    .left-login-box button {
        width: 48%;
        background-color: #4b6c9b;
        border: none;
        color: white;
        padding: 5px;
        cursor: pointer;
        font-weight: bold;
    }

    .welcome-box {
        padding: 20px;
        margin-left: 260px;
    }

    h2 {
        text-align: center;
        margin-top: 0;
        font-size: 22px;
    }

    .footer {
        text-align: center;
        font-size: 12px;
        color: #444;
        margin-top: 20px;
    }

    .footer a {
        color: #4b6c9b;
        text-decoration: none;
        margin: 0 5px;
    }

    .footer div {
        margin-top: 10px;
        font-size: 11px;
        color: #777;
    }
</style>

</head>
<body>

<div class="top-title">
    [ thefacebook ]
</div>

<div class="nav-bar">
    <a href="login.php">login</a>
    <a href="register.php">register</a>
    <a href="about.php">about</a>
</div>

<div class="main-container">

    <div class="left-login-box">
        <label>Email:</label>
        <input type="text" name="email">

        <label>Password:</label>
        <input type="password" name="password">

        <button onclick="window.location='register.php'">register</button>
        <button onclick="window.location='login.php'">login</button>
    </div>

    <div class="welcome-box">
        <h2>[ Welcome to Thefacebook ]</h2>

        <p>
            Thefacebook is an online directory that connects people through social networks at colleges.
        </p>

        <p>
            We have opened up Thefacebook for popular consumption at <b>Harvard University.</b>
        </p>

        <p>You can use Thefacebook to:</p>
        <ul>
            <li>Search for people at your school</li>
            <li>Find out who are in your classes</li>
            <li>Look up your friends' friends</li>
            <li>See a visualization of your social network</li>
        </ul>

        <p>
            To get started, click below to register.  
            If you have already registered, you can log in.
        </p>

        <button onclick="window.location='register.php'" style="width:120px; margin-right:10px;">Register</button>
        <button onclick="window.location='login.php'" style="width:120px;">Login</button>
    </div>

    <div style="clear: both;"></div>

</div>

<div class="footer">
    <a href="#">about</a> |
    <a href="#">contact</a> |
    <a href="#">faq</a> |
    <a href="#">terms</a> |
    <a href="#">privacy</a>

    <div>
        a Mark Zuckerberg production <br>
        Thefacebook © 2004
    </div>
</div>

</body>
</html>
