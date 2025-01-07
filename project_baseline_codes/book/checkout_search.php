<?php
include '../dbconn.php'; // 데이터베이스 연결

session_start();  // 세션 시작

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $b_num = $_POST['b_num']; // 입력받은 도서 번호

    // SQL 인젝션 방지를 위해 준비된 명령문 사용
    $stmt = $con->prepare("SELECT * FROM book_list WHERE b_num = ?");
    $stmt->bind_param("s", $b_num);
    $stmt->execute();
    $result = $stmt->get_result();

    // 장르 매핑 배열
    $genreMap = [
        "fantasy" => "판타지",
        "sci-fi" => "과학 소설 (SF)",
        "mystery" => "미스터리",
        "thriller" => "스릴러",
        "romance" => "로맨스",
        "nonfiction" => "논픽션",
        "comedy" => "코미디",
        "horror" => "호러",
        "historical" => "역사",
        "personalwriting" => "수필"
    ];

    if ($result->num_rows > 0) {
        // 결과가 있을 경우, 테이블로 결과 표시
        echo "<div class='search-results'>";
        echo "<table>";
        echo "<tr><th>도서명</th><th>작가</th><th>장르</th><th>대여</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $genre = $genreMap[$row['b_genre']] ?? $row['b_genre']; // 장르 한글화
            echo "<tr>";
            echo "<td>{$row['b_name']}</td>";
            echo "<td>{$row['b_author']}</td>";
            echo "<td>{$genre}</td>";
            echo "<td>";
            echo "<form action='b_checkoutOk.php' method='post'>";
            echo "<input type='hidden' name='b_num' value='{$row['b_num']}' />";
            echo "<input type='hidden' name='b_name' value='{$row['b_name']}' />";
            // 세션에 저장된 유저 이름을 숨겨진 필드로 추가
            if (isset($_SESSION['user_name'])) {
                echo "<input type='hidden' name='user_name' value='{$_SESSION['user_name']}' />";
            }
            echo "<input type='submit' value='대여하기' />";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='search-results'>해당 도서 번호의 도서를 찾을 수 없습니다.</div>";
    }
    $stmt->close();
}
mysqli_close($con);
?>
