<!DOCTYPE html>
<html>
<head>
    <title>Manage Posts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        body {
            background-image: url('http://localhost/w1830232_backend_CI/imgs/new2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #000000;
        }

        .comment {
            border: 1px solid #ccc;
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.5); 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            color: #000000; 
        }
        .card {
            cursor: pointer;
            border: 2px solid #ccc; 
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 50px rgba(255, 0, 0, 0.5); 
            transition: transform 0.2s, box-shadow 0.2s; /* Smooth transition for hover effect */
        }
        .card:hover {
            transform: scale(1.05); 
            box-shadow: 0 0 30px rgba(255, 0, 0, 0.7);  
        }
        .large-text {
            font-size: 1.25rem; 
            color: #000000; 
        }
        .post-view {
            display: flex;
            align-items: flex-start;
            gap: 1cm; 
        }
        .post-image {
            flex: 3;
            margin-right: 20px;
            border: 5px solid #9c0b69; 
        }
        .post-details {
            flex: 2;
        }
        .caption-container {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc; 
            border-radius: 10px;
            background-color: rgba(232, 16, 121, 0.2); /* 0.2->transparent  */
            color: #000000;  
            margin-bottom: 30px;
        }

        .desc-container {
            margin-top: 20px;
            padding: 15px;
            border: 2px solid #e81079; 
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.4); 
            color: #000000; 
            margin-bottom: 30px;
            
        }
        .comments-section {
            margin-top: 40px;
            border: 1px solid #ccc; 
            padding: 15px;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.2); 
        }
        .chat-box {
            max-width: 600px;
            margin: auto;
        }
        .chat-box ul {
            padding: 0;
            list-style: none;
        }
        .chat-box li {
            margin-bottom: 10px;
        }
        .chat-box .comment {
            padding: 15px;
            border-radius: 15px;
            background-color: rgba(255, 255, 255, 0.6);  
        }
        .chat-box .comment strong {
            display: block;
            margin-bottom: 5px;
        }
        .chat-box .comment small {
            display: block;
            margin-top: 5px;
            color: #888;
        }
        .form-label {
            font-weight: bold;
            font-size: 1.25rem; 
            color: #000000; 
        }
        .reactions {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- load Navbar -->
    <?php include('navbar.html'); ?>

    <div class="container">
        <div class="caption-container text-center">
            <h1><?= isset($post['caption']) ? htmlspecialchars($post['caption']) : 'N/A' ?></h1>
        </div>
        <div class="post-view">
            <div class="post-image">
                <?php if (isset($post['image']) && $post['image'] !== ''): ?>
                    <div class="card">
                        <img src="data:image/jpeg;base64,<?= htmlspecialchars($post['image']) ?>" alt="Post Image" class="img-fluid">
                    </div>
                <?php else: ?>
                    <p>No image available</p>
                <?php endif; ?>
            </div>
            <div class="post-details">
                <div class="desc-container">
                    <p class="card-text large-text"><?= isset($post['description']) ? htmlspecialchars($post['description']) : 'N/A' ?></p>
                </div>
            </div>
        </div>
        <div class="comments-section">
            <h2 class="text-center">Add a Comment</h2>
            <div id="message" class="alert" style="display: none;"></div>
            <form id="addCommentForm" method="post" action="<?= site_url('comment/' . (isset($post_id) ? $post_id : '') . '/addComment') ?>" class="chat-box">
                <input type="hidden" name="post_id" id="post_id" value="<?= isset($post_id) ? $post_id : '' ?>">
                <div class="form-group">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" id="content" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Add Comment</button>
            </form>
            <hr>
            <h2 class="text-center">Comments</h2>
            <div id="commentsContainer" class="chat-box">
                <?php if (!empty($comments)): ?>
                    <ul>
                        <?php foreach ($comments as $comment): ?>
                            <li>
                                <div class="comment">
                                    <strong>Username: <?= htmlspecialchars($comment['user_name']) ?></strong>
                                    <p><?= htmlspecialchars($comment['content']) ?></p>
                                    <small>Posted on: <?= htmlspecialchars($comment['created_at']) ?></small>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-center">No comments found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
    $(function() {
        var baseUrl = '<?= base_url() ?>';

        $('#addCommentForm').on('submit', function(e) {
            e.preventDefault();
            var post_id = $('#post_id').val();
            var user_id = $('#user_id').val();
            var content = $('#content').val();
            
            $.ajax({
                url: '<?= site_url('comment/addComment') ?>/' + post_id,
                type: 'POST',
                data: {
                    user_id: user_id,
                    content: content
                },
                success: function(response) {
                    console.log(response); // Debug the response
                    try {
                        var result = JSON.parse(response);
                        if (result.message === 'Comment added successfully') {
                            location.reload();
                        } else {
                            $('#message').show().addClass('alert-danger').text(result.message);
                        }
                    } catch (e) {
                        console.error('Invalid JSON response:', response);
                        alert('Error: Invalid JSON response');
                    }
                }
            });
        });
    });
</script>
</body>
</html>
