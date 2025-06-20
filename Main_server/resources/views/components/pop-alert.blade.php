@if (is_countable($allPumpsPlanExpires12Months) && count($allPumpsPlanExpires12Months) > 0)
    <div id="overlay" class="overlay">
        <div class="message">
            <h1>Your plan has expired</h1>
            <p>Please renew your plan to continue using the service.</p>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span>Sign Out</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </div>
    </div>
@endif

{{-- Notification Card for 11 Months Expiry --}}
@if (is_countable($allPumpsPlanExpires11Months) && count($allPumpsPlanExpires11Months) > 0)
    <div class="col-lg-3 pop-card">
        <div class="card info-card customers-card bg-warning" id="plan-expiry-card-11">
            <div class="card-body">
                <h5 class="card-title">Plan Expires soon <span>| Borewell</span>
                    <img src="{{ asset('assets/img/logo2.png') }}" alt="Logo" class="log-pop">
                </h5>
                <button class="close-button" onclick="skipNotification()">
                    <span class="close">&times;</span>
                </button>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-droplet"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ count($allPumpsPlanExpires11Months) }}</h6>
                    </div>
                </div>
                <ul class="no-list-style">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                         style="margin-top:-48px">
                        <i class="bi bi-calendar-date"></i>
                    </div>
                    @foreach ($allPumpsPlanExpires11Months as $pump)
                        <li>
                            <strong style="margin-left: -300px;"> Borewell ID: {{ $pump->id }} </strong>
                            <div class="countdown-timer" data-plan_end_date="{{ $pump->plan_end_date }}"></div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<script>
    function skipNotification() {
        var notificationCard = document.getElementById('plan-expiry-card-11');
        if (notificationCard) {
            notificationCard.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var overlay = document.getElementById('overlay');
        if (overlay && @json(count($allPumpsPlanExpires12Months)) > 0) {
            overlay.style.display = 'flex';
            document.body.classList.add('blur');
        }

        var countdownElements = document.querySelectorAll('.countdown-timer');
        countdownElements.forEach(function(element) {
            var planEndDateStr = element.getAttribute('data-plan_end_date');
            var planEndDate = new Date(planEndDateStr);
            var twelveMonthsAfterEndDate = new Date(planEndDate);
            twelveMonthsAfterEndDate.setMonth(twelveMonthsAfterEndDate.getMonth());

            var now = new Date();
            var distance = twelveMonthsAfterEndDate.getTime() - now.getTime();
            var daysLeft = Math.ceil(distance / (1000 * 60 * 60 * 24));

            if (daysLeft >= 0) {
                element.innerHTML = "Left days <strong>" + daysLeft + "</strong>";
                element.style.fontSize = "20px";
                element.style.marginTop = "-30px";
            } else {
                element.innerHTML = "Plan already expired. Please renew your plan.";
            }
        });
    });
</script>
