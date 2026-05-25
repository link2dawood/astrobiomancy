@php
    $user_data = Auth::user();
@endphp
<aside class="sidebar fixed" style="width: 260px; left: 0px; ">
    <div class="brand-logo" style="background: #e7e7e7;
    margin: 10px;">
            <div id="">
              Astrobiomancy
            </div> 
             </div>
    <div class="user-logged-in">
        <div class="content">
            <div class="user-name">{{$user_data->name}} <span class="text-muted f9">{{$user_data->name}}</span></div>
            <div class="user-email">{{$user_data->email}}</div>
            <div class="user-actions"> <a class="m-r-5" href="#"></a> <a href="{{url('logout')}}">logout</a> </div>
        </div>
    </div>
    <ul class="menu-links">
       
        <li icon="md md-blur-on"> <a href="{{url('dashboard')}}"><i class="md md-blur-on"></i>&nbsp;<span>Dashboard</span></a></li>
        
        <li icon="md md-blur-on"> <a href="{{url('dashboard/orders')}}"><i class="md md-blur-on"></i>&nbsp;<span>Orders</span></a></li>

        <li icon="md md-blur-on"> <a href="{{url('dashboard/orders?status=completed')}}"><i class="md md-blur-on"></i>&nbsp;<span>Completed Orders</span></a></li>

        <li > <a href="#" data-toggle="collapse" data-target="#users" aria-expanded="false" aria-controls="Jobs" class="collapsible-header waves-effect">
		 <i class="md md-work "></i>&nbsp;Users
		
		 </a>
            <ul id="users" class="collapse">
                <li> <a href="{{url('dashboard/admin/users')}}" ><span>Admin Users </span></a></li>
                <li> <a href="{{url('dashboard/users')}}" ><span>Users </span></a></li>
                
            </ul>
        </li>
        <li > <a href="#" data-toggle="collapse" data-target="#blogs" aria-expanded="false" aria-controls="Jobs" class="collapsible-header waves-effect">
         <i class="md md-work "></i>&nbsp;Blog
        
         </a>
            <ul id="blogs" class="collapse">
                <li> <a href="{{url('dashboard/blog/post')}}" ><span>Posts </span></a></li>
                <li> <a href="{{url('dashboard/category')}}" ><span>Category </span></a></li>
                
            </ul>
        </li>
        <li > <a href="#" data-toggle="collapse" data-target="#pages" aria-expanded="false" aria-controls="pages" class="collapsible-header waves-effect">
         <i class="md md-pages "></i>&nbsp;Pages
         </a>
            <ul id="pages" class="collapse">
                <li> <a href="{{url('dashboard/pages/home')}}" ><span>Home</span></a></li>
                <li> <a href="{{url('dashboard/pages/about')}}" ><span>About Us </span></a></li>
                <li> <a href="{{url('dashboard/pages/about-the-book')}}" ><span>About The Book</span></a></li>
                <li> <a href="{{url('dashboard/pages/disclaimer')}}" ><span>Disclaimer</span></a></li>
                <li> <a href="{{url('dashboard/pages/privacypolicy')}}" ><span>Privacy Policy</span></a></li>
                <li> <a href="{{url('dashboard/services/dietary-health-advice')}}" ><span> Dietary / Health advice</span></a></li>
                <li> <a href="{{url('dashboard/services/energy-work-blockage-removal')}}" ><span>Energy work / Removal</span></a></li>
                <li> <a href="{{url('dashboard/services/biomantic-astrobiomantic-readings')}}" ><span>Biomantic / Astrobiomantic readings</span></a></li>
                <li> <a href="{{url('dashboard/services/geomantic-astrogeomantic-readings')}}" ><span>Geomantic / Astrogeomantic readings</span></a></li>

                <li> <a href="{{url('dashboard/pages/terms-conditions')}}" ><span>Terms & Conditions</span></a></li>
                <li> <a href="{{url('dashboard/pages/cookie-policy')}}" ><span>Cookie Policy</span></a></li>

            </ul>
        </li>
        <li icon="md md-blur-on"> <a href="{{url('dashboard/testimonials')}}"><i class="md md-format-quote"></i>&nbsp;<span>Testimonials</span></a></li>

        <li icon="md md-blur-on"> <a href="{{url('dashboard/menus')}}"><i class="md md-list"></i>&nbsp;<span>Menus</span></a></li>

        <li icon="md md-blur-on"> <a href="{{url('dashboard/settings')}}"><i class="md md-settings"></i>&nbsp;<span>Settings</span></a></li>

        <li icon="md md-blur-on"> <a href="{{url('dashboard/media')}}"><i class="md md-settings"></i>&nbsp;<span>Media</span></a></li>
    </ul>
</aside>