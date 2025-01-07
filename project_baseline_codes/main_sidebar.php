<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<html>
<body>

<div class="sidebar" id="most-rented">
  <h3>가장 많이 대여된 책</h3>
  <ul>
    <?php
    include './dbconn.php';  // 데이터베이스 연결
    $query = "SELECT b_name, rent_count FROM mostrentedbooks ORDER BY rent_count DESC LIMIT 7";
    $result = $con->query($query);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $b_name = htmlspecialchars($row['b_name'], ENT_QUOTES, 'UTF-8');
          $rent_count = htmlspecialchars($row['rent_count'], ENT_QUOTES, 'UTF-8');
          $b_name_encoded = urlencode($row['b_name']);
          echo "<li><a href='./book/ub_selectAll.php?search={$b_name_encoded}'>{$b_name} ({$rent_count}회)</a></li>";
      }
  } else {
      echo "<li>대여된 책이 없습니다.</li>";
  }
    ?>
  </ul>
</div>

<div class="sidebar" id="top-rated">
  <h3>평균 평점이 가장 높은 책</h3>
  <ul>
    <?php
    // 서브쿼리를 사용하여 평균 평점과 평점 개수를 조회하는 쿼리
    $query = "
      SELECT b_name, ROUND(avg_rate, 1) AS avg_rate, rate_count FROM (
        SELECT b_name, AVG(b_rate) AS avg_rate, COUNT(b_rate) AS rate_count
        FROM comment_list
        GROUP BY b_name
      ) AS subquery
      ORDER BY avg_rate DESC
      LIMIT 5
    ";
    $result = $con->query($query);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $b_name = htmlspecialchars($row['b_name'], ENT_QUOTES, 'UTF-8');
          $avg_rate = htmlspecialchars($row['avg_rate'], ENT_QUOTES, 'UTF-8');
          $rate_count = htmlspecialchars($row['rate_count'], ENT_QUOTES, 'UTF-8');
          $b_name_encoded = urlencode($row['b_name']);
          echo "<li><a href='./book/ub_selectAll.php?search={$b_name_encoded}'>{$b_name} (평점: {$avg_rate}점 / {$rate_count}개)</a></li>";
      }
  } else {
      echo "<li>평가된 책이 없습니다.</li>";
  }

    ?>
  </ul>
</div>

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
  .title {
    color: #333;
  }
  .title a {
    text-decoration: none;
    color: inherit;
  }
  .btn {
    padding: 10px 20px;
    margin: 10px;
    border: none;
    background-color: #5C67F2;
    color: white;
    border-radius: 5px;
    cursor: pointer;
  }
  .btn:hover {
    background-color: #6e7bff;
  }
  .sidebar {
    width: 200px;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    overflow-y: auto;
    border-radius: 10px;
  }
  #most-rented {
    position: fixed;
    top: 0;
    right: 0;
    height: 45vh; /* Adjusted height */
    overflow-y: auto; /* Ensures scroll if content overflows */
  }
  #top-rated {
    position: fixed;
    top: 45vh; /* Adjusted height */
    right: 0;
    height: 55vh; /* Adjusted height to avoid content cut-off */
    overflow-y: auto; /* Ensures scroll if content overflows */
  }
  .sidebar h3 {
    color: #333;
    border-bottom: 2px solid #5C67F2;
    padding-bottom: 10px;
    margin-bottom: 20px;
    font-size: 1.2em;
  }
  .sidebar ul {
    list-style: none;
    padding: 0;
  }
  .sidebar ul li {
    padding: 10px;
    border-bottom: 1px solid #eee;
    transition: background-color 0.3s;
  }
  .sidebar ul li a {
    text-decoration: none;
    color: #5C67F2;
    display: block;
  }
  .sidebar ul li:hover {
    background-color: #f0f0f0;
  }
</style>
</body>
</html>
