@extends('layouts.Main')

@section('title', 'Home')
  
@section('content')

<style>
    /* Add your custom styles here */
    #chatbotModal {
        position: fixed;
        bottom: 20px; /* Add some margin at the bottom */
        right: 20px; /* Add some margin at the right */
        width: 400px;
        background-color: #f1f1f1;
        border: 1px solid #d4d4d4;
        padding: 10px;
        min-height: 300px;
        overflow-y: auto;
        display: none;
        border-radius: 15px; /* Adjust the border-radius to make corners curved */
    }

    .chatbot-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border-top-left-radius: 15px; /* Match the border-radius for top-left corner */
        border-top-right-radius: 15px; /* Match the border-radius for top-right corner */
    }

    #chatbotMessages {
        max-height: 200px;
        overflow-y: auto;
        margin-bottom: 10px;
    }

    #chatbotContent {
        display: flex;
        flex-direction: column;
        flex-grow: 1; /* Add this line to make the content area grow to fill the available space */
    }

    .user-message {
        background-color: #2196F3;
        color: white;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 5px;
        max-width: 70%;
        word-wrap: break-word;
        align-self: flex-end; /* Align user messages to the right */
    }

    .chatbot-message {
        background-color: #C0C0C0;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 5px;
        max-width: 70%;
        word-wrap: break-word;
        align-self: flex-start; /* Align chatbot messages to the left */
    }

    #userMessage {
        width: 100%;
        margin-bottom: 5px;
        padding: 10px;
        box-sizing: border-box;
    }

    #closeButton {
        background-color: #f44336;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

<div class="container">   
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif         
    
     <!-- Button to open Chatbot Modal -->
     <a href="#" class="float-end" onclick="toggleChatbotModal()">
        <span class="material-symbols-outlined">chat</span>
    </a>

    <!-- Chatbot Modal -->
    <div id="chatbotModal">
        <div class="chatbot-header">
            <span>EduBot</span>
            <button onclick="toggleChatbotModal()" id="closeButton"><span class="material-symbols-outlined">close_small</span></button>
        </div>
        <div id="chatbotContent">
            <div id="chatbotMessages"></div>
            <input type="text" id="userMessage" placeholder="Type your message..." onkeypress="handleKeyPress(event)">
            
        </div>
    </div>

    <script>
        function toggleChatbotModal() {
            var modal = document.getElementById('chatbotModal');
            modal.style.display = modal.style.display === 'none' ? 'block' : 'none';

            // Show the chat messages area when opening the modal
            if (modal.style.display === 'block') {
                document.getElementById('chatbotMessages').style.display = 'block';
            }
        }

        function sendMessage() {
            var userName = "{{ Auth::user()->name }}";
            var userMessage = document.getElementById('userMessage').value;

            // Display user message
            document.getElementById('chatbotMessages').innerHTML += '<div class="user-message">' + userName + ': ' + userMessage + '</div>';

            // Make an AJAX request to the chatbot server
            axios.post('/chatbot/ask', { message: userMessage })
                .then(function (response) {
                    var botResponse = response.data.botResponse;
                    
                    // Display chatbot message
                    document.getElementById('chatbotMessages').innerHTML += '<div class="chatbot-message">Bot: ' + botResponse + '</div>';
                })
                .catch(function (error) {
                    console.error('Error sending message to chatbot:', error);
                });

            // Clear the input field
            document.getElementById('userMessage').value = '';
        }

        // Handle Enter key press in the input field
        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }
    </script>
</div>
           
@endsection
