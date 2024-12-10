// Lấy ID môn học từ URL
const urlParams = new URLSearchParams(window.location.search);
const subjectId = urlParams.get('subject');

// Tải dữ liệu quiz từ tệp JavaScript tương ứng
const quizFilePath = `Quizz/${subjectId}.js`;

// Cấu hình thời gian làm bài (ví dụ: 10 phút)
const timeLimit = 10 * 60;  // 10 phút = 600 giây
let timeRemaining = timeLimit;

// Tải file quiz tương ứng
fetch(quizFilePath)
    .then(response => {
        if (!response.ok) {
            throw new Error('Không thể tải tệp quiz');
        }
        return response.json();
    })
    .then(quizData => {
        // Hiển thị tên môn học
        document.getElementById('subject-name').textContent = subjectId;

        // Hiển thị các câu hỏi quiz
        const quizContainer = document.getElementById('quiz-container');
        quizData.forEach(question => {
            const questionElement = document.createElement('div');
            questionElement.classList.add('question');
            questionElement.innerHTML = `
                <p>${question.Text}</p>
                ${question.Answers.map(answer => `
                    <label>
                        <input type="radio" name="question-${question.Id}" value="${answer.Id}">
                        ${answer.Text}
                    </label>
                `).join('<br>')}
            `;
            quizContainer.appendChild(questionElement);
        });

        // Đếm ngược thời gian
        const timerElement = document.getElementById('timer');
        const countdown = setInterval(() => {
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            timerElement.textContent = `Thời gian còn lại: ${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;

            if (timeRemaining <= 0) {
                clearInterval(countdown);
                alert('Thời gian đã hết!');
                submitQuiz();  // Tự động nộp bài khi hết giờ
            }
            timeRemaining--;
        }, 1000);

        // Xử lý sự kiện nộp bài
        document.getElementById('submit-btn').addEventListener('click', submitQuiz);

        function submitQuiz() {
            // Tính điểm
            let score = 0;
            quizData.forEach(question => {
                const selectedAnswer = document.querySelector(`input[name="question-${question.Id}"]:checked`);
                if (selectedAnswer && parseInt(selectedAnswer.value) === question.AnswerId) {
                    score += question.Marks;
                }
            });

            // Hiển thị điểm số
            document.getElementById('score').textContent = `Điểm của bạn: ${score}`;

            // Chuyển đến trang kết quả
            setTimeout(() => {
                window.location.href = `result.html?score=${score}&subject=${subjectId}`;
            }, 2000);  // Chờ 2 giây trước khi chuyển hướng
        }
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Không thể tải quiz.');
    });





