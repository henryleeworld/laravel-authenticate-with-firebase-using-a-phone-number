<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ config('app.name') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <body>
        <div class="container mt-3">
            <div class="alert alert-danger" id="error" style="display: none;"></div>
            <div class="card">
                <div class="card-header">
				    {{ trans('frontend.authenticate.content.enter.phone_number') }}
                </div>
                <div class="card-body">
                    <div class="alert alert-success" id="sentSuccess" style="display: none;"></div>
                    <form>
                        <label>{{ trans('frontend.authenticate.content.phone_number') }}</label>
                        <input type="text" id="number" class="form-control" placeholder="+886 *********" />
                        <div id="recaptcha-container" class="mt-1"></div>
                        <button type="button" class="btn btn-success mt-1" onclick="phoneSendAuth();">{{ trans('frontend.authenticate.content.send_code') }}</button>
                    </form>
                </div>
            </div>
            <div class="card" style="margin-top: 10px;">
                <div class="card-header">
                    {{ trans('frontend.authenticate.content.enter.verification_code') }}
                </div>
                <div class="card-body">
                    <div class="alert alert-success" id="successRegsiter" style="display: none;"></div>
                    <form>
                        <input type="text" id="verificationCode" class="form-control" placeholder="{{ trans('frontend.authenticate.content.enter.verification_code') }}" />
                        <button type="button" class="btn btn-success mt-1" onclick="codeverify();">{{ trans('frontend.authenticate.content.verify_code') }}</button>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
        <script>
            var firebaseConfig = {
                apiKey: "{{ env('FIREBASE_API_KEY') }}",
                authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
                databaseURL: "{{ env('FIREBASE_DATABASE_URL') }}",
                projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
                storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
                messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
                appId: "{{ env('FIREBASE_APP_ID') }}",
                measurementId: "{{ env('FIREBASE_MEASUREMENT_ID') }}",
            };

            firebase.initializeApp(firebaseConfig);
        </script>

        <script type="text/javascript">
            window.onload = function () {
                render();
            };

            function render() {
                window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier("recaptcha-container");
                recaptchaVerifier.render();
            }

            function phoneSendAuth() {
                var number = $("#number").val();

                firebase
                    .auth()
                    .signInWithPhoneNumber(number, window.recaptchaVerifier)
                    .then(function (confirmationResult) {
                        window.confirmationResult = confirmationResult;
                        coderesult = confirmationResult;
                        console.log(coderesult);

                        $("#sentSuccess").text("{{ trans('frontend.authenticate.content.message.sent_successfully') }}");
                        $("#sentSuccess").show();
                    })
                    .catch(function (error) {
                        $("#error").text(error.message);
                        $("#error").show();
                    });
            }

            function codeverify() {
                var code = $("#verificationCode").val();

                coderesult
                    .confirm(code)
                    .then(function (result) {
                        var user = result.user;
                        console.log(user);

                        $("#successRegsiter").text("{{ trans('frontend.authenticate.content.message.you_are_register_successfully') }}");
                        $("#successRegsiter").show();
                    })
                    .catch(function (error) {
                        $("#error").text(error.message);
                        $("#error").show();
                    });
            }
        </script>
    </body>
</html>