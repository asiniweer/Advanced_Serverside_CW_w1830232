<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
/* Universal box model */
* {
  box-sizing: border-box;
}

/* Body styles */
body {
  background-image: url('https://getwallpapers.com/wallpaper/full/6/6/f/1231493-full-size-cartoon-wallpaper-for-desktop-1920x1200-for-android-tablet.jpg');
  background-size: cover; /* Ensures the image covers the entire background */
  background-repeat: no-repeat;
  background-position: center;
  color: black;
  height: 100%;
  
}


/* Form container */
/* .container {
  border-radius: 10px;
  background-color: rgba(0, 0, 0, 0.1);
  padding: 100px;
  margin: 90px auto;
  max-width: 400px; */
  /* backdrop-filter: blur(10px); */
/* } */

.container {
  border-radius: 10px;
  /* background-color: #277d7c; */
  padding: 50px;
  margin: 90px auto;
  max-width: 500px;
  box-shadow: 0px 0px 20px 0px Red; /*Dark blue box shadow*/
  backdrop-filter: blur(100px);

}
/* Heading styles */
h1 {
  text-align: center;
  font-weight: bold;
  font-size: 40px;
}

/* Grid column styles */
.col-25, .col-75 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  width: 75%;
}

/* Input field styles */
input[type=text], input[type=password] {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
  background-color: #f2f2f2;
  color: black;
}

/* Submit button styles */
input[type=submit] {
  background-color: black;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

input[type=submit]:hover {
  background-color: #333;
}

/* Error styling for input fields */
input.error, select.error, textarea.error {
  border-color: red;
}

/* Label styles */
label {
  padding: 8px 8px 8px 0;
  display: inline-block;
  font-weight: bold;
}

/* Responsive layout */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
</style>
</head>
<body>

<div class="container">
  <h1>Register</h1>
  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
  <?php endif; ?>
  <form id="registerForm">
    <div class="row">
      <div class="col-25">
        <label for="userName">User Name</label>
      </div>
      <div class="col-75">
        <input type="text" id="userName" name="user_name" placeholder=" User Name.." class="input-field">
        <div class="error-message" id="userNameError"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="email">Email</label>
      </div>
      <div class="col-75">
        <input type="email" id="email" name="email" placeholder=" Email" class="input-field">
        <div class="error-message" id="emailError"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="password">Password</label>
      </div>
      <div class="col-75">
        <input type="password" id="password" name="password" placeholder=" Password" class="input-field">
        <div class="error-message" id="passwordError"></div>
      </div>
    </div>
    <div class="row">
      <input type="submit" value="Submit">
    </div>
  </form>
  <div class="message"></div>
  <div>
    <p style="font-size: 16px; font-weight: bold; color: #000;"> Already have an account? Click  <a href="<?=base_url('auth/login')?>">here</a></p>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#registerForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?=base_url('auth/register')?>',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.status == 'success') {
                    $('.message').html('<span style="color:green">' + response.message + '</span>');
                } else {
                    $('.message').html('<span style="color:red">' + response.message + '</span>');
                }
            }
        });
    });
});
</script>

</body>

</html>





<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
/* Universal box model */
* {
  box-sizing: border-box;
}

/* Body styles */
body {
  background-image: url('https://getwallpapers.com/wallpaper/full/6/6/f/1231493-full-size-cartoon-wallpaper-for-desktop-1920x1200-for-android-tablet.jpg');
  background-size: cover; /* Ensures the image covers the entire background */
  background-repeat: no-repeat;
  background-position: center;
  color: black;
  height: 100%;
  
}


/* Form container */
/* .container {
  border-radius: 10px;
  background-color: rgba(0, 0, 0, 0.1);
  padding: 100px;
  margin: 90px auto;
  max-width: 400px; */
  /* backdrop-filter: blur(10px); */
/* } */

