<?php
// 에러 리포팅 활성화
error_reporting(E_ALL);
ini_set("display_errors", 1);

include '../dbconn.php';

// 세션 시작
session_start();
$userid = $_SESSION['user_id'];  // 세션에서 사용자 ID를 가져옵니다.

// POST 데이터 안전하게 처리
$b_num = $_POST['b_num'] ?? '';
$b_name = $_POST['b_name'] ?? '';
$b_author = $_POST['b_author'] ?? '';
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!DOCTYPE html>
<html lang="en">
<head>
    <title>도서 관리</title>
</head>
<body>
    <div class="center">
        <h2>도서 반납 및 평점/코멘트</h2>
        <form id="bookForm" method='post'>
            <input type='hidden' name='b_name' value='<?php echo htmlspecialchars($b_name); ?>' />
            <input type='hidden' name='b_num' value='<?php echo htmlspecialchars($b_num); ?>' />
            <input type='hidden' name='b_author' value='<?php echo htmlspecialchars($b_author); ?>' />
            <label>평점 : </label>
            <div id="stars">
                <span class="star" data-value="1">&#9734;</span>
                <span class="star" data-value="2">&#9734;</span>
                <span class="star" data-value="3">&#9734;</span>
                <span class="star" data-value="4">&#9734;</span>
                <span class="star" data-value="5">&#9734;</span>
            </div>
            <input type="hidden" name="b_rate" id="rating" value="0">
            <label>코멘트 : </label><textarea name="b_comment" id="comment" class="box"></textarea><br />
            <input type="submit" value="제출" />
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star');
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-value');
                    document.getElementById('rating').value = rating;
                    stars.forEach(s => s.innerHTML = '&#9734;');
                    for (let i = 0; i < rating; i++) {
                        stars[i].innerHTML = '&#9733;';
                    }
                });
            });

            document.getElementById('bookForm').addEventListener('submit', function(event) {
                event.preventDefault();
                
                const rating = document.getElementById('rating').value;
                const comment = document.getElementById('comment').value.trim();

                if ((rating > 0 && comment === "") || (rating === "0" && comment !== "")) {
                    alert('평점과 코멘트를 모두 입력하거나 둘 다 입력하지 않아야 합니다.');
                    return;
                }

                const formData = new FormData(event.target);

                // b_checkinOk.php 요청
                fetch('b_checkinOk.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log('반납 결과:', data);
                    if (rating > 0 && comment !== "") {
                        // 평점과 코멘트가 있을 때만 b_commentOk.php 요청
                        fetch('b_commentOk.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log('코멘트 결과:', data);
                            alert('도서가 반납되고 평점 및 코멘트가 저장되었습니다.');
                            location.href = '../main.php'; // 메인 페이지로 이동
                        })
                        .catch(error => console.error('코멘트 에러:', error));
                    } else {
                        alert('도서가 반납되었습니다.');
                        location.href = '../main.php'; // 메인 페이지로 이동
                    }
                })
                .catch(error => console.error('반납 에러:', error));
            });
        });
    </script>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .center {
            text-align: center;
            margin-top: 50px;
        }
        .box {
            display: block;
            margin-bottom: 10px;
            width: 100%;
            max-width: 500px;
            margin: 0 auto 10px auto;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        #stars {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-bottom: 10px;
        }
        .star {
            font-size: 2em;
            cursor: pointer;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            background-color: #5C67F2;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #6e7bff;
        }
    </style>
</body>
</html>
