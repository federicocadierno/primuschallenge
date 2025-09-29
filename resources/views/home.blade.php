<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        <style>
            body main {
                margin: 0 auto;
                max-width: 1440px;
            }
            body main .hidden {
                display: none
            }
        </style>
            

    </head>
    <body>
        <main>
            <h1>Get Shipping Rates</h1>
            @php
                $display_login_form = '';
                $display_rates_form = 'hidden';
                if($cookieset == true) {
                    $display_login_form = 'hidden';
                    $display_rates_form = '';
                }
            @endphp
            <form method="POST" action="" id="loginForm" class=" <?php echo $display_login_form ?>">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div>
                    <label for="name">User Name:</label>
                    <input type="text" id="username" name="username" value="testDemo" required />
                </div>
                <div>
                    <label for="email">Password:</label>
                    <input type="password" id="password" name="password" value="1234" required />
                </div>
             
                </div>
                <button id="loginBtn" type="submit">Submit</button>
            </form>



            <form method="POST" action="" id="getRatesForm" class="<?php echo $display_rates_form ?>">
                <input type="hidden" name="_token_rates" value="{{ csrf_token() }}" />
                <input type="hidden" name="vendorid" value="1901539643" />
                <div>
                    <input type="text" id="originCity" name="originCity" value="KEY LARGO" required />
                </div>
                <div>
                    <input type="text" id="originState" name="originState" value="FL" required />
                </div>
                <div>
                    <input type="text" id="originZipcode" name="originZipcode" value="33037" required />
                </div>
                <div>
                    <input type="text" id="originCountry" name="originCountry" value="US" required />
                </div>
                <div>
                    <input type="text" id="destinationCity" name="destinationCity" value="LOS ANGELES" required />
                </div>
                <div>
                    <input type="text" id="destinationState" name="destinationState" value="CA" required />
                </div>
                <div>
                    <input type="text" id="destinationZipcode" name="destinationZipcode" value="90001" required />
                </div>
             
                <div>
                    <input type="text" id="destinationCountry" name="destinationCountry" value="US" required />
                </div>

                <div>
                    <input type="text" id="UOM" name="UOM" value="US" required />
                </div>

                    <?php $dataArray = ["qty" => 1,"weight"=>100,"weightType"=>"each","length"=>40,"width"=>40,"height"=>40,"class"=>100,"hazmat"=>0,"commodity"=>"","dimType"=>"PLT","stack"=>false] ?>
                    <input type="hidden" name="freightInfo" value="[{{ json_encode($dataArray) }}]">



                <button id="getRatesBtn" type="submit">Submit</button>
            </form>

            <div id="results">

            </div>
        </main>

        <script>
            window.addEventListener('load', function() {

                const login_btn = document.querySelector('#loginBtn');
                if(login_btn) {
                    login_btn.addEventListener('click', async function(e){
                        e.preventDefault();
                        const loginForm = document.getElementById('loginForm');
                        const formData = new FormData(loginForm);
                        const response = await fetch("/login-api", {
                            method: "POST",
                            headers: {
                                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
                                'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
                            },
                            body: JSON.stringify({
                                username: formData.get('username'),
                                password: formData.get('password')
                            })
                        });

                        if (response.status >= 200 && response.status <= 299) {
                            const jwt = await response.json()
                            document.querySelector('#loginForm').classList.add('hidden');
                            document.querySelector('#getRatesForm').classList.remove('hidden');
                            //setJwtCookie(jwt.data.accessToken, jwt.data.exp)
                        } else {
                        
                            console.log(response.status, response.statusText)
                        }


                    });
                }
                const getrates_btn = document.querySelector('#getRatesBtn');
                if(getrates_btn) {
                    getrates_btn.addEventListener("click", async function(e) {
                        e.preventDefault();
                        const getRatesForm = document.getElementById('getRatesForm');
                        const formData = new FormData(getRatesForm);
                        const response = await fetch("/get-rates", {
                            method: "POST",
                            headers: {
                                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
                                'X-CSRF-TOKEN': document.querySelector('[name="_token_rates"]').value
                            },
                            body: new URLSearchParams(formData).toString()
                        });

                        if (response.status >= 200 && response.status <= 299) {
                            const res = await response.json()
                            console.log("res", res);
                            document.querySelector('#results').innerHTML = res;
                            // display formatted array
                        } else {
                            console.log(response.status, response.statusText)
                        }
                    })
                }
            });
        </script>
        
    </body>
</html>