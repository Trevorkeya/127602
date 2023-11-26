from flask import Flask, request, jsonify
from chatterbot import ChatBot
from chatterbot.trainers import ListTrainer  
from flask_cors import CORS
import spacy
import random

app = Flask(__name__)
CORS(app)

chatbot = ChatBot('MyChatBot')

# Load spaCy model
nlp = spacy.load("en_core_web_sm")

@app.route('/')
def home():
    return "Welcome to MyChatBot Server!"

@app.route('/ask', methods=['POST'])
def ask():
    if request.is_json:
        user_message = request.json.get('message', '')
        user_name = request.json.get('user', '')  
    else:
        user_message = request.form.get('message', '')
        user_name = request.form.get('user', '')  

    doc = nlp(user_message)
    tagged_message = " ".join([f"{token.text}_{token.pos_}" for token in doc])

    response = generate_response(user_message, user_name)

    return jsonify({'response': str(response)})

def extract_intent(message):
    # Use spaCy for intent recognition
    doc = nlp(message)

    # Define a dictionary to map lists of keywords to intents
    keyword_intents = {
        ('hello', 'hi', 'hey', 'greetings'): 'greeting',
        ('enroll', 'join', 'registration'): 'enroll_course',
        ('access', 'materials', 'content', 'resources', 'materials', 'documents'): 'access_materials',
        ('access', 'quizzes', 'take','take quiz', 'participate in quiz', 'quiz session', 'assessments', 'question'): 'access_quizzes',
        ('view', 'quiz results', 'check performance', 'see grades', 'quiz scores', 'assessment outcomes'): 'quiz_results',
        ('view profile', 'check profile', 'user information', 'personal details', 'profile page'): 'view_profile',
        # Add more tuples of keywords and intents as needed
    }

    # Check for specific keywords in the message
    for keywords, intent in keyword_intents.items():
        if any(token.text.lower() in keywords for token in doc):
            return intent

    # If no specific keyword is found, return None
    return None

def generate_response(user_message, user_name):
    intent = extract_intent(user_message)

    if intent == 'greeting':
        greetings = [
            "Hello! How can I assist you today?",
            "Hi there! What can I do for you?",
            "Hey! I'm here to help. What do you need?",
        ]
        return random.choice(greetings)
    elif intent == 'enroll_course':
        enroll_responses = [
            "To enroll in a course, follow these steps:\n1. Go to the 'Courses' section in the main menu.\n2. Browse through the available courses and choose the one you're interested in.\n3. Click on the Enroll button associated with the selected course.\n4. Enter the enrollment key.\n5. And you're all set!",
            "Enrolling in a course is easy:\n 1. Navigate to the 'Courses' tab on the homepage. \n2. Explore the list of available courses and click on the one you want to enroll in.\n3. Hit the 'Enroll' button. \n4. Fill in the required information in the enrollment form. \n5.Click 'Submit' to complete the enrollment process.",
            "Here's how you can enroll for a course:\n1. Visit the 'Courses' page from the main menu.\n2. Select your desired course and click on the 'Enroll' option.\n3. Provide the necessary details in the enrollment form.\n4. Confirm your enrollment by clicking the designated button."
        ]
        return random.choice(enroll_responses)
    elif intent == 'access_materials':
        materials_access = [
            "You can access materials in two ways:\n First, you can explore a variety of resources in the library section located in the sidebar.\n Alternatively, for course-specific materials, visit the course page and find the materials section there.",
            "To access materials, you have two options:\n Check out the library section in the sidebar for a wide range of resources.\n For course-specific materials, head to a specific course page and navigate to the materials section.",
            "There are two ways to access materials:\n Use the library option in the sidebar to explore a diverse collection.\n For course-specific materials, go to a desired course page and find the materials under different topics.",
        ]
        return random.choice(materials_access)
    elif intent == 'access_quizzes':
        quiz_responses = [
            "To view quizzes, go to your courses and select an enrolled course. You'll find quizzes organized under the specific topics within the course if created by an instructor.",
            "To view quizzes, navigate to your courses, and choose the enrolled course. You'll discover quizzes organized under specific topics within the course if they have been created by an instructor.",
            "Accessing quizzes is a breeze! Simply go to your courses, select the enrolled course, and you'll find quizzes neatly organized under specific topics within the course, provided they've been created by an instructor.",
            "When you want to view quizzes, head to your courses and pick the enrolled course. You'll see quizzes well-organized under specific topics within the course, especially if an instructor has created them.",
            "For a glimpse of quizzes, go to your courses, and select the enrolled course. You'll encounter quizzes structured under specific topics within the course, particularly if they've been created by an instructor.",
            "To find quizzes, visit your courses, and choose the enrolled course. Quizzes are usually organized under specific topics within the course, especially if they've been created by an instructor.",
        ]
        return random.choice(quiz_responses)
    elif intent == 'quiz_results':
        quiz_results_responses = [
            "After completing a quiz, you can view your results immediately. Alternatively, check your profile page for a detailed overview of all your quiz performances.",
            "To see your quiz results, complete a quiz, and your results will be displayed right away. You can also view a summary of all your quiz performances on your profile page.",
            "Viewing quiz results is simple. Finish a quiz to see your results instantly. For a comprehensive overview, head to your profile page, where you can find detailed information on all your quiz performances.",
            "Once you've completed a quiz, you'll get instant access to your results. Additionally, your profile page provides a convenient location to review a summary of all your quiz performances.",
            "Check your quiz results immediately after completing a quiz. For a more detailed analysis of your quiz performances, explore the profiles page, where you'll find a comprehensive overview.",
        ]
        return random.choice(quiz_results_responses)
    elif intent == 'view_profile':
        view_profile_responses = [
            "To view your profile, simply click on the 'Profile' option in the sidebar. There, you can find and manage all your personal information.",
            "Accessing your profile is easy! Navigate to the sidebar and click on 'Profile.' You can view and edit all your personal details from there.",
            "For a quick look at your profile, select 'Profile' from the sidebar. This is where you can find and update all your personal information.",
            "Your profile is just a click away! Choose 'Profile' from the sidebar to view and manage all your personal details in one place.",
            "To access your profile, go to the sidebar and click on 'Profile.' From there, you can view and modify all your personal information.",
        ]
        return random.choice(view_profile_responses)

    return "I'm sorry, but I couldn't identify a specific intent related to your message."

if __name__ == '__main__':
    app.run(debug=True)
