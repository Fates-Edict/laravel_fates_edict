<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Teramedik Screening</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
</head>
<body>
    Dashboard
    <button id="logout">Logout</button>
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
                        window.location = '/login'
                    }
                }
            })
        }
        if(token) getMe()
        else window.location = '/login'

        $('#logout').click(() => {
            $.ajax({
                url: '/api/logout',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                statusCode: {
                    200: (res) => {
                        if(res) {
                            localStorage.removeItem('token')
                            window.location = '/login'
                        }
                    }
                }
            })
        })
    })
</script>
</body>
</html>