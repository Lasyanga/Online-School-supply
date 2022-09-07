<div class="nav navbar navbar-dark bg-white sticky-top shadow-sm">
			<button type="button" class="btn btn-light text-black font-buxton lead" onclick="openNav()">&#9776; Menu</button>

			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown no-arrow">
					<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="mr-2 d-none d-lg-inline text-black-50 small"><?php echo $_SESSION['username'];?></span>
						 <img class="img-profile rounded-circle" src="../uploads/user_profile/<?php echo $_SESSION['img'];?>" width="30px" height="30px">
					</a>
                    <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="../user_setting/profile.php?user=<?php echo $_SESSION['user_id'];?>">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-black"></i>
                            Profile
                        </a>
                        <a class="dropdown-item" href="../user_setting/account_setting.php?user=<?php echo $_SESSION['user_id'];?>">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-black"></i>
                            Settings
                        </a>
                        <a class="dropdown-item" href="../user_setting/actlog.php?user=<?php echo $_SESSION['user_id'];?>">
                            <i class="fas fa-list fa-sm fa-fw mr-2 text-black"></i>
                            Activity Log
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../logout.php?logout">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
				</li>

			</ul>
	</div>