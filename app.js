// Danh sách các môn học
const subjects = [
    { "Id": "ADAV", "Name": "Lập trình Android nâng cao", "Logo": "ADAV.jpg" },
    { "Id": "ADBS", "Name": "Lập trình Android cơ bản", "Logo": "ADBS.jpg" },
    { "Id": "ADTE", "Name": "Kiểm thử và triển khai ứng dụng Android", "Logo": "ADTE.jpg" },
    { "Id": "ADUI", "Name": "Thiết kế giao diện trên Android", "Logo": "ADUI.jpg" },
    { "Id": "ASNE", "Name": "Lập trình ASP.NET", "Logo": "ASNE.png" },
    { "Id": "CLCO", "Name": "Điện toán đám mây", "Logo": "CLCO.jpg" },
    { "Id": "DBAV", "Name": "SQL Server", "Logo": "DBAV.png" },
    { "Id": "DBBS", "Name": "Cơ sở dữ liệu", "Logo": "DBBS.png" },
    { "Id": "GAME", "Name": "Lập trình game 2D", "Logo": "GAME.png" },
    { "Id": "HTCS", "Name": "HTML5 và CSS3", "Logo": "HTCS.jpg" },
    { "Id": "INMA", "Name": "Internet Marketing", "Logo": "INMA.jpg" },
    { "Id": "JAAV", "Name": "Lập trình Java nâng cao", "Logo": "JAAV.png" },
    { "Id": "JABS", "Name": "Lập trình hướng đối tượng với Java", "Logo": "JABS.png" },
    { "Id": "JSPR", "Name": "Lập trình JavaScript", "Logo": "JSPR.png" },
    { "Id": "LAYO", "Name": "Thiết kế layout", "Logo": "LAYO.jpg" },
    { "Id": "MOWE", "Name": "Thiết kế web cho điện thoại di động", "Logo": "MOWE.png" },
    { "Id": "PHPP", "Name": "Lập trình PHP", "Logo": "PHPP.png" },
    { "Id": "PMAG", "Name": "Quản lý dự án với Agile", "Logo": "PMAG.jpg" },
    { "Id": "VBPR", "Name": "Lập trình VB.NET", "Logo": "VBPR.png" },
    { "Id": "WEBU", "Name": "Xây dựng trang web", "Logo": "WEBU.jpg" }
];

// Hiển thị danh sách môn học
const subjectsListElement = document.getElementById('subjects-list');
subjects.forEach(subject => {
    const subjectElement = document.createElement('div');
    subjectElement.classList.add('subject');
    subjectElement.innerHTML = `
        <img src="./images/logos/${subject.Logo}" alt="${subject.Name}" class="subject-logo">
        <h3>${subject.Name}</h3>
        <button onclick="goToQuiz('${subject.Id}')">Làm Bài</button>
    `;
    subjectsListElement.appendChild(subjectElement);
});

// Chuyển sang trang quiz của môn học
function goToQuiz(subjectId) {
    window.location.href = `test.html?subject=${subjectId}`;
}

// Xử lý sự kiện tìm kiếm
const searchInput = document.getElementById('search-input');
const subjectsList = document.getElementById('subjects-list');

searchInput.addEventListener('input', function () {
    const query = this.value.toLowerCase();
    
    // Lọc danh sách môn học theo từ khóa tìm kiếm
    const filteredSubjects = subjects.filter(subject =>
        subject.Name.toLowerCase().includes(query) || subject.Id.toLowerCase().includes(query)
    );
    
    // Hiển thị lại danh sách môn học
    displaySubjects(filteredSubjects);
});

// Hiển thị tất cả môn học khi mới tải trang
displaySubjects(subjects);

// Hàm hiển thị danh sách môn học
function displaySubjects(subjectsToDisplay) {
    subjectsList.innerHTML = ''; // Xóa danh sách cũ
    if (subjectsToDisplay.length > 0) {
        subjectsToDisplay.forEach(subject => {
            const subjectItem = document.createElement('div');
            subjectItem.className = 'subject-item';
            subjectItem.innerHTML = `
                <img src="./images/logos/${subject.Logo}" alt="${subject.Name}" class="subject-logo">
                <div class="subject-info">
                    <h3>${subject.Name}</h3>
                    <p>Mã môn học: ${subject.Id}</p>
                    <button onclick="goToQuiz('${subject.Id}')">Làm Bài</button>
                </div>
            `;
            subjectsList.appendChild(subjectItem);
        });
    } else {
        subjectsList.innerHTML = '<p>Không tìm thấy môn học phù hợp.</p>';
    }
}
