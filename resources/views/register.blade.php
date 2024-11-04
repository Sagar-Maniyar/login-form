<!-- resources/views/register.blade.php -->
@include('includes.header')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Full height for the body and html */
        html,
        body {
            height: 100%;
        }

        .registration-container {
            height: 100%;
            display: flex;
            align-items: center;
            /* Center vertically */
            justify-content: center;
            /* Center horizontally */
        }

        .error {
            color: red;
            font-size: 0.875rem;
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

    <div class="registration-container">
        <div class="container col-md-4">
            <h2 class="text-center">Register</h2>
            <form id="registrationForm" class="mt-4">
                @csrf
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username">
                    <div id="usernameError" class="error"></div>
                </div>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name">
                    <div id="nameError" class="error"></div>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email">
                    <div id="emailError" class="error"></div>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <div id="passwordError" class="error"></div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password:</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    <div id="confirmPasswordError" class="error"></div>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('login.view') }}" class="btn btn-secondary mr-2">Back</a>

                    <button type="submit" class="btn btn-primary ">Register</button>
                </div>
                
                
            </form>

            <div id="responseMessage" class="mt-3"></div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#registrationForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Clear previous error messages
                $('.error').text('');

                // Validate form fields
                let isValid = true;

                const username = $('#username').val().trim();
                const name = $('#name').val().trim();
                const email = $('#email').val().trim();
                const password = $('#password').val().trim();
                const passwordConfirmation = $('#password_confirmation').val().trim();

                if (username.length < 3 || username.length > 255) {
                    $('#usernameError').text('Username must be between 3 and 255 characters.');
                    isValid = false;
                }

                if (name.length < 1) {
                    $('#nameError').text('Name is required.');
                    isValid = false;
                }

                const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
                if (!email.match(emailPattern)) {
                    $('#emailError').text('Please enter a valid email address.');
                    isValid = false;
                }

                if (password.length < 8) {
                    $('#passwordError').text('Password must be at least 8 characters long.');
                    isValid = false;
                }

                if (password !== passwordConfirmation) {
                    $('#confirmPasswordError').text('Passwords do not match.');
                    isValid = false;
                }

                // If the form is valid, proceed with AJAX submission
                if (isValid) {
                    $.ajax({
                        type: 'POST', // Ensure POST method
                        url: '/register',
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.success) {
                                $('#responseMessage').html(
                                    `<div class="alert alert-success">${response.message}</div>`
                                );
                                window.location.href = '/home'; // Redirect on success
                            } else {
                                $('#responseMessage').html(
                                    `<div class="alert alert-danger">${response.message}</div>`
                                );
                            }
                        },
                        error: function(xhr) {
                            // Handle server-side validation errors
                            var errors = xhr.responseJSON.errors;
                            var errorMessage =
                                '<div class="alert alert-danger"><strong>Registration failed:</strong><ul>';
                            for (var key in errors) {
                                errorMessage += `<li>${errors[key][0]}</li>`;
                            }
                            errorMessage += '</ul></div>';
                            $('#responseMessage').html(errorMessage);
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>
