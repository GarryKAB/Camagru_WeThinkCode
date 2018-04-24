<div class="widget">
	<h2>Login</h2>
	<div class="inner">
		<form action="login.php" method="post">
			<ul id="login">
				<li>
					<input type="text" name="username" placeholder="Username">
				</li>
				<li>
					<input type="password" name="password" placeholder="Password">
				</li>
				<li>
					<input type="submit" value="Login">
				</li>
				<!-- <li>
					<a href="register.php">Register</a>
				</li> -->
			</ul>	
		</form>

		<h2>Register</h2>
		<form action="register.php" method="post">
			<ul id="register">
				<li>
					<input type="text" name="user" placeholder="Username">
				</li>
				<li>
					<input type="password" name="password" placeholder="Password">
				</li>
				<li>
					<input type="password" name="password2" placeholder="Retype password">
				</li>
				<li>
					<input type="email" name="email" placeholder="Email">
				</li>
				<li>
					<input type="submit" value="Register">
				</li>
			</ul>
		</form>
	</div>
</div>
