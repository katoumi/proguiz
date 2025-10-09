// === BACKGROUND MUSIC ===
document.addEventListener("DOMContentLoaded", () => {
  const music = new Audio("sounds/chill.mp3");
  music.loop = true;
  music.volume = 0.3;

  const toggle = document.getElementById("music-toggle");
  let playing = false;
  let unlocked = false;

  function unlockMusic() {
    if (!unlocked) {
      unlocked = true;
      music.play().then(() => {
        playing = true;
        if (toggle) toggle.textContent = "⏸ Pause Music";
      }).catch(err => console.warn("Autoplay blocked:", err));
    }
  }

  document.addEventListener("click", unlockMusic, { once: true });

  if (toggle) {
    toggle.addEventListener("click", e => {
      e.stopPropagation();
      if (!playing) {
        music.play().catch(() => {});
        toggle.textContent = "⏸ Pause Music";
      } else {
        music.pause();
        toggle.textContent = "🎵 Play Music";
      }
      playing = !playing;
    });
  }
});

// === UNIVERSAL BUTTON CLICK SOUND ===
document.addEventListener("DOMContentLoaded", () => {
  const clickSound = new Audio("sounds/click.mp3");
  clickSound.volume = 0.4;
  let unlocked = false;

  document.addEventListener("click", () => {
    if (!unlocked) {
      clickSound.play().catch(() => {});
      unlocked = true;
    }
  }, { once: true });

  document.addEventListener("click", e => {
    const btn = e.target.closest("button");
    if (btn && btn.id !== "music-toggle") {
      clickSound.currentTime = 0;
      clickSound.play().catch(() => {});
    }
  });
});

// === FLASHCARDS ===
const topic = localStorage.getItem("selectedSet");
const data = studySets[topic] || { flashcards: [], quiz: [] };
const card = document.getElementById("card");
const title = document.getElementById("topicTitle");

if (title && topic) title.textContent = `${topic.toUpperCase()} Flashcards`;

if (card && data.flashcards.length > 0) {
  const front = card.querySelector(".front");
  const back = card.querySelector(".back");
  let currentCard = 0;

  function showCard() {
    const item = data.flashcards[currentCard];
    front.textContent = item.front;
    back.textContent = item.back;
  }

  document.getElementById("flip").onclick = () => card.classList.toggle("flipped");
  document.getElementById("next").onclick = () => {
    currentCard = (currentCard + 1) % data.flashcards.length;
    card.classList.remove("flipped");
    showCard();
  };
  document.getElementById("prev").onclick = () => {
    currentCard = (currentCard - 1 + data.flashcards.length) % data.flashcards.length;
    card.classList.remove("flipped");
    showCard();
  };

  showCard();
} else if (card) {
  card.querySelector(".front").textContent = "No flashcards found for this topic.";
}

// === QUIZ LOGIC ===
document.addEventListener("DOMContentLoaded", () => {
  const topic = localStorage.getItem("selectedSet");
  if (!topic || !studySets[topic]) {
    const qElem = document.getElementById("question");
    if (qElem) qElem.textContent = "Please select a topic first.";
    return;
  }

  const data = studySets[topic].quiz;
  const qElem = document.getElementById("question");
  const opts = document.getElementById("options");
  const confirmBtn = document.getElementById("confirm-btn");
  const nextBtn = document.getElementById("next-btn");
  const progressFill = document.getElementById("progressFill");
  const progressText = document.getElementById("progressText");

  const correctSound = new Audio("sounds/correct.mp3");
  const wrongSound = new Audio("sounds/wrong.mp3");
  [correctSound, wrongSound].forEach(s => (s.volume = 0.4));

  let qIndex = 0;
  let score = 0;
  let selected = null;

  function playSound(audio) {
    audio.currentTime = 0;
    audio.play().catch(() => {});
  }

  function updateProgress() {
    const percent = ((qIndex + 1) / data.length) * 100;
    progressFill.style.width = percent + "%";
    progressText.textContent = `Question ${qIndex + 1} of ${data.length}`;
  }

  function loadQuestion() {
    // Prevent re-attaching listeners
    opts.replaceChildren();

    if (qIndex >= data.length) return finishQuiz();

    const q = data[qIndex];
    qElem.textContent = q.q;
    selected = null;
    confirmBtn.disabled = true;
    nextBtn.style.display = "none";
    updateProgress();

    q.options.forEach((opt, i) => {
      const btn = document.createElement("button");
      btn.textContent = opt;
      btn.classList.add("option-btn");

      btn.addEventListener("click", () => {
        document.querySelectorAll(".option-btn").forEach(b => b.classList.remove("selected"));
        btn.classList.add("selected");
        selected = i;
        confirmBtn.disabled = false;
      });

      opts.appendChild(btn);
    });
  }

  // --- Confirm Answer ---
  confirmBtn.onclick = () => {
    if (selected === null) return;

    const q = data[qIndex];
    const buttons = document.querySelectorAll(".option-btn");
    buttons.forEach(b => (b.disabled = true));

    if (selected === q.a) {
      buttons[selected].classList.add("correct");
      playSound(correctSound);
      score++;
    } else {
      buttons[selected].classList.add("wrong");
      playSound(wrongSound);
      buttons[q.a].classList.add("correct");
    }

    confirmBtn.style.display = "none";
    nextBtn.textContent = qIndex < data.length - 1 ? "Next Question" : "See Results";
    nextBtn.style.display = "inline-block";
  };

  // --- Next or Finish ---
  nextBtn.onclick = () => {
    if (qIndex >= data.length - 1) {
      finishQuiz();
    } else {
      qIndex++;
      confirmBtn.style.display = "inline-block";
      confirmBtn.disabled = true;
      nextBtn.style.display = "none";
      loadQuestion();
    }
  };

  function finishQuiz() {
    const date = new Date().toLocaleString();
    const result = { topic, score, total: data.length, date };
    const history = JSON.parse(localStorage.getItem("quizHistory")) || [];
    history.push(result);
    localStorage.setItem("quizHistory", JSON.stringify(history));

    localStorage.setItem("score", score);
    localStorage.setItem("total", data.length);
    localStorage.setItem("selectedSet", topic);

    qElem.textContent = "";
    opts.innerHTML = `
      <div class="quiz-summary">
        <h2>Quiz Complete!</h2>
        <p>You scored <strong>${score}</strong> out of <strong>${data.length}</strong>.</p>
        <div class="quiz-summary-buttons">
          <button id="view-results">View Past Results</button>
          <button id="retry-quiz">Retry Quiz</button>
        </div>
      </div>
    `;
    confirmBtn.style.display = "none";
    nextBtn.style.display = "none";
    progressFill.style.width = "100%";
    progressText.textContent = "Quiz Finished";

    // Attach new event listeners ONCE
    document.getElementById("view-results").onclick = () => {
      window.location.href = "results.html";
    };
    document.getElementById("retry-quiz").onclick = () => {
      qIndex = 0;
      score = 0;
      confirmBtn.style.display = "inline-block";
      confirmBtn.disabled = true;
      loadQuestion();
    };
  }

  loadQuestion();
});
