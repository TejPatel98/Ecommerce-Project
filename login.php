<html>
<head>
    <title>CS 405 - Ecommerce</title>
</head>
    <h3>Sign Up</h3>
    <form action="initLogin.php" method="post">
	<label for="userId">User Number </label> <input type="text" id="userId" name="userId"><br /><br />
	<label for="email">Email Address </label> <input type="text" id="email" name="email"><br /><br />
	<label for="username">User Id </label> <input type="text" id="username" name="username"><br /><br />
	<label for="password">Password </label> <input type="text" id="password" name="password"><br /><br />
	<label for="permissionLevel">Status ('C' or 'E' or 'M')</label> <input type="text" id="permissionLevel" name="permissionLevel"><br /><br />
        <button type = "submit">Sign Up</button>
    </form>
    <h3>Sign In</h3>
    <form action="signIn.php" method="post">
	<label for="username">User Id </label> <input type="text" id="username" name="username"><br /><br />
	<label for="password">Password </label> <input type="text" id="password" name="password"><br /><br />
        <button type = "submit">Sign In</button>
    </form>
</html>
