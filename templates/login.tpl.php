<?php declare(strict_types = 1); ?>

<?php function drawLogin() { ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Trouble Ticket Website</title>
        <link rel="stylesheet" href="/../css/login.css">
        <script src="/../javascript/login.js" defer></script>
        <script src="/../javascript/editUser.js" defer></script>

        <style>
body {
    background: linear-gradient(45deg, #212529, #1b9f90, #28b498);
    background-size: 400% 400%;
    animation: gradientAnimation 10s ease infinite;
}

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
    </style>
    </head>
    <body class="overflow--hidden">
    <section class="auth-wrapper">
        <div class="card-container">
            <div class="card">
                <div class="login-form">
                    <div class="header">Log in</div>
                    <div class="content">
                        <form  action="../actions/session/action_login.php" method="post">
                            <div class="input-field" >
                                <input type="text" placeholder="Email" name="email">
                            </div>
                            <div class="input-field">
                                <input type="password" placeholder="Password" name="password" id="password">
                                <i class="password-toggle fa fa-eye" id="password-toggle" onclick="togglePasswordVisibility()"></i>

                            </div>
                            <div class="input-field">
                                <button class="btn btn-submit" type="submit">Log in</button>
                            </div>
                        </form>
                    </div>
                </div> 
                <div class="signup-form">
                    <div class="header">Sign up</div>
                    <div class="content">
                        <form action="../actions/session/action_signup.php" method="post">
                            <div class="input-field" >
                                <input type="username" placeholder="Username" name="username" required>
                            </div>
                            <div class="input-field" >
                                <input type="email" placeholder="Email" name="email" required>
                            </div>
                            <div class="input-field group">
                                <input type="password" placeholder="Password" name="password" required>
                            </div>
                            <div class="input-field">
                                <button class="btn btn-submit" type="submit">Get started</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div> 

        <section class="image-container image-container_login">
            <div class="container-wrapper">
                <div class="animate-text"><div class="container-text__wrapper">
                        <h1 class="image-container-title">New Here ?</h1>
                        <div class="image-container-text">Create an account !</div>
                </div></div>

                <button class="btn btn-submit" id="btn-signup">Sign up</button>

            </div>
        </section>
        <section class="container-flapper"></section>
    </section>

    </body>
    </html>
<?php } ?>