<?php
    session_start();
    include 'logout.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fetch Fixture Details</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <nav class="navbar">
        <ul class="nav-links">
            <li><a href="index.php" id="homeButton">Home</a></li>
            <?php if($isLoggedIn) { ?>
                <li><a href="?logout=true">Log Out</a></li>
            <?php } else { ?>
                <li><a href="login.php">Log In</a></li>
            <?php } ?>
            <li><a href="javascript:void(0);" id="chatButton">Chat</a></li>
        </ul>
    </nav>
    <div class="content">
        <h1>Fixture Details</h1>
        <div class="date-picker-form">
            <form id="dateForm">
                <label for="dateInput">Choose a date:</label>
                <input type="date" id="dateInput" name="dateInput">
                <button type="submit">Show Fixtures</button>
            </form>
            <div class="team-search-form">
                <form id="teamSearchForm">
                    <label for="teamSearchInput">Search for your Teams most recent Results:</label>
                    <input type="text" id="teamSearchInput" name="teamSearchInput" placeholder="Enter team name">
                    <button type="submit">Search Fixtures</button>
                </form>
            </div>
        </div>
        <div id="fixture-details"></div>
        <div id="pagination-controls">
            <button class="previous" onclick="prevPage()">Previous</button>
            <button class="next" onclick="nextPage()">Next</button>
            <button id="feedbackButton" onclick="window.location.href='feedback.html'">Leave Feedback</button>
            <span id="page-info"></span>
            <button id="back-to-top" onclick="scrollToTop()" style="display: none;">Back to Top</button>
        </div>
    </div>
    <div class="chat-slidebar hidden" id="chat-container">
        <div class="chat-header">
            <h2>Chat</h2>
        </div>
        <div class="chat-content" id="chatbox">
            <!-- Messages will be loaded here -->
        </div>
        <div class="chat-input">
            <input type="text" id="message" placeholder="<?php echo $isLoggedIn ? 'Type your message...' : 'Create an account to access live chat'; ?>" <?php if (!$isLoggedIn) echo 'disabled'; ?>>
            <button id="send" <?php if (!$isLoggedIn) echo 'disabled'; ?>>Send</button>
        </div>
    </div>

    <script>
        function loadMessages() {
            $.ajax({
                url: 'get_messages.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    let chatbox = $('#chatbox');
                    chatbox.html('');
                    if (response.messages && Array.isArray(response.messages)) {
                        response.messages.forEach(message => {
                            chatbox.append(`<div class="chat-message"><strong>${message.username}</strong>: ${message.message} <small>${message.timestamp}</small></div>`);
                        });
                    } else {
                        console.error('Invalid or missing messages array in the response:', response);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                }
            });
        }

        $(document).ready(function() {
            loadMessages();
            setInterval(loadMessages, 3000);

            $('#send').click(function() {
                let message = $('#message').val();
                if (message.trim() !== '') {
                    $.post('send_message.php', { message: message }, function(data) {
                        $('#message').val('');
                        loadMessages();
                    });
                }
            });

            $('#chatButton').click(function() {
                $('#chat-container').toggleClass('hidden');
            });
        });
    </script>
    <script src="script.js"></script>
</body>
</html>
