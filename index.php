<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>Источник данных</title>
    <style>
        .form-item {
            margin-bottom: 10px;
        }
    </style>
  </head>
  <body>
    <form enctype="multipart/form-data" method="post" action="chart.php">
        <div class="form-item">
            <select name="window">
                <option value="" selected>Ширина окна..</option>
                <option value="day">День</option>
                <option value="week">Неделя</option>
                <option value="month">Месяц</option>
            </select>
        </div>
        <div class="form-item">
            <input type="file" name="src_file">
        </div>
        <div class="form-item">
            <input type="submit">
        </div>
    </form>
  </body>
</html>
