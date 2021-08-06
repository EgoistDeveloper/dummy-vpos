@extends('dummy-vpos::layout.main-layout')

@section('content')
<!-- template from: https://tailwindcomponents.com/component/form-create -->

<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
    <div class="relative py-3 sm:max-w-xl sm:mx-auto">
        <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
            <div class="max-w-md mx-auto">
                <div class="flex items-center space-x-5">
                    <div class="h-14 w-14 bg-yellow-200 rounded-full flex flex-shrink-0 justify-center items-center text-yellow-500 text-2xl font-mono">
                        f
                    </div>

                    <div class="block pl-2 font-semibold text-xl self-start text-gray-700">
                        <h2 class="leading-relaxed">
                            Fake Bank123
                        </h2>

                        <p class="text-sm text-gray-500 font-normal leading-relaxed">
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col">
                    <label class="text-left mt-6">
                        <span class="font-semibold">
                            Total Price:
                        </span>
                        {{ request()->get('price') }}
                    </label>
                </div>

                <div class="flex flex-col">
                    <label class="text-left mt-6">
                        <span class="font-semibold">
                            Time Remaining:
                        </span>
                        <span id="timer-text">
                            00:00:{{ $countDown }}
                        </span>
                    </label>
                </div>

                <div class="divide-y divide-gray-200">
                    <div class="py-8 text-base">
                        <div class="flex flex-col">
                            <label class="leading-loose">
                                Enter Verification SMS/Code
                            </label>

                            <input type="text" id="password"
                                class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                placeholder="Hint: {{ config('dummy-vpos.password') }}"
                                minlength="{{ strlen(config('dummy-vpos.password')) }}"
                                maxlength="{{ strlen(config('dummy-vpos.password')) }}"
                                value="{{ config('dummy-vpos.password_autofill', true) ? config('dummy-vpos.password') : ''}}"
                                required>
                        </div>
                    </div>

                    <div class="pt-4 flex items-center space-x-4">
                        <button id="cancel-button"
                            class="bg-red-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none">
                            <i class="mdi mdi-keyboard-return mr-3"></i>
                            Cancel
                        </button>

                        <button id="confirm-button"
                            class="bg-blue-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none">
                            <i class="mdi mdi-check mr-3"></i>
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/easytimer@1.1.3/dist/easytimer.min.js"></script>

<script>
    (function () {
        // Example POST method implementation:
        async function postData(url = '', data = {}) {
            // Default options are marked with *
            const response = await fetch(url, {
                method: 'POST', // *GET, POST, PUT, DELETE, etc.
                mode: 'cors', // no-cors, *cors, same-origin
                cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                credentials: 'same-origin', // include, *same-origin, omit
                headers: {
                    'Content-Type': 'application/json'
                    // 'Content-Type': 'application/x-www-form-urlencoded',
                },
                redirect: 'follow', // manual, *follow, error
                referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
                body: JSON.stringify(data) // body data type must match "Content-Type" header
            });
            return response.json(); // parses JSON response into native JavaScript objects
        }

        const confirmPassword = function (e) {
            const password = document.getElementById('password').value;

            postData('', {
                password: password
            })
            .then(data => {
                document.location.href = data.callback
            });
        };

        const cancelPassword = function () {
            postData('', {
                password: 'canceled'
            })
            .then(data => {
                document.location.href = data.callback
            });
        };

        function startCountdown() {
            var timerInstance = new Timer(),
                timerText = document.getElementById('timer-text');

            timerInstance.start({
                countdown: true,
                startValues: {
                    seconds: {{ $countDown }}
                }
            });

            timerInstance.addEventListener("secondsUpdated", function (e) {
                timerText.innerHTML = timerInstance.getTimeValues().toString();
            });

            timerInstance.addEventListener('targetAchieved', function() {
                postData('', {
                    password: 'timeout'
                })
                .then(data => {
                    document.location.href = data.callback
                });
            });
        }

        // abort confirmation
        document.getElementById('cancel-button').addEventListener('click', cancelPassword);

        // validate confirmation code/password
        document.getElementById('confirm-button').addEventListener('click', confirmPassword);

        startCountdown();
    })();
</script>
@endsection
