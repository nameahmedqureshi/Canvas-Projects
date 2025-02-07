<?php

add_action( 'wp_footer', function(){ ?>

    <style>

        .chatBox .chat-icon {
            position: fixed;
            right: 0.5%;
            top: 20%;
            cursor: pointer;
            z-index: 1000;
        }

        .chatBox .chat-icon img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .chatBox .chat-icon img:hover {
            transform: scale(1.1);
        }

        .chatBox .dialog-box {
            display: none;
            position: fixed;
            right: 20px;
            top: 28%;
            width: 250px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 15px;
            z-index: 999;
        }

        .chatBox .dialog-box h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
            color: #333;
            text-align: center;
        }

        .chatBox .user {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 8px;
            background-color: #f9f9f9;
            color: rgba(39, 39, 39, 0.5);
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .chatBox .user:hover {
            background-color: #f1f1f1;
        }

        .chatBox .user img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid #ddd;
        }

        .chatBox .msg-count {
            background-color: #ff4d4d;
            color: #fff;
            border-radius: 50%;
            padding: 0px 10px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>

    <div class="chatBox">
        <div class="chat-icon" onclick="toggleDialog()">
            <img src="https://cdn-icons-png.flaticon.com/512/134/134914.png" alt="Chat Icon">
        </div>

        <!-- Dialog Box -->
        <div id="dialogBox" class="dialog-box">
<!--             <h3>Active Users</h3>
            <a class="user">
                <img src="https://i.pravatar.cc/40?img=1" alt="User 1">
                <span>John Doe</span>
                <span class="msg-count">5</span>
            </a>
            <a class="user">
                <img src="https://i.pravatar.cc/40?img=2" alt="User 2">
                <span>Jane Smith</span>
                <span class="msg-count">3</span>
            </a>
            <a class="user">
                <img src="https://i.pravatar.cc/40?img=3" alt="User 3">
                <span>Mike Johnson</span>
                <span class="msg-count">7</span>
            </a>
            <a class="user">
                <span style="width: 100%; text-align: center;">View all</span>
            </a> -->
        </div>
    </div>

    <script>
        function toggleDialog() {
            var dialogBox = document.getElementById("dialogBox");
            if (dialogBox.style.display === "none" || dialogBox.style.display === "") {
                dialogBox.style.display = "block";
            } else {
                dialogBox.style.display = "none";
            }
        }
    </script>

<?php } ) ?>