<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css'>
        <style type="text/tailwindcss">

        </style>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">

            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">

                        @if (Route::has('login'))
                            <nav class="-mx-3 flex flex-1 justify-end">
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Log in
                                    </a>

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </header>

                    <main class="mt-6">
                        <div class="">
                            <div class="text-center place-content-center ">
                                <span id="rate_result" class=" text-4xl">&nbsp;</span>
                                <span id="difference_result" class="text-1xl">&nbsp;</span>
                            </div>
                            <section class="max-w-4xl p-6 mx-auto bg-indigo-600 rounded-md shadow-md dark:bg-gray-800 mt-20">
                                <h1 class="text-xl font-bold text-white capitalize dark:text-white">Currency data</h1>
                                <form id="exchangeForm">

                                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

                                        <div>
                                            <label class="text-white dark:text-gray-200">Currency</label>
                                            <div class="relative text-black" x-data="selectmenu(datalist())" @click.away="close()">
                                                <input type="text" x-model="selectedkey" name="currency" id="currency" class="hidden">
                                                <span class="inline-block w-full rounded-md shadow-sm mt-2"
                                                      @click="toggle(); $nextTick(() => $refs.filterinput.focus());">
                                        <div
                                            class="relative z-0 w-full py-2 pl-3 pr-10 text-left transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 ">
                                            <span class="block truncate" x-text="selectedlabel ?? 'Please Select'"></span>

                                            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                                    <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round"
                                                          stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                    </span>

                                                <div x-show="state" class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg p-2">
                                                    <input type="text" class="w-full rounded-md py-1 px-2 mb-1 border border-gray-400" x-model="filter" x-ref="filterinput">
                                                    <ul
                                                        class="py-1 overflow-auto text-base leading-6 rounded-md shadow-xs max-h-60 focus:outline-none">

                                                        <template x-for="(value, key) in getlist()" :key="key">

                                                            <li @click="select(value, key)" :class="{'bg-gray-100': isselected(key)}"
                                                                class="relative py-1 pl-3 mb-1 text-gray-900 select-none pr-9 hover:bg-gray-100 cursor-pointer rounded-md">
                                                                <span x-text="value" class="block font-normal truncate"></span>

                                                                <span x-show="isselected(key)"
                                                                      class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-700">
                                                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                  clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                            </li>
                                                        </template>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="text-white dark:text-gray-200" for="passwordConfirmation">Date</label>
                                            <input name="date" id="date" type="date" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                        </div>

                                        <div>
                                            <label class="text-white dark:text-gray-200" for="passwordConfirmation">Base Currency</label>
                                            <select id="basecurrency" name="basecurrency" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                                <option value="RUB" selected>RUB</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="flex justify-center mt-6">
                                        <button class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-500 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-gray-600">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">

                    </footer>
                </div>
            </div>
        </div>
    </body>
    <script>

        document.addEventListener("DOMContentLoaded", function() {
            // Get the form element
            var form = document.getElementById("exchangeForm");
            // Add event listener for form submit
            form.addEventListener("submit", function(event) {
                // Prevent the default form submission behavior
                event.preventDefault();

                // Get form data
                var formData = new FormData(form);

                // Iterate over form data
                for (var pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }

                // Alternatively, you can convert the form data to JSON
                var formDataJSON = {};
                formData.forEach(function(value, key) {
                    formDataJSON[key] = value;
                });

                console.log(formDataJSON);

                fetch('/get-rate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formDataJSON)
                })
                    .then(response => response.json())
                    .then( data => {
                            // Process the JSON data
                            console.log(data);
                            var rate = document.getElementById("rate_result");
                            rate.innerHTML = data.rate;

                            var difference = document.getElementById("difference_result");
                            var floatNumber = parseFloat(data.difference);

                            while (difference.classList.length > 0) {
                                difference.classList.remove(difference.classList.item(0));
                            }
                            difference.classList.add("text-1xl");
                            if (floatNumber > 0)  {
                                difference.classList.add("text-green-500");
                            } else if (floatNumber === 0) {
                                difference.classList.add("text-grey-500");
                            } else {
                                difference.classList.add("text-red-500");
                            }
                            difference.innerHTML = data.difference+"%";
                        }

                    )
                    .catch(error => console.error('Fetch error:', error));
            });
        });

        // CURRENCY INPUT
        function selectmenu(datalist){
            return {
                state: false,
                filter: '',
                list: datalist,
                selectedkey: 'USD',
                selectedlabel: 'USD',
                toggle: function() {
                    this.state = !this.state;
                    this.filter = '';
                },
                close: function(){
                    this.state = false;
                },
                select: function(value, key){
                    if(this.selectedkey == key){
                        this.selectedlabel = null;
                        this.selectedkey = null;
                    }else{
                        this.selectedlabel = value;
                        this.selectedkey = key;
                        this.state = false;
                    }
                },
                isselected: function(key){
                    return this.selectedkey == key;
                },
                getlist: function(){
                    if(this.filter == ''){
                        return this.list;
                    }
                    var filtered = Object.entries(this.list).filter(([key, value]) => value.toLowerCase().includes(this.filter.toLowerCase()));

                    var result = Object.fromEntries(filtered);
                    return result;
                }
            };
        }
        var currencies = @json($currency);
        //console.log(currencies);
        function datalist(){
            return currencies;
        }

        // BASECURRENCY INPUT
        // Function to update the select element
        function updateSelect(jsonData) {
            // Get the select element
            var selectElement = document.getElementById("basecurrency");

            // Clear existing options
            //selectElement.innerHTML = "";

            for (var key in jsonData) {
                if (jsonData.hasOwnProperty(key)) {
                    var optionElement = document.createElement("option");
                    if (key == 'RUB') {
                        optionElement.selected = true;
                    }
                    optionElement.value = key;
                    optionElement.text = key;
                    selectElement.appendChild(optionElement);
                }
            }
        }
        updateSelect(currencies);

        // DATE INPUT
        // Get the current date
        var currentDate = new Date();
        // Format the date as YYYY-MM-DD
        var formattedDate = currentDate.toISOString().split('T')[0];
        // Set the formatted date as the value of the input
        document.getElementById("date").value = formattedDate;

    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.9.1/cdn.js'></script>
</html>
