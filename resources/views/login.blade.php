<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication - Teramedik Screening</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
</head>
<body>
    
<div class="container pt-5">
    <div class="row mt-5 justify-content-center">
        <div class="card col-12 col-md-5 col-lg-4 py-4">
            <div class="card-body">
                <h3 class="text-center">Screening Teramedik</h3>
                <p class="text-center">Authentication</p>

                <form autocomplete="off" id="formLogin">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input name="username" type="text" class="form-control" id="username" autofocus>
                        <div class="invalid-feedback" id="invalidUsername"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" id="password">
                        <div class="invalid-feedback" id="invalidPassword"></div>
                    </div>
                    <div class="d-grid gap-2 col-12 mx-auto mb-3">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                    <div class="text-center">
                        <p>Programmed by <a href="https://www.linkedin.com/in/mutaqin-yusuf/" target="_blank">Mutaqin Yusuf</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(() => {
        const token = localStorage.getItem('token')

        function getMe() {
            $.ajax({
                url: '/api/me',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                statusCode: {
                    401: (res) => {
                        alert(res.responseJSON.message)
                        localStorage.removeItem('token')
                    },
                    200: (res) => {
                        window.location = '/'
                    }
                }
            })
        }

        if(token) getMe()

        $('#formLogin').submit((e) => {
            e.preventDefault()

            $.ajax({
                url: '/api/authenticate',
                method: 'POST',
                data: $('#formLogin').serialize(),
                dataType: 'JSON',
                statusCode: {
                    400: (res) => {
                        const response = res.responseJSON
                        const errors = response.errors

                        if(errors.username) {
                            $('#username').addClass('is-invalid') 
                            $('#invalidUsername').text(errors.username[0])
                        } else {
                            $('#username').removeClass('is-invalid')
                            $('#invalidUsername').text('')
                        }

                        if(errors.password) {
                            $('#password').addClass('is-invalid') 
                            $('#invalidPassword').text(errors.password[0])
                        } else {
                            $('#password').removeClass('is-invalid')
                            $('#invalidPassword').text('')
                        }
                    },
                    201: (res) => {
                        if(res.data) {
                            localStorage.setItem('token', res.data)
                            window.location = '/'
                        }
                    }
                }
            })
        })
    })
</script>
</body>
</html>