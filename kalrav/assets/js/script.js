// Kalrav Vidhya Mandir - Main JavaScript

document.addEventListener('DOMContentLoaded', function () {

    // ===== MOBILE NAV TOGGLE =====
    const navToggle = document.querySelector('.nav-toggle');
    const mainNav = document.querySelector('.main-nav');
    if (navToggle && mainNav) {
        navToggle.addEventListener('click', function () {
            mainNav.classList.toggle('open');
            this.classList.toggle('active');
        });
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.main-header')) {
                mainNav.classList.remove('open');
            }
        });
    }

    // ===== BANNER SLIDER =====
    const slides = document.querySelectorAll('.banner-slide');
    const dots = document.querySelectorAll('.banner-dot');
    let currentSlide = 0;
    let sliderInterval;

    function goToSlide(n) {
        slides.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));
        currentSlide = (n + slides.length) % slides.length;
        if (slides[currentSlide]) slides[currentSlide].classList.add('active');
        if (dots[currentSlide]) dots[currentSlide].classList.add('active');
    }

    function startSlider() {
        sliderInterval = setInterval(() => {
            goToSlide(currentSlide + 1);
        }, 4500);
    }

    if (slides.length > 0) {
        dots.forEach((dot, i) => {
            dot.addEventListener('click', () => {
                clearInterval(sliderInterval);
                goToSlide(i);
                startSlider();
            });
        });
        startSlider();
    }

    // ===== GALLERY FILTER =====
    const filterTabs = document.querySelectorAll('.filter-tab');
    const galleryItems = document.querySelectorAll('.gallery-item[data-category]');

    filterTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const cat = this.dataset.filter;
            galleryItems.forEach(item => {
                if (cat === 'all' || item.dataset.category === cat) {
                    item.style.display = '';
                    item.style.animation = 'fadeInUp 0.4s ease forwards';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // ===== QUIZ SYSTEM =====
    window.quizData = {};
    let currentQuestion = 0;
    let score = 0;
    let answered = false;
    let questions = [];

    window.openQuiz = function (quizId) {
        const modal = document.getElementById('quiz-modal');
        if (modal) {
            modal.classList.add('open');
            loadQuiz(quizId);
        }
    };

    window.closeQuiz = function () {
        const modal = document.getElementById('quiz-modal');
        if (modal) {
            modal.classList.remove('open');
            currentQuestion = 0;
            score = 0;
            answered = false;
        }
    };

    function loadQuiz(quizId) {
        const container = document.getElementById('quiz-container');
        if (!container) return;
        container.innerHTML = '<div style="text-align:center;padding:40px;"><div class="spinner"></div><p>Loading quiz...</p></div>';

        fetch('quiz_data.php?id=' + quizId)
            .then(r => r.json())
            .then(data => {
                questions = data.questions || [];
                currentQuestion = 0;
                score = 0;
                if (questions.length === 0) {
                    container.innerHTML = '<p style="text-align:center;padding:30px;color:#666;">No questions available for this quiz.</p>';
                    return;
                }
                document.getElementById('quiz-title').textContent = data.title || 'Quiz';
                showQuestion();
            })
            .catch(() => {
                container.innerHTML = '<p style="text-align:center;padding:30px;color:#c62828;">Failed to load quiz. Please try again.</p>';
            });
    }

    function showQuestion() {
        const container = document.getElementById('quiz-container');
        if (!container || currentQuestion >= questions.length) {
            showScore();
            return;
        }
        answered = false;
        const q = questions[currentQuestion];
        const total = questions.length;
        const progress = ((currentQuestion) / total) * 100;
        const labels = ['A', 'B', 'C', 'D'];
        const opts = [q.option_a, q.option_b, q.option_c, q.option_d].filter(o => o);

        let optionsHtml = '';
        opts.forEach((opt, i) => {
            optionsHtml += `<button class="option-btn" onclick="selectAnswer(this,'${labels[i]}','${q.correct_answer}')">
                <span class="option-label">${labels[i]}</span> ${opt}
            </button>`;
        });

        container.innerHTML = `
            <div class="question-counter">Question ${currentQuestion + 1} of ${total}</div>
            <div class="quiz-progress"><div class="quiz-progress-bar" style="width:${progress}%"></div></div>
            <div class="question-text">${q.question}</div>
            <div class="options-grid">${optionsHtml}</div>
            <div id="next-btn-area" style="margin-top:20px;text-align:right;display:none;">
                <button class="btn-primary" onclick="nextQuestion()" style="padding:10px 25px;font-size:14px;">
                    ${currentQuestion + 1 < total ? 'Next Question →' : 'See Results 🎉'}
                </button>
            </div>
        `;
    }

    window.selectAnswer = function (btn, selected, correct) {
        if (answered) return;
        answered = true;
        const allBtns = document.querySelectorAll('.option-btn');
        allBtns.forEach(b => {
            b.disabled = true;
            const lbl = b.querySelector('.option-label').textContent;
            if (lbl === correct) b.classList.add('correct');
        });
        if (selected === correct) {
            btn.classList.add('correct');
            score++;
        } else {
            btn.classList.add('wrong');
        }
        document.getElementById('next-btn-area').style.display = 'block';
    };

    window.nextQuestion = function () {
        currentQuestion++;
        showQuestion();
    };

    function showScore() {
        const container = document.getElementById('quiz-container');
        if (!container) return;
        const total = questions.length;
        const pct = Math.round((score / total) * 100);
        let emoji = pct >= 80 ? '🏆' : pct >= 60 ? '⭐' : pct >= 40 ? '👍' : '📚';
        let msg = pct >= 80 ? 'Outstanding!' : pct >= 60 ? 'Good job!' : pct >= 40 ? 'Keep practicing!' : 'Better luck next time!';

        container.innerHTML = `
            <div class="score-display">
                <span class="score-emoji">${emoji}</span>
                <span class="score-num">${pct}%</span>
                <h3 style="font-size:22px;margin:10px 0 5px;">${msg}</h3>
                <p>You scored ${score} out of ${total} questions correctly.</p>
                <div style="margin-top:25px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                    <button class="btn-primary" onclick="closeQuiz()" style="font-size:14px;padding:11px 25px;">Close</button>
                </div>
            </div>
        `;
    }

    // ===== ACTIVE NAV LINK =====
    const currentPath = window.location.pathname.split('/').pop() || 'index.php';
    document.querySelectorAll('.main-nav a').forEach(a => {
        const href = a.getAttribute('href') || '';
        if (href === currentPath || (currentPath === '' && href === 'index.php')) {
            a.classList.add('active');
        }
    });

    // ===== SCROLL ANIMATIONS =====
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.card, .feature-card, .event-card, .notice-item').forEach(el => {
        observer.observe(el);
    });

    // ===== CLOSE MODAL ON OUTSIDE CLICK =====
    document.querySelectorAll('.quiz-modal').forEach(modal => {
        modal.addEventListener('click', function (e) {
            if (e.target === this) closeQuiz();
        });
    });

    // ===== IMAGE ERROR FALLBACK =====
    document.querySelectorAll('img').forEach(img => {
        img.addEventListener('error', function () {
            const cat = this.dataset.category || 'school';
            const colors = ['FFC107', 'FF8F00', 'FFD54F', 'FF6F00'];
            const c = colors[Math.floor(Math.random() * colors.length)];
            this.src = `https://placehold.co/400x300/${c}/1a1a2e?text=${encodeURIComponent(cat)}`;
        });
    });

});

// ===== ADMIN SIDEBAR TOGGLE =====
function toggleSidebar() {
    document.querySelector('.admin-sidebar')?.classList.toggle('open');
}

// ===== CONFIRM DELETE =====
function confirmDelete(msg) {
    return confirm(msg || 'Are you sure you want to delete this item?');
}
