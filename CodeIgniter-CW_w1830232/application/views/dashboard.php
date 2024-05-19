<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JavaScript for functionality -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Load JavaScript dependencies for Backbone -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
    <style>
        body {
            background-image: url('../imgs/background.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #000000; 
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
            width: 50%;
            height: 100%;
        }

        .card {
            cursor: pointer;
            width: 100%;
            height: 100%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            background-color: #f8f9fa; 
        }
        .card-img-top {
            height: 200px; 
            width: 100%;
            object-fit: cover;
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

    <script>
    $(function() {
        var baseUrl = '<?= base_url() ?>';

        // Define a Backbone Model for each Post
        var Post = Backbone.Model.extend({});

        // Define a Collection of Posts
        var PostsCollection = Backbone.Collection.extend({
            model: Post,
            url: baseUrl + 'post/posts', // URL to fetch data from the backend
            parse: function(response) {
                return response; // Return the response directly
            }
        });

        // Define a Backbone View for a Post
        var PostView = Backbone.View.extend({
            tagName: 'div',
            className: 'post',
            template: _.template(
                '<div class="card h-100" data-id="<%= id %>">' + 
                    '<% if (typeof image !== "undefined" && image) { %>' +
                    '<img class="card-img-top" loading="lazy" src="data:image/jpeg;base64,<%= image %>" alt="<%= _.escape(caption || "Image") %>" style="height:200px; object-fit:cover;">' +
                    '<% } else { %>' +
                    '<img class="card-img-top" loading="lazy" src="' + baseUrl + 'assets/images/placeholder.jpg" alt="No Image" style="height:200px; object-fit:cover;">' +
                    '<% } %>' +
                    '<div class="card-body">' +
                        '<h5 class="card-title"><%= _.escape(caption || "No Caption") %></h5>' +
                        '<div class="reactions">' +
                            '<button class="btn btn-success btn-sm like-button">Like <span class="like-count"><%= likes %></span></button> ' +
                            '<button class="btn btn-danger btn-sm dislike-button">Dislike <span class="dislike-count"><%= dislikes %></span></button>' +
                        '</div>' +
                    '</div>' +
                '</div>'
            ),
            events: {
                'click .card': 'navigateToPost',
                'click .like-button': 'likePost',
                'click .dislike-button': 'dislikePost'
            },
            navigateToPost: function(event) {
                if (event.target.classList.contains('like-button') || event.target.classList.contains('dislike-button')) {
                    return;
                }
                var postId = this.model.get('id');
                window.location.href = baseUrl + 'comment/postComments/' + postId;
            },
            likePost: function(event) {
            event.stopPropagation();
            var postId = this.model.get('id');
            $.ajax({
                url: baseUrl + 'post/like/' + postId,
                type: 'POST',
                success: function(response) {
                    if (response.status) {
                        this.$('.like-count').text(response.counts.likes);
                        this.$('.dislike-count').text(response.counts.dislikes);
                    } else {
                        alert(response.message);
                    }
                }.bind(this),
                error: function(xhr) {
                                alert('Error: ' + xhr.responseText);
                            }
                        });
            },
            dislikePost: function(event) {
            event.stopPropagation();
            var postId = this.model.get('id');
            $.ajax({
                url: baseUrl + 'post/dislike/' + postId,
                type: 'POST',
                success: function(response) {
                    if (response.status) {
                        this.$('.like-count').text(response.counts.likes);
                        this.$('.dislike-count').text(response.counts.dislikes);
                    } else {
                        alert(response.message);
                    }
                }.bind(this),
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
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
