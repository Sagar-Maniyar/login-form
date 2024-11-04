@include('includes.header')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->

    <style>
        /* Full height for the body and html */
        html,
        body {
            height: 100%;
        }

        .login-container {
            height: 100%;
            display: flex;
            align-items: center;
            /* Center vertically */
            justify-content: center;
            /* Center horizontally */
        }
    </style>
</head>

<body>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="login-container ">
        <div class="container col-md-4">
            <h2 class="text-center">Login</h2>
            <form id="loginForm" class="mt-4">
                @csrf
                <div class="form-group">
                    <label for="identifier">Username or Email:</label>
                    <input type="text" class="form-control" id="identifier" name="identifier" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>

            <div id="responseMessage" class="mt-3"></div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                $.ajax({
                    type: 'POST', // Ensure POST method
                    url: '/login',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#responseMessage').html(
                            `<div class="alert alert-success">${response.message}</div>`);
                        if (response.success) {
                            window.location.href = '/home'; // Redirect on success
                        }
                    },
                    error: function(xhr) {
                        // Handle errors
                        var errors = xhr.responseJSON.errors;
                        var errorMessage =
                            '<div class="alert alert-danger"><strong>Login failed:</strong><ul>';
                        for (var key in errors) {
                            errorMessage += `<li>${errors[key][0]}</li>`;
                        }
                        errorMessage += '</ul></div>';
                        $('#responseMessage').html(errorMessage);
                    }
                });
            });
        });
    </script>

</body>

</html>