.container {
  border-radius: 10px;
  /* background-color: #277d7c; */
  padding: 50px;
  margin: 90px auto;
  max-width: 500px;
  box-shadow: 0px 0px 20px 0px Red; /*Dark blue box shadow*/
  backdrop-filter: blur(100px);

}
/* Heading styles */
h1 {
  text-align: center;
  font-weight: bold;
  font-size: 40px;
}

/* Grid column styles */
.col-25, .col-75 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  width: 75%;
}

/* Input field styles */
input[type=text], input[type=password] {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
  background-color: #f2f2f2;
  color: black;
}

/* Submit button styles */
input[type=submit] {
  background-color: black;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

input[type=submit]:hover {
  background-color: #333;
}

/* Error styling for input fields */
input.error, select.error, textarea.error {
  border-color: red;
}

/* Label styles */
label {
  padding: 8px 8px 8px 0;
  display: inline-block;
  font-weight: bold;
}

/* Responsive layout */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
</style>
</head>
<body>

<div class="container">
  <h1>Register</h1>
  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
  <?php endif; ?>
  <form id="registerForm">
    <div class="row">
      <div class="col-25">
        <label for="userName">User Name</label>
      </div>
      <div class="col-75">
        <input type="text" id="userName" name="user_name" placeholder=" User Name.." class="input-field">
        <div class="error-message" id="userNameError"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="email">Email</label>
      </div>
      <div class="col-75">
        <input type="email" id="email" name="email" placeholder=" Email" class="input-field">
        <div class="error-message" id="emailError"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="password">Password</label>
      </div>
      <div class="col-75">
        <input type="password" id="password" name="password" placeholder=" Password" class="input-field">
        <div class="error-message" id="passwordError"></div>
      </div>
    </div>
    <div class="row">
      <input type="submit" value="Submit">
    </div>
  </form>
  <div class="message"></div>
  <div>
    <p style="font-size: 16px; font-weight: bold; color: #000;"> Already have an account? Click  <a href="<?=base_url('auth/login')?>">here</a></p>
  </div>
</div>


</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#registerForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?=base_url('auth/register')?>',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.status == 'success') {
                    $('.message').html('<span style="color:green">' + response.message + '</span>');
                } else {
                    $('.message').html('<span style="color:red">' + response.message + '</span>');
                }
            }
        });
    });
});
</script>

</body>

</html>






$(document).ready(function() {
    $('#signupForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.status == 'success') {
                    $('.message').html('<span style="color:green">' + response.message + '</span>');
                } else {
                    $('.message').html('<span style="color:red">' + response.message + '</span>');
                }
            }
        });
    });
});




<h1>LOGIN</h1>
<?php if ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
<?php endif; ?>
<form method="post" action="<?=base_url('auth/login')?>">
  <!-- Username input field -->
  <div class="row">
    <div class="col-25">
      <label for="username">User name</label>
    </div>
    <div class="col-75">
      <input type="text" id="username" name="username" placeholder="Enter  Username" class="<?= form_error('username') ? 'error' : '' ?>">
      <?php if(form_error('username')) echo '<div style="color:red">'.form_error('username').'</div>'; ?>
    </div>
  </div>
  <!-- Password input field -->
  <div class="row">
    <div class="col-25">
      <label for="password">Password</label>
    </div>
    <div class="col-75">
      <input type="password" id="password" name="password" placeholder="Your Password" class="<?= form_error('password') ? 'error' : '' ?>">
      <?php if(form_error('password')) echo '<div style="color:red">'.form_error('password').'</div>'; ?>
    </div>
  </div>

  <!-- Submit button -->
  <div class="row">
    <input type="submit" value="Submit">
  </div>
</form>
<!-- Link to signup page -->
<div>
  <p style="font-size: 16px; font-weight: bold; color: #000; text-stroke: 3px #fff;">
      Don't have an account? Click <a href="<?=base_url('user/signup')?>">here</a>
  </p>
</div>












