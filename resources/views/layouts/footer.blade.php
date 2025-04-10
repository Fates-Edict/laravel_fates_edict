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

@stack('script')
</body>
</html>