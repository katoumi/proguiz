# Proguiz

**Proguiz** is an interactive web-based learning platform designed to assist users in mastering web development fundamentals, specifically HTML, CSS, and JavaScript.  
The application integrates flashcards and quizzes to provide a dynamic, self-paced learning experience, while maintaining a minimalistic and professional interface.

---

## 1. Overview

Proguiz offers an engaging environment for learners through interactive flashcards and quizzes. Users can explore different study topics, review materials, test their knowledge, and track their progress.  
The system is built entirely with **HTML**, **CSS**, and **JavaScript**, using **localStorage** for data persistence. It operates fully client-side without any backend or external dependencies.

Key features include:
- Topic-based learning modules.
- Interactive flashcards with navigation controls.
- Quizzes with real-time scoring and result tracking.
- Results history stored locally for review.
- Background audio and button sound feedback.
- Smooth visual transitions between pages.

---

## 2. Design Pattern: Model–View–Controller (MVC)

Proguiz follows the **Model–View–Controller (MVC)** design pattern to maintain modularity and separation of concerns.

- **Model:** Manages data structures for flashcards, quizzes, and user results, including storage and retrieval from `localStorage`.  
- **View:** Defines the user interface elements such as buttons, cards, and quiz containers, ensuring responsive and accessible design.  
- **Controller:** Handles user interactions (button clicks, navigation, quiz logic) and connects the Model with the View.

This pattern ensures a clean architecture that is both maintainable and scalable, allowing future enhancements without affecting the system’s core logic.

---

## 3. Human–Computer Interaction (HCI) Principles Applied

The platform’s interface and functionality adhere to fundamental HCI principles:

1. **Simplicity and Minimalism** – The interface reduces unnecessary complexity, keeping the focus on the learning content.  
2. **Consistency** – Unified typography, button design, and color palette create a cohesive user experience.  
3. **Visibility and Feedback** – Immediate visual and auditory feedback reinforces user actions.  
4. **Flexibility and Efficiency** – The design accommodates both new and returning users, allowing smooth transitions between learning and testing.  
5. **Aesthetic and Minimalist Design** – The overall visual style promotes clarity and reduces cognitive load.

---

## 4. Website Structure and Navigation

| Page | Description |
|------|--------------|
| **Home** | Serves as the landing page introducing the purpose of the platform. |
| **Topics** | Displays available study sets that users can select. |
| **Flashcards** | Interactive flashcard interface for reviewing content. |
| **Quiz** | Quiz interface that presents questions, validates answers, and calculates scores. |
| **Results** | Displays stored quiz results and performance history. |
| **Info** | Provides a detailed explanation of the design pattern used (MVC) and HCI principles. |
| **Team** | Lists project contributors with their roles. |
| **About** | Presents an overview of the project’s goals and background. |

---

## 5. Features

- Background music toggle and interactive sound effects.  
- Persistent result tracking using local storage.  
- Animated page transitions for enhanced user flow.  
- Fully responsive design for both desktop and mobile displays.  
- Lightweight and fast, requiring no server-side processing.

---

## 6. Setup and Deployment

### Local Development
1. Clone the repository:
   ```bash
   git clone https://github.com/katoumi/proguiz.git