// Method to load login form
public function login() {
    if ($this->session->has_userdata('id')) {
        redirect('user/welcome_page');
    }
    $this->load->view('login_form');
}

// Method to authenticate user login
public function login_user() {
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() == FALSE) {
        $this->load->view('login_form');
    } else {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if ($user = $this->user_model->getUserByUsername($username)) {
            if (password_verify($password, $user->password)) { // Verify hashed password
                $newdata = array(
                    'username' => $user->username, // Changed to username
                    'id' => $user->user_id
                );
                $this->session->set_userdata($newdata);
                redirect('user/welcome_page');
            } else {
                $this->session->set_flashdata('error', 'Invalid password');
                redirect('user/login');
            }
        } else {
            $this->session->set_flashdata('error', 'No account exists with this username');
            redirect('user/login');
        }
    }
}






    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('form_validation');
    }

    // Method to load login form
    public function login_get() {
        if ($this->session->has_userdata('id')) {
            $this->response(['message' => 'User already logged in'], REST_Controller::HTTP_BAD_REQUEST);
        }
        $this->load->view('login_form');
    }

    // Method to authenticate user login
    public function login_post() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->response(['message' => validation_errors()], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $username = $this->post('username');
            $password = $this->post('password');
            if ($user = $this->user_model->getUserByUsername($username)) {
                if (password_verify($password, $user->password)) { // Verify hashed password
                    $newdata = array(
                        'username' => $user->username, // Changed to username
                        'id' => $user->user_id
                    );
                    $this->session->set_userdata($newdata);
                    $this->response(['message' => 'Login successful', 'user_id' => $user->user_id], REST_Controller::HTTP_OK);
                } else {
                    $this->response(['message' => 'Invalid password'], REST_Controller::HTTP_UNAUTHORIZED);
                }
            } else {
                $this->response(['message' => 'No account exists with this username'], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }
}

http://localhost/w1830232_backend_CI/auth/register


http://localhost/w1830232_backend_CI/index.php/auth/register


http://localhost/w1830232_backend_CI/index.php/auth/submit_signup 404 (Not Found)

http://localhost/w1830232_backend_CI/auth/submit_register 404 (Not Found)

http://localhost/w1830232_backend_CI/auth/submitRegister 500 (Internal Server Error)





A Database Error Occurred
Error Number: 1054

Unknown column 'user_name' in 'field list'



INSERT INTO `user` (`user_name`, `email`, `password`) VALUES ('john_doe', 'weerakoonau@gmail.com', '$2y$10$sFaJM02X7PkRN8BlsN1UHufWdvuFi/6yZ1ke1hvNkf91WiUXpV5oe')

Filename: C:/xampp/htdocs/w1830232_backend_CI/system/database/DB_driver.php

Line Number: 692



ALTER TABLE `user` CHANGE `username` `user_name` VARCHAR(255) NOT NULL;
ALTER TABLE `user` ADD `user_name` VARCHAR(255) NOT NULL;


<!-- Lazy load images using loading="lazy" attribute -->
<img class="card-img-top" loading="lazy" src="<?= base_url('upload_images/' . $post['image_path']) ?>" alt="<?= htmlspecialchars($post['caption'] ?? 'Image') ?>" style="height:200px; object-fit:cover;">
























<!DOCTYPE html>
<html>
<head>
    <title>Manage Comments</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://underscorejs.org/underscore-min.js"></script>
    <script src="https://backbonejs.org/backbone-min.js"></script>

    <style>
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
        .comment {
            border: 1px solid #ccc;
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Manage Comments</h1>
        <div id="message" class="alert" style="display: none;"></div>
        <form id="addCommentForm">
            <div class="form-group">
                <label for="post_id">Post ID</label>
                <input type="text" name="post_id" id="post_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="user_id">User ID</label>
                <input type="text" name="user_id" id="user_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Comment</button>
        </form>
        
        <hr>
        
        <div id="commentsContainer"></div>
    </div>

    <script>
        // Define Comment model
        var Comment = Backbone.Model.extend({
            urlRoot: '<?= base_url('index.php/comments') ?>',
            defaults: {
                post_id: '',
                user_id: '',
                content: ''
            }
        });

        // Define Comments collection
        var Comments = Backbone.Collection.extend({
            model: Comment,
            url: '<?= base_url('index.php/comments') ?>'
        });

        // Define Comment View
        var CommentView = Backbone.View.extend({
            tagName: 'div',
            className: 'comment',
            template: _.template($('#commentTemplate').html()),

            events: {
                'click .edit': 'editComment',
                'click .delete': 'deleteComment',
                'click .update': 'updateComment',
                'click .cancel': 'cancelEdit'
            },

            editComment: function() {
                this.$('.edit').hide();
                this.$('.delete').hide();
                this.$('.content').hide();
                this.$('.edit-form').show();
            },

            updateComment: function() {
                var newContent = this.$('.edit-content').val();
                this.model.save({ content: newContent }, {
                    success: function(model, response) {
                        $('#message').removeClass('alert-danger').addClass('alert-success').html('Comment updated successfully').show();
                    },
                    error: function(model, response) {
                        $('#message').removeClass('alert-success').addClass('alert-danger').html('Error updating comment').show();
                    }
                });
            },

            deleteComment: function() {
                this.model.destroy({
                    success: function(model, response) {
                        $('#message').removeClass('alert-danger').addClass('alert-success').html('Comment deleted successfully').show();
                        this.remove();
                    }.bind(this),
                    error: function(model, response) {
                        $('#message').removeClass('alert-success').addClass('alert-danger').html('Error deleting comment').show();
                    }
                });
            },

            cancelEdit: function() {
                this.render();
            },

            render: function() {
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            }
        });

        // Define Comments View
        var CommentsView = Backbone.View.extend({
            el: '#commentsContainer',

            initialize: function() {
                this.collection = new Comments();
                this.collection.fetch({ reset: true });
                this.listenTo(this.collection, 'reset', this.render);
                this.listenTo(this.collection, 'add', this.renderComment);
                this.listenTo(this.collection, 'remove', this.render);
            },

            render: function() {
                this.$el.empty();
                this.collection.each(function(comment) {
                    this.renderComment(comment);
                }, this);
                return this;
            },

            renderComment: function(comment) {
                var commentView = new CommentView({ model: comment });
                this.$el.append(commentView.render().el);
            }
        });

        // Add Comment Form View
        var AddCommentFormView = Backbone.View.extend({
            el: '#addCommentForm',
            events: {
                'submit': 'submitForm'
            },

            submitForm: function(e) {
                e.preventDefault();

                var newComment = new Comment({
                    post_id: $('#post_id').val(),
                    user_id: $('#user_id').val(),
                    content: $('#content').val()
                });

                var comments = new Comments();
                comments.create(newComment, {
                    success: function(model, response) {
                        $('#message').removeClass('alert-danger').addClass('alert-success').html('Comment added successfully').show();
                        $('#addCommentForm')[0].reset();
                    },
                    error: function(model, response) {
                        $('#message').removeClass('alert-success').addClass('alert-danger').html('Error adding comment').show();
                    }
                });
            }
        });

        // Initialize the views
        var commentsView = new CommentsView();
        var addCommentFormView = new AddCommentFormView();
    </script>

    <!-- Comment Template -->
    <script type="text/template" id="commentTemplate">
        <p class="content"><%= content %></p>
        <button class="btn btn-warning edit">Edit</button>
        <button class="btn btn-danger delete">Delete</button>
        <div class="edit-form" style="display:none;">
            <textarea class="form-control edit-content"><%= content %></textarea>
            <button class="btn btn-primary update">Update</button>
            <button class="btn btn-secondary cancel">Cancel</button>
        </div>
    </script>
</body>
</html>





// Fetch comments for a specific post
    public function index_get($post_id = NULL) {
        if ($post_id === NULL) {
            show_error('No post ID provided', 400);
            return;
        }

        $comments = $this->Comment_model->get_comments_by_post($post_id);
        if ($comments) {
            $data['comments'] = $comments;
            $this->load->view('comments', $data); // Load the comments view with the fetched comments
        } else {
            $data['comments'] = [];
            $data['message'] = 'No comments found';
            $this->load->view('comments', $data); // Load the comments view with an empty comments array and a message
        }
    }




    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #343a40; /* Dark background color */
        }
        .navbar-custom .navbar-brand, 
        .navbar-custom .nav-link {
            color: #ffffff; /* White text color */
        }
        .navbar-custom .nav-link:hover {
            color: #cccccc; /* Lighter color on hover */
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
        .card {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'navbar.html'; ?>

    <!-- Main content -->
    <div class="container mt-5">
        <h1 class="mb-4">Dashboard</h1>
        <div id="postsContainer" class="row">
            <!-- Posts will be dynamically injected here by Backbone.js -->
        </div>
    </div>

    <!-- Bootstrap JavaScript for functionality -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Load JavaScript dependencies for Backbone -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
    <script>
        $(function() {
            var baseUrl = '<?= base_url() ?>';

            // Define a Backbone Model for each Post
            var Post = Backbone.Model.extend({});

            // Define a Collection of Posts
            var PostsCollection = Backbone.Collection.extend({
                model: Post,
                url: baseUrl + 'index.php/post/posts_get', // URL to fetch data from the backend
                parse: function(response) {
                    return response; // Return the response directly
                }
            });

            // Define a Backbone View for a Post
            var PostView = Backbone.View.extend({
                tagName: 'div',
                className: 'post col-md-4',
                template: _.template(
                    '<div class="card h-100" data-id="<%= id %>">' + 
                        '<% if (typeof image !== "undefined" && image) { %>' +
                        '<img class="card-img-top" loading="lazy" src="data:image/jpeg;base64,<%= image %>" alt="<%= _.escape(caption || "Image") %>" style="height:200px; object-fit:cover;">' +
                        '<% } else { %>' +
                        '<img class="card-img-top" loading="lazy" src="' + baseUrl + 'assets/images/placeholder.jpg" alt="No Image" style="height:200px; object-fit:cover;">' +
                        '<% } %>' +
                        '<div class="card-body">' +
                            '<h5 class="card-title"><%= _.escape(caption || "No Caption") %></h5>' +
                            '<p class="card-text"><%= _.escape(description || "No Description") %></p>' +
                        '</div>' +
                    '</div>'
                ),
                events: {
                    'click .card': 'navigateToPost'
                },
                navigateToPost: function() {
                    var postId = this.model.get('id');
                    window.location.href = baseUrl + 'index.php/comment/post_comments_get/' + postId;
                },
                render: function() {
                    this.$el.html(this.template(this.model.attributes));
                    return this;
                }
            });

            // Define a Backbone View for the Collection of Posts
            var PostsView = Backbone.View.extend({
                el: '#postsContainer',
                initialize: function() {
                    this.listenTo(this.collection, 'sync', this.render); // Listen to the sync event to render the view
                    this.collection.fetch().fail(function() {
                        alert("Error fetching data."); // Alert or handle fetch errors
                    });
                },
                render: function() {
                    this.$el.empty(); // Clear the container before re-rendering
                    this.collection.each(this.addPost, this);
                    return this;
                },
                addPost: function(post) {
                    var postView = new PostView({model: post});
                    this.$el.append(postView.render().el); // Append the rendered post to the container
                }
            });

            // Instantiate the collection and the view
            var posts = new PostsCollection();
            var postsView = new PostsView({collection: posts});
        });
    </script>
</body>
</html>




