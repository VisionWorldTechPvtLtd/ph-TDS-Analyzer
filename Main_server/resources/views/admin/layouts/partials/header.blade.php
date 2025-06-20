<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard.index') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/img/logo2.png') }}" alt="">
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <a href="javascript:void(0);" class="notification" id="notification-bell" style="margin-left: 850px; position: relative;">
        <i class="bi bi-bell" style="font-size:24px; color: black;"></i>
        <span id="notification-badge" style="
        position: absolute;
        top: -5px;
        right: -5px;
        background: red;
        color: white;
        font-size: 12px;
        font-weight: bold;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        display: none;
        align-items: center;
        justify-content: center;">!</span>
    </a>

    <!-- Notification Message Box -->
    <div id="notification-box" style="
    display: none;
    position: absolute;
    top: 35px;
    right: 0;
    background: white;
    border: 1px solid #ddd;
    padding: 10px;
    width: 250px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    z-index: 1000;">
        <div id="plan-end-message" style="display: none; padding: 5px; border-bottom: 1px solid #ddd;"></div>
        <div id="sim-end-message" style="display: none; padding: 5px; border-bottom: 1px solid #ddd;"></div>
        <div id="negative-flow-message" style="display: none; padding: 5px;"></div>
    </div>

    <script>
        function fetchNotificationCount() {
            fetch("{{ route('admin.notification.count') }}")
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById("notification-badge");
                    const planEndMessage = document.getElementById("plan-end-message");
                    const simEndMessage = document.getElementById("sim-end-message");
                    const negativeFlowMessage = document.getElementById("negative-flow-message");

                    let hasNotification = false;


                    if (data.hasExpiringPlan) {
                        planEndMessage.innerHTML = `Pumps' plans expiring soon <a href="http://visioncgwa.com/admin/planend" target="_blank">Click</a>`;
                        planEndMessage.style.display = "block";
                        hasNotification = true;
                    } else {
                        planEndMessage.style.display = "none";
                    }

                    if (data.hasExpiringSim) {
                        simEndMessage.innerHTML = `SIMs' plans expiring soon <a href="http://visioncgwa.com/admin/planend" target="_blank">Click</a>`;
                        simEndMessage.style.display = "block";
                        hasNotification = true;
                    } else {
                        simEndMessage.style.display = "none";
                    }

                    if (data.hasNegativeFlow) {
                        negativeFlowMessage.innerHTML = `Negative flow detected <a href="http://visioncgwa.com/admin/negative" target="_blank">Click</a>.`;
                        negativeFlowMessage.style.display = "block";
                        hasNotification = true;
                    } else {
                        negativeFlowMessage.style.display = "none";
                    }

                    if (hasNotification) {
                        badge.style.display = "flex";
                    } else {
                        badge.style.display = "none";
                    }
                })
                .catch(error => console.error("Error fetching notification count:", error));
        }

        setInterval(fetchNotificationCount, 10000);
        fetchNotificationCount();

        document.getElementById("notification-bell").addEventListener("click", function(event) {
            event.stopPropagation();
            const box = document.getElementById("notification-box");
            box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
        });

        document.addEventListener("click", function(event) {
            const box = document.getElementById("notification-box");
            const bell = document.getElementById("notification-bell");
            if (!box.contains(event.target) && !bell.contains(event.target)) {
                box.style.display = "none";
            }
        });

    </script>
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">



            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset(Auth::user()->profile_pic) }}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->first_name }} </span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="text-left dropdown-header">
                        <h6>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h6>
                        <p class="mb-0">Admin</p>
                        <p class="mb-0">{{ Auth::user()->email }}</p>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('account.index') }}">
                            <i class="bi bi-person"></i>
                            <span>Account</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
