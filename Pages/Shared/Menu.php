<!--NAV BAR-->
<div class="navbar navbar-expand-md navbard-light fixed-top bg-light">
	<div class="container-fluid justify-content-between">
		<!--elements: Left-->
		<div class="nav">
			<a class="navbar-brand" href="#">HELP DESK</a>
		</div>
		<!--elements: Left-->
		<!--elements: center-->
		<div class="nav justify-content-center me-3">
			<div class="collapse navbar-collapse">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="/Pages/MainPage/Main.php">
							<div class="icon-container">
								<span title="home"><i data-feather="home"></i></span>
								<span class="icon-text">Main menu</span>
							</div>
						</a>
					</li>
					<?php if ($users->HaveAdminPermissions()) : ?>
						<li class="nav-item">
							<a class="nav-link" href="/Pages/Departments/DepartmentsList.php">
								<div class="icon-container">
									<span title="Departments"><i class="icon-icon" data-feather="grid"></i></span>
									<span class="icon-text">Departments</span>
								</div>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/Pages/Users/UsersList.php">
								<div class="icon-container">
									<span title="Users"><i data-feather="users"></i></span>
									<span class="icon-text">Users</span>
								</div>
							</a>
						</li>
					<?php endif ?>
					<?php if ($users->HaveHelpDeskPermissions()) : ?>
						<li class="nav-item">
							<a class="nav-link" href="/Pages/Tickets/TicketsList.php">
								<div class="icon-container">
									<span title="Tickets"><i data-feather="list"></i></span>
									<span class="icon-text">Helpdesk</span>
								</div>
							</a>
						</li>
					<?php endif ?>
					<li class="nav-item">
						<a class="nav-link" href="/Pages/Tickets/TicketsList.php">
							<div class="icon-container">
								<span title="Tickets"><i data-feather="list"></i></span>
								<span class="icon-text">Tickets</span>
							</div>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<!--elements: center-->
		<!--elements: right-->
		<div class="justify-content-end">
			<div class="collapse navbar-collapse">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a href="../Account/Logout.php">
							<div class="icon-container me-3">
								<span title="Logout"><i data-feather="log-out"></i></span>
								<span class="icon-text">Logout</span>
							</div>
						</a>
					</li>

				</ul>
			</div>
		</div>
		<!--elements: right-->
	</div>
</div>
<!--NAV BAR-->