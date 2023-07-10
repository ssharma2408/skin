<!-- navbar end -->

<div class="card-box sidebar-content px-0">
	<div class="ba-main-menu">
		<ul class="vertical-menu">
			@if (Session::has('user_details') && Session::get('user_details')->role=="Clinic Admin")
				<li><a href="{{route('clinic.admin.dashboard')}}"><i class="ri-dashboard-line"></i><span> Home</span></a></li>
				<li><a href="{{route('my-clinic.show')}}"><i class="ri-service-line"></i><span> My Clinic</span></a></li>
				<li><a href="{{route('doctors.index')}}"><i class="ri-nurse-fill"></i><span> Doctors</span></a></li>
				<li><a href="{{route('staffs.index')}}"><i class="ri-group-line"></i><span> Staffs</span></a></li>
				<li><a href="all-page.html"><i class="ri-book-read-line"></i><span> Pages</span></a></li>	
				<li><a href="{{ route('login.logout') }}"><i class="ri-login-circle-line"></i><span> Logout</span></a></li>
			@endif
			
			@if (Session::has('user_details') && Session::get('user_details')->role=="Doctor")
				<li><a href="{{route('doctor.dashboard')}}"><i class="ri-dashboard-line"></i><span> Home</span></a></li>			
				<li><a href="{{route('timings.index')}}"><i class="ri-dashboard-line"></i><span> Timings</span></a></li>
				<li><a href="{{route('doctor.current.appointments')}}"><i class="ri-dashboard-line"></i><span> Current Appointments</span></a></li>
				<li><a href="{{route('doctor.patients')}}"><i class="ri-dashboard-line"></i><span> Patients</span></a></li>
				<li><a href="{{ route('login.logout') }}"><i class="ri-login-circle-line"></i><span> Logout</span></a></li>
			@endif
			
			@if (Session::has('user_details') && Session::get('user_details')->role=="Staff")
				<li><a href="{{route('staff.dashboard')}}"><i class="ri-dashboard-line"></i><span> Home</span></a></li>
				<li><a href="{{route('clinic.show')}}"><i class="ri-dashboard-line"></i><span> My Clinic</span></a></li>
				<li><a href="{{route('clinic.doctors')}}"><i class="ri-nurse-fill"></i><span> Doctors</span></a></li>
				<li><a href="{{ route('login.logout') }}"><i class="ri-login-circle-line"></i><span> Logout</span></a></li>
			@endif
		</ul>
	</div>
</div>

<!-- navbar end -->