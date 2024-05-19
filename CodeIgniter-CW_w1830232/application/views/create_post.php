<!DOCTYPE html>
<html>
<head>
    <title>Create a New Post</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pica/8.0.0/pica.min.js"></script>
    <style>
        body {
            background-image: url('../imgs/new1.jpg');  
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #fff;
        }
        .navbar-custom {
            background-color: #343a40; 
        }
        .navbar-custom .navbar-brand, 
        .navbar-custom .nav-link {
            color: #ffffff; 
        }
        .navbar-custom .nav-link:hover {
            color: #cccccc; 
        }
        .clock {
            color: #ffffff;
        }
        .post { 
            border: 1px solid #ccc; 
            margin-top: 10px; 
            padding: 10px; 
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .card-custom {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(255, 0, 0, 0.5);
            padding: 20px;
            max-width: 600px;
            margin: 50px auto;
        }
    </style>
</head>
<body>

    <!-- Include Navbar -->
    <?php include 'navbar.html'; ?>

    <div class="container">
        <h1 class="text-center mt-5">Create a New Post</h1>
        <div id="message" class="alert" style="display: none;"></div>
        <div class="card-custom">
            <form id="createPostForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="caption">Caption</label>
                    <input type="text" name="caption" id="caption" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Create Post</button>
            </form>
        </div>
    </div>

    <script>
$(document).ready(function() {
    $('#createPostForm').on('submit', function(e) {
        e.preventDefault();

        var fileInput = $('#image')[0];
        var file = fileInput.files[0];

        if (!file) {
            alert('Please select an image file.');
            return;
        }

        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(event) {
            var img = new Image();
            img.src = event.target.result;
            img.onload = function() {
                var canvas = document.createElement('canvas');
                var MAX_WIDTH = 800;
                var MAX_HEIGHT = 800;
                var width = img.width;
                var height = img.height;

                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height *= MAX_WIDTH / width;
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width *= MAX_HEIGHT / height;
                        height = MAX_HEIGHT;
                    }
                }
                canvas.width = width;
                canvas.height = height;
                var ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                pica().toBlob(canvas, 'image/jpeg', 0.8).then(function(blob) {
                    var formData = new FormData();
                    formData.append('image', blob, file.name);
                    formData.append('caption', $('#caption').val());
                    formData.append('description', $('#description').val());

                    $.ajax({
                        url: '<?= base_url('post/createPost') ?>',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status === false) {
                                $('#message').removeClass('alert-success').addClass('alert-danger').html(response.message).show();
                            } else {
                                $('#message').removeClass('alert-danger').addClass('alert-success').html('Post created successfully').show();
                                $('#createPostForm')[0].reset(); // Reset form fields
                                setTimeout(function() {
                                    window.location.href = '<?= base_url('post/dashboard') ?>';
                                }, 500);
                            }
                        },
                        error: function(xhr) {
                            var errorMessage = xhr.status + ': ' + xhr.statusText;
                            $('#message').removeClass('alert-success').addClass('alert-danger').html('Error - ' + errorMessage).show();
                        }
                    });
                }).catch(function(error) {
                    console.error('Error processing image:', error);
                });
            }
        }
    });
});

    </script>
</body>
</html>


<!-- http://localhost/w1830232_backend_CI/auth/login -->