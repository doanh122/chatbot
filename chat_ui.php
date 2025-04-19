
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chatbot AI </title>
  <style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(to right, #f8f9fa, #e9ecef);
    margin: 0;
    padding: 0;
  }

  #chatbox {
    width: 90%;
    max-width: 500px;
    height: 520px;
    border: none;
    margin: 50px auto 20px;
    padding: 15px;
    overflow-y: auto;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .user, .bot {
    padding: 10px 14px;
    margin: 8px 0;
    border-radius: 18px;
    max-width: 75%;
    display: inline-block;
    line-height: 1.4;
    font-size: 15px;
    word-wrap: break-word;
  }

  .user {
    background: #d1e7dd;
    color: #0f5132;
    align-self: flex-end;
    float: right;
    clear: both;
    border-bottom-right-radius: 4px;
  }

  .bot {
    background: #f8d7da;
    color: #842029;
    align-self: flex-start;
    float: left;
    clear: both;
    border-bottom-left-radius: 4px;
  }

  #message {
    width: 65%;
    padding: 10px;
    border-radius: 20px;
    border: 1px solid #ccc;
    outline: none;
    font-size: 14px;
    margin-right: 10px;
  }

  button {
    padding: 10px 16px;
    border: none;
    background-color: #0d6efd;
    color: white;
    border-radius: 50px;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.2s ease;
  }

  button:hover {
    background-color: #0b5ed7;
  }

  /* Responsive */
  @media (max-width: 600px) {
    #chatbox {
      height: 400px;
      padding: 10px;
    }

    #message {
      width: 60%;
      font-size: 13px;
    }

    button {
      padding: 8px 14px;
      font-size: 13px;
    }
  }
</style>




</head>
<body>
  <div id="chatbox"></div>
  <div style="text-align:center;">
    <input id="message" placeholder="Text massage..." />
    <button onclick="sendMessage()">Send</button>
  </div>

  <script>
    async function sendMessage() {
      const msg = document.getElementById("message").value;
      if (!msg) return;
      const chatbox = document.getElementById("chatbox");
      chatbox.innerHTML += `<div class="user">${msg}</div>`;
      document.getElementById("message").value = "";

      const res = await fetch("chatbot.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({ message: msg })
      });

      const data = await res.json();
      chatbox.innerHTML += `<div class="bot">${data.reply}</div>`;
      chatbox.scrollTop = chatbox.scrollHeight;
    }


    window.onload = () => {
  const chatbox = document.getElementById("chatbox");
  chatbox.innerHTML += `<div class="bot"> Hi! I'm your assistant. How can I help you today?</div>`;
};

  </script>
</body>
</html>
